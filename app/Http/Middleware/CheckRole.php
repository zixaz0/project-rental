<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            // Kalo bukan role yang sesuai, redirect ke halaman masing-masing
            return auth()->user()->role === 'admin' 
                ? redirect()->route('admin.dashboard')
                : redirect()->route('home');
        }

        return $next($request);
    }
}