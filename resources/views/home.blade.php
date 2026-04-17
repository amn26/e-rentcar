<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-RentCar - Premium Car Rental</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                <div class="hidden md:flex gap-8 items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
                    <a href="#cars" class="text-gray-700 hover:text-blue-600 font-medium">Cars</a>
                </div>
                <div class="flex gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Admin Dashboard
                            </a>
                        @else
                            <a href="{{ route('user.bookings') }}" class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 font-medium">My Bookings</a>
                        @endif
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50"
                                 style="display: none;">
                                <a href="{{ auth()->user()->isAdmin() ? route('user.profile') : route('user.profile') }}" 
                                   class="block px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    My Profile
                                </a>
                                <hr class="my-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="container mx-auto px-6 py-24 relative">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Rent Your Dream Car Today</h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">Premium cars at affordable prices. Book now and drive with confidence.</p>
                <div class="flex gap-4">
                    <a href="#cars" class="px-8 py-4 bg-white text-blue-600 rounded-lg hover:bg-gray-100 font-bold text-lg shadow-lg">Browse Cars</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Verified Cars</h3>
                    <p class="text-gray-600">All cars are inspected and verified for your safety</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Best Prices</h3>
                    <p class="text-gray-600">Competitive rates with no hidden fees</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Customer support available anytime you need</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cars Section -->
    <section id="cars" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">Available Cars</h2>
                <p class="text-gray-600 text-lg">Choose from our wide selection of premium vehicles</p>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('home') }}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search car or brand..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <select name="transmisi" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="">All Transmission</option>
                                <option value="Automatic" {{ request('transmisi') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="Manual" {{ request('transmisi') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            </select>
                        </div>
                        <div>
                            <select name="kapasitas" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="">All Capacity</option>
                                <option value="5" {{ request('kapasitas') == '5' ? 'selected' : '' }}>5 Seats</option>
                                <option value="7" {{ request('kapasitas') == '7' ? 'selected' : '' }}>7 Seats</option>
                            </select>
                        </div>
                        <div>
                            <select name="sort" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="">Sort By</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Search</button>
                            <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($cars as $car)
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="relative h-56 bg-gradient-to-br from-blue-50 to-gray-100 overflow-hidden">
                        @if($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <svg class="w-24 h-24 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Available</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $car->name }}</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                {{ $car->kapasitas_penumpang }} seats
                            </span>
                            <span>•</span>
                            <span>{{ $car->transmisi }}</span>
                            <span>•</span>
                            <span>{{ $car->year }}</span>
                        </div>
                        <div class="flex items-baseline mb-4">
                            <span class="text-3xl font-bold text-blue-600">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                            <span class="text-gray-500 ml-2">/day</span>
                        </div>
                        <a href="{{ route('cars.show', $car->id) }}" class="block text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold transition">
                            View Details →
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-20">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 text-xl">No cars available at the moment</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Rental Calculator -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-8">Rental Cost Calculator</h2>
                <div class="bg-gray-50 rounded-xl p-8 shadow-lg">
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Select Car</label>
                        <select id="calc-car" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="">Choose a car...</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->price_per_day }}" data-name="{{ $car->name }}">{{ $car->name }} - Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/day</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Start Date</label>
                            <input type="date" id="calc-start" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">End Date</label>
                            <input type="date" id="calc-end" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-6 mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-700">Total Days:</span>
                            <span class="font-bold text-xl" id="calc-days">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Total Price:</span>
                            <span class="font-bold text-2xl text-blue-600" id="calc-total">Rp 0</span>
                        </div>
                    </div>
                    <button onclick="calculateRental()" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-bold">Calculate</button>
                </div>
            </div>
        </div>
    </section>

    <script>
        function calculateRental() {
            const pricePerDay = parseFloat(document.getElementById('calc-car').value);
            const startDate = new Date(document.getElementById('calc-start').value);
            const endDate = new Date(document.getElementById('calc-end').value);
            
            if (!pricePerDay || !startDate || !endDate) {
                alert('Please fill all fields');
                return;
            }
            
            if (endDate <= startDate) {
                alert('End date must be after start date');
                return;
            }
            
            const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
            const total = days * pricePerDay;
            
            document.getElementById('calc-days').textContent = days;
            document.getElementById('calc-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        // Set min date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('calc-start').setAttribute('min', today);
        document.getElementById('calc-end').setAttribute('min', today);
    </script>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-xl font-bold mb-2">E-RentCar</h3>
                    <p class="text-gray-400">Rental Mobil Terpercaya</p>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-gray-400 mb-1">Hubungi Kami:</p>
                    <p class="text-gray-300">📧 info@erentcar.com</p>
                    <p class="text-gray-300">📱 +62 812-3456-7890</p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-6 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; 2026 E-RentCar. Kelompok 3 - Sistem Rental Mobil</p>
            </div>
        </div>
    </footer>
</body>
</html>
