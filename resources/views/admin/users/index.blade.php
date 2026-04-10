<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
                <a href="{{ route('admin.users.index') }}" class="block py-3 px-6 bg-gray-900">Users</a>
                <a href="{{ route('admin.cars.index') }}" class="block py-3 px-6 hover:bg-gray-700">Cars</a>
                <a href="{{ route('admin.bookings.index') }}" class="block py-3 px-6 hover:bg-gray-700">Bookings</a>
                <a href="{{ route('home') }}" class="block py-3 px-6 hover:bg-gray-700">View Site</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto p-8">
            <h1 class="text-3xl font-bold mb-8">User Management</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow">
                <table class="w-full">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left p-4">Name</th>
                            <th class="text-left p-4">Email</th>
                            <th class="text-left p-4">Phone</th>
                            <th class="text-left p-4">Status</th>
                            <th class="text-left p-4">Documents</th>
                            <th class="text-left p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $user->name }}</td>
                            <td class="p-4">{{ $user->email }}</td>
                            <td class="p-4">{{ $user->phone }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    @if($user->verification_status == 'verified') bg-green-100 text-green-700
                                    @elseif($user->verification_status == 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($user->verification_status) }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($user->ktp_image)
                                    <a href="{{ asset('storage/' . $user->ktp_image) }}" target="_blank" class="text-blue-600 hover:underline mr-2">KTP</a>
                                @endif
                                @if($user->sim_image)
                                    <a href="{{ asset('storage/' . $user->sim_image) }}" target="_blank" class="text-blue-600 hover:underline">SIM</a>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($user->verification_status == 'pending')
                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 mr-2">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Reject</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
