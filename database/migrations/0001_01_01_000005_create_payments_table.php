<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('booking_id', 10);
            $table->string('transaction_id', 50)->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->decimal('gross_amount', 10, 2);
            $table->string('transaction_status', 20);
            $table->string('snap_token', 100)->nullable();
            $table->text('payment_response')->nullable();
            $table->string('CompanyCode', 32)->nullable();
            $table->tinyInteger('Status')->default(1);
            $table->tinyInteger('IsDeleted')->default(0);
            $table->string('CreatedBy', 32)->nullable();
            $table->dateTime('CreatedDate')->nullable();
            $table->string('LastUpdatedBy', 32)->nullable();
            $table->dateTime('LastUpdatedDate')->nullable();
            
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
