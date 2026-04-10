<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
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
            <h1 class="text-3xl font-bold mb-8">Add New Car</h1>

            <div class="bg-white rounded-lg shadow p-8 max-w-3xl">
                <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Car Name</label>
                            <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Brand</label>
                            <input type="text" name="brand" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Year</label>
                            <input type="number" name="year" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Plate Number</label>
                            <input type="text" name="plate_number" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Price Per Day</label>
                            <input type="number" name="price_per_day" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">STNK Number</label>
                            <input type="text" name="stnk_number" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">STNK Expired</label>
                            <input type="date" name="stnk_expired_date" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Pajak Expired</label>
                            <input type="date" name="pajak_expired_date" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Color</label>
                            <input type="text" name="warna" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Fuel Type</label>
                            <select name="bahan_bakar" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="Bensin">Bensin</option>
                                <option value="Diesel">Diesel</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Transmission</label>
                            <select name="transmisi" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="Automatic">Automatic</option>
                                <option value="Manual">Manual</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Capacity</label>
                            <input type="number" name="kapasitas_penumpang" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Condition</label>
                            <input type="text" name="kondisi" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Image</label>
                            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                    </div>
                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Car</button>
                        <a href="{{ route('admin.cars.index') }}" class="px-6 py-3 bg-gray-300 rounded-lg hover:bg-gray-400">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
