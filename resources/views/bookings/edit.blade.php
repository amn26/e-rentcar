<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking - E-RentCar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-day.disabled {
            color: rgba(57,57,57,0.3) !important;
            background: #f3f4f6 !important;
            cursor: not-allowed !important;
        }
        .flatpickr-day.disabled:hover {
            background: #f3f4f6 !important;
            border-color: transparent !important;
        }
    </style>
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
                <a href="{{ route('user.bookings') }}" class="flex items-center gap-2 text-gray-600 hover:text-blue-600 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to My Bookings
                </a>
            </div>
        </div>
    </nav>

    <section class="py-12">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold mb-8">Edit Booking</h1>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-lg p-8">
                    <!-- Car Selection -->
                    <div class="mb-8 pb-8 border-b">
                        <label class="block text-gray-700 font-semibold mb-4">Select Car</label>
                        <select name="car_id" id="car_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-4" required>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}" 
                                    data-price="{{ $car->price_per_day }}"
                                    data-image="{{ $car->image ? asset('storage/' . $car->image) : '' }}"
                                    data-name="{{ $car->name }}"
                                    data-brand="{{ $car->brand }}"
                                    data-year="{{ $car->year }}"
                                    data-transmisi="{{ $car->transmisi }}"
                                    data-kapasitas="{{ $car->kapasitas_penumpang }}"
                                    {{ $car->id == $booking->car_id ? 'selected' : '' }}>
                                    {{ $car->name }} - {{ $car->brand }} (Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/day)
                                </option>
                            @endforeach
                        </select>

                        <!-- Car Preview -->
                        <div class="flex gap-6" id="carPreview">
                            <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                <img id="carImage" src="{{ $booking->car->image ? asset('storage/' . $booking->car->image) : '' }}" alt="" class="w-full h-full object-cover rounded-lg {{ $booking->car->image ? '' : 'hidden' }}">
                                <svg id="carPlaceholder" class="w-16 h-16 text-gray-400 {{ $booking->car->image ? 'hidden' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 id="carName" class="text-2xl font-bold mb-2">{{ $booking->car->name }}</h2>
                                <p id="carDetails" class="text-gray-600 mb-1">{{ $booking->car->brand }} • {{ $booking->car->year }}</p>
                                <p id="carSpecs" class="text-gray-600 mb-1">{{ ucfirst($booking->car->transmisi) }} • {{ $booking->car->kapasitas_penumpang }} Seats</p>
                                <p id="carPrice" class="text-2xl font-bold text-blue-600 mt-2">Rp {{ number_format($booking->car->price_per_day, 0, ',', '.') }}/day</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('user.bookings.update', $booking->id) }}" method="POST" id="bookingForm">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="car_id" id="selectedCarId" value="{{ $booking->car_id }}">
                        
                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Start Date</label>
                                <input type="text" name="start_date" id="start_date" 
                                    value="{{ $booking->start_date->format('Y-m-d') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                    placeholder="Select start date" readonly required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">End Date</label>
                                <input type="text" name="end_date" id="end_date" 
                                    value="{{ $booking->end_date->format('Y-m-d') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                    placeholder="Select end date" readonly required>
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded-lg p-6 mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700 font-semibold">Total Days:</span>
                                <span id="totalDays" class="text-2xl font-bold text-blue-600">{{ $booking->total_days }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-semibold">Total Price:</span>
                                <span id="totalPrice" class="text-2xl font-bold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <input type="hidden" name="total_days" id="totalDaysInput" value="{{ $booking->total_days }}">
                        <input type="hidden" name="total_price" id="totalPriceInput" value="{{ $booking->total_price }}">

                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold transition">
                                Update Booking
                            </button>
                            <a href="{{ route('user.bookings') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 font-semibold transition text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        let pricePerDay = {{ $booking->car->price_per_day }};
        let currentCarId = '{{ $booking->car_id }}';
        let bookedDates = [];
        let startDatePicker, endDatePicker;

        // Car selection change
        document.getElementById('car_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            currentCarId = this.value;
            pricePerDay = parseInt(selectedOption.dataset.price);
            
            // Update hidden input
            document.getElementById('selectedCarId').value = currentCarId;
            
            // Update preview
            const image = selectedOption.dataset.image;
            const carImage = document.getElementById('carImage');
            const carPlaceholder = document.getElementById('carPlaceholder');
            
            if (image) {
                carImage.src = image;
                carImage.classList.remove('hidden');
                carPlaceholder.classList.add('hidden');
            } else {
                carImage.classList.add('hidden');
                carPlaceholder.classList.remove('hidden');
            }
            
            document.getElementById('carName').textContent = selectedOption.dataset.name;
            document.getElementById('carDetails').textContent = selectedOption.dataset.brand + ' • ' + selectedOption.dataset.year;
            document.getElementById('carSpecs').textContent = selectedOption.dataset.transmisi.charAt(0).toUpperCase() + selectedOption.dataset.transmisi.slice(1) + ' • ' + selectedOption.dataset.kapasitas + ' Seats';
            document.getElementById('carPrice').textContent = 'Rp ' + parseInt(selectedOption.dataset.price).toLocaleString('id-ID') + '/day';
            
            // Fetch booked dates for new car
            fetchBookedDates();
        });

        function fetchBookedDates() {
            fetch(`{{ url('/api/cars') }}/${currentCarId}/booked-dates?exclude={{ $booking->id }}`)
                .then(response => response.json())
                .then(data => {
                    bookedDates = data;
                    updateDatePickers();
                    calculateTotal();
                })
                .catch(error => {
                    console.error('Error fetching booked dates:', error);
                    bookedDates = [];
                    updateDatePickers();
                });
        }

        function updateDatePickers() {
            if (startDatePicker) startDatePicker.destroy();
            if (endDatePicker) endDatePicker.destroy();

            startDatePicker = flatpickr("#start_date", {
                minDate: "today",
                dateFormat: "Y-m-d",
                defaultDate: "{{ $booking->start_date->format('Y-m-d') }}",
                disable: bookedDates,
                onChange: function(selectedDates, dateStr) {
                    endDatePicker.set('minDate', dateStr);
                    calculateTotal();
                }
            });

            endDatePicker = flatpickr("#end_date", {
                minDate: "{{ $booking->start_date->format('Y-m-d') }}",
                dateFormat: "Y-m-d",
                defaultDate: "{{ $booking->end_date->format('Y-m-d') }}",
                disable: bookedDates,
                onChange: function() {
                    calculateTotal();
                }
            });
        }

        function calculateTotal() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                
                if (end > start) {
                    const diffTime = Math.abs(end - start);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    const totalPrice = diffDays * pricePerDay;
                    
                    document.getElementById('totalDays').textContent = diffDays;
                    document.getElementById('totalPrice').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
                    document.getElementById('totalDaysInput').value = diffDays;
                    document.getElementById('totalPriceInput').value = totalPrice;
                }
            }
        }

        // Initialize
        fetchBookedDates();
    </script>
</body>
</html>
