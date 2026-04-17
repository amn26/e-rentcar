<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|max:50',
            'phone' => 'required|max:15',
            'address' => 'required|max:150',
            'ktp_image' => 'nullable|image|max:2048',
            'sim_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('ktp_image')) {
            $validated['ktp_image'] = $request->file('ktp_image')->store('ktp', 'public');
            $validated['verification_status'] = 'pending'; // Reset verification
        }

        if ($request->hasFile('sim_image')) {
            $validated['sim_image'] = $request->file('sim_image')->store('sim', 'public');
            $validated['verification_status'] = 'pending'; // Reset verification
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully');
    }

    public function setupTOTP()
    {
        $user = auth()->user();
        
        if (!$user->totp_secret) {
            $user->totp_secret = \App\Services\TOTPService::generateSecret();
            $user->save();
        }

        $qrCodeUrl = \App\Services\TOTPService::getQRCodeUrl($user->email, $user->totp_secret);
        
        return view('user.totp-setup', compact('user', 'qrCodeUrl'));
    }

    public function enableTOTP(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);
        
        $user = auth()->user();
        
        if (\App\Services\TOTPService::verifyCode($user->totp_secret, $request->code)) {
            $user->totp_enabled = true;
            $user->save();
            
            return redirect()->route('user.profile')->with('success', 'Authenticator App enabled successfully!');
        }
        
        return back()->with('error', 'Invalid code. Please try again.');
    }

    public function disableTOTP()
    {
        $user = auth()->user();
        $user->totp_enabled = false;
        $user->totp_secret = null;
        $user->save();
        
        return back()->with('success', 'Authenticator App disabled successfully');
    }
}
