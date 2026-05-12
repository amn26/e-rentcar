<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, {{ $status == 'approved' ? '#10b981' : '#ef4444' }} 0%, {{ $status == 'approved' ? '#059669' : '#dc2626' }} 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; padding: 12px 30px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .info-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $status == 'approved' ? '✅ Verification Approved' : '❌ Verification Rejected' }}</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $user->name }},</h2>
            
            @if($status == 'approved')
                <p>Great news! Your account verification has been <strong>approved</strong>.</p>
                
                <div class="info-box">
                    <p>You can now:</p>
                    <ul>
                        <li>Browse available cars</li>
                        <li>Make bookings</li>
                        <li>Enjoy our rental services</li>
                    </ul>
                </div>

                <center>
                    <a href="{{ url('/') }}" class="button">Browse Cars</a>
                </center>
            @else
                <p>We regret to inform you that your account verification has been <strong>rejected</strong>.</p>
                
                <div class="info-box">
                    <p><strong>Possible reasons:</strong></p>
                    <ul>
                        <li>Unclear or invalid ID documents</li>
                        <li>Incomplete information</li>
                        <li>Document mismatch</li>
                    </ul>
                </div>

                <p>Please re-upload your documents with clear and valid information.</p>

                <center>
                    <a href="{{ url('/user/profile') }}" class="button">Update Profile</a>
                </center>
            @endif

            <p>If you have any questions, please contact us at support@erentcar.com</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 E-RentCar. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
