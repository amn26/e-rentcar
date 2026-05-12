<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; padding: 12px 30px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .info-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ef4444; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>❌ Booking Cancelled</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $booking->user->name }},</h2>
            <p>Your booking has been cancelled.</p>
            
            <div class="info-box">
                <h3>Cancelled Booking Details</h3>
                <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                <p><strong>Car:</strong> {{ $booking->car->name }}</p>
                <p><strong>Rental Period:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                <p><strong>Cancellation Date:</strong> {{ now()->format('d M Y, H:i') }}</p>
            </div>

            <p>If you didn't cancel this booking or have any questions, please contact us immediately.</p>

            <center>
                <a href="{{ url('/') }}" class="button">Browse Other Cars</a>
            </center>

            <p>We hope to serve you again in the future!</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 E-RentCar. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
