# E-RentCar

Aplikasi rental mobil online berbasis Laravel dengan Tailwind CSS.

## Features

### User Features
- ✅ User Registration & Authentication
- ✅ KTP & SIM Verification
- ✅ Car Browsing with Search & Filter
- ✅ Car Booking System with Auto Calculate
- ✅ User Profile Management
- ✅ Booking History
- ⏳ Payment Integration (Midtrans) - Coming Soon
- ⏳ Google SSO Login - Coming Soon

### Admin Features
- ✅ Admin Dashboard with Statistics
- ✅ User Management & Verification (Approve/Reject)
- ✅ Car Management (CRUD with Image Upload)
- ✅ Booking Management
- ⏳ Payment Management - Coming Soon
- ⏳ Reports & Export PDF - Coming Soon

## Tech Stack
- Laravel 12
- PHP 8.5
- MySQL
- Tailwind CSS
- Vite

## Installation

1. Clone repository
```bash
git clone https://github.com/amn26/e-rentcar.git
cd e-rentcar
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database di `.env`
```
DB_DATABASE=e-rentcar
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Run migration & seeder
```bash
php artisan migrate
php artisan db:seed
```

6. Build assets
```bash
npm run build
# atau untuk development
npm run dev
```

7. Run server
```bash
php artisan serve
```

## Default Login Credentials

**Admin:**
- Email: `admin@erentcar.com`
- Password: `admin123`

**User:**
- Email: `user@erentcar.com`
- Password: `user123`

## Database Structure

### Tables
- **users** - User data with KTP/SIM verification
- **cars** - Car inventory with specifications
- **bookings** - Booking transactions
- **payments** - Payment records (coming soon)

### Relationships
- User → Bookings (One to Many)
- Car → Bookings (One to Many)
- Booking → Payment (One to One)

## User Flow

1. User register dengan upload KTP & SIM
2. Admin approve user verification
3. User browse & search mobil
4. User booking mobil (auto calculate price)
5. User payment (coming soon)
6. Admin manage bookings

## Admin Flow

1. Login sebagai admin
2. Dashboard - lihat statistik & pending approvals
3. Approve/reject user verification
4. Manage cars (CRUD)
5. View all bookings
6. Manage payments (coming soon)

## Features Detail

### Search & Filter
- Search by car name or brand
- Filter by transmission (Automatic/Manual)
- Filter by capacity (5/7 seats)
- Sort by price (low to high, high to low)
- Sort by newest

### Booking System
- Select start & end date
- Auto calculate total days
- Auto calculate total price
- Verification status check
- Booking history

### User Profile
- Edit personal information
- Re-upload KTP & SIM
- View verification status
- Status reset on document update

## Project Structure

```
app/
├── Http/Controllers/
│   ├── HomeController.php
│   ├── AuthController.php
│   ├── CarController.php
│   ├── BookingController.php
│   ├── Admin/
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   ├── CarController.php
│   │   └── BookingController.php
│   └── User/
│       └── ProfileController.php
├── Models/
│   ├── User.php
│   ├── Car.php
│   ├── Booking.php
│   └── Payment.php
└── Http/Middleware/
    └── RoleMiddleware.php

resources/views/
├── home.blade.php
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── cars/
│   └── show.blade.php
├── bookings/
│   ├── index.blade.php
│   └── create.blade.php
├── user/
│   └── profile.blade.php
└── admin/
    ├── dashboard.blade.php
    ├── users/
    │   └── index.blade.php
    ├── cars/
    │   ├── index.blade.php
    │   └── create.blade.php
    └── bookings/
        └── index.blade.php
```

## Development Team

Kelompok 3 - Sistem Rental Mobil

## License

This project is for educational purposes.
