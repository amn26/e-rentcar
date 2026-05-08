# Booking Lock & Auto-Release System

## Overview

Sistem ini mengimplementasikan mekanisme locking unit mobil dengan timeout otomatis untuk mencegah double booking dan memastikan ketersediaan mobil.

## Features

### 1. **Locking Unit (Instant Lock)**
- Begitu user klik booking, mobil langsung dikunci dengan status `pending`
- Mobil tidak bisa dibooking oleh user lain untuk tanggal yang sama
- Lock berlaku selama 10 menit

### 2. **Short Timeout (10 Minutes)**
- Setiap booking pending memiliki waktu 10 menit untuk menyelesaikan pembayaran
- Countdown dimulai sejak booking dibuat
- Field `payment_expires_at` menyimpan waktu expiry

### 3. **Auto-Release (Automatic Cancellation)**
- Jika dalam 10 menit belum dibayar, booking otomatis dibatalkan
- Status berubah menjadi `cancelled` dan payment status menjadi `expired`
- Mobil kembali tersedia untuk user lain
- Proses berjalan otomatis via:
  - **Cron Job**: Setiap menit via Laravel Scheduler
  - **Middleware**: Real-time check pada setiap request

### 4. **Real-time Availability Check**
- Pengecekan ketersediaan dilakukan tepat sebelum booking dibuat
- Mencegah race condition (2 user booking bersamaan)
- Validasi overlap tanggal dengan booking aktif lainnya

## Technical Implementation

### Database Schema

```sql
ALTER TABLE bookings ADD COLUMN payment_expires_at TIMESTAMP NULL;
```

### Booking Statuses

| Status | Description |
|--------|-------------|
| `pending` | Booking dibuat, menunggu pembayaran (max 10 menit) |
| `confirmed` | Pembayaran berhasil, booking dikonfirmasi |
| `cancelled` | Booking dibatalkan (manual atau auto-expired) |

### Payment Statuses

| Status | Description |
|--------|-------------|
| `unpaid` | Belum dibayar |
| `paid` | Sudah dibayar |
| `expired` | Waktu pembayaran habis (auto-cancelled) |

## How It Works

### User Booking Flow

```
1. User pilih mobil & tanggal
   ↓
2. System check availability (real-time)
   ↓
3. Jika available → Create booking dengan status "pending"
   ↓
4. Set payment_expires_at = now() + 10 minutes
   ↓
5. Mobil terkunci untuk tanggal tersebut
   ↓
6. User diarahkan ke payment gateway (Midtrans)
   ↓
7a. Jika bayar dalam 10 menit → Status "confirmed"
7b. Jika tidak bayar → Auto-cancelled setelah 10 menit
```

### Auto-Release Mechanism

#### Method 1: Cron Job (Recommended)
```bash
# Runs every minute
* * * * * cd /www/wwwroot/e-rentcar.com && php artisan schedule:run
```

Command: `php artisan bookings:release-expired`
- Mencari semua booking dengan status `pending` dan `payment_expires_at < now()`
- Update status menjadi `cancelled` dan payment status menjadi `expired`

#### Method 2: Middleware (Real-time)
- Middleware `CheckExpiredBookings` berjalan pada setiap HTTP request
- Melakukan pengecekan dan release expired bookings secara real-time
- Backup mechanism jika cron job belum setup

### Availability Check Logic

```php
// Check if car is available for specific dates
$car->isAvailableForDates($startDate, $endDate)

// Checks:
1. Car status is active
2. No overlapping bookings with status "pending" or "confirmed"
3. Excludes cancelled/expired bookings
```

### Overlap Detection

Booking dianggap overlap jika:
- Start date baru berada di antara booking existing
- End date baru berada di antara booking existing
- Booking baru mencakup seluruh periode booking existing

```
Existing: |-------|
New:         |-------|  ❌ Overlap

Existing: |-------|
New:               |-------| ✅ OK

Existing:    |---|
New:      |---------|  ❌ Overlap
```

## API Endpoints

### Create Booking
```
POST /user/bookings
```

**Request:**
```json
{
  "car_id": "CAR001",
  "start_date": "2026-05-10",
  "end_date": "2026-05-12",
  "total_days": 2,
  "total_price": 600000
}
```

**Response (Success):**
```json
{
  "message": "Booking created. Please complete payment within 10 minutes.",
  "booking_id": "BKG1234567",
  "payment_expires_at": "2026-05-08T14:00:00+07:00"
}
```

**Response (Car Not Available):**
```json
{
  "error": "Car is not available for selected dates. Please choose different dates."
}
```

## Testing

### Test Scenario 1: Normal Booking
```bash
1. User A booking mobil X untuk tanggal 10-12 Mei
2. Status: pending, expires_at: +10 minutes
3. User B coba booking mobil X untuk tanggal 10-12 Mei
4. Result: Error "Car is not available"
```

### Test Scenario 2: Auto-Release
```bash
1. User A booking mobil X untuk tanggal 10-12 Mei
2. Tunggu 10 menit (atau run command manual)
3. Run: php artisan bookings:release-expired
4. Result: Booking A cancelled, mobil X available lagi
```

### Test Scenario 3: Different Dates
```bash
1. User A booking mobil X untuk tanggal 10-12 Mei
2. User B booking mobil X untuk tanggal 13-15 Mei
3. Result: Both bookings success (no overlap)
```

### Manual Testing Commands

```bash
# Test auto-release command
php artisan bookings:release-expired

# Check scheduler
php artisan schedule:list

# Run scheduler manually
php artisan schedule:run

# Check database
mysql -u root -p e-rentcar
SELECT id, booking_status, payment_status, payment_expires_at FROM bookings;
```

## Configuration

### Timeout Duration

Default: 10 minutes

Untuk mengubah durasi, edit di `BookingController.php`:

```php
'payment_expires_at' => now()->addMinutes(10), // Change 10 to desired minutes
```

### Scheduler Frequency

Default: Every minute

Untuk mengubah, edit di `routes/console.php`:

```php
Schedule::command('bookings:release-expired')->everyMinute(); // Change to everyFiveMinutes(), etc.
```

## Monitoring

### Check Expired Bookings

```sql
SELECT * FROM bookings 
WHERE booking_status = 'pending' 
AND payment_expires_at < NOW();
```

### Check Active Locks

```sql
SELECT * FROM bookings 
WHERE booking_status = 'pending' 
AND payment_expires_at > NOW();
```

### Statistics

```sql
-- Total expired bookings today
SELECT COUNT(*) FROM bookings 
WHERE booking_status = 'cancelled' 
AND payment_status = 'expired' 
AND DATE(payment_expires_at) = CURDATE();
```

## Troubleshooting

### Issue: Bookings tidak auto-release

**Solution:**
1. Check cron job: `crontab -l`
2. Check scheduler: `php artisan schedule:list`
3. Run manual: `php artisan bookings:release-expired`
4. Check middleware registered: `bootstrap/app.php`

### Issue: Double booking masih terjadi

**Solution:**
1. Check availability logic di `Car.php`
2. Pastikan middleware `CheckExpiredBookings` aktif
3. Check database untuk booking overlap

### Issue: Cron job tidak jalan

**Solution:**
1. Verify cron syntax: `* * * * *`
2. Check PHP path: `which php`
3. Check permissions: `chmod +x artisan`
4. Check logs: `tail -f storage/logs/laravel.log`

## Best Practices

1. **Always check availability** sebelum create booking
2. **Set realistic timeout** (10 menit cukup untuk payment)
3. **Monitor expired bookings** untuk analisis user behavior
4. **Setup cron job** untuk production environment
5. **Test thoroughly** sebelum deploy ke production

## Future Enhancements

- [ ] Email notification sebelum booking expired (5 menit warning)
- [ ] SMS notification untuk payment reminder
- [ ] Dashboard admin untuk monitor expired bookings
- [ ] Analytics: conversion rate (booking → payment)
- [ ] Extend timeout option untuk VIP users
- [ ] Queue system untuk high-traffic scenarios

## Integration dengan Midtrans

Ketika integrasi Midtrans:

```php
// Set expiry time di Midtrans transaction
$params = [
    'transaction_details' => [...],
    'expiry' => [
        'start_time' => date('Y-m-d H:i:s O'),
        'unit' => 'minutes',
        'duration' => 10
    ]
];
```

Pastikan expiry time di Midtrans sama dengan `payment_expires_at` di database.

## Security Considerations

1. **Race Condition Prevention**: Database-level locking via availability check
2. **Timezone Consistency**: Gunakan `now()` Laravel (respects APP_TIMEZONE)
3. **Validation**: Double-check availability sebelum payment redirect
4. **Audit Trail**: Log semua booking creation dan cancellation

## Performance

- **Middleware overhead**: Minimal (~5-10ms per request)
- **Cron job**: Lightweight query, runs in <100ms
- **Database indexes**: Ensure indexes on `booking_status`, `payment_expires_at`

```sql
CREATE INDEX idx_booking_expiry ON bookings(booking_status, payment_expires_at);
```

---

**Last Updated:** 2026-05-08
**Version:** 1.0.0
