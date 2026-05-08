<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'LastUpdatedDate';

    protected $fillable = [
        'id', 'user_id', 'car_id', 'start_date', 'end_date',
        'total_days', 'total_price', 'booking_status', 'payment_status', 'payment_expires_at', 'snap_token',
        'CreatedDate', 'CreatedBy', 'LastUpdatedDate', 'LastUpdatedBy'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'payment_expires_at' => 'datetime',
    ];

    public function isExpired()
    {
        return $this->payment_expires_at && now()->greaterThan($this->payment_expires_at);
    }

    public function scopeExpiredPending($query)
    {
        return $query->where('booking_status', 'pending')
                    ->where('payment_status', 'unpaid')
                    ->whereNotNull('payment_expires_at')
                    ->where('payment_expires_at', '<', now());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
