<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'brand', 'year', 'plate_number', 'price_per_day',
        'image', 'stnk_number', 'stnk_expired_date', 'pajak_expired_date',
        'warna', 'bahan_bakar', 'transmisi', 'kapasitas_penumpang', 'kondisi'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable()
    {
        return $this->Status == 1 && $this->IsDeleted == 0;
    }
}
