<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-RentCar - Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">E-RentCar</a>
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 font-medium">About</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 font-medium">Contact</a>
                </div>
                <div class="flex space-x-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Dashboard</a>
                        @else
                            <a href="{{ route('user.bookings') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">My Bookings</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-5xl font-bold mb-4">Find Your Perfect Ride</h1>
            <p class="text-xl mb-8">Rent premium cars at affordable prices</p>
        </div>
    </section>

    <!-- Filter & Cars Section -->
    <section class="container mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filter Sidebar -->
            <div class="lg:w-64 bg-white rounded-2xl shadow-lg p-6 h-fit sticky top-24">
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Filters</h3>
                <hr class="mb-4">
                
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-3">Seater</h4>
                    <label class="flex items-center mb-2 cursor-pointer">
                        <input type="radio" name="seater" value="5" checked class="mr-2 text-indigo-600">
                        <span>5 Seater</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="seater" value="7" class="mr-2 text-indigo-600">
                        <span>7 Seater</span>
                    </label>
                </div>

                <hr class="mb-4">

                <div>
                    <h4 class="font-semibold text-gray-700 mb-3">Transmission</h4>
                    <label class="flex items-center mb-2 cursor-pointer">
                        <input type="radio" name="transmission" value="automatic" checked class="mr-2 text-indigo-600">
                        <span>Automatic</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="transmission" value="manual" class="mr-2 text-indigo-600">
                        <span>Manual</span>
                    </label>
                </div>
            </div>

            <!-- Car Grid -->
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($cars as $car)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                        <div class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200">
                            <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-full object-contain p-4">
                            @if($car->isAvailable())
                                <span class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Available</span>
                            @else
                                <span class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Booked</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $car->brand }} {{ $car->model }}</h3>
                            <p class="text-2xl font-bold text-indigo-600 mb-4">Rp {{ number_format($car->price_per_day, 0, ',', '.') }} <span class="text-sm text-gray-500">/ day</span></p>
                            <p class="text-gray-600 text-sm mb-4">{{ $car->description }}</p>
                            <a href="{{ route('cars.show', $car->id) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition duration-200">
                                View Details
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No cars available at the moment</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2026 E-RentCar. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
