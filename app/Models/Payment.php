<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'booking_id', 'transaction_id', 'payment_type',
        'gross_amount', 'transaction_status', 'snap_token', 'payment_response'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
