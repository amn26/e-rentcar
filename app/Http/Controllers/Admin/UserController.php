<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['verification_status' => 'verified']);
        
        // Send approval email
        try {
            \Mail::to($user->email)->send(new \App\Mail\UserVerificationStatus($user, 'approved'));
        } catch (\Exception $e) {
            \Log::error('Failed to send approval email: ' . $e->getMessage());
        }
        
        return back()->with('success', 'User approved successfully');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['verification_status' => 'rejected']);
        
        // Send rejection email
        try {
            \Mail::to($user->email)->send(new \App\Mail\UserVerificationStatus($user, 'rejected'));
        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }
        
        return back()->with('success', 'User rejected');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|max:15',
            'address' => 'nullable|max:150',
            'verification_status' => 'required|in:pending,verified,rejected',
            'password' => 'nullable|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }
}
