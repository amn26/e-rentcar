<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    public function show($bookingId)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue payment');
        }

        $booking = Booking::with(['car', 'user'])->findOrFail($bookingId);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->payment_status !== 'unpaid') {
            return redirect()->route('user.bookings')->with('info', 'Payment already processed');
        }

        // Always regenerate snap token if null (including after booking update)
        if (empty($booking->snap_token)) {
            $snapToken = $this->midtrans->getSnapToken($booking);
            $booking->update(['snap_token' => $snapToken]);
        } else {
            $snapToken = $booking->snap_token;
        }

        return view('payment.show', compact('booking', 'snapToken'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $booking = Booking::find($request->order_id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status ?? 'accept';

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $booking->update([
                    'payment_status' => 'paid',
                    'booking_status' => 'confirmed',
                ]);
            }
        } elseif ($transactionStatus == 'settlement') {
            $booking->update([
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
            ]);
        } elseif ($transactionStatus == 'pending') {
            $booking->update([
                'payment_status' => 'pending',
            ]);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $booking->update([
                'payment_status' => 'failed',
                'booking_status' => 'cancelled',
            ]);
        }

        return response()->json(['message' => 'OK']);
    }

    public function finish(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('user.bookings')->with('success', 'Payment completed successfully!');
        }
        return redirect()->route('login')->with('success', 'Payment completed! Please login to view your booking.');
    }

    public function unfinish(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('user.bookings')->with('warning', 'Payment not completed. Please complete your payment.');
        }
        return redirect()->route('login')->with('warning', 'Payment not completed. Please login to continue.');
    }

    public function error(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('user.bookings')->with('error', 'Payment failed. Please try again.');
        }
        return redirect()->route('login')->with('error', 'Payment failed. Please login to try again.');
    }
}
