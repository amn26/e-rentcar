<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">E-RentCar</a>
                <div class="flex gap-4">
                    <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Home</a>
                    <a href="{{ route('user.profile') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold mb-8">My Bookings</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6">
            @forelse($bookings as $booking)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start">
                    <div class="flex gap-6">
                        <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center">
                            @if($booking->car->image)
                                <img src="{{ asset('storage/' . $booking->car->image) }}" alt="{{ $booking->car->name }}" class="w-full h-full object-cover rounded">
                            @else
                                <span class="text-gray-400 text-4xl">🚗</span>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">{{ $booking->car->name }}</h3>
                            <p class="text-gray-600 mb-1"><strong>Booking ID:</strong> {{ $booking->id }}</p>
                            <p class="text-gray-600 mb-1"><strong>Period:</strong> {{ $booking->start_date }} to {{ $booking->end_date }}</p>
                            <p class="text-gray-600 mb-1"><strong>Duration:</strong> {{ $booking->total_days }} days</p>
                            <p class="text-2xl font-bold text-blue-600 mt-2">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                            @if($booking->booking_status == 'confirmed') bg-green-100 text-green-700
                            @elseif($booking->booking_status == 'pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($booking->booking_status) }}
                        </span>
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold mt-2
                            @if($booking->payment_status == 'paid') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($booking->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <p class="text-gray-500 text-lg mb-4">No bookings yet</p>
                <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Browse Cars</a>
            </div>
            @endforelse
        </div>
    </div>
</body>
</html>
