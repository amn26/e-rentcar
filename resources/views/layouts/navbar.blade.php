<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">E-RentCar</a>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="ml-10 flex space-x-4">
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded hover:bg-gray-100">Users</a>
                            <a href="{{ route('admin.cars.index') }}" class="px-3 py-2 rounded hover:bg-gray-100">Cars</a>
                            <a href="{{ route('admin.bookings.index') }}" class="px-3 py-2 rounded hover:bg-gray-100">Bookings</a>
                        </div>
                    @else
                        <div class="ml-10 flex space-x-4">
                            <a href="{{ route('home') }}" class="px-3 py-2 rounded hover:bg-gray-100">Home</a>
                            <a href="{{ route('user.bookings') }}" class="px-3 py-2 rounded hover:bg-gray-100">My Bookings</a>
                            <a href="{{ route('user.profile') }}" class="px-3 py-2 rounded hover:bg-gray-100">Profile</a>
                        </div>
                    @endif
                @endauth
            </div>

            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 text-blue-600 hover:text-blue-800">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Register</a>
                @else
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>
