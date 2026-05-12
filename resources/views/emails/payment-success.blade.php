<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; padding: 12px 30px; background: #10b981; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .info-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #10b981; }
        .success-badge { background: #d1fae5; color: #065f46; padding: 10px 20px; border-radius: 20px; display: inline-block; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Payment Successful!</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $booking->user->name }},</h2>
            <p>Your payment has been successfully processed!</p>
            
            <center>
                <div class="success-badge">✓ PAID</div>
            </center>

            <div class="info-box">
                <h3>Payment Details</h3>
                <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                <p><strong>Car:</strong> {{ $booking->car->name }}</p>
                <p><strong>Rental Period:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                <p><strong>Amount Paid:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                <p><strong>Payment Date:</strong> {{ now()->format('d M Y, H:i') }}</p>
            </div>

            <p><strong>Next Steps:</strong></p>
            <ul>
                <li>Download your receipt from your booking page</li>
                <li>Bring your ID and driver's license on pickup day</li>
                <li>Arrive at our location on {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</li>
            </ul>

            <center>
                <a href="{{ url('/user/bookings/' . $booking->id . '/receipt') }}" class="button">View Receipt</a>
            </center>

            <p>Thank you for choosing E-RentCar!</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 E-RentCar. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
