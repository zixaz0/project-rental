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

        // Statistik
        $totalPendapatan = Invoice::where('status_pembayaran', 'lunas')->sum('total_invoice');
        $totalPending = Invoice::where('status_pembayaran', 'pending')->sum('total_invoice');
        $totalBelumBayar = Invoice::where('status_pembayaran', 'belum_bayar')->sum('total_invoice');

        return view('admin.riwayat-pesanan.index', compact(
            'invoices',
            'totalPendapatan',
            'totalPending',
            'totalBelumBayar'
        ));
    }

    public function show($id)
    {
        $invoice = Invoice::with(['booking.mobil','user'])
            ->findOrFail($id);

        return view('admin.riwayat-pesanan.show', compact('invoice'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:pending,lunas,belum_bayar,dibatalkan'
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->status_pembayaran = $request->status_pembayaran;
        
        if ($request->status_pembayaran == 'lunas') {
            $invoice->tanggal_pembayaran = now();
        }
        
        $invoice->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate!');
    }

    public function exportPdf($id)
    {
        $invoice = Invoice::with(['booking.mobil', 'user'])
            ->findOrFail($id);

        $pdf = \PDF::loadView('admin.riwayat-pesanan.pdf', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->nomor_invoice . '.pdf');
    }
}