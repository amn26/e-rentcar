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
        'warna', 'bahan_bakar', 'transmisi', 'kapasitas_penumpang', 'kondisi', 'features'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable()
    {
        return $this->Status == 1 && $this->IsDeleted == 0;
    }

    public function isAvailableForDates($startDate, $endDate, $excludeBookingId = null)
    {
        if (!$this->isAvailable()) {
            return false;
        }

        $query = $this->bookings()
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('start_date', '<=', $startDate)
                         ->where('end_date', '>=', $endDate);
                  });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count() === 0;
    }

    public function isAvailableForDate($date)
    {
        if (!$this->isAvailable()) {
            return false;
        }

        return $this->bookings()
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->count() === 0;
    }
}
