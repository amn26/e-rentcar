<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        // For development without auth
        if (!auth()->check()) {
            $user = \App\Models\User::where('role', 'user')->first();
            auth()->login($user);
        }
        
        $bookings = auth()->user()->bookings()->with('car')->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create($carId)
    {
        // For development without auth
        if (!auth()->check()) {
            $user = \App\Models\User::where('role', 'user')->first();
            auth()->login($user);
        }
        
        $car = Car::findOrFail($carId);
        return view('bookings.create', compact('car'));
    }

    public function store(Request $request)
    {
        // For development without auth
        if (!auth()->check()) {
            $user = \App\Models\User::where('role', 'user')->first();
            auth()->login($user);
        }
        if (!auth()->user()->isVerified()) {
            return back()->with('error', 'Your account must be verified first');
        }

        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'total_days' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        Booking::create([
            'id' => 'BKG' . strtoupper(Str::random(7)),
            'user_id' => auth()->id(),
            'car_id' => $validated['car_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => $validated['total_days'],
            'total_price' => $validated['total_price'],
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        return redirect()->route('user.bookings')->with('success', 'Booking created successfully');
    }
}
