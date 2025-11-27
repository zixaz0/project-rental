<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\KendaraanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\HargaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\BookingController;

// ============================================================================
// PUBLIC ROUTES
// ============================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/booking/{kendaraan}', [BookingController::class, 'show'])->name('booking.show');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking-success/{booking}', [BookingController::class, 'success'])->name('booking.success');
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('booking.my-bookings');

// ============================================================================
// AUTHENTICATION ROUTES (Guest Only)
// ============================================================================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    
    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});


// ============================================================================
// LOGOUT ROUTE (Authenticated Users)
// ============================================================================
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


// ============================================================================
// PROFILE ROUTES (Authenticated Users - Admin & Customer)
// ============================================================================
Route::middleware(['auth'])->group(function () {
    // Lengkapi data profil
    Route::get('/profile/complete', [ProfileController::class, 'completeProfile'])->name('profile.complete');
    Route::post('/profile/complete', [ProfileController::class, 'storeCompleteProfile'])->name('profile.store.complete');
    
    // Lihat dan edit profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// ============================================================================
// OWNER ROUTES (Auth + Role Owner Only)
// ============================================================================
Route::prefix('owner')
    ->middleware(['auth', 'role:owner'])
    ->name('owner.')
    ->group(function () {
        // Dashboard Owner
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
        
        // Kendaraan Management (nanti bikin controllernya)
        // Route::resource('vehicles', VehicleController::class);
        
        // Booking Management
        // Route::resource('bookings', BookingController::class);
        
        // Customer Management
        // Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        
        // Reports
        // Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        
        // Settings
        // Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    });


// ============================================================================
// ADMIN ROUTES (Auth + Role Admin Only)
// ============================================================================
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Kendaraan Management
        Route::resource('kendaraan', KendaraanController::class);
        
        // Kategori Management
        Route::resource('kategori', KategoriController::class);

        // Harga Management
        Route::resource('harga', HargaController::class);

        // User Management
        Route::resource('users', UserController::class)->only(['index', 'destroy']);
        Route::post('users/{user}/verify', [UserController::class, 'verify'])->name('users.verify');
        Route::post('users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
        Route::post('users/{user}/unverify', [UserController::class, 'unverify'])->name('users.unverify');
        Route::get('users/verification-requests', [UserController::class, 'verificationRequests'])->name('users.verification-requests');
        Route::post('users/bulk-verify', [UserController::class, 'bulkVerify'])->name('users.bulk-verify');
        Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    });


// ============================================================================
// CUSTOMER ROUTES (Auth + Role Customer Only)
// ============================================================================
Route::middleware(['auth', 'role:customer'])
    ->name('customer.')
    ->group(function () {
        // My Orders/Bookings
        Route::get('/my-orders', function () {
            return view('customer.orders');
        })->name('orders');
    });