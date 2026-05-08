<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class ReleaseExpiredBookings extends Command
{
    protected $signature = 'bookings:release-expired';
    protected $description = 'Release expired pending bookings and make cars available again';

    public function handle()
    {
        $expiredBookings = Booking::expiredPending()->get();
        
        $count = 0;
        foreach ($expiredBookings as $booking) {
            $booking->update([
                'booking_status' => 'cancelled',
                'payment_status' => 'expired',
            ]);
            $count++;
        }

        $this->info("Released {$count} expired booking(s)");
        return 0;
    }
}
