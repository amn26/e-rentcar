<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book {{ $car->name }} - E-RentCar</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-day.disabled {
            color: rgba(57,57,57,0.3) !important;
            background: #f3f4f6 !important;
            cursor: not-allowed !important;
        }
        .flatpickr-day.disabled:hover {
            background: #f3f4f6 !important;
            border-color: transparent !important;
        }
    </style>
</head>
<body class="bg-gray-50">
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
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Book Your Car</h1>
            <p class="text-xl text-blue-100">Complete your booking for {{ $car->name }}</p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-5xl mx-auto">
                @if(!auth()->user()->isVerified())
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg mb-6">
                        <strong>⚠️ Verification Required:</strong> Your account is pending verification. Please wait for admin approval before booking.
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold mb-4">Car Details</h2>
                        <div class="h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="h-full w-full object-cover rounded-lg">
                            @else
                                <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            @endif
                        </div>
                        <h3 class="text-2xl font-bold mb-2">{{ $car->name }}</h3>
                        <p class="text-3xl font-bold text-blue-600 mb-4">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}<span class="text-lg text-gray-500">/day</span></p>
                        <div class="space-y-2 text-gray-700">
                            <p><span class="font-semibold">Brand:</span> {{ $car->brand }}</p>
                            <p><span class="font-semibold">Year:</span> {{ $car->year }}</p>
                            <p><span class="font-semibold">Transmission:</span> {{ $car->transmisi }}</p>
                            <p><span class="font-semibold">Capacity:</span> {{ $car->kapasitas_penumpang }} seats</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-2xl font-bold mb-4">Booking Details</h2>
                        <form action="{{ route('bookings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">
                            <input type="hidden" name="price_per_day" value="{{ $car->price_per_day }}">

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">Start Date</label>
                                <input type="text" name="start_date" id="start_date" required 
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="Select start date" readonly>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">End Date</label>
                                <input type="text" name="end_date" id="end_date" required 
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="Select end date" readonly>
                            </div>

                        <div class="bg-blue-50 rounded-lg p-4 mb-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-700">Total Days:</span>
                                <span class="font-bold" id="total_days">0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Total Price:</span>
                                <span class="font-bold text-2xl text-blue-600" id="total_price">Rp 0</span>
                            </div>
                        </div>

                        <input type="hidden" name="total_days" id="total_days_input">
                        <input type="hidden" name="total_price" id="total_price_input">

                        @if(auth()->user()->isVerified())
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-bold">
                                Confirm Booking
                            </button>
                        @else
                            <button type="button" disabled class="w-full bg-gray-400 text-white py-3 rounded-lg cursor-not-allowed">
                                Waiting for Verification
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 w-full text-white py-8 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2026 E-RentCar. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const pricePerDay = {{ $car->price_per_day }};
        const bookedDates = @json($bookedDates);
        
        const startDatePicker = flatpickr("#start_date", {
            minDate: "today",
            dateFormat: "Y-m-d",
            disable: bookedDates,
            onChange: function(selectedDates, dateStr) {
                endDatePicker.set('minDate', dateStr);
                endDatePicker.clear();
                calculateTotal();
            }
        });

        const endDatePicker = flatpickr("#end_date", {
            minDate: "today",
            dateFormat: "Y-m-d",
            disable: bookedDates,
            onChange: function() {
                calculateTotal();
            }
        });

        function calculateTotal() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                
                if (end > start) {
                    const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                    const total = days * pricePerDay;

                    document.getElementById('total_days').textContent = days;
                    document.getElementById('total_price').textContent = 'Rp ' + total.toLocaleString('id-ID');
                    document.getElementById('total_days_input').value = days;
                    document.getElementById('total_price_input').value = total;
                } else {
                    resetTotal();
                }
            } else {
                resetTotal();
            }
        }

        function resetTotal() {
            document.getElementById('total_days').textContent = '0';
            document.getElementById('total_price').textContent = 'Rp 0';
            document.getElementById('total_days_input').value = '';
            document.getElementById('total_price_input').value = '';
        }
    </script>
</body>
</html>
