<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckExpiredBookings
{
    public function handle(Request $request, Closure $next): Response
    {
        Booking::expiredPending()->update([
            'booking_status' => 'cancelled',
            'payment_status' => 'expired',
        ]);

        return $next($request);
    }
}
