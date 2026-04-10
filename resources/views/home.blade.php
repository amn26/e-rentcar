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
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600 flex items-center">
                    <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                    </svg>
                    E-RentCar
                </a>
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">Home</a>
                    <a href="#about" class="text-gray-700 hover:text-indigo-600 font-medium transition">About</a>
                    <a href="#contact" class="text-gray-700 hover:text-indigo-600 font-medium transition">Contact</a>
                </div>
                <div class="flex space-x-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Dashboard</a>
                        @else
                            <a href="{{ route('user.bookings') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">My Bookings</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-yellow-300 rounded-full blur-3xl"></div>
        </div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-6xl font-extrabold mb-4 animate-fade-in">Find Your Perfect Ride</h1>
            <p class="text-2xl mb-8 font-light">Rent premium cars at affordable prices</p>
            <div class="flex justify-center gap-4">
                <a href="#cars" class="px-8 py-4 bg-white text-indigo-600 rounded-full font-bold hover:bg-gray-100 transition shadow-lg">Browse Cars</a>
                <a href="{{ route('register') }}" class="px-8 py-4 bg-yellow-400 text-gray-900 rounded-full font-bold hover:bg-yellow-300 transition shadow-lg">Get Started</a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white py-12 shadow-md">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <h3 class="text-4xl font-bold text-indigo-600">50+</h3>
                    <p class="text-gray-600 mt-2">Premium Cars</p>
                </div>
                <div>
                    <h3 class="text-4xl font-bold text-indigo-600">1000+</h3>
                    <p class="text-gray-600 mt-2">Happy Customers</p>
                </div>
                <div>
                    <h3 class="text-4xl font-bold text-indigo-600">24/7</h3>
                    <p class="text-gray-600 mt-2">Customer Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter & Cars Section -->
    <section id="cars" class="container mx-auto px-6 py-16">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Available Cars</h2>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filter Sidebar -->
            <div class="lg:w-64 bg-white rounded-2xl shadow-xl p-6 h-fit sticky top-24 border-2 border-indigo-100">
                <h3 class="text-2xl font-bold mb-4 text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filters
                </h3>
                <hr class="mb-4 border-indigo-200">
                
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        Seater
                    </h4>
                    <label class="flex items-center mb-3 cursor-pointer hover:bg-indigo-50 p-2 rounded-lg transition">
                        <input type="radio" name="seater" value="5" checked class="mr-3 text-indigo-600 w-4 h-4">
                        <span class="text-gray-700">5 Seater</span>
                    </label>
                    <label class="flex items-center cursor-pointer hover:bg-indigo-50 p-2 rounded-lg transition">
                        <input type="radio" name="seater" value="7" class="mr-3 text-indigo-600 w-4 h-4">
                        <span class="text-gray-700">7 Seater</span>
                    </label>
                </div>

                <hr class="mb-4 border-indigo-200">

                <div>
                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                        Transmission
                    </h4>
                    <label class="flex items-center mb-3 cursor-pointer hover:bg-indigo-50 p-2 rounded-lg transition">
                        <input type="radio" name="transmission" value="automatic" checked class="mr-3 text-indigo-600 w-4 h-4">
                        <span class="text-gray-700">Automatic</span>
                    </label>
                    <label class="flex items-center cursor-pointer hover:bg-indigo-50 p-2 rounded-lg transition">
                        <input type="radio" name="transmission" value="manual" class="mr-3 text-indigo-600 w-4 h-4">
                        <span class="text-gray-700">Manual</span>
                    </label>
                </div>
            </div>

            <!-- Car Grid -->
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($cars as $car)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100">
                        <div class="relative h-56 bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 flex items-center justify-center">
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-32 h-32 text-indigo-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            @endif
                            @if($car->isAvailable())
                                <span class="absolute top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">Available</span>
                            @else
                                <span class="absolute top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">Booked</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $car->brand }} {{ $car->model }}</h3>
                            <div class="flex items-baseline mb-4">
                                <span class="text-3xl font-bold text-indigo-600">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500 ml-2">/ day</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $car->description ?? 'Premium car with excellent features' }}</p>
                            <div class="flex gap-2 mb-4 text-xs text-gray-600">
                                <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $car->year }}</span>
                                <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $car->plate_number }}</span>
                            </div>
                            <a href="{{ route('cars.show', $car->id) }}" class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 rounded-xl transition duration-200 shadow-md">
                                View Details →
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-20">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 text-xl">No cars available at the moment</p>
                        <p class="text-gray-400 mt-2">Check back soon for new arrivals!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-12 mt-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">E-RentCar</h3>
                    <p class="text-gray-400">Your trusted partner for premium car rentals</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contact Us</h4>
                    <p class="text-gray-400">Email: info@erentcar.com</p>
                    <p class="text-gray-400">Phone: +62 123 4567 890</p>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
                <p>&copy; 2026 E-RentCar. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
