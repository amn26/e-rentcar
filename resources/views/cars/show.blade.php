<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $car->brand }} {{ $car->model }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">E-RentCar</a>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">← Back</a>
            </div>
        </div>
    </nav>

    <!-- Car Detail -->
    <div class="container mx-auto px-6 py-12">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="h-96 bg-gray-200 flex items-center justify-center">
                    @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->brand }}" class="h-full w-full object-cover">
                    @else
                        <span class="text-gray-400 text-9xl">🚗</span>
                    @endif
                </div>
                <div class="p-8">
                    <h1 class="text-3xl font-bold mb-4">{{ $car->brand }} {{ $car->model }}</h1>
                    <p class="text-3xl font-bold text-blue-600 mb-6">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/day</p>
                    
                    <div class="mb-6 space-y-2">
                        <p><strong>Year:</strong> {{ $car->year }}</p>
                        <p><strong>Plate:</strong> {{ $car->plate_number }}</p>
                        <p><strong>Status:</strong> 
                            @if($car->isAvailable())
                                <span class="text-green-600">Available</span>
                            @else
                                <span class="text-red-600">Not Available</span>
                            @endif
                        </p>
                    </div>

                    @if($car->isAvailable())
                        <a href="{{ route('bookings.create', $car->id) }}" class="block text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-bold">Book Now</a>
                    @else
                        <button disabled class="block w-full text-center bg-gray-400 text-white py-3 rounded-lg cursor-not-allowed">Not Available</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
