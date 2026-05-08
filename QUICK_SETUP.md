# Quick Setup Guide - Booking Lock System

## ✅ What's Implemented

1. **Database Migration** - Added `payment_expires_at` column to bookings table
2. **Booking Model** - Added expiry check methods and scopes
3. **Car Model** - Added date-based availability check
4. **Booking Controller** - Real-time availability check + 10-minute lock
5. **Console Command** - Auto-release expired bookings
6. **Scheduler** - Run command every minute
7. **Middleware** - Real-time expiry check on every request

## 🚀 Quick Start

### 1. Migration (Already Done)
```bash
php artisan migrate
```

### 2. Setup Cron Job (REQUIRED for Production)

**Option A: cPanel**
```
Command: cd /www/wwwroot/e-rentcar.com && php artisan schedule:run
Frequency: * * * * * (Every minute)
```

**Option B: Linux Terminal**
```bash
crontab -e
# Add this line:
* * * * * cd /www/wwwroot/e-rentcar.com && php artisan schedule:run >> /dev/null 2>&1
```

### 3. Test Manually
```bash
# Test the auto-release command
php artisan bookings:release-expired

# Check scheduler
php artisan schedule:list
```

## 📋 How It Works

### User Flow
```
1. User clicks "Book Now"
   ↓
2. System checks real-time availability
   ↓
3. If available → Create booking (status: pending)
   ↓
4. Set expiry: now() + 10 minutes
   ↓
5. Car is LOCKED for those dates
   ↓
6. User has 10 minutes to pay
   ↓
7a. Paid → Status: confirmed ✅
7b. Not paid → Auto-cancelled after 10 min ❌
```

### Auto-Release Mechanism

**Method 1: Cron Job (Every Minute)**
- Runs: `php artisan bookings:release-expired`
- Finds: All pending bookings where `payment_expires_at < now()`
- Action: Set status to `cancelled` and payment to `expired`

**Method 2: Middleware (Real-time)**
- Runs on every HTTP request
- Same logic as cron job
- Backup if cron not setup

## 🔍 Testing Scenarios

### Test 1: Booking Lock
```
1. User A books Car X (May 10-12)
2. User B tries to book Car X (May 10-12)
3. Result: ❌ "Car is not available for selected dates"
```

### Test 2: Auto-Release
```
1. User A books Car X (May 10-12)
2. Wait 10 minutes (or run: php artisan bookings:release-expired)
3. Result: ✅ Booking cancelled, Car X available again
```

### Test 3: Different Dates (No Overlap)
```
1. User A books Car X (May 10-12)
2. User B books Car X (May 13-15)
3. Result: ✅ Both bookings successful
```

## 📊 Database Check

```sql
-- Check pending bookings with expiry
SELECT id, car_id, booking_status, payment_status, payment_expires_at 
FROM bookings 
WHERE booking_status = 'pending';

-- Check expired bookings
SELECT id, car_id, booking_status, payment_status, payment_expires_at 
FROM bookings 
WHERE payment_expires_at < NOW() AND booking_status = 'pending';
```

## ⚙️ Configuration

### Change Timeout Duration
File: `app/Http/Controllers/BookingController.php`
```php
'payment_expires_at' => now()->addMinutes(10), // Change 10 to desired minutes
```

### Change Scheduler Frequency
File: `routes/console.php`
```php
Schedule::command('bookings:release-expired')->everyMinute(); // or everyFiveMinutes()
```

## 🐛 Troubleshooting

### Bookings not auto-releasing?
```bash
# 1. Check cron job
crontab -l

# 2. Run manually
php artisan bookings:release-expired

# 3. Check middleware
# Should see CheckExpiredBookings in bootstrap/app.php
```

### Double booking still happening?
```bash
# 1. Clear cache
php artisan optimize:clear

# 2. Check availability logic
# File: app/Models/Car.php → isAvailableForDates()

# 3. Check database for overlaps
SELECT * FROM bookings WHERE car_id = 'CAR001' AND booking_status IN ('pending', 'confirmed');
```

## 📝 Files Modified/Created

### Created:
- `database/migrations/2026_05_08_065103_add_payment_expires_at_to_bookings_table.php`
- `app/Console/Commands/ReleaseExpiredBookings.php`
- `app/Http/Middleware/CheckExpiredBookings.php`
- `BOOKING_LOCK_SYSTEM.md` (Full documentation)
- `CRON_SETUP.md` (Cron setup guide)
- `QUICK_SETUP.md` (This file)

### Modified:
- `app/Models/Booking.php` - Added expiry methods
- `app/Models/Car.php` - Added availability check
- `app/Http/Controllers/BookingController.php` - Added real-time check + lock
- `routes/console.php` - Added scheduler
- `bootstrap/app.php` - Registered middleware
- `README.md` - Updated features list

## 🎯 Next Steps

1. ✅ Setup cron job (IMPORTANT!)
2. ✅ Test booking flow
3. ✅ Test auto-release
4. ⏳ Integrate with Midtrans payment
5. ⏳ Add email notification before expiry
6. ⏳ Add countdown timer on frontend

## 📚 Documentation

- **Full Documentation**: `BOOKING_LOCK_SYSTEM.md`
- **Cron Setup**: `CRON_SETUP.md`
- **Quick Setup**: `QUICK_SETUP.md` (this file)

## ✨ Key Features

✅ **Instant Lock** - Car locked immediately on booking
✅ **10-Minute Timeout** - Short window for payment
✅ **Auto-Release** - Automatic cancellation after timeout
✅ **Real-time Check** - Prevents double booking
✅ **Dual Mechanism** - Cron + Middleware for reliability
✅ **Production Ready** - Tested and documented

---

**Status:** ✅ Fully Implemented
**Version:** 1.0.0
**Date:** 2026-05-08
