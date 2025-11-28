<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    // Daftar semua booking
    public function index(Request $request)
    {
        $query = Booking::with(['kendaraan', 'user']);

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_booking', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    // Detail booking
    public function show($id)
    {
        $booking = Booking::with(['kendaraan', 'user', 'invoice'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    // Konfirmasi booking (pending -> dikonfirmasi, ubah status kendaraan jadi disewa)
    public function confirm($id)
    {
        try {
            DB::beginTransaction();

            $booking = Booking::with('kendaraan')->findOrFail($id);

            if ($booking->status !== 'pending') {
                return back()->with('error', 'Booking ini tidak dapat dikonfirmasi.');
            }

            // Update booking
            $booking->update([
                'status' => 'dikonfirmasi',
                'status_pembayaran' => 'lunas'
            ]);

            // Update status kendaraan jadi DISEWA
            $booking->kendaraan->harga()->update([
                'status' => 'disewa'
            ]);

            DB::commit();
            return back()->with('success', 'Booking berhasil dikonfirmasi! Status kendaraan diubah menjadi DISEWA.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Mulai perjalanan (dikonfirmasi -> dalam_perjalanan)
    public function startTrip($id)
    {
        try {
            $booking = Booking::findOrFail($id);

            if ($booking->status !== 'dikonfirmasi') {
                return back()->with('error', 'Booking belum dikonfirmasi.');
            }

            $booking->update(['status' => 'dalam_perjalanan']);

            return back()->with('success', 'Perjalanan dimulai!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Selesaikan booking & generate invoice (dalam_perjalanan -> selesai)
    public function complete(Request $request, $id)
    {
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'biaya_tambahan' => 'nullable|numeric|min:0',
            'keterangan_biaya_tambahan' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $booking = Booking::with('kendaraan')->findOrFail($id);

            if ($booking->status !== 'dalam_perjalanan') {
                return back()->with('error', 'Booking belum dalam perjalanan.');
            }

            // Hitung denda jika telat
            $dendaInfo = Invoice::hitungDenda(
                $booking->tanggal_selesai,
                $request->tanggal_pengembalian,
                $booking->harga_per_hari
            );

            // Generate invoice
            $nomorInvoice = 'INV-' . strtoupper(uniqid());
            $subtotal = $booking->total_harga;
            $biayaTambahan = $request->biaya_tambahan ?? 0;
            $totalInvoice = $subtotal + $dendaInfo['denda_keterlambatan'] + $biayaTambahan;

            Invoice::create([
                'nomor_invoice' => $nomorInvoice,
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'subtotal' => $subtotal,
                'denda_keterlambatan' => $dendaInfo['denda_keterlambatan'],
                'hari_keterlambatan' => $dendaInfo['hari_keterlambatan'],
                'biaya_tambahan' => $biayaTambahan,
                'keterangan_biaya_tambahan' => $request->keterangan_biaya_tambahan,
                'total_invoice' => $totalInvoice,
                'status_pembayaran' => 'belum_bayar',
                'tanggal_jatuh_tempo' => Carbon::now()->addDays(7)
            ]);

            // Update booking
            $booking->update(['status' => 'selesai']);

            // Kembalikan status kendaraan jadi TERSEDIA
            $booking->kendaraan->harga()->update([
                'status' => 'tersedia'
            ]);

            DB::commit();

            return redirect()->route('admin.bookings.show', $booking->id)
                ->with('success', 'Booking selesai! Invoice telah dibuat. Status kendaraan dikembalikan ke TERSEDIA.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Batalkan booking
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'alasan_pembatalan' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $booking = Booking::with('kendaraan')->findOrFail($id);

            if (in_array($booking->status, ['selesai', 'dibatalkan'])) {
                return back()->with('error', 'Booking tidak dapat dibatalkan.');
            }

            $booking->update([
                'status' => 'dibatalkan',
                'alasan_pembatalan' => $request->alasan_pembatalan
            ]);

            // Kembalikan status kendaraan jadi TERSEDIA
            $booking->kendaraan->harga()->update([
                'status' => 'tersedia'
            ]);

            DB::commit();
            return back()->with('success', 'Booking berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}