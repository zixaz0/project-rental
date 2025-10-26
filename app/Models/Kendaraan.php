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
}