<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'pending_users' => User::where('verification_status', 'pending')->count(),
            'total_cars' => Car::where('Status', 1)->count(),
            'total_bookings' => Booking::count(),
        ];

        $pending_users = User::where('verification_status', 'pending')->latest('CreatedDate')->take(5)->get();
        $recent_bookings = Booking::with(['user', 'car'])->latest('CreatedDate')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pending_users', 'recent_bookings'));
    }
}
