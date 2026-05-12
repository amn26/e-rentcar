<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt - {{ $booking->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2563eb;
            font-size: 28px;
            margin: 0;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .info-col {
            display: table-cell;
            width: 50%;
        }
        .info-col.right {
            text-align: right;
        }
        .label {
            color: #666;
            font-size: 10px;
            margin-bottom: 3px;
        }
        .value {
            font-weight: bold;
            font-size: 13px;
        }
        .section {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .section h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        .detail-row {
            margin-bottom: 8px;
        }
        .detail-label {
            color: #666;
            display: inline-block;
            width: 150px;
        }
        .detail-value {
            font-weight: bold;
        }
        .total-section {
            background: #eff6ff;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .total-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        .total-label {
            display: table-cell;
            text-align: right;
            padding-right: 20px;
            font-size: 13px;
        }
        .total-value {
            display: table-cell;
            text-align: right;
            font-weight: bold;
            font-size: 13px;
        }
        .grand-total {
            border-top: 2px solid #2563eb;
            padding-top: 10px;
            margin-top: 10px;
        }
        .grand-total .total-label {
            font-size: 16px;
            font-weight: bold;
        }
        .grand-total .total-value {
            font-size: 18px;
            color: #2563eb;
        }
        .status-badge {
            background: #d1fae5;
            color: #065f46;
            padding: 8px 20px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #666;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>E-RENTCAR</h1>
        <p>Payment Receipt</p>
    </div>

    <!-- Receipt Info -->
    <div class="info-row">
        <div class="info-col">
            <div class="label">Receipt Number</div>
            <div class="value">{{ $booking->id }}</div>
        </div>
        <div class="info-col right">
            <div class="label">Payment Date</div>
            <div class="value">{{ \Carbon\Carbon::parse($booking->LastUpdatedDate ?? $booking->CreatedDate)->format('d M Y, H:i') }}</div>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="section">
        <h3>Customer Information</h3>
        <div class="detail-row">
            <span class="detail-label">Name:</span>
            <span class="detail-value">{{ $booking->user->name }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Email:</span>
            <span class="detail-value">{{ $booking->user->email }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Phone:</span>
            <span class="detail-value">{{ $booking->user->phone ?? '-' }}</span>
        </div>
    </div>

    <!-- Rental Details -->
    <div class="section">
        <h3>Rental Details</h3>
        <div class="detail-row">
            <span class="detail-label">Car:</span>
            <span class="detail-value">{{ $booking->car->name }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Brand:</span>
            <span class="detail-value">{{ $booking->car->brand }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Plate Number:</span>
            <span class="detail-value">{{ $booking->car->plate_number }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Rental Period:</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Duration:</span>
            <span class="detail-value">{{ $booking->total_days }} days</span>
        </div>
    </div>

    <!-- Payment Summary -->
    <div class="total-section">
        <div class="total-row">
            <div class="total-label">Price per Day:</div>
            <div class="total-value">Rp {{ number_format($booking->car->price_per_day, 0, ',', '.') }}</div>
        </div>
        <div class="total-row">
            <div class="total-label">Number of Days:</div>
            <div class="total-value">{{ $booking->total_days }} days</div>
        </div>
        <div class="total-row grand-total">
            <div class="total-label">Total Amount:</div>
            <div class="total-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Payment Status -->
    <div style="text-align: center;">
        <div class="status-badge">✓ PAID</div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for choosing E-RentCar!</p>
        <p>For inquiries, contact us at support@erentcar.com</p>
        <p style="margin-top: 10px;">This is a computer-generated receipt and does not require a signature.</p>
    </div>
</body>
</html>
