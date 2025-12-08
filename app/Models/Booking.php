<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'nomor_booking',
        'user_id',
        'kendaraan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'durasi',
        'harga_per_hari',
        'total_harga',
        'catatan',
        'metode_pembayaran',
        'status',
        'status_pembayaran',
        'bukti_pembayaran',
        'tanggal_pembayaran',
        'alasan_pembatalan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_pembayaran' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    // Alias untuk kendaraan -> mobil (TAMBAHAN INI)
    public function mobil()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Menunggu</span>',
            'dikonfirmasi' => '<span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Dikonfirmasi</span>',
            'dalam_perjalanan' => '<span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full">Dalam Perjalanan</span>',
            'selesai' => '<span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Selesai</span>',
            'dibatalkan' => '<span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Dibatalkan</span>',
        ];

        return $badges[$this->status] ?? $this->status;
    }

    // Accessor untuk status pembayaran badge
    public function getStatusPembayaranBadgeAttribute()
    {
        $badges = [
            'belum_bayar' => '<span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Belum Bayar</span>',
            'menunggu_verifikasi' => '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Menunggu Verifikasi</span>',
            'lunas' => '<span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Lunas</span>',
        ];

        return $badges[$this->status_pembayaran] ?? $this->status_pembayaran;
    }

    // Accessor untuk kode booking (alias nomor_booking)
    public function getKodeBookingAttribute()
    {
        return $this->nomor_booking;
    }
}