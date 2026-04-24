<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car - E-RentCar</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Users</a>
                    <a href="{{ route('admin.cars.index') }}" class="text-blue-600 font-medium">Cars</a>
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
        <div class="container mx-auto px-6 py-16 relative">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Edit Car</h1>
            <p class="text-xl text-blue-100">Update car information</p>
        </div>
    </section>

    <!-- Content -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6">
            <div class="bg-white rounded-xl shadow-lg p-8 max-w-3xl mx-auto">
                <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Car Name</label>
                            <input type="text" name="name" value="{{ $car->name }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Brand</label>
                            <input type="text" name="brand" value="{{ $car->brand }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Year</label>
                            <input type="number" name="year" value="{{ $car->year }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Plate Number</label>
                            <input type="text" name="plate_number" value="{{ $car->plate_number }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Price Per Day</label>
                            <input type="number" name="price_per_day" value="{{ $car->price_per_day }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">STNK Number</label>
                            <input type="text" name="stnk_number" value="{{ $car->stnk_number }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">STNK Expired</label>
                            <input type="date" name="stnk_expired_date" value="{{ $car->stnk_expired_date }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Pajak Expired</label>
                            <input type="date" name="pajak_expired_date" value="{{ $car->pajak_expired_date }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Color</label>
                            <input type="text" name="warna" value="{{ $car->warna }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Fuel Type</label>
                            <select name="bahan_bakar" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="Bensin" {{ $car->bahan_bakar == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                                <option value="Diesel" {{ $car->bahan_bakar == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Transmission</label>
                            <select name="transmisi" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="Automatic" {{ $car->transmisi == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="Manual" {{ $car->transmisi == 'Manual' ? 'selected' : '' }}>Manual</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Capacity</label>
                            <input type="number" name="kapasitas_penumpang" value="{{ $car->kapasitas_penumpang }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Condition</label>
                            <input type="text" name="kondisi" value="{{ $car->kondisi }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Features & Benefits</label>
                            <textarea name="features" rows="4" placeholder="Air Conditioning&#10;Insurance Included&#10;24/7 Support&#10;Free Cancellation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ $car->features }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Enter each feature on a new line</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Image</label>
                            @if($car->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="h-32 rounded-lg">
                                    <p class="text-sm text-gray-500 mt-1">Current image (leave empty to keep)</p>
                                </div>
                            @endif
                            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                    </div>
                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Update Car</button>
                        <a href="{{ route('admin.cars.index') }}" class="px-6 py-3 bg-gray-300 rounded-lg hover:bg-gray-400 font-medium">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

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
