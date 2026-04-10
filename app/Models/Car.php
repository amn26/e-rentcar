<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'brand', 'model', 'year', 'plate_number', 'price_per_day',
        'status', 'image', 'description'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }
}
