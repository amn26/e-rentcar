<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book {{ $car->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">E-RentCar</a>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">← Back</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-8">Book {{ $car->name }}</h1>

            @if(!auth()->user()->isVerified())
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                    Your account is pending verification. Please wait for admin approval before booking.
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Car Details</h2>
                    <div class="h-48 bg-gray-200 rounded mb-4 flex items-center justify-center">
                        @if($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="h-full w-full object-cover rounded">
                        @else
                            <span class="text-gray-400 text-6xl">🚗</span>
                        @endif
                    </div>
                    <h3 class="text-2xl font-bold mb-2">{{ $car->name }}</h3>
                    <p class="text-3xl font-bold text-blue-600 mb-4">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/day</p>
                    <div class="space-y-2 text-gray-700">
                        <p><strong>Brand:</strong> {{ $car->brand }}</p>
                        <p><strong>Year:</strong> {{ $car->year }}</p>
                        <p><strong>Transmission:</strong> {{ $car->transmisi }}</p>
                        <p><strong>Capacity:</strong> {{ $car->kapasitas_penumpang }} seats</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Booking Details</h2>
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="car_id" value="{{ $car->id }}">
                        <input type="hidden" name="price_per_day" value="{{ $car->price_per_day }}">

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Start Date</label>
                            <input type="date" name="start_date" id="start_date" required 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                min="{{ date('Y-m-d') }}" onchange="calculateTotal()">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">End Date</label>
                            <input type="date" name="end_date" id="end_date" required 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                min="{{ date('Y-m-d') }}" onchange="calculateTotal()">
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
    </div>

    <script>
        const pricePerDay = {{ $car->price_per_day }};

        function calculateTotal() {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);

            if (startDate && endDate && endDate > startDate) {
                const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                const total = days * pricePerDay;

                document.getElementById('total_days').textContent = days;
                document.getElementById('total_price').textContent = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('total_days_input').value = days;
                document.getElementById('total_price_input').value = total;
            }
        }
    </script>
</body>
</html>
