<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamps();
        });
        
        // Update existing records
        DB::statement('UPDATE bookings SET created_at = NOW(), updated_at = NOW() WHERE created_at IS NULL');
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
