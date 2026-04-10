<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-6">
                <h2 class="text-2xl font-bold">Admin Panel</h2>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block py-3 px-6 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="block py-3 px-6 hover:bg-gray-700">Users</a>
                <a href="{{ route('admin.cars.index') }}" class="block py-3 px-6 hover:bg-gray-700">Cars</a>
                <a href="{{ route('admin.bookings.index') }}" class="block py-3 px-6 bg-gray-900">Bookings</a>
                <a href="{{ route('home') }}" class="block py-3 px-6 hover:bg-gray-700">View Site</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto p-8">
            <h1 class="text-3xl font-bold mb-8">Booking Management</h1>

            <div class="bg-white rounded-lg shadow">
                <table class="w-full">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left p-4">Booking ID</th>
                            <th class="text-left p-4">User</th>
                            <th class="text-left p-4">Car</th>
                            <th class="text-left p-4">Period</th>
                            <th class="text-left p-4">Days</th>
                            <th class="text-left p-4">Total</th>
                            <th class="text-left p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $booking->id }}</td>
                            <td class="p-4">{{ $booking->user->name }}</td>
                            <td class="p-4">{{ $booking->car->name }}</td>
                            <td class="p-4">{{ $booking->start_date }} - {{ $booking->end_date }}</td>
                            <td class="p-4">{{ $booking->total_days }}</td>
                            <td class="p-4">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    @if($booking->booking_status == 'confirmed') bg-green-100 text-green-700
                                    @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ ucfirst($booking->booking_status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500">No bookings yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
