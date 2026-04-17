<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Authenticator - E-RentCar</title>
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
                <a href="{{ route('user.profile') }}" class="text-gray-700 hover:text-blue-600 font-medium">← Back to Profile</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Setup Authenticator App</h1>
                    <p class="text-gray-600">Scan QR code with Google Authenticator or Microsoft Authenticator</p>
                </div>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="space-y-6">
                    <!-- Step 1 -->
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h3 class="font-bold text-lg mb-2">Step 1: Scan QR Code</h3>
                        <p class="text-gray-600 mb-4">Open your authenticator app and scan this QR code:</p>
                        <div class="bg-white p-4 rounded-lg border-2 inline-block">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrCodeUrl) }}" alt="QR Code" class="w-48 h-48">
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h3 class="font-bold text-lg mb-2">Step 2: Manual Entry (Optional)</h3>
                        <p class="text-gray-600 mb-2">Or enter this secret key manually:</p>
                        <div class="bg-gray-100 p-4 rounded-lg font-mono text-lg">
                            {{ $user->totp_secret }}
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h3 class="font-bold text-lg mb-2">Step 3: Verify Code</h3>
                        <p class="text-gray-600 mb-4">Enter the 6-digit code from your app:</p>
                        <form action="{{ route('user.totp.enable') }}" method="POST">
                            @csrf
                            <div class="flex gap-4">
                                <input type="text" name="code" maxlength="6" required
                                       class="flex-1 px-4 py-3 border-2 rounded-lg text-center text-2xl tracking-widest font-bold focus:outline-none focus:border-blue-500"
                                       placeholder="000000" pattern="[0-9]{6}">
                                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold">
                                    Enable
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">

                <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                    <h4 class="font-bold mb-2">📱 Recommended Apps:</h4>
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>• Google Authenticator (Android/iOS)</li>
                        <li>• Microsoft Authenticator (Android/iOS)</li>
                        <li>• Authy (Android/iOS/Desktop)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
