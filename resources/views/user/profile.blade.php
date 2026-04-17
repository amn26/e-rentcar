<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - E-RentCar</title>
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
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}" class="flex items-center gap-2 text-gray-600 hover:text-blue-600 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ auth()->user()->isAdmin() ? 'Back to Dashboard' : 'Back to Home' }}
                </a>
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
            <h1 class="text-4xl md:text-5xl font-bold mb-4">My Profile</h1>
            <p class="text-xl text-blue-100">Manage your account settings</p>
        </div>
    </section>

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-3xl mx-auto">

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

                <!-- 2FA Section -->
                <div class="mt-8 pt-8 border-t">
                    <h2 class="text-xl font-bold mb-6">Security Settings</h2>
                    
                    <!-- Authenticator App (TOTP) -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border-2 border-blue-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg">Two-Factor Authentication</h3>
                                    <p class="text-sm text-gray-600">Google/Microsoft Authenticator</p>
                                </div>
                            </div>
                            @if(auth()->user()->totp_enabled)
                                <form action="{{ route('user.totp.disable') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                                        Disable 2FA
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('user.totp.setup') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                                    Enable 2FA
                                </a>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                @if(auth()->user()->totp_enabled) bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    @if(auth()->user()->totp_enabled)
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    @else
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    @endif
                                </svg>
                                {{ auth()->user()->totp_enabled ? 'Enabled' : 'Disabled' }}
                            </span>
                            @if(auth()->user()->totp_enabled)
                                <span class="text-sm text-green-600 font-medium">✓ Your account is protected</span>
                            @else
                                <span class="text-sm text-orange-600 font-medium">⚠ Enable 2FA for better security</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-12 w-full">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2026 E-RentCar. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
