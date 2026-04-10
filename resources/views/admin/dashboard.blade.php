<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                <a href="{{ route('admin.dashboard') }}" class="block py-3 px-6 bg-gray-900">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="block py-3 px-6 hover:bg-gray-700">
                    Users
                    @if($stats['pending_users'] > 0)
                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs ml-2">{{ $stats['pending_users'] }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.cars.index') }}" class="block py-3 px-6 hover:bg-gray-700">Cars</a>
                <a href="{{ route('admin.bookings.index') }}" class="block py-3 px-6 hover:bg-gray-700">Bookings</a>
                <a href="{{ route('home') }}" class="block py-3 px-6 hover:bg-gray-700">View Site</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button class="block w-full text-left py-3 px-6 hover:bg-gray-700">Logout</button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <div class="p-8">
                <h1 class="text-3xl font-bold mb-8">Dashboard</h1>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-gray-500 text-sm mb-2">Total Users</div>
                        <div class="text-3xl font-bold">{{ $stats['total_users'] }}</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-gray-500 text-sm mb-2">Pending Approval</div>
                        <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_users'] }}</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-gray-500 text-sm mb-2">Total Cars</div>
                        <div class="text-3xl font-bold">{{ $stats['total_cars'] }}</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-gray-500 text-sm mb-2">Total Bookings</div>
                        <div class="text-3xl font-bold">{{ $stats['total_bookings'] }}</div>
                    </div>
                </div>

                <!-- Pending Users -->
                @if($pending_users->count() > 0)
                <div class="bg-white rounded-lg shadow mb-8">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold">Pending User Approvals</h2>
                    </div>
                    <div class="p-6">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b">
                                    <th class="pb-3">Name</th>
                                    <th class="pb-3">Email</th>
                                    <th class="pb-3">Phone</th>
                                    <th class="pb-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pending_users as $user)
                                <tr class="border-b">
                                    <td class="py-3">{{ $user->name }}</td>
                                    <td class="py-3">{{ $user->email }}</td>
                                    <td class="py-3">{{ $user->phone }}</td>
                                    <td class="py-3">
                                        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">Review</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Recent Bookings -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold">Recent Bookings</h2>
                    </div>
                    <div class="p-6">
                        @if($recent_bookings->count() > 0)
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b">
                                    <th class="pb-3">Booking ID</th>
                                    <th class="pb-3">User</th>
                                    <th class="pb-3">Car</th>
                                    <th class="pb-3">Status</th>
                                    <th class="pb-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_bookings as $booking)
                                <tr class="border-b">
                                    <td class="py-3">{{ $booking->id }}</td>
                                    <td class="py-3">{{ $booking->user->name }}</td>
                                    <td class="py-3">{{ $booking->car->name }}</td>
                                    <td class="py-3">
                                        <span class="px-3 py-1 rounded-full text-sm
                                            @if($booking->booking_status == 'confirmed') bg-green-100 text-green-700
                                            @else bg-yellow-100 text-yellow-700 @endif">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </td>
                                    <td class="py-3">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-gray-500 text-center py-8">No bookings yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
