<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'E-RentCar' }}</title>
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
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="hidden md:flex gap-8 items-center">
                            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }} font-medium">Dashboard</a>
                            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }} font-medium">Users</a>
                            <a href="{{ route('admin.cars.index') }}" class="{{ request()->routeIs('admin.cars.*') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }} font-medium">Cars</a>
                            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }} font-medium">Bookings</a>
                        </div>
                    @else
                        <div class="hidden md:flex gap-8 items-center">
                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }} font-medium">Home</a>
                            <a href="{{ route('user.bookings') }}" class="{{ request()->routeIs('user.bookings') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }} font-medium">My Bookings</a>
                            <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }} font-medium">Profile</a>
                        </div>
                    @endif
                @else
                    <div class="hidden md:flex gap-8 items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
                        <a href="#cars" class="text-gray-700 hover:text-blue-600 font-medium">Cars</a>
                        <a href="#about" class="text-gray-700 hover:text-blue-600 font-medium">About</a>
                        <a href="#contact" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a>
                    </div>
                @endauth

                <div class="flex gap-3 items-center">
                    @auth
                        <span class="text-gray-700 font-medium hidden md:block">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button class="px-5 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{ $slot }}

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2026 E-RentCar. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
