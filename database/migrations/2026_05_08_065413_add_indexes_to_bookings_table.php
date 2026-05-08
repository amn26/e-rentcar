<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->index(['booking_status', 'payment_expires_at'], 'idx_booking_expiry');
            $table->index(['car_id', 'booking_status', 'start_date', 'end_date'], 'idx_car_availability');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('idx_booking_expiry');
            $table->dropIndex('idx_car_availability');
        });
    }
};
