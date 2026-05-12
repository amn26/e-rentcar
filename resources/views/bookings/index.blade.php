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
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Actions</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Booking ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Car</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Period</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Days</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Total Price</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Payment</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Created By</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Created Date</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Last Updated By</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Last Updated Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">
                                    <div class="flex gap-2 justify-center">
                                        @if($booking->payment_status == 'unpaid' && $booking->booking_status == 'pending')
                                            <a href="{{ route('payment.show', $booking->id) }}" class="p-2 bg-green-500 text-white rounded hover:bg-green-600" title="Pay Now">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                </svg>
                                            </a>
                                        @endif
                                        @if($booking->payment_status == 'paid')
                                            <a href="{{ route('user.bookings.receipt', $booking->id) }}" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600" title="View Receipt">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </a>
                                        @endif
                                        @if($booking->booking_status == 'pending')
                                            <a href="{{ route('user.bookings.edit', $booking->id) }}" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button onclick="return confirm('Cancel this booking? You can still see it in the list.')" class="p-2 bg-orange-500 text-white rounded hover:bg-orange-600" title="Cancel Booking">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('user.bookings.destroy', $booking->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Delete this booking permanently? It will be removed from your list.')" class="p-2 bg-red-500 text-white rounded hover:bg-red-600" title="Delete Booking">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm font-mono text-gray-900">{{ $booking->id }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                            @if($booking->car->image)
                                                <img src="{{ asset('storage/' . $booking->car->image) }}" alt="{{ $booking->car->name }}" class="w-full h-full object-cover rounded">
                                            @else
                                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $booking->car->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <div>{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</div>
                                    <div class="text-gray-500">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $booking->total_days }} days</td>
                                <td class="px-4 py-3 text-sm font-semibold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($booking->booking_status == 'confirmed') bg-green-100 text-green-700
                                        @elseif($booking->booking_status == 'pending') bg-yellow-100 text-yellow-700
                                        @else bg-red-100 text-red-700 @endif">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($booking->payment_status == 'paid') bg-green-100 text-green-700
                                        @else bg-orange-100 text-orange-700 @endif">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $booking->CreatedBy ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $booking->CreatedDate ? date('d/m/Y H:i', strtotime($booking->CreatedDate)) : '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $booking->LastUpdatedBy ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $booking->LastUpdatedDate ? date('d/m/Y H:i', strtotime($booking->LastUpdatedDate)) : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="px-4 py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg mb-4">No bookings yet</p>
                                    <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Browse Cars</a>
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

    <script>
        function updateCountdowns() {
            const countdowns = document.querySelectorAll('.countdown');
            
            countdowns.forEach(countdown => {
                const expiresAt = new Date(countdown.dataset.expires).getTime();
                const now = new Date().getTime();
                const distance = expiresAt - now;
                
                if (distance < 0) {
                    countdown.textContent = 'EXPIRED';
                    countdown.classList.add('text-red-600');
                } else {
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    countdown.textContent = minutes + 'm ' + seconds + 's';
                }
            });
        }
        
        // Update every second
        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    </script>
</body>
</html>
