<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    // Relasi ke Kendaraan
    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }
}