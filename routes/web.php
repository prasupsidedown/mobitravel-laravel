<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agen\AuthController as AgenAuthController;
use App\Http\Controllers\Agen\DashboardController as AgenDashboardController;
use App\Http\Controllers\Agen\DestinationController as AgenDestinationController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AgentVerificationController;

// Halaman landing
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route dummy untuk mencegah error di landing page
Route::get('/login', function () {
    return redirect()->route('agen.login');
})->name('login');

Route::get('/register', function () {
    return redirect()->route('agen.register');
})->name('register');

// ==============================================
// ROUTE UNTUK AGEN
// ==============================================
Route::prefix('agen')->name('agen.')->group(function () {

    // Auth
    Route::get('/register', [AgenAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AgenAuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AgenAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AgenAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AgenAuthController::class, 'logout'])->name('logout');

    // Dashboard (butuh login)
    Route::middleware(['auth:agent'])->group(function () {
        Route::get('/dashboard', [AgenDashboardController::class, 'index'])->name('dashboard');

        // CRUD Destinasi
        Route::get('/destinations', [AgenDestinationController::class, 'index'])->name('destinations.index');
        Route::get('/destinations/create', [AgenDestinationController::class, 'create'])->name('destinations.create');
        Route::post('/destinations', [AgenDestinationController::class, 'store'])->name('destinations.store');
        Route::get('/destinations/{id}/edit', [AgenDestinationController::class, 'edit'])->name('destinations.edit');
        Route::put('/destinations/{id}', [AgenDestinationController::class, 'update'])->name('destinations.update');
        Route::delete('/destinations/{id}', [AgenDestinationController::class, 'destroy'])->name('destinations.destroy');

        // CRUD Paket Wisata
        Route::resource('tour-packages', App\Http\Controllers\Agen\TourPackageController::class);

        // Upload & hapus foto destinasi
        Route::post('/destinations/{id}/upload-image', [App\Http\Controllers\Agen\DestinationController::class, 'uploadImage'])->name('destinations.upload-image');
        Route::delete('/destinations/image/{id}', [App\Http\Controllers\Agen\DestinationController::class, 'deleteImage'])->name('destinations.delete-image');

        // Booking / Pemesanan
        Route::get('/bookings', [App\Http\Controllers\Agen\BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{id}', [App\Http\Controllers\Agen\BookingController::class, 'show'])->name('bookings.show');
        Route::put('/bookings/{id}/payment', [App\Http\Controllers\Agen\BookingController::class, 'updatePaymentStatus'])->name('bookings.update-payment');
        Route::put('/bookings/{id}/cancel', [App\Http\Controllers\Agen\BookingController::class, 'cancel'])->name('bookings.cancel');

        // Kendaraan
        Route::resource('vehicles', App\Http\Controllers\Agen\VehicleController::class);
        Route::put('/vehicles/{id}/status', [App\Http\Controllers\Agen\VehicleController::class, 'updateStatus'])->name('vehicles.update-status');

        // Profil Agen
        Route::get('/profile', [App\Http\Controllers\Agen\ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [App\Http\Controllers\Agen\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [App\Http\Controllers\Agen\ProfileController::class, 'changePassword'])->name('profile.password');
        Route::post('/profile/upload-logo', [App\Http\Controllers\Agen\ProfileController::class, 'uploadLogo'])->name('profile.upload-logo');
    });
});

// ==============================================
// ROUTE UNTUK ADMIN
// ==============================================
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Manajemen Agen
        Route::get('/agents', [AgentVerificationController::class, 'index'])->name('agents.index');
        Route::get('/agents/{id}', [AgentVerificationController::class, 'show'])->name('agents.show');
        Route::post('/agents/{id}/verify', [AgentVerificationController::class, 'verify'])->name('agents.verify');
        Route::post('/agents/{id}/reject', [AgentVerificationController::class, 'reject'])->name('agents.reject');
        Route::delete('/agents/{id}', [AgentVerificationController::class, 'destroy'])->name('agents.destroy');
        Route::post('/agents/{id}/suspend', [AgentVerificationController::class, 'suspend'])->name('agents.suspend');
        Route::post('/agents/{id}/activate', [AgentVerificationController::class, 'activate'])->name('agents.activate');

        // Manajemen Driver Travel (pakai AgentVerificationController yang sama)
        Route::get('/drivers', [AgentVerificationController::class, 'indexDrivers'])->name('drivers.index');
        Route::get('/drivers/{id}', [AgentVerificationController::class, 'showDriver'])->name('drivers.show');
        Route::post('/drivers/{id}/verify', [AgentVerificationController::class, 'verify'])->name('drivers.verify');
        Route::post('/drivers/{id}/reject', [AgentVerificationController::class, 'reject'])->name('drivers.reject');
        Route::delete('/drivers/{id}', [AgentVerificationController::class, 'destroy'])->name('drivers.destroy');
        Route::post('/drivers/{id}/suspend', [AgentVerificationController::class, 'suspend'])->name('drivers.suspend');
        Route::post('/drivers/{id}/activate', [AgentVerificationController::class, 'activate'])->name('drivers.activate');

        // Manajemen User
        Route::get('/users', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('users.show');
        Route::put('/users/{id}/block', [App\Http\Controllers\Admin\UserManagementController::class, 'block'])->name('users.block');
        Route::put('/users/{id}/activate', [App\Http\Controllers\Admin\UserManagementController::class, 'activate'])->name('users.activate');
        Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('users.destroy');

        // Manajemen Booking
        Route::get('/bookings', [App\Http\Controllers\Admin\BookingManagementController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{id}', [App\Http\Controllers\Admin\BookingManagementController::class, 'show'])->name('bookings.show');
        Route::put('/bookings/{id}/payment', [App\Http\Controllers\Admin\BookingManagementController::class, 'updatePaymentStatus'])->name('bookings.update-payment');
        Route::put('/bookings/{id}/cancel', [App\Http\Controllers\Admin\BookingManagementController::class, 'cancel'])->name('bookings.cancel');
        Route::delete('/bookings/{id}', [App\Http\Controllers\Admin\BookingManagementController::class, 'destroy'])->name('bookings.destroy');
    });
});