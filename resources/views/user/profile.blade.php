<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">E-RentCar</a>
                <div class="flex gap-4">
                    <a href="{{ route('user.bookings') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">My Bookings</a>
                    <a href="{{ route('user.profile') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold mb-8">My Profile</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow p-8">
                <!-- Verification Status -->
                <div class="mb-6 p-4 rounded-lg
                    @if(auth()->user()->verification_status == 'verified') bg-green-50 border border-green-200
                    @elseif(auth()->user()->verification_status == 'pending') bg-yellow-50 border border-yellow-200
                    @else bg-red-50 border border-red-200 @endif">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold">Verification Status:</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if(auth()->user()->verification_status == 'verified') bg-green-100 text-green-700
                            @elseif(auth()->user()->verification_status == 'pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst(auth()->user()->verification_status) }}
                        </span>
                    </div>
                    @if(auth()->user()->verification_status == 'pending')
                        <p class="text-sm text-gray-600 mt-2">Your documents are being reviewed by admin</p>
                    @endif
                </div>

                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full px-4 py-2 border rounded-lg bg-gray-100">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Phone</label>
                        <input type="text" name="phone" value="{{ auth()->user()->phone }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Address</label>
                        <textarea name="address" rows="3" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ auth()->user()->address }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">KTP Image</label>
                            @if(auth()->user()->ktp_image)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . auth()->user()->ktp_image) }}" target="_blank" class="text-blue-600 hover:underline">View Current KTP</a>
                                </div>
                            @endif
                            <input type="file" name="ktp_image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                            <p class="text-sm text-gray-500 mt-1">Upload new KTP to update (will reset verification)</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">SIM Image</label>
                            @if(auth()->user()->sim_image)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . auth()->user()->sim_image) }}" target="_blank" class="text-blue-600 hover:underline">View Current SIM</a>
                                </div>
                            @endif
                            <input type="file" name="sim_image" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                            <p class="text-sm text-gray-500 mt-1">Upload new SIM to update (will reset verification)</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-bold">
                        Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
