<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-RentCar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">E-RentCar</a>
                <div class="flex gap-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Dashboard</a>
                        @else
                            <a href="{{ route('user.bookings') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">My Bookings</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="bg-blue-600 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold mb-4">Rent Your Dream Car</h1>
            <p class="text-xl">Premium cars at affordable prices</p>
        </div>
    </div>

    <!-- Cars -->
    <div class="container mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold mb-8">Available Cars</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($cars as $car)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <div class="h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                    @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->brand }}" class="h-full w-full object-cover rounded-t-lg">
                    @else
                        <span class="text-gray-400 text-4xl">🚗</span>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">{{ $car->name }}</h3>
                    <p class="text-2xl font-bold text-blue-600 mb-4">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/day</p>
                    <a href="{{ route('cars.show', $car->id) }}" class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">View Details</a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">No cars available</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2026 E-RentCar. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
