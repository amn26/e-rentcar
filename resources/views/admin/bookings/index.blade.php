<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management - E-RentCar</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                    </svg>
                    E-RentCar
                </a>
                <div class="hidden md:flex gap-8 items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Users</a>
                    <a href="{{ route('admin.cars.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Cars</a>
                    <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 font-medium">Bookings</a>
                </div>
                <div class="flex gap-3 items-center">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 hidden md:block">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50" style="display: none;">
                            <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                My Profile
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="container mx-auto px-6 py-16 relative">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Booking Management</h1>
            <p class="text-xl text-blue-100">View and manage all bookings</p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="text-left p-4 font-semibold text-gray-700">Booking ID</th>
                                <th class="text-left p-4 font-semibold text-gray-700">User</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Car</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Period</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Days</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Total</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Status</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Created By</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Created Date</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Last Updated By</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Last Updated Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 font-mono text-sm">{{ $booking->id }}</td>
                                <td class="p-4">{{ $booking->user->name }}</td>
                                <td class="p-4">{{ $booking->car->name }}</td>
                                <td class="p-4 text-sm">
                                    <div>{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</div>
                                    <div class="text-gray-500">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</div>
                                </td>
                                <td class="p-4">{{ $booking->total_days }} days</td>
                                <td class="p-4 font-semibold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        @if($booking->booking_status == 'confirmed') bg-green-100 text-green-700
                                        @elseif($booking->booking_status == 'pending') bg-yellow-100 text-yellow-700
                                        @else bg-gray-100 text-gray-700 @endif">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-900">{{ $booking->CreatedBy ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-900">{{ $booking->CreatedDate ? date('d/m/Y H:i', strtotime($booking->CreatedDate)) : '-' }}</td>
                                <td class="p-4 text-sm text-gray-900">{{ $booking->LastUpdatedBy ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-900">{{ $booking->LastUpdatedDate ? date('d/m/Y H:i', strtotime($booking->LastUpdatedDate)) : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="p-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg">No bookings yet</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 w-full text-white py-4 mt-auto">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-2 text-xs">
                <span class="font-semibold">E-RentCar</span>
                <span class="text-gray-400">info@erentcar.com | +62 812-3456-7890</span>
                <span class="text-gray-400">&copy; 2026 E-RentCar</span>
            </div>
        </div>
    </footer>
</body>
</html>
