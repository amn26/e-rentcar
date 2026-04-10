<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('name', 50);
            $table->string('brand', 50);
            $table->integer('year');
            $table->string('plate_number', 15)->unique();
            $table->decimal('price_per_day', 10, 2);
            $table->string('image', 100)->nullable();
            $table->string('stnk_number', 50);
            $table->date('stnk_expired_date');
            $table->date('pajak_expired_date');
            $table->string('warna', 30);
            $table->string('bahan_bakar', 20);
            $table->string('transmisi', 20);
            $table->integer('kapasitas_penumpang');
            $table->string('kondisi', 50);
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
        Schema::dropIfExists('cars');
    }
};
