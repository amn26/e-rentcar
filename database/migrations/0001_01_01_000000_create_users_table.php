<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('role', 10);
            $table->string('phone', 15)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('ktp_image', 100)->nullable();
            $table->string('sim_image', 100)->nullable();
            $table->string('verification_status', 20)->default('pending');
            $table->string('CompanyCode', 32)->nullable();
            $table->tinyInteger('Status')->default(1);
            $table->tinyInteger('IsDeleted')->default(0);
            $table->string('CreatedBy', 32)->nullable();
            $table->dateTime('CreatedDate')->nullable();
            $table->string('LastUpdatedBy', 32)->nullable();
            $table->dateTime('LastUpdatedDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
