<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';

    protected $fillable = [
        'kategori_id',
        'merk',
        'model',
        'tahun',
        'no_plat',
        'warna',
        'transmisi',
        'kapasitas_penumpang',
        'foto',
        'keterangan',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'kapasitas_penumpang' => 'integer',
    ];

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi ke Harga
    public function harga()
    {
        return $this->hasOne(Harga::class);
    }

    // Relasi ke Bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Accessor untuk nama mobil lengkap
    public function getNamaMobilAttribute()
    {
        return "{$this->merk} {$this->model}";
    }

    // Accessor untuk nama mobil dengan tahun
    public function getNamaMobilLengkapAttribute()
    {
        return "{$this->merk} {$this->model} ({$this->tahun})";
    }
}