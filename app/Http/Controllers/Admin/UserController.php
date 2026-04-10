<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['verification_status' => 'verified']);
        return back()->with('success', 'User approved successfully');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['verification_status' => 'rejected']);
        return back()->with('success', 'User rejected');
    }
}
