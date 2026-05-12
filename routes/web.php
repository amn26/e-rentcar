<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');

// Midtrans Notification (no auth required)
Route::post('/payment/notification', [App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.notification');

// API for booked dates
Route::get('/api/cars/{id}/booked-dates', [CarController::class, 'getBookedDates']);

// Payment Redirect Routes (must be before {booking} route)
Route::get('/payment/finish', [App\Http\Controllers\PaymentController::class, 'finish'])->name('payment.finish');
Route::get('/payment/unfinish', [App\Http\Controllers\PaymentController::class, 'unfinish'])->name('payment.unfinish');
Route::get('/payment/error', [App\Http\Controllers\PaymentController::class, 'error'])->name('payment.error');

// Payment Show Route
Route::get('/payment/{booking}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// 2FA Routes (outside guest middleware)
Route::get('/totp/verify', [AuthController::class, 'showTOTPVerify'])->name('totp.verify');
Route::post('/totp/verify', [AuthController::class, 'verifyTOTP'])->name('totp.verify.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User Routes (Login Required)
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('user.bookings')->middleware('role:user');
    Route::get('/bookings/create/{car}', [BookingController::class, 'create'])->name('bookings.create')->middleware('role:user');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store')->middleware('role:user');
    Route::get('/bookings/{id}/edit', [BookingController::class, 'edit'])->name('user.bookings.edit')->middleware('role:user');
    Route::put('/bookings/{id}', [BookingController::class, 'update'])->name('user.bookings.update')->middleware('role:user');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('user.bookings.destroy')->middleware('role:user');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('user.bookings.cancel')->middleware('role:user');
    Route::get('/bookings/{id}/receipt', [BookingController::class, 'receipt'])->name('user.bookings.receipt')->middleware('role:user');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/profile/totp-setup', [ProfileController::class, 'setupTOTP'])->name('user.totp.setup');
    Route::post('/profile/totp-enable', [ProfileController::class, 'enableTOTP'])->name('user.totp.enable');
    Route::post('/profile/totp-disable', [ProfileController::class, 'disableTOTP'])->name('user.totp.disable');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::post('/users/{id}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
    Route::post('/users/{id}/reject', [UserController::class, 'reject'])->name('admin.users.reject');
    
    Route::get('/cars', [AdminCarController::class, 'index'])->name('admin.cars.index');
    Route::get('/cars/create', [AdminCarController::class, 'create'])->name('admin.cars.create');
    Route::post('/cars', [AdminCarController::class, 'store'])->name('admin.cars.store');
    Route::get('/cars/{id}/edit', [AdminCarController::class, 'edit'])->name('admin.cars.edit');
    Route::put('/cars/{id}', [AdminCarController::class, 'update'])->name('admin.cars.update');
    Route::delete('/cars/{id}', [AdminCarController::class, 'destroy'])->name('admin.cars.destroy');
    
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
});
