<!-- FRONTEND COUNTDOWN TIMER EXAMPLE -->
<!-- Add this to your booking confirmation page -->

<div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm text-yellow-700">
                <strong>Payment Timeout:</strong> Complete your payment within 
                <span id="countdown" class="font-bold text-red-600">10:00</span> minutes
            </p>
        </div>
    </div>
</div>

<script>
// Countdown Timer for Payment Expiry
(function() {
    // Get expiry time from backend (Laravel Blade)
    const expiryTime = new Date("{{ $booking->payment_expires_at }}").getTime();
    
    const countdownElement = document.getElementById('countdown');
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = expiryTime - now;
        
        if (distance < 0) {
            countdownElement.innerHTML = "EXPIRED";
            countdownElement.classList.add('text-red-600');
            
            // Show expired message
            alert('Payment time has expired. Your booking has been cancelled.');
            window.location.href = '/user/bookings';
            return;
        }
        
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        countdownElement.innerHTML = 
            String(minutes).padStart(2, '0') + ':' + 
            String(seconds).padStart(2, '0');
        
        // Change color when less than 2 minutes
        if (minutes < 2) {
            countdownElement.classList.add('text-red-600', 'animate-pulse');
        }
    }
    
    // Update every second
    updateCountdown();
    const interval = setInterval(updateCountdown, 1000);
    
    // Clear interval when page unloads
    window.addEventListener('beforeunload', () => clearInterval(interval));
})();
</script>

<!-- Alternative: Progress Bar Style -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-2">
        <h3 class="text-lg font-semibold text-gray-800">Complete Payment</h3>
        <span id="countdown-alt" class="text-2xl font-bold text-blue-600">10:00</span>
    </div>
    
    <div class="w-full bg-gray-200 rounded-full h-2.5">
        <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full transition-all duration-1000" style="width: 100%"></div>
    </div>
    
    <p class="text-sm text-gray-600 mt-2">
        Your booking will be automatically cancelled if payment is not completed within the time limit.
    </p>
</div>

<script>
// Countdown with Progress Bar
(function() {
    const expiryTime = new Date("{{ $booking->payment_expires_at }}").getTime();
    const createdTime = new Date("{{ $booking->CreatedDate ?? now() }}").getTime();
    const totalDuration = expiryTime - createdTime; // 10 minutes in milliseconds
    
    const countdownElement = document.getElementById('countdown-alt');
    const progressBar = document.getElementById('progress-bar');
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = expiryTime - now;
        
        if (distance < 0) {
            countdownElement.innerHTML = "EXPIRED";
            progressBar.style.width = "0%";
            progressBar.classList.remove('bg-blue-600');
            progressBar.classList.add('bg-red-600');
            
            setTimeout(() => {
                alert('Payment time has expired. Your booking has been cancelled.');
                window.location.href = '/user/bookings';
            }, 1000);
            return;
        }
        
        // Update countdown
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        countdownElement.innerHTML = 
            String(minutes).padStart(2, '0') + ':' + 
            String(seconds).padStart(2, '0');
        
        // Update progress bar
        const percentage = (distance / totalDuration) * 100;
        progressBar.style.width = percentage + '%';
        
        // Change color based on time remaining
        if (percentage < 20) {
            progressBar.classList.remove('bg-blue-600', 'bg-yellow-500');
            progressBar.classList.add('bg-red-600');
            countdownElement.classList.add('text-red-600', 'animate-pulse');
        } else if (percentage < 50) {
            progressBar.classList.remove('bg-blue-600');
            progressBar.classList.add('bg-yellow-500');
            countdownElement.classList.add('text-yellow-600');
        }
    }
    
    updateCountdown();
    const interval = setInterval(updateCountdown, 1000);
    
    window.addEventListener('beforeunload', () => clearInterval(interval));
})();
</script>

<!-- Usage in Blade Template -->
<!-- 
In your bookings/create.blade.php or payment page:

@if($booking->payment_expires_at && !$booking->isExpired())
    @include('components.payment-countdown', ['booking' => $booking])
@else
    <div class="bg-red-50 border-l-4 border-red-400 p-4">
        <p class="text-red-700">This booking has expired. Please create a new booking.</p>
    </div>
@endif
-->

<!-- API Endpoint for Real-time Check (Optional) -->
<script>
// Check booking status every 30 seconds
setInterval(async () => {
    try {
        const response = await fetch('/api/bookings/{{ $booking->id }}/status');
        const data = await response.json();
        
        if (data.status === 'cancelled' || data.status === 'expired') {
            alert('Your booking has been cancelled due to payment timeout.');
            window.location.href = '/user/bookings';
        }
    } catch (error) {
        console.error('Error checking booking status:', error);
    }
}, 30000); // Check every 30 seconds
</script>
