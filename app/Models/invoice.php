<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    protected $fillable = [
        'nomor_invoice',
        'booking_id',
        'user_id',
        'subtotal',
        'denda_keterlambatan',
        'hari_keterlambatan',
        'biaya_tambahan',
        'keterangan_biaya_tambahan',
        'total_invoice',
        'status_pembayaran',
        'tanggal_pembayaran',
        'tanggal_jatuh_tempo'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'denda_keterlambatan' => 'decimal:2',
        'biaya_tambahan' => 'decimal:2',
        'total_invoice' => 'decimal:2',
        'tanggal_pembayaran' => 'datetime',
        'tanggal_jatuh_tempo' => 'datetime',
    ];

    // Relasi
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: Hitung denda otomatis
    public static function hitungDenda($tanggalSelesai, $tanggalPengembalian, $hargaPerHari)
    {
        $selesai = \Carbon\Carbon::parse($tanggalSelesai);
        $kembali = \Carbon\Carbon::parse($tanggalPengembalian);
        
        // Jika telat
        if ($kembali->gt($selesai)) {
            $hariTelat = $kembali->diffInDays($selesai);
            // Denda 50% dari harga per hari
            $dendaPerHari = $hargaPerHari * 0.5;
            $totalDenda = $dendaPerHari * $hariTelat;
            
            return [
                'hari_keterlambatan' => $hariTelat,
                'denda_keterlambatan' => $totalDenda,
            ];
        }
        
        return [
            'hari_keterlambatan' => 0,
            'denda_keterlambatan' => 0,
        ];
    }
}