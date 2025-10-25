<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Pastikan hanya admin yang bisa akses
        $this->middleware('auth');
        // $this->middleware('role:admin'); // Uncomment kalau pakai role middleware
    }

    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Nanti bisa ambil data dari database
        // $totalVehicles = Vehicle::count();
        // $activeRentals = Rental::where('status', 'active')->count();
        // $customers = User::where('role', 'customer')->count();
        // $monthlyRevenue = Rental::whereMonth('created_at', now()->month)->sum('total_price');
        
        return view('admin.dashboard');
    }
}