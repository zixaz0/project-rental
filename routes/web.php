<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout (authenticated users only)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes (protected)
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Vehicles
    // Route::resource('vehicles', VehicleController::class);
    
    // Orders/Rentals
    // Route::resource('orders', OrderController::class);
    
    // Customers
    // Route::resource('customers', CustomerController::class);
    
    // Reports
    // Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

// Customer Routes (protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('customer.profile');
    })->name('profile');
    
    Route::get('/my-orders', function () {
        return view('customer.orders');
    })->name('orders');
});