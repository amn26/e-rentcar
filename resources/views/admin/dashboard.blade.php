<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-RentCar</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-700 font-medium">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Users</a>
                    <a href="{{ route('admin.cars.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Cars</a>
                    <a href="{{ route('admin.bookings.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Bookings</a>
                </div>
                <div class="flex gap-3 items-center">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 hidden md:block">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50" style="display: none;">
                            <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                My Profile
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
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
        <div class="container mx-auto px-6 py-8 relative">
            <h1 class="text-3xl font-bold mb-2">Admin Dashboard</h1>
            <p class="text-blue-100">Manage your rental business efficiently</p>
        </div>
    </section>

    <!-- Statistics Cards -->
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-6">
            <!-- Filter -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Dashboard Overview</h3>
                    <div class="flex gap-2">
                        <button onclick="filterDashboard('24h')" class="filter-btn {{ $filter == '24h' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-300">24 Hours</button>
                        <button onclick="filterDashboard('7d')" class="filter-btn {{ $filter == '7d' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-300">7 Days</button>
                        <button onclick="filterDashboard('30d')" class="filter-btn {{ $filter == '30d' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-300">30 Days</button>
                        <button onclick="filterDashboard('all')" class="filter-btn {{ $filter == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }} px-4 py-2 text-sm font-medium rounded-lg hover:bg-gray-300">All Time</button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-5 gap-4 mb-6">
                <!-- Total Users -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500 hover:shadow-md transition">
                    <div class="flex flex-col">
                        <div class="bg-blue-100 p-2 rounded-lg w-fit mb-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-xs font-medium mb-1">Total Users</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                        <p class="text-xs text-green-600 mt-1">
                            <span class="font-semibold">{{ $stats['verified_users'] }}</span> verified
                        </p>
                    </div>
                </div>

                <!-- Total Cars -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500 hover:shadow-md transition">
                    <div class="flex flex-col">
                        <div class="bg-green-100 p-2 rounded-lg w-fit mb-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-xs font-medium mb-1">Total Cars</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total_cars'] }}</p>
                        <p class="text-xs text-green-600 mt-1">
                            <span class="font-semibold">{{ $stats['available_cars'] }}</span> available
                        </p>
                    </div>
                </div>

                <!-- Total Bookings -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500 hover:shadow-md transition">
                    <div class="flex flex-col">
                        <div class="bg-purple-100 p-2 rounded-lg w-fit mb-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-xs font-medium mb-1">Total Bookings</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total_bookings'] }}</p>
                        <p class="text-xs text-green-600 mt-1">
                            <span class="font-semibold">{{ $stats['active_bookings'] }}</span> active
                        </p>
                    </div>
                </div>

                <!-- Pending Users -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-orange-500 hover:shadow-md transition">
                    <div class="flex flex-col">
                        <div class="bg-orange-100 p-2 rounded-lg w-fit mb-2">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-xs font-medium mb-1">Pending Users</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_users'] }}</p>
                        <p class="text-xs text-orange-600 mt-1">Need approval</p>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-indigo-500 hover:shadow-md transition">
                    <div class="flex flex-col">
                        <div class="bg-indigo-100 p-2 rounded-lg w-fit mb-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-xs font-medium mb-1">Total Revenue</p>
                        <p class="text-xl font-bold text-gray-800">Rp {{ number_format($stats['total_revenue']/1000000, 1) }}M</p>
                        <p class="text-xs text-gray-500 mt-1">Paid bookings</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Data -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                <a href="{{ route('admin.users.index') }}" class="bg-gradient-to-br from-orange-500 to-orange-600 text-white p-4 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-2xl font-bold">{{ $stats['pending_users'] }}</span>
                    </div>
                    <p class="text-xs font-medium opacity-90">Pending Verifications</p>
                </a>

                <a href="{{ route('admin.bookings.index') }}" class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-4 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-2xl font-bold">{{ $stats['pending_bookings'] }}</span>
                    </div>
                    <p class="text-xs font-medium opacity-90">Pending Bookings</p>
                </a>

                <a href="{{ route('admin.cars.index') }}" class="bg-gradient-to-br from-pink-500 to-pink-600 text-white p-4 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-medium opacity-90">Manage Cars</p>
                </a>
            </div>

            <!-- Recent Data -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Pending Verifications -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-4">
                        <h2 class="text-lg font-bold">Pending Verifications</h2>
                        <p class="text-orange-100 text-xs mt-1">Users waiting for approval</p>
                    </div>
                    <div class="p-4">
                        @forelse($pending_users as $user)
                            <div class="flex items-center justify-between py-3 border-b last:border-0">
                                <div>
                                    <p class="font-semibold text-sm text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                                <a href="{{ route('admin.users.index') }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs font-medium">
                                    Review
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-500 text-sm">No pending verifications</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-4">
                        <h2 class="text-lg font-bold">Recent Bookings</h2>
                        <p class="text-purple-100 text-xs mt-1">Latest rental transactions</p>
                    </div>
                    <div class="p-4">
                        @forelse($recent_bookings as $booking)
                            <div class="flex items-center justify-between py-3 border-b last:border-0">
                                <div>
                                    <p class="font-semibold text-sm text-gray-800">{{ $booking->car->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->user->name ?? 'N/A' }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($booking->booking_status == 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->booking_status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($booking->booking_status) }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="text-gray-500 text-sm">No recent bookings</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function filterDashboard(period) {
            // Remove active class from all buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });
            
            // Add active class to clicked button
            event.target.classList.add('active', 'bg-blue-600', 'text-white');
            event.target.classList.remove('bg-gray-200', 'text-gray-700');
            
            // Reload page with filter parameter
            window.location.href = '{{ route("admin.dashboard") }}?filter=' + period;
        }
    </script>

    <!-- Footer -->
    <footer class="bg-gray-900 w-full text-white py-4 mt-12">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-2 text-xs">
                <span class="font-semibold">E-RentCar</span>
                <span class="text-gray-400">info@erentcar.com | +62 812-3456-7890</span>
                <span class="text-gray-400">&copy; 2026 E-RentCar</span>
            </div>
        </div>
    </footer>
</body>
</html>
