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
            'total_cars' => Car::count(),
            'total_bookings' => Booking::count(),
            'active_bookings' => Booking::where('booking_status', 'confirmed')->count(),
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('total_price'),
        ];

        $pending_users = User::where('verification_status', 'pending')->latest('id')->take(5)->get();
        $recent_bookings = Booking::with(['user', 'car'])->latest('id')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pending_users', 'recent_bookings'));
    }
}
