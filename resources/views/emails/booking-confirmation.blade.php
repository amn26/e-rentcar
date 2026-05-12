<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; padding: 12px 30px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .info-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #2563eb; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚗 E-RentCar</h1>
            <p>Booking Confirmation</p>
        </div>
        <div class="content">
            <h2>Hello {{ $booking->user->name }},</h2>
            <p>Thank you for your booking! Your reservation has been confirmed.</p>
            
            <div class="info-box">
                <h3>Booking Details</h3>
                <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                <p><strong>Car:</strong> {{ $booking->car->name }} ({{ $booking->car->plate_number }})</p>
                <p><strong>Rental Period:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                <p><strong>Duration:</strong> {{ $booking->total_days }} days</p>
                <p><strong>Total Price:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($booking->booking_status) }}</p>
            </div>

            <p><strong>⏰ Payment Deadline:</strong> {{ \Carbon\Carbon::parse($booking->payment_expires_at)->format('d M Y, H:i') }}</p>
            <p>Please complete your payment within 10 minutes to secure your booking.</p>

            <center>
                <a href="{{ url('/payment/' . $booking->id) }}" class="button">Pay Now</a>
            </center>

            <p>If you have any questions, please contact us at support@erentcar.com</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 E-RentCar. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
