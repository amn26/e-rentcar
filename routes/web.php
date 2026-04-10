<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User Routes (Login Required) - MIDDLEWARE DISABLED FOR DEVELOPMENT
Route::prefix('user')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('user.bookings');
    Route::get('/bookings/create/{car}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
});

// Admin Routes - MIDDLEWARE DISABLED FOR DEVELOPMENT
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{id}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
    Route::post('/users/{id}/reject', [UserController::class, 'reject'])->name('admin.users.reject');
    
    Route::get('/cars', [AdminCarController::class, 'index'])->name('admin.cars.index');
    Route::get('/cars/create', [AdminCarController::class, 'create'])->name('admin.cars.create');
    Route::post('/cars', [AdminCarController::class, 'store'])->name('admin.cars.store');
    Route::delete('/cars/{id}', [AdminCarController::class, 'destroy'])->name('admin.cars.destroy');
    
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
});
