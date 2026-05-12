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
        
        $bookings = auth()->user()->bookings()
            ->where('IsDeleted', 0)
            ->with('car')
            ->orderBy('CreatedDate', 'desc')
            ->get();
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
        
        // Get booked dates
        $bookedDates = Booking::where('car_id', $carId)
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->get()
            ->flatMap(function($booking) {
                $dates = [];
                $start = \Carbon\Carbon::parse($booking->start_date);
                $end = \Carbon\Carbon::parse($booking->end_date);
                
                while ($start->lte($end)) {
                    $dates[] = $start->format('Y-m-d');
                    $start->addDay();
                }
                return $dates;
            })
            ->unique()
            ->values()
            ->toArray();
        
        return view('bookings.create', compact('car', 'bookedDates'));
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

        // Real-time availability check
        $car = Car::findOrFail($validated['car_id']);
        if (!$car->isAvailableForDates($validated['start_date'], $validated['end_date'])) {
            return back()->with('error', 'Car is not available for selected dates. Please choose different dates.');
        }

        // Lock unit with 10 minutes expiry
        $booking = Booking::create([
            'id' => 'BKG' . strtoupper(Str::random(7)),
            'user_id' => auth()->id(),
            'car_id' => $validated['car_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => $validated['total_days'],
            'total_price' => $validated['total_price'],
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_expires_at' => now()->addMinutes(10),
            'CreatedDate' => now(),
            'CreatedBy' => auth()->user()->email,
        ]);

        // Redirect to payment page
        return redirect()->route('payment.show', $booking->id);
    }

    public function edit($id)
    {
        if (!auth()->check()) {
            $user = \App\Models\User::where('role', 'user')->first();
            auth()->login($user);
        }

        $booking = Booking::with('car')->findOrFail($id);
        
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->booking_status !== 'pending') {
            return redirect()->route('user.bookings')->with('error', 'Only pending bookings can be edited.');
        }

        // Get all available cars
        $cars = Car::where('status', 1)->get();

        return view('bookings.edit', compact('booking', 'cars'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->check()) {
            $user = \App\Models\User::where('role', 'user')->first();
            auth()->login($user);
        }

        $booking = Booking::findOrFail($id);
        
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->booking_status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be edited.');
        }

        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'total_days' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        // Check availability excluding current booking
        $car = Car::findOrFail($validated['car_id']);
        if (!$car->isAvailableForDates($validated['start_date'], $validated['end_date'], $booking->id)) {
            return back()->with('error', 'Car is not available for selected dates.');
        }

        $booking->update([
            'car_id' => $validated['car_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => $validated['total_days'],
            'total_price' => $validated['total_price'],
            'payment_expires_at' => now()->addMinutes(10), // Reset timer
        ]);

        return redirect()->route('user.bookings')->with('success', 'Booking updated successfully.');
    }

    public function destroy($id)
    {
        if (!auth()->check()) {
            $user = \App\Models\User::where('role', 'user')->first();
            auth()->login($user);
        }

        $booking = Booking::findOrFail($id);
        
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Soft delete - set IsDeleted to 1
        $booking->update([
            'IsDeleted' => 1,
        ]);

        return redirect()->route('user.bookings')->with('success', 'Booking deleted successfully.');
    }

    public function cancel($id)
    {
        if (!auth()->check()) {
            $user = \App\Models\User::where('role', 'user')->first();
            auth()->login($user);
        }

        $booking = Booking::findOrFail($id);
        
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->booking_status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled.');
        }

        // Cancel booking - change status only
        $booking->update([
            'booking_status' => 'cancelled',
            'payment_status' => 'cancelled',
        ]);

        return redirect()->route('user.bookings')->with('success', 'Booking cancelled successfully.');
    }

    public function receipt($id)
    {
        if (!auth()->check()) {
            $user = \App\Models\User::where('role', 'user')->first();
            auth()->login($user);
        }

        $booking = Booking::with(['car', 'user'])->findOrFail($id);
        
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->payment_status !== 'paid') {
            return back()->with('error', 'Receipt only available for paid bookings.');
        }

        return view('bookings.receipt', compact('booking'));
    }
}
