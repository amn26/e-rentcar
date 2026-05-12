<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', '24h');
        
        // Calculate date range based on filter
        $dateFrom = match($filter) {
            '24h' => now()->subDay(),
            '7d' => now()->subDays(7),
            '30d' => now()->subDays(30),
            default => null,
        };

        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'verified_users' => User::where('verification_status', 'verified')->count(),
            'pending_users' => User::where('verification_status', 'pending')->count(),
            'total_cars' => Car::where('IsDeleted', 0)->count(),
            'available_cars' => Car::where('IsDeleted', 0)->where('Status', 1)->count(),
            'total_bookings' => $dateFrom ? Booking::where('CreatedDate', '>=', $dateFrom)->count() : Booking::count(),
            'active_bookings' => $dateFrom ? Booking::where('booking_status', 'confirmed')->where('CreatedDate', '>=', $dateFrom)->count() : Booking::where('booking_status', 'confirmed')->count(),
            'pending_bookings' => Booking::where('booking_status', 'pending')->count(),
            'total_revenue' => $dateFrom ? Booking::where('payment_status', 'paid')->where('CreatedDate', '>=', $dateFrom)->sum('total_price') : Booking::where('payment_status', 'paid')->sum('total_price'),
        ];

        $pending_users = User::where('verification_status', 'pending')->latest('id')->take(5)->get();
        $recent_bookings = Booking::with(['user', 'car'])->latest('id')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pending_users', 'recent_bookings', 'filter'));
    }
}
