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
}
