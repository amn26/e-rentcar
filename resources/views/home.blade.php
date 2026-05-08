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
    <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="container mx-auto px-6 py-20 md:py-32 relative">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-block bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-semibold mb-6">
                        🚗 Premium Car Rental Service
                    </div>
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">Sewa Mobil Impian Anda dengan Mudah</h1>
                    <p class="text-lg md:text-xl mb-8 text-blue-50 leading-relaxed">Nikmati pengalaman berkendara terbaik dengan armada mobil premium kami. Proses cepat, harga terjangkau, dan layanan 24/7.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#cars" class="px-8 py-4 bg-white text-blue-600 rounded-xl hover:bg-gray-100 font-bold text-lg shadow-2xl transition-all hover:scale-105 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Lihat Mobil
                        </a>
                        @guest
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-xl hover:bg-white hover:text-blue-600 font-bold text-lg transition-all">
                            Daftar Sekarang
                        </a>
                        @endguest
                    </div>
                    <div class="grid grid-cols-3 gap-6 mt-12">
                        <div>
                            <div class="text-3xl font-bold mb-1">{{ $cars->count() }}+</div>
                            <div class="text-blue-100 text-sm">Mobil Tersedia</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-1">100%</div>
                            <div class="text-blue-100 text-sm">Terverifikasi</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-1">24/7</div>
                            <div class="text-blue-100 text-sm">Support</div>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/10 backdrop-blur-sm rounded-3xl transform rotate-6"></div>
                        <div class="relative bg-white/20 backdrop-blur-md rounded-3xl p-8 shadow-2xl">
                            <div class="space-y-4">
                                <div class="flex items-center gap-4 bg-white/90 rounded-xl p-4">
                                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">Proses Cepat</div>
                                        <div class="text-sm text-gray-600">Booking dalam hitungan menit</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 bg-white/90 rounded-xl p-4">
                                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">Aman & Terpercaya</div>
                                        <div class="text-sm text-gray-600">Verifikasi KTP & SIM</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 bg-white/90 rounded-xl p-4">
                                    <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">Harga Terbaik</div>
                                        <div class="text-sm text-gray-600">Tanpa biaya tersembunyi</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Mengapa Memilih Kami?</h2>
                <p class="text-gray-600 text-lg">Layanan terbaik untuk pengalaman rental mobil yang sempurna</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center p-6 rounded-xl hover:shadow-xl transition-all group">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Mobil Terverifikasi</h3>
                    <p class="text-gray-600">Semua mobil telah diinspeksi dan dijamin kondisinya</p>
                </div>
                <div class="text-center p-6 rounded-xl hover:shadow-xl transition-all group">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Harga Terbaik</h3>
                    <p class="text-gray-600">Harga kompetitif tanpa biaya tersembunyi</p>
                </div>
                <div class="text-center p-6 rounded-xl hover:shadow-xl transition-all group">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Support 24/7</h3>
                    <p class="text-gray-600">Layanan pelanggan siap membantu kapan saja</p>
                </div>
                <div class="text-center p-6 rounded-xl hover:shadow-xl transition-all group">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Proses Cepat</h3>
                    <p class="text-gray-600">Booking mudah dan proses verifikasi cepat</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cars Section -->
    <section id="cars" class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Pilihan Mobil Kami</h2>
                <p class="text-gray-600 text-lg">Temukan mobil yang sesuai dengan kebutuhan Anda</p>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-10 border border-gray-100">
                <form method="GET" action="{{ route('home') }}">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                            <input type="date" name="filter_date" value="{{ request('filter_date', $filterDate) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Mobil</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Nama/Brand..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Transmisi</label>
                            <select name="transmisi" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua</option>
                                <option value="Automatic" {{ request('transmisi') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="Manual" {{ request('transmisi') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kapasitas</label>
                            <select name="kapasitas" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua</option>
                                <option value="5" {{ request('kapasitas') == '5' ? 'selected' : '' }}>5 Kursi</option>
                                <option value="7" {{ request('kapasitas') == '7' ? 'selected' : '' }}>7 Kursi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                            <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Default</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga ↑</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga ↓</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 font-semibold transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari
                            </button>
                            <a href="{{ route('home') }}" class="px-4 py-3 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            
            @if(request('filter_date'))
            <div class="mb-6 text-center">
                <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-6 py-3 rounded-xl font-semibold">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    Menampilkan ketersediaan untuk tanggal: {{ \Carbon\Carbon::parse($filterDate)->format('d F Y') }}
                </span>
            </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($cars as $car)
                @php
                    $isAvailable = $car->isAvailableForDate($filterDate);
                @endphp
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group border border-gray-100">
                    <div class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                        @if($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <svg class="w-24 h-24 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                        @endif
                        @if($isAvailable)
                            <div class="absolute top-4 right-4 bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-lg">✓ Available</div>
                        @else
                            <div class="absolute top-4 right-4 bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-lg">✗ Booked</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-gray-800 group-hover:text-blue-600 transition-colors">{{ $car->name }}</h3>
                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 mb-4">
                            <span class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-lg">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                {{ $car->kapasitas_penumpang }} kursi
                            </span>
                            <span class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-lg">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                </svg>
                                {{ $car->transmisi }}
                            </span>
                            <span class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-lg">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                {{ $car->year }}
                            </span>
                        </div>
                        <div class="flex items-baseline mb-5 pb-5 border-b border-gray-200">
                            <span class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                            <span class="text-gray-500 ml-2 font-medium">/hari</span>
                        </div>
                        <a href="{{ route('cars.show', $car->id) }}" class="block text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 font-semibold transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            Lihat Detail
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-20">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 text-xl font-semibold">Belum ada mobil tersedia</p>
                    <p class="text-gray-400 mt-2">Silakan coba lagi nanti</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Rental Calculator -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Kalkulator Biaya Rental</h2>
                    <p class="text-gray-600 text-lg">Hitung estimasi biaya rental mobil Anda</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 shadow-xl border border-blue-100">
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-3 text-lg">Pilih Mobil</label>
                        <select id="calc-car" class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white text-gray-700">
                            <option value="">Pilih mobil...</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->price_per_day }}" data-name="{{ $car->name }}">{{ $car->name }} - Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/hari</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-3 text-lg">Tanggal Mulai</label>
                            <input type="date" id="calc-start" class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-3 text-lg">Tanggal Selesai</label>
                            <input type="date" id="calc-end" class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-6 mb-6 shadow-lg">
                        <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-200">
                            <span class="text-gray-700 font-medium text-lg">Total Hari:</span>
                            <span class="font-bold text-2xl text-gray-800" id="calc-days">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 font-medium text-lg">Total Biaya:</span>
                            <span class="font-bold text-3xl bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent" id="calc-total">Rp 0</span>
                        </div>
                    </div>
                    <button onclick="calculateRental()" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 rounded-xl hover:from-blue-700 hover:to-blue-800 font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Hitung Biaya
                    </button>
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
                alert('Mohon isi semua field');
                return;
            }
            
            if (endDate <= startDate) {
                alert('Tanggal selesai harus setelah tanggal mulai');
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
    <footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white py-10 border-t border-gray-700">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-6">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-7 h-7 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                        </svg>
                        <span class="font-bold text-xl">E-RentCar</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Solusi rental mobil terpercaya untuk perjalanan Anda</p>
                </div>
                <div>
                    <h4 class="font-bold mb-3 text-blue-400">Kontak</h4>
                    <div class="space-y-2 text-gray-300 text-sm">
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            info@erentcar.com
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            +62 812-3456-7890
                        </p>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-3 text-blue-400">Jam Operasional</h4>
                    <div class="space-y-2 text-gray-300 text-sm">
                        <p>Senin - Jumat<br><span class="text-white">08:00 - 20:00</span></p>
                        <p>Sabtu - Minggu<br><span class="text-white">09:00 - 18:00</span></p>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-3 text-blue-400">Ikuti Kami</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 bg-gray-700 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-700 hover:bg-blue-400 rounded-lg flex items-center justify-center transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-700 hover:bg-pink-600 rounded-lg flex items-center justify-center transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-6 flex flex-col md:flex-row justify-between items-center gap-2 text-sm text-gray-400">
                <p>&copy; 2026 E-RentCar. All rights reserved.</p>
                <p>Kelompok 3 - Sistem Rental Mobil</p>
            </div>
        </div>
    </footer>
</body>
</html>
