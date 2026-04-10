<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-6">
                <h2 class="text-2xl font-bold">Admin Panel</h2>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block py-3 px-6 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="block py-3 px-6 hover:bg-gray-700">Users</a>
                <a href="{{ route('admin.cars.index') }}" class="block py-3 px-6 bg-gray-900">Cars</a>
                <a href="{{ route('admin.bookings.index') }}" class="block py-3 px-6 hover:bg-gray-700">Bookings</a>
                <a href="{{ route('home') }}" class="block py-3 px-6 hover:bg-gray-700">View Site</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold">Car Management</h1>
                <a href="{{ route('admin.cars.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add New Car</a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($cars as $car)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-400 text-6xl">🚗</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-bold mb-2">{{ $car->name }}</h3>
                        <p class="text-gray-600 mb-2">{{ $car->plate_number }}</p>
                        <p class="text-2xl font-bold text-blue-600 mb-4">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/day</p>
                        <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
