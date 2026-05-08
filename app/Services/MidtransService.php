<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction($booking)
    {
        // Add timestamp suffix if snap_token exists (retry scenario)
        $orderId = $booking->id;
        if ($booking->snap_token) {
            $orderId = $booking->id . '-' . time();
        }

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
                'phone' => $booking->user->phone ?? '08123456789',
            ],
            'item_details' => [
                [
                    'id' => $booking->car->id,
                    'price' => $booking->car->price_per_day,
                    'quantity' => $booking->total_days,
                    'name' => $booking->car->name,
                ]
            ],
            'enabled_payments' => [
                'qris',
                'bca_va',
                'bni_va',
                'bri_va',
                'permata_va',
                'other_va',
                'gopay',
                'shopeepay',
            ],
        ];

        return Snap::createTransaction($params);
    }

    public function getSnapToken($booking)
    {
        $transaction = $this->createTransaction($booking);
        return $transaction->token;
    }
}
