<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\TourPackageController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\TravelDriverController; // ← BARU

// ==============================================
// PUBLIC ROUTES (tanpa login)
// ==============================================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Destinasi
Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/{id}', [DestinationController::class, 'show']);
Route::get('/categories', [DestinationController::class, 'categories']);

// Paket Wisata
Route::get('/tour-packages', [TourPackageController::class, 'index']);
Route::get('/tour-packages/{id}', [TourPackageController::class, 'show']);
Route::get('/tour-packages/{id}/check-availability', [TourPackageController::class, 'checkAvailability']);

// Kendaraan    
Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']);

// ─── BARU: Travel Driver (publik) ─────────────────────────────────────────
Route::get('/travel-drivers', [TravelDriverController::class, 'index']);
Route::get('/travel-drivers/{id}', [TravelDriverController::class, 'show']);
Route::post('/travel-drivers/register', [TravelDriverController::class, 'register']);

// ==============================================
// PROTECTED ROUTES (pakai token)
// ==============================================
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    
    // Booking
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/my-bookings', [BookingController::class, 'myBookings']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::delete('/bookings/{id}/cancel', [BookingController::class, 'cancel']);

    Route::get('/my-bookings', [BookingController::class, 'myBookings']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{bookingCode}/payment', [BookingController::class, 'getPayment']);
    Route::post('/bookings/{bookingCode}/confirm-payment', [BookingController::class, 'confirmPayment']);
    Route::delete('/bookings/{id}', [BookingController::class, 'cancel']);

    // ─── BARU: Driver update ketersediaan dirinya sendiri ─────────────────
    Route::patch('/travel-drivers/{id}/availability', [TravelDriverController::class, 'updateAvailability']);
});