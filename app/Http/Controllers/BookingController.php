<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kendaraan;
use App\Models\Harga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tampilkan form booking
    public function show($kendaraanId)
    {
        Carbon::setLocale('id');
        
        $kendaraan = Kendaraan::with('harga')->findOrFail($kendaraanId);
        
        // Ambil dari URL / query
        $tanggal = request('tanggal', date('Y-m-d'));
        $jam = request('jam', '08:00');

        // Durasi *HARUS* jadi integer
        $durasi = (int) request('durasi', 1);
        
        // Hitung tanggal selesai
        $tanggalMulai = Carbon::parse($tanggal);
        $tanggalSelesai = $tanggalMulai->copy()->addDays($durasi);

        // Hitung total harga
        $hargaPerHari = $kendaraan->harga->harga_per_hari;
        $totalHarga = $hargaPerHari * $durasi;
        
        return view('booking.show', compact(
            'kendaraan',
            'tanggal',
            'jam',
            'durasi',
            'tanggalMulai',
            'tanggalSelesai',
            'hargaPerHari',
            'totalHarga'
        ));
    }
    // Proses booking
    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'durasi' => 'required|integer|min:1',
            'alamat_penjemputan' => 'required|string|max:500',
            'metode_pembayaran' => 'required|in:transfer,cash',
            'catatan' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Generate nomor booking
            $nomorBooking = 'BKG-' . strtoupper(uniqid());

            // Ambil data kendaraan
            $kendaraan = Kendaraan::with('harga')->findOrFail($request->kendaraan_id);
            
            // Cek ketersediaan
            if ($kendaraan->harga->status !== 'tersedia') {
                return back()->with('error', 'Maaf, kendaraan tidak tersedia saat ini.');
            }

            // Hitung tanggal selesai
            $tanggalMulai = Carbon::parse($request->tanggal_mulai);
            $tanggalSelesai = $tanggalMulai->copy()->addDays((int)$request->durasi);

            // Hitung total harga
            $hargaPerHari = $kendaraan->harga->harga_per_hari;
            $totalHarga = $hargaPerHari * $request->durasi;

            // Cek overlap booking
            $overlap = Booking::where('kendaraan_id', $request->kendaraan_id)
                ->where('status', '!=', 'dibatalkan')
                ->where('status', '!=', 'selesai')
                ->where(function($query) use ($tanggalMulai, $tanggalSelesai) {
                    $query->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalSelesai])
                          ->orWhereBetween('tanggal_selesai', [$tanggalMulai, $tanggalSelesai])
                          ->orWhere(function($q) use ($tanggalMulai, $tanggalSelesai) {
                              $q->where('tanggal_mulai', '<=', $tanggalMulai)
                                ->where('tanggal_selesai', '>=', $tanggalSelesai);
                          });
                })
                ->exists();

            if ($overlap) {
                return back()->with('error', 'Maaf, kendaraan sudah dibooking untuk tanggal tersebut.');
            }

            // Buat booking
            $booking = Booking::create([
                'nomor_booking' => $nomorBooking,
                'user_id' => Auth::id(),
                'kendaraan_id' => $request->kendaraan_id,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'jam_mulai' => $request->jam_mulai,
                'durasi' => $request->durasi,
                'harga_per_hari' => $hargaPerHari,
                'total_harga' => $totalHarga,
                'alamat_penjemputan' => $request->alamat_penjemputan,
                'catatan' => $request->catatan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'pending',
                'status_pembayaran' => 'belum_bayar'
            ]);

            // Update status kendaraan jadi pending
            $kendaraan->harga()->update([
                'status' => 'pending'
            ]);

            DB::commit();

            return redirect()->route('booking.success', $booking->id)
                ->with('success', 'Booking berhasil dibuat! Silakan datang ke tempat rental untuk pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Halaman sukses booking
    public function success($bookingId)
    {
        $booking = Booking::with(['kendaraan', 'user'])
            ->where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('booking.success', compact('booking'));
    }

    // Daftar booking user
    public function myBookings()
    {
        $bookings = Booking::with(['kendaraan'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('booking.my-bookings', compact('bookings'));
    }

    // Detail booking
    public function detail($bookingId)
    {
        $booking = Booking::with(['kendaraan', 'user'])
            ->where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('booking.detail', compact('booking'));
    }

    // Cancel booking
    public function cancel(Request $request, $bookingId)
    {
        $request->validate([
            'alasan_pembatalan' => 'required|string|max:500'
        ]);

        $booking = Booking::where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Hanya bisa cancel jika status pending atau dikonfirmasi
        if (!in_array($booking->status, ['pending', 'dikonfirmasi'])) {
            return back()->with('error', 'Booking tidak dapat dibatalkan.');
        }

        DB::beginTransaction();
        try {
            $booking->update([
                'status' => 'dibatalkan',
                'alasan_pembatalan' => $request->alasan_pembatalan
            ]);

            // Kembalikan status kendaraan jadi tersedia
            $booking->kendaraan->harga()->update([
                'status' => 'tersedia'
            ]);

            DB::commit();
            return back()->with('success', 'Booking berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membatalkan booking.');
        }
    }
}