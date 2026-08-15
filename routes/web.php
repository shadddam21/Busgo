<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\BookingController;

// Public
Route::get('/', [PublicController::class, 'home']);
Route::get('/search', [PublicController::class, 'search']);
Route::get('/bantuan', [PublicController::class, 'bantuan']);

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\CustomerController;

// Customer
Route::prefix('customer')->middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard']);
    Route::get('/orders', [CustomerController::class, 'orders']);
    Route::get('/orders/{order}/ticket', [CustomerController::class, 'ticket'])->name('customer.ticket');
    Route::get('/orders/{order}/ticket/download', [CustomerController::class, 'downloadTicket'])->name('customer.ticket.download');
    Route::get('/profile', [CustomerController::class, 'profile']);
});

// Booking Flow
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/booking/{schedule}', [BookingController::class, 'seat'])->name('booking.seat');
    Route::post('/booking/{schedule}/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('/booking/{schedule}/process', [BookingController::class, 'process'])->name('booking.process');
});

use App\Http\Controllers\AdminController;

// Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // Payments
    Route::get('/payments', [AdminController::class, 'payments']);
    Route::post('/payments/{payment}/verify', [AdminController::class, 'verifyPayment']);
    Route::post('/payments/{payment}/reject', [AdminController::class, 'rejectPayment']);

    // Other pages
    Route::get('/schedules', [AdminController::class, 'schedules']);
    Route::get('/schedules/create', [AdminController::class, 'createSchedule']);
    Route::post('/schedules', [AdminController::class, 'storeSchedule']);
    Route::get('/schedules/{schedule}/edit', [AdminController::class, 'editSchedule']);
    Route::put('/schedules/{schedule}', [AdminController::class, 'updateSchedule']);
    Route::delete('/schedules/{schedule}', [AdminController::class, 'deleteSchedule']);
    Route::get('/orders', [AdminController::class, 'orders']);
    Route::get('/orders/create', [AdminController::class, 'createOrder']);
    Route::post('/orders', [AdminController::class, 'storeOrder']);
    Route::get('/driver-letters', [AdminController::class, 'driverLetters']);
    Route::get('/schedules/{schedule}/surat-jalan', [AdminController::class, 'downloadSuratJalan']);
    Route::get('/cities', [AdminController::class, 'cities']);
    Route::get('/routes', [AdminController::class, 'routes']);
    Route::get('/reports', [AdminController::class, 'reports']);
    Route::get('/users', [AdminController::class, 'users']);
});

use App\Http\Controllers\CheckerController;

// Checker
Route::prefix('checker')->middleware(['auth', 'role:checker'])->group(function () {
    Route::get('/dashboard', [CheckerController::class, 'dashboard']);
    Route::get('/scan', [CheckerController::class, 'scan']);
    Route::post('/scan/process', [CheckerController::class, 'processScan']);
    Route::get('/manifest', [CheckerController::class, 'manifest']);
});
