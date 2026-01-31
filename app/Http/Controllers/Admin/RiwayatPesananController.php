<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class RiwayatPesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['booking.mobil', 'user'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status pembayaran
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pembayaran', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('dari_tanggal') && $request->dari_tanggal != '') {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->has('sampai_tanggal') && $request->sampai_tanggal != '') {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_invoice', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('booking', function($q) use ($search) {
                      $q->where('kode_booking', 'like', "%{$search}%");
                  });
            });
        }

        $invoices = $query->paginate(20);

        return view('admin.riwayat-pesanan.index', compact('invoices'));
    }

    public function show($id)
    {
        $invoice = Invoice::with(['booking.mobil','user'])
            ->findOrFail($id);

        return view('admin.riwayat-pesanan.show', compact('invoice'));
    }

    public function exportPdf($id)
    {
        $invoice = Invoice::with(['booking.mobil', 'user'])
            ->findOrFail($id);

        $pdf = \PDF::loadView('admin.riwayat-pesanan.pdf', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->nomor_invoice . '.pdf');
    }
}