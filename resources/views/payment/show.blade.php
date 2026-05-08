<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - E-RentCar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="bg-gray-50">
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
            </div>
        </div>
    </nav>

    <section class="py-12">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold mb-2">Complete Your Payment</h1>
                        <p class="text-gray-600">Booking ID: <span class="font-semibold">{{ $booking->id }}</span></p>
                    </div>

                    <!-- Timer -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded mb-6">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-yellow-800">Payment expires in:</p>
                                <p class="text-2xl font-bold text-yellow-900" id="countdown"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="font-bold text-lg mb-4">Car Details</h3>
                            <div class="space-y-2">
                                <p><span class="text-gray-600">Car:</span> <span class="font-semibold">{{ $booking->car->name }}</span></p>
                                <p><span class="text-gray-600">Brand:</span> {{ $booking->car->brand }}</p>
                                <p><span class="text-gray-600">Year:</span> {{ $booking->car->year }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="font-bold text-lg mb-4">Rental Period</h3>
                            <div class="space-y-2">
                                <p><span class="text-gray-600">Start:</span> <span class="font-semibold">{{ $booking->start_date->format('d M Y') }}</span></p>
                                <p><span class="text-gray-600">End:</span> <span class="font-semibold">{{ $booking->end_date->format('d M Y') }}</span></p>
                                <p><span class="text-gray-600">Duration:</span> {{ $booking->total_days }} days</p>
                            </div>
                        </div>
                    </div>

                    <!-- Price Summary -->
                    <div class="bg-blue-50 rounded-xl p-6 mb-8">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-gray-700">Price per day:</span>
                            <span class="font-semibold">Rp {{ number_format($booking->car->price_per_day, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-gray-700">Total days:</span>
                            <span class="font-semibold">{{ $booking->total_days }} days</span>
                        </div>
                        <div class="border-t border-blue-200 pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold">Total Payment:</span>
                                <span class="text-3xl font-bold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods Info -->
                    <div class="mb-8">
                        <h3 class="font-bold text-lg mb-4">Available Payment Methods:</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center">
                                <p class="font-semibold text-sm">QRIS</p>
                            </div>
                            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center">
                                <p class="font-semibold text-sm">Virtual Account</p>
                            </div>
                            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center">
                                <p class="font-semibold text-sm">GoPay</p>
                            </div>
                            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center">
                                <p class="font-semibold text-sm">ShopeePay</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pay Button -->
                    <button id="pay-button" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 rounded-xl hover:from-blue-700 hover:to-blue-800 font-bold text-lg shadow-lg hover:shadow-xl transition-all">
                        Pay Now
                    </button>

                    <p class="text-center text-sm text-gray-500 mt-4">
                        Secure payment powered by Midtrans
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script>
        const payButton = document.getElementById('pay-button');
        const snapToken = '{{ $snapToken }}';
        
        payButton.addEventListener('click', function() {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.href = '{{ route("payment.finish") }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route("payment.unfinish") }}';
                },
                onError: function(result) {
                    window.location.href = '{{ route("payment.error") }}';
                },
                onClose: function() {
                    alert('You closed the payment popup without completing the payment');
                }
            });
        });

        // Countdown timer
        const expiresAt = new Date('{{ $booking->payment_expires_at }}').getTime();
        
        const countdown = setInterval(function() {
            const now = new Date().getTime();
            const distance = expiresAt - now;
            
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('countdown').textContent = minutes + 'm ' + seconds + 's';
            
            if (distance < 0) {
                clearInterval(countdown);
                document.getElementById('countdown').textContent = 'EXPIRED';
                payButton.disabled = true;
                payButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                payButton.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-blue-700');
            }
        }, 1000);
    </script>
</body>
</html>
