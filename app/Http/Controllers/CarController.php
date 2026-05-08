<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('cars.show', compact('car'));
    }

    public function getBookedDates(Request $request, $id)
    {
        $excludeBookingId = $request->query('exclude');
        
        $query = Booking::where('car_id', $id)
            ->whereIn('booking_status', ['pending', 'confirmed']);
        
        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }
        
        $bookedDates = $query->get()
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
            ->values();
        
        return response()->json($bookedDates);
    }
}
