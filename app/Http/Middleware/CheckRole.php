<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek login
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        // Cek role
        if (auth()->user()->role !== $role) {
            // Log attempt (opsional tapi bagus buat security)
            \Log::warning('Unauthorized access attempt', [
                'user_id' => auth()->id(),
                'user_role' => auth()->user()->role,
                'required_role' => $role,
                'url' => $request->url()
            ]);

            // Redirect berdasarkan role user
            $userRole = auth()->user()->role;
            
            if ($userRole === 'owner') {
                return redirect()->route('owner.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
            } elseif ($userRole === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
            } else {
                return redirect()->route('home')
                    ->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        }

        return $next($request);
    }
}