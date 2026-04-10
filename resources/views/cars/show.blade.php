<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $car->brand }} {{ $car->model }} - E-RentCar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">E-RentCar</a>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600">← Back to Home</a>
            </div>
        </div>
    </nav>

    <!-- Car Detail -->
    <section class="container mx-auto px-6 py-12">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Car Image -->
                <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-12 flex items-center justify-center">
                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="max-w-full h-auto">
                </div>

                <!-- Car Info & Booking -->
                <div class="p-12">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $car->brand }} {{ $car->model }}</h1>
                    <p class="text-3xl font-bold text-indigo-600 mb-6">Rp {{ number_format($car->price_per_day, 0, ',', '.') }} <span class="text-lg text-gray-500">/ day</span></p>
                    
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">Specifications</h3>
                        <p class="text-gray-600 mb-4">{{ $car->description }}</p>
                        <div class="space-y-2 text-gray-700">
                            <p><span class="font-semibold">Year:</span> {{ $car->year }}</p>
                            <p><span class="font-semibold">Plate:</span> {{ $car->plate_number }}</p>
                            <p><span class="font-semibold">Status:</span> 
                                @if($car->isAvailable())
                                    <span class="text-green-600 font-semibold">Available</span>
                                @else
                                    <span class="text-red-600 font-semibold">Not Available</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($car->isAvailable())
                        <a href="{{ route('bookings.create', $car->id) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition duration-200 shadow-lg">
                            Book Now
                        </a>
                    @else
                        <button disabled class="block w-full text-center bg-gray-400 text-white font-bold py-4 rounded-xl cursor-not-allowed">
                            Not Available
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>
</body>
</html>
