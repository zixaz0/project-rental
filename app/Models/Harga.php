<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;

    protected $table = 'harga';

    protected $fillable = [
        'kendaraan_id',
        'harga_per_hari',
        'status',
    ];

    protected $casts = [
        'harga_per_hari' => 'decimal:2',
    ];

    // Relasi ke Kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}