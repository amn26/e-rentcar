<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - {{ $booking->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-8">
        <!-- Print Buttons -->
        <div class="no-print mb-4 flex gap-2">
            <a href="{{ route('user.bookings.download-pdf', $booking->id) }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-medium">
                📥 Download PDF
            </a>
            <a href="{{ route('user.bookings') }}" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 font-medium">
                ← Back to Bookings
            </a>
        </div>

        <!-- Receipt -->
        <div class="bg-white shadow-lg rounded-lg p-8" id="receipt">
            <!-- Header -->
            <div class="text-center border-b-2 border-blue-600 pb-6 mb-6">
                <h1 class="text-3xl font-bold text-blue-600">E-RENTCAR</h1>
                <p class="text-gray-600 mt-2">Payment Receipt</p>
            </div>

            <!-- Receipt Info -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-600">Receipt Number</p>
                    <p class="font-bold">{{ $booking->id }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Payment Date</p>
                    <p class="font-bold">{{ \Carbon\Carbon::parse($booking->UpdatedDate ?? $booking->CreatedDate)->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-bold mb-3">Customer Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="font-semibold">{{ $booking->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold">{{ $booking->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-semibold">{{ $booking->user->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="mb-6">
                <h3 class="font-bold mb-3">Booking Details</h3>
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-left p-3">Car</th>
                            <th class="text-center p-3">Duration</th>
                            <th class="text-right p-3">Price/Day</th>
                            <th class="text-right p-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="p-3">
                                <p class="font-semibold">{{ $booking->car->name }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->car->brand }}</p>
                            </td>
                            <td class="text-center p-3">{{ $booking->total_days }} days</td>
                            <td class="text-right p-3">Rp {{ number_format($booking->car->price_per_day, 0, ',', '.') }}</td>
                            <td class="text-right p-3 font-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Rental Period -->
            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                <h3 class="font-bold mb-3">Rental Period</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Start Date</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">End Date</p>
                        <p class="font-semibold">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="border-t-2 border-gray-300 pt-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-lg">Subtotal</span>
                    <span class="text-lg">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-2xl font-bold text-blue-600">
                    <span>Total Paid</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="mt-6 text-center">
                <span class="inline-block bg-green-100 text-green-800 px-6 py-2 rounded-full font-semibold">
                    ✓ PAID
                </span>
            </div>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t text-center text-sm text-gray-600">
                <p>Thank you for choosing E-RentCar!</p>
                <p class="mt-2">For inquiries, contact us at support@erentcar.com</p>
            </div>
        </div>
    </div>
</body>
</html>
