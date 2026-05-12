# E-RentCar

Aplikasi rental mobil online berbasis Laravel dengan Tailwind CSS dan fitur keamanan modern.

## Features

### User Features
- ✅ User Registration & Authentication
- ✅ Google OAuth Login (SSO)
- ✅ Two-Factor Authentication (TOTP/Authenticator App)
- ✅ KTP & SIM Verification
- ✅ Car Browsing with Search & Filter
- ✅ Car Booking System with Auto Calculate
- ✅ **Booking Lock System (10-minute timeout)**
- ✅ **Real-time Availability Check**
- ✅ **Auto-Release Expired Bookings**
- ✅ **Edit & Cancel Booking (CRUD)**
- ✅ **Soft Delete Booking (IsDeleted flag)**
- ✅ User Profile Management
- ✅ Booking History with Audit Trail
- ✅ **PDF Receipt Download (mPDF)**
- ✅ **Email Notifications**
- ✅ Payment Integration (Midtrans)

### Admin Features
- ✅ **Professional Dashboard with Date Filter (24H/7D/30D/All Time)**
- ✅ Admin Profile Management
- ✅ **User Management (Table View with Audit Fields)**
- ✅ Edit User Data (Modal-based)
- ✅ **Car Management (Table View with Audit Fields)**
- ✅ **Booking Management (Table View with Audit Fields)**
- ✅ **Icon-based Action Buttons (Edit, Delete, Approve, Reject)**
- ✅ Payment Management
- ⏳ Reports & Export PDF - Coming Soon

## Tech Stack
- **Backend**: Laravel 12
- **PHP**: 8.5
- **Database**: MySQL
- **Frontend**: Tailwind CSS
- **Build Tool**: Vite
- **Authentication**: Laravel Socialite (Google OAuth)
- **2FA**: PragmaRX Google2FA (TOTP)
- **PDF**: mPDF (Receipt Generation)
- **Payment**: Midtrans Payment Gateway

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
```env
DB_DATABASE=e-rentcar
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Configure Google OAuth (Optional)
```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://your-domain.com/auth/google/callback
```

6. Configure Midtrans Payment
```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

7. Configure Email (SMTP)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@erentcar.com"
MAIL_FROM_NAME="E-RentCar"
```

**Note for Gmail:**
- Enable 2-Step Verification
- Generate App Password: https://myaccount.google.com/apppasswords
- Use App Password instead of regular password

8. Run migration & seeder
```bash
php artisan migrate
php artisan db:seed
```

8. Create storage link
```bash
php artisan storage:link
```

9. Set storage permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

10. Build assets
```bash
npm run build
# atau untuk development
npm run dev
```

11. Run server
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

## Security Features

### Two-Factor Authentication (2FA)
- TOTP-based authentication menggunakan Google Authenticator, Microsoft Authenticator, atau Authy
- User dapat enable/disable 2FA dari profile
- QR Code untuk easy setup
- Manual secret key entry sebagai alternatif
- Berlaku untuk login normal dan Google OAuth

### Google OAuth Integration
- Single Sign-On dengan akun Google
- Auto-create user jika belum terdaftar
- Tetap memerlukan 2FA jika sudah diaktifkan

### Audit Trail System
- **Auditable Trait** untuk auto-fill audit fields
- Setiap create/update otomatis mencatat:
  - `CreatedBy` - Nama user yang membuat
  - `CreatedDate` - Waktu pembuatan
  - `LastUpdatedBy` - Nama user yang terakhir update
  - `LastUpdatedDate` - Waktu terakhir update
- Berlaku untuk: Cars, Users, Bookings

### Soft Delete System
- Data tidak benar-benar dihapus dari database
- Menggunakan flag `IsDeleted = 1`
- Data tetap tersimpan untuk audit dan history
- Tidak muncul di tampilan user tapi masih bisa diakses admin

## Database Structure

### Tables
- **users** - User data dengan KTP/SIM verification dan TOTP settings
  - `totp_secret` - Secret key untuk TOTP
  - `totp_enabled` - Status 2FA aktif/tidak
  - Audit fields: `CreatedBy`, `CreatedDate`, `LastUpdatedBy`, `LastUpdatedDate`
- **cars** - Car inventory dengan specifications
  - Audit fields: `CreatedBy`, `CreatedDate`, `LastUpdatedBy`, `LastUpdatedDate`
  - `IsDeleted` - Soft delete flag
- **bookings** - Booking transactions
  - `payment_expires_at` - 10-minute payment timeout
  - `snap_token` - Midtrans payment token
  - Audit fields: `CreatedBy`, `CreatedDate`, `LastUpdatedBy`, `LastUpdatedDate`
  - `IsDeleted` - Soft delete flag
- **payments** - Payment records

### Relationships
- User → Bookings (One to Many)
- Car → Bookings (One to Many)
- Booking → Payment (One to One)

## User Flow

1. **Registration**
   - Register dengan email/password atau Google OAuth
   - Upload KTP & SIM untuk verifikasi
   - Tunggu approval dari admin

2. **Login & Security**
   - Login dengan email/password atau Google
   - Jika 2FA aktif, masukkan kode dari authenticator app
   - Setup 2FA dari profile (optional tapi recommended)

3. **Booking**
   - Browse & search mobil
   - Pilih mobil dan tanggal rental
   - System auto-calculate total harga
   - Konfirmasi booking
   - **Payment timeout 10 menit**
   - Bayar via Midtrans (QRIS, VA, E-Wallet)

4. **Manage Booking**
   - **Edit booking** (tanggal, mobil) - hanya pending bookings
   - **Cancel booking** - ubah status jadi cancelled, masih muncul di list
   - **Delete booking** - soft delete, hilang dari list tapi masih di database
   - **Download PDF Receipt** - untuk paid bookings

5. **Profile Management**
   - Edit informasi personal
   - Re-upload KTP/SIM jika perlu
   - Enable/disable 2FA
   - View booking history dengan audit trail

## Admin Flow

1. **Dashboard**
   - **Date filter**: 24 Hours, 7 Days, 30 Days, All Time
   - View statistik (total users, cars, bookings, revenue)
   - Quick access ke pending user approvals
   - Quick access ke pending bookings
   - Recent bookings list

2. **User Management**
   - **Table view** dengan semua data user
   - **Icon buttons**: Edit, Approve, Reject
   - View audit trail (Created By/Date, Last Updated By/Date)
   - Approve/reject user verification
   - Edit user data (nama, email, phone, status)
   - Reset password user

3. **Car Management**
   - **Table view** dengan semua data mobil
   - **Icon buttons**: Edit, Delete
   - View audit trail
   - Add new cars dengan foto
   - Edit car details
   - Soft delete cars

4. **Booking Management**
   - **Table view** dengan semua bookings
   - View audit trail
   - Monitor booking status
   - Monitor payment status

5. **Admin Profile**
   - Edit profile sendiri
   - Change password

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
- **10-minute payment timeout**
- **Booking lock** - mobil tidak bisa dibooking orang lain selama pending
- **Auto-release** - booking expired otomatis dibatalkan
- **Edit booking** - recalculate price, reset payment token
- **Cancel vs Delete**:
  - Cancel: Status jadi cancelled, masih muncul di list
  - Delete: Soft delete (IsDeleted=1), hilang dari list

### Payment System (Midtrans)
- Multiple payment methods: QRIS, Bank Transfer (VA), E-Wallet
- **Unique order_id** dengan timestamp untuk setiap payment attempt
- **Auto-regenerate snap_token** setelah booking di-edit
- Real-time payment notification
- Payment callback handling

### PDF Receipt
- **Professional PDF layout** dengan mPDF
- Auto-download dengan nama `Receipt-{BookingID}.pdf`
- Berisi: Customer info, rental details, payment summary
- Format A4 dengan styling yang rapi

### Email Notifications
- **Booking Confirmation** - Sent when user creates a booking
- **Payment Success** - Sent when payment is completed
- **Booking Cancelled** - Sent when user cancels a booking
- **Verification Approved** - Sent when admin approves user verification
- **Verification Rejected** - Sent when admin rejects user verification
- Professional HTML email templates
- Automatic retry with error logging

### User Profile
- Edit personal information
- Re-upload KTP & SIM
- View verification status
- Status reset on document update
- 2FA management dengan QR Code

### Admin Features
- **Professional dashboard** dengan filter tanggal
- **Table-based views** untuk semua management pages
- **Icon-based actions** (lebih compact dan modern)
- **Audit trail** di semua tabel
- Real-time statistics
- Modal-based user editing (no page reload)

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── AuthController.php (Login, Register, Google OAuth, TOTP)
│   │   ├── CarController.php
│   │   ├── BookingController.php (CRUD + PDF Download)
│   │   ├── PaymentController.php (Midtrans Integration)
│   │   ├── Admin/
│   │   │   ├── DashboardController.php (with Date Filter)
│   │   │   ├── UserController.php (CRUD + Profile)
│   │   │   ├── CarController.php
│   │   │   └── BookingController.php
│   │   └── User/
│   │       └── ProfileController.php (Profile + TOTP Setup)
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/
│   ├── User.php (with TOTP fields + Auditable trait)
│   ├── Car.php (with Auditable trait)
│   ├── Booking.php (with Auditable trait)
│   └── Payment.php
├── Services/
│   ├── TOTPService.php (TOTP generation & verification)
│   ├── MidtransService.php (Payment gateway integration)
│   └── ImageValidator.php
└── Traits/
    └── Auditable.php (Auto-fill audit fields)

resources/views/
├── home.blade.php
├── auth/
│   ├── login.blade.php (Modern design with Google OAuth)
│   ├── register.blade.php (Modern design with file upload)
│   └── totp-verify.blade.php
├── cars/
│   └── show.blade.php
├── bookings/
│   ├── index.blade.php (Table view with audit fields)
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── receipt.blade.php
│   └── receipt-pdf.blade.php (PDF template)
├── payment/
│   └── show.blade.php (Midtrans Snap)
├── user/
│   ├── profile.blade.php
│   └── totp-setup.blade.php (QR Code + Manual Entry)
└── admin/
    ├── dashboard.blade.php (with date filter)
    ├── profile.blade.php
    ├── users/
    │   └── index.blade.php (Table view with icons)
    ├── cars/
    │   ├── index.blade.php (Table view with icons)
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── bookings/
        └── index.blade.php (Table view with audit)

database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 0001_01_01_000003_create_cars_table.php
│   ├── 0001_01_01_000004_create_bookings_table.php
│   ├── 0001_01_01_000005_create_payments_table.php
│   └── 2026_04_17_042933_add_totp_to_users_table.php
└── seeders/
    ├── UserSeeder.php
    └── CarSeeder.php
```

## API Routes

### Public Routes
- `GET /` - Homepage
- `GET /cars/{id}` - Car detail
- `GET /login` - Login page
- `POST /login` - Login process
- `GET /register` - Register page
- `POST /register` - Register process
- `GET /auth/google` - Google OAuth redirect
- `GET /auth/google/callback` - Google OAuth callback

### TOTP Routes
- `GET /totp/verify` - TOTP verification page
- `POST /totp/verify` - TOTP verification process

### User Routes (Auth Required)
- `GET /user/bookings` - User booking history (table view)
- `GET /user/bookings/create/{car}` - Create booking
- `POST /user/bookings` - Store booking
- `GET /user/bookings/{id}/edit` - Edit booking
- `PUT /user/bookings/{id}` - Update booking
- `POST /user/bookings/{id}/cancel` - Cancel booking (status only)
- `DELETE /user/bookings/{id}` - Delete booking (soft delete)
- `GET /user/bookings/{id}/receipt` - View receipt
- `GET /user/bookings/{id}/download-pdf` - Download PDF receipt
- `GET /user/profile` - User profile
- `POST /user/profile` - Update profile
- `GET /user/profile/totp-setup` - TOTP setup page
- `POST /user/profile/totp-enable` - Enable TOTP
- `POST /user/profile/totp-disable` - Disable TOTP

### Payment Routes
- `GET /payment/{booking}` - Payment page (Midtrans Snap)
- `POST /payment/callback` - Midtrans callback

### Admin Routes (Auth + Admin Role Required)
- `GET /admin/dashboard` - Admin dashboard (with date filter)
- `GET /admin/profile` - Admin profile
- `POST /admin/profile` - Update admin profile
- `GET /admin/users` - User management (table view)
- `POST /admin/users/{id}` - Update user
- `POST /admin/users/{id}/approve` - Approve user
- `POST /admin/users/{id}/reject` - Reject user
- `GET /admin/cars` - Car management (table view)
- `GET /admin/cars/create` - Create car form
- `POST /admin/cars` - Store car
- `GET /admin/cars/{id}/edit` - Edit car form
- `PUT /admin/cars/{id}` - Update car
- `DELETE /admin/cars/{id}` - Delete car (soft delete)
- `GET /admin/bookings` - Booking management (table view)

## UI/UX Improvements

### Modern Design
- Gradient backgrounds
- Card-based layouts
- **Table-based data views** (admin pages)
- Smooth transitions and hover effects
- **Icon-based action buttons**
- Professional color scheme (Blue primary)

### Responsive Design
- Mobile-friendly navigation
- Responsive grid layouts
- Touch-friendly buttons
- Optimized for all screen sizes

### User Experience
- Modal-based editing (no page reload)
- **Icon buttons** (Edit, Delete, Approve, Reject, Cancel, Pay, Receipt)
- Clear visual feedback
- Loading states
- Error handling with user-friendly messages
- **Audit trail visibility** (Created By/Date, Last Updated By/Date)
- **Date filter** on dashboard (24H/7D/30D/All Time)

## Development Commands

```bash
# Clear all cache
php artisan optimize:clear

# Clear specific cache
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Build assets
npm run build

# Watch for changes (development)
npm run dev

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Create storage link
php artisan storage:link

# Set permissions
chmod -R 775 storage bootstrap/cache
```

## Troubleshooting

### TOTP Issues
- Pastikan waktu di phone sudah sync (Settings → Date & Time → Auto)
- Delete old entry di authenticator app dan scan ulang
- Tunggu code refresh (setiap 30 detik)

### Google OAuth Issues
- Pastikan Google Client ID dan Secret sudah benar
- Pastikan Redirect URI sudah terdaftar di Google Console
- Check `.env` configuration

### Midtrans Payment Issues
- Pastikan Server Key dan Client Key sudah benar
- Set `MIDTRANS_IS_PRODUCTION=false` untuk testing
- Check callback URL di Midtrans dashboard
- Jika edit booking, snap_token otomatis di-reset

### PDF Generation Issues
- Pastikan folder `storage/app/mpdf` ada dan writable
- Run `chmod -R 775 storage`
- Check mPDF temp directory permissions

### Cache Issues
- Run `php artisan optimize:clear`
- Hard refresh browser (Ctrl+Shift+R)
- Clear browser cache

## Security Best Practices

1. **Enable 2FA** untuk semua akun penting
2. **Gunakan strong password** minimal 8 karakter
3. **Jangan share** TOTP secret key
4. **Backup** TOTP secret key di tempat aman
5. **Regular update** dependencies dengan `composer update`
6. **Monitor audit trail** untuk aktivitas mencurigakan
7. **Review soft deleted data** secara berkala

## Development Team

Kelompok 3 - Sistem Rental Mobil

## License

This project is for educational purposes.

## Changelog

### Version 1.4.0 (2026-05-12)
- ✅ Added Email Notifications System
- ✅ Booking Confirmation Email
- ✅ Payment Success Email
- ✅ Booking Cancellation Email
- ✅ User Verification Status Email (Approved/Rejected)
- ✅ Professional HTML Email Templates
- ✅ SMTP Configuration with Gmail Support

### Version 1.3.0 (2026-05-12)
- ✅ Added Professional Dashboard with Date Filter (24H/7D/30D/All Time)
- ✅ Converted all admin pages to table view
- ✅ Added Audit Trail fields (CreatedBy, CreatedDate, LastUpdatedBy, LastUpdatedDate)
- ✅ Implemented Auditable Trait for auto-fill audit fields
- ✅ Changed all action buttons to icon-based (Edit, Delete, Approve, Reject)
- ✅ Added Soft Delete system for bookings (IsDeleted flag)
- ✅ Separated Cancel and Delete booking functions
- ✅ Added PDF Receipt download with mPDF
- ✅ Fixed payment issue after booking edit (reset snap_token)
- ✅ Added timestamp to Midtrans order_id for uniqueness
- ✅ Improved user booking table view with audit fields

### Version 1.2.0 (2026-04-20)
- ✅ Added Midtrans Payment Integration
- ✅ Added 10-minute payment timeout
- ✅ Added booking lock system
- ✅ Added auto-release expired bookings
- ✅ Added payment callback handling

### Version 1.1.0 (2026-04-17)
- ✅ Added Google OAuth Login
- ✅ Added Two-Factor Authentication (TOTP)
- ✅ Added Admin Profile Management
- ✅ Added User Edit Modal
- ✅ Improved UI/UX with modern design
- ✅ Enhanced security features
- ✅ Fixed Google OAuth TOTP bypass issue

### Version 1.0.0 (2026-01-19)
- ✅ Initial release
- ✅ Basic authentication
- ✅ Car management
- ✅ Booking system
- ✅ User verification

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
```env
DB_DATABASE=e-rentcar
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Configure Google OAuth (Optional)
```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://your-domain.com/auth/google/callback
```

6. Run migration & seeder
```bash
php artisan migrate
php artisan db:seed
```

7. Create storage link
```bash
php artisan storage:link
```

8. Build assets
```bash
npm run build
# atau untuk development
npm run dev
```

9. Run server
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

## Security Features

### Two-Factor Authentication (2FA)
- TOTP-based authentication menggunakan Google Authenticator, Microsoft Authenticator, atau Authy
- User dapat enable/disable 2FA dari profile
- QR Code untuk easy setup
- Manual secret key entry sebagai alternatif
- Berlaku untuk login normal dan Google OAuth

### Google OAuth Integration
- Single Sign-On dengan akun Google
- Auto-create user jika belum terdaftar
- Tetap memerlukan 2FA jika sudah diaktifkan

## Database Structure

### Tables
- **users** - User data dengan KTP/SIM verification dan TOTP settings
  - `totp_secret` - Secret key untuk TOTP
  - `totp_enabled` - Status 2FA aktif/tidak
- **cars** - Car inventory dengan specifications
- **bookings** - Booking transactions
- **payments** - Payment records (coming soon)

### Relationships
- User → Bookings (One to Many)
- Car → Bookings (One to Many)
- Booking → Payment (One to One)

## User Flow

1. **Registration**
   - Register dengan email/password atau Google OAuth
   - Upload KTP & SIM untuk verifikasi
   - Tunggu approval dari admin

2. **Login & Security**
   - Login dengan email/password atau Google
   - Jika 2FA aktif, masukkan kode dari authenticator app
   - Setup 2FA dari profile (optional tapi recommended)

3. **Booking**
   - Browse & search mobil
   - Pilih mobil dan tanggal rental
   - System auto-calculate total harga
   - Konfirmasi booking

4. **Profile Management**
   - Edit informasi personal
   - Re-upload KTP/SIM jika perlu
   - Enable/disable 2FA
   - View booking history

## Admin Flow

1. **Dashboard**
   - View statistik (total users, cars, bookings)
   - Quick access ke pending user approvals

2. **User Management**
   - View semua users
   - Approve/reject user verification
   - Edit user data (nama, email, phone, status)
   - Reset password user

3. **Car Management**
   - Add new cars dengan foto
   - Edit car details
   - Delete cars
   - View car availability

4. **Booking Management**
   - View all bookings
   - Monitor booking status

5. **Admin Profile**
   - Edit profile sendiri
   - Change password

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
- 2FA management

### Admin Features
- Modal-based user editing (no page reload)
- Inline approve/reject buttons
- Real-time statistics
- Professional dashboard UI

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── AuthController.php (Login, Register, Google OAuth, TOTP)
│   │   ├── CarController.php
│   │   ├── BookingController.php
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── UserController.php (CRUD + Profile)
│   │   │   ├── CarController.php
│   │   │   └── BookingController.php
│   │   └── User/
│   │       └── ProfileController.php (Profile + TOTP Setup)
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/
│   ├── User.php (with TOTP fields)
│   ├── Car.php
│   ├── Booking.php
│   └── Payment.php
└── Services/
    └── TOTPService.php (TOTP generation & verification)

resources/views/
├── home.blade.php
├── auth/
│   ├── login.blade.php (Modern design with Google OAuth)
│   ├── register.blade.php (Modern design with file upload)
│   └── totp-verify.blade.php
├── cars/
│   └── show.blade.php
├── bookings/
│   ├── index.blade.php
│   └── create.blade.php
├── user/
│   ├── profile.blade.php
│   └── totp-setup.blade.php (QR Code + Manual Entry)
└── admin/
    ├── dashboard.blade.php
    ├── profile.blade.php
    ├── users/
    │   └── index.blade.php (with edit modal)
    ├── cars/
    │   ├── index.blade.php
    │   └── create.blade.php
    └── bookings/
        └── index.blade.php

database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 0001_01_01_000003_create_cars_table.php
│   ├── 0001_01_01_000004_create_bookings_table.php
│   ├── 0001_01_01_000005_create_payments_table.php
│   └── 2026_04_17_042933_add_totp_to_users_table.php
└── seeders/
    ├── UserSeeder.php
    └── CarSeeder.php
```

## API Routes

### Public Routes
- `GET /` - Homepage
- `GET /cars/{id}` - Car detail
- `GET /login` - Login page
- `POST /login` - Login process
- `GET /register` - Register page
- `POST /register` - Register process
- `GET /auth/google` - Google OAuth redirect
- `GET /auth/google/callback` - Google OAuth callback

### TOTP Routes
- `GET /totp/verify` - TOTP verification page
- `POST /totp/verify` - TOTP verification process

### User Routes (Auth Required)
- `GET /user/bookings` - User booking history
- `GET /user/bookings/create/{car}` - Create booking
- `POST /user/bookings` - Store booking
- `GET /user/profile` - User profile
- `POST /user/profile` - Update profile
- `GET /user/profile/totp-setup` - TOTP setup page
- `POST /user/profile/totp-enable` - Enable TOTP
- `POST /user/profile/totp-disable` - Disable TOTP

### Admin Routes (Auth + Admin Role Required)
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/profile` - Admin profile
- `POST /admin/profile` - Update admin profile
- `GET /admin/users` - User management
- `POST /admin/users/{id}` - Update user
- `POST /admin/users/{id}/approve` - Approve user
- `POST /admin/users/{id}/reject` - Reject user
- `GET /admin/cars` - Car management
- `GET /admin/cars/create` - Create car form
- `POST /admin/cars` - Store car
- `DELETE /admin/cars/{id}` - Delete car
- `GET /admin/bookings` - Booking management

## UI/UX Improvements

### Modern Design
- Gradient backgrounds
- Card-based layouts
- Smooth transitions and hover effects
- Icon integration
- Professional color scheme (Blue primary)

### Responsive Design
- Mobile-friendly navigation
- Responsive grid layouts
- Touch-friendly buttons
- Optimized for all screen sizes

### User Experience
- Modal-based editing (no page reload)
- Inline actions
- Clear visual feedback
- Loading states
- Error handling with user-friendly messages

## Development Commands

```bash
# Clear all cache
php artisan optimize:clear

# Clear specific cache
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Build assets
npm run build

# Watch for changes (development)
npm run dev

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Create storage link
php artisan storage:link
```

## Troubleshooting

### TOTP Issues
- Pastikan waktu di phone sudah sync (Settings → Date & Time → Auto)
- Delete old entry di authenticator app dan scan ulang
- Tunggu code refresh (setiap 30 detik)

### Google OAuth Issues
- Pastikan Google Client ID dan Secret sudah benar
- Pastikan Redirect URI sudah terdaftar di Google Console
- Check `.env` configuration

### Cache Issues
- Run `php artisan optimize:clear`
- Hard refresh browser (Ctrl+Shift+R)
- Clear browser cache

## Security Best Practices

1. **Enable 2FA** untuk semua akun penting
2. **Gunakan strong password** minimal 8 karakter
3. **Jangan share** TOTP secret key
4. **Backup** TOTP secret key di tempat aman
5. **Regular update** dependencies dengan `composer update`

## Development Team

Kelompok 3 - Sistem Rental Mobil

## License

This project is for educational purposes.

## Changelog

### Version 1.1.0 (2026-04-17)
- ✅ Added Google OAuth Login
- ✅ Added Two-Factor Authentication (TOTP)
- ✅ Added Admin Profile Management
- ✅ Added User Edit Modal
- ✅ Improved UI/UX with modern design
- ✅ Enhanced security features
- ✅ Fixed Google OAuth TOTP bypass issue

### Version 1.0.0 (2026-01-19)
- ✅ Initial release
- ✅ Basic authentication
- ✅ Car management
- ✅ Booking system
- ✅ User verification
