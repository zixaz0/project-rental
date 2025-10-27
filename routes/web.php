<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KendaraanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\HargaController;

// ============================================================================
// PUBLIC ROUTES
// ============================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');


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
// ADMIN ROUTES (Auth + Role Admin Only)
// ============================================================================
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        
        // Kendaraan Management
        Route::resource('kendaraan', KendaraanController::class);
        
        // Kategori Management
        Route::resource('kategori', KategoriController::class);

        // Harga Management
        Route::resource('harga', HargaController::class);
    });


// ============================================================================
// CUSTOMER ROUTES (Auth + Role User Only)
// ============================================================================
Route::middleware(['auth', 'role:user'])
    ->name('customer.')
    ->group(function () {
        
        // Profile
        Route::get('/profile', function () {
            return view('customer.profile');
        })->name('profile');
        
        // My Orders/Bookings
        Route::get('/my-orders', function () {
            return view('customer.orders');
        })->name('orders');
    
    });



Route::fallback(function () {
    return redirect()->route('home')->with('error', 'Halaman tidak ditemukan!');
});