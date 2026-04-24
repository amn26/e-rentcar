<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - E-RentCar</title>
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
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-gray-600 hover:text-blue-600 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Home
                </a>
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
            <h1 class="text-4xl md:text-5xl font-bold mb-4">My Bookings</h1>
            <p class="text-xl text-blue-100">View and manage your car rentals</p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6">
                @forelse($bookings as $booking)
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex flex-col md:flex-row justify-between gap-6">
                        <div class="flex gap-6">
                            <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                @if($booking->car->image)
                                    <img src="{{ asset('storage/' . $booking->car->image) }}" alt="{{ $booking->car->name }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold mb-2">{{ $booking->car->name }}</h3>
                                <p class="text-gray-600 mb-1"><span class="font-semibold">Booking ID:</span> {{ $booking->id }}</p>
                                <p class="text-gray-600 mb-1"><span class="font-semibold">Period:</span> {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                                <p class="text-gray-600 mb-2"><span class="font-semibold">Duration:</span> {{ $booking->total_days }} days</p>
                                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="flex md:flex-col gap-2">
                            <span class="px-4 py-2 rounded-full text-sm font-semibold text-center
                                @if($booking->booking_status == 'confirmed') bg-green-100 text-green-700
                                @elseif($booking->booking_status == 'pending') bg-yellow-100 text-yellow-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($booking->booking_status) }}
                            </span>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold text-center
                                @if($booking->payment_status == 'paid') bg-green-100 text-green-700
                                @else bg-orange-100 text-orange-700 @endif">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="text-gray-500 text-lg mb-4">No bookings yet</p>
                    <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Browse Cars</a>
                </div>
                @endforelse
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
