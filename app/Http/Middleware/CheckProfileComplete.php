<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk memastikan user sudah lengkapi data sebelum akses halaman tertentu
 * Bisa dipake untuk protect halaman booking, dll
 */
class CheckProfileComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->is_complete) {
            return redirect()->route('profile.complete')
                ->with('warning', 'Silakan lengkapi data diri Anda terlebih dahulu');
        }

        return $next($request);
    }
}

// Cara pakai di routes:
// Route::get('/booking/{id}', [BookingController::class, 'create'])
//     ->middleware(['auth', 'check.profile.complete'])
//     ->name('booking.create');

// Jangan lupa register di app/Http/Kernel.php atau bootstrap/app.php (Laravel 11):
// protected $middlewareAliases = [
//     'check.profile.complete' => \App\Http\Middleware\CheckProfileComplete::class,
// ];