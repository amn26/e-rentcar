<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Check if TOTP is enabled (Authenticator App)
            if ($user->totp_enabled) {
                Auth::logout();
                session(['totp_user_id' => $user->id]);
                return redirect()->route('totp.verify');
            }
            
            $request->session()->regenerate();
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('home');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|max:15',
            'address' => 'required|max:150',
            'ktp_image' => 'required|image|max:2048',
            'sim_image' => 'required|image|max:2048',
        ]);

        $ktpPath = $request->file('ktp_image')->store('ktp', 'public');
        $simPath = $request->file('sim_image')->store('sim', 'public');

        User::create([
            'id' => 'USR' . strtoupper(Str::random(7)),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'user',
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'ktp_image' => $ktpPath,
            'sim_image' => $simPath,
            'verification_status' => 'pending',
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please wait for admin verification.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->email)->first();
            
            if ($user) {
                // Check if TOTP is enabled
                if ($user->totp_enabled) {
                    session(['totp_user_id' => $user->id]);
                    return redirect()->route('totp.verify');
                }
                Auth::login($user);
            } else {
                $user = User::create([
                    'id' => 'USR' . strtoupper(Str::random(7)),
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'user',
                    'verification_status' => 'pending',
                ]);
                
                Auth::login($user);
            }
            
            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed');
        }
    }

    public function showTOTPVerify()
    {
        if (!session('totp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.totp-verify');
    }

    public function verifyTOTP(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);
        
        $user = User::find(session('totp_user_id'));
        
        if (!$user || !$user->totp_secret) {
            return back()->with('error', 'Invalid session');
        }
        
        if (!\App\Services\TOTPService::verifyCode($user->totp_secret, $request->code)) {
            return back()->with('error', 'Invalid code');
        }
        
        Auth::login($user);
        $request->session()->regenerate();
        session()->forget('totp_user_id');
        
        return $user->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('home');
    }
}
