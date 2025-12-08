<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter dari request
        $tanggal = $request->input('tanggal', date('d M Y'));
        $jam = $request->input('jam', '08:00');
        $durasi = $request->input('durasi', 1);
        
        // Query builder untuk kendaraan
        $query = Kendaraan::with(['kategori', 'harga'])
            ->whereHas('harga', function($q) {
                $q->where('status', 'tersedia');
            });

        // Filter kategori
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter harga
        if ($request->has('harga_min')) {
            $query->whereHas('harga', function($q) use ($request) {
                $q->where('harga_per_hari', '>=', $request->harga_min);
            });
        }

        if ($request->has('harga_max')) {
            $query->whereHas('harga', function($q) use ($request) {
                $q->where('harga_per_hari', '<=', $request->harga_max);
            });
        }

        // Filter kapasitas penumpang
        if ($request->has('kapasitas')) {
            $kapasitas = $request->kapasitas;
            
            if ($kapasitas == '4') {
                $query->where('kapasitas_penumpang', '<=', 4);
            } elseif ($kapasitas == '5-6') {
                $query->whereBetween('kapasitas_penumpang', [5, 6]);
            } elseif ($kapasitas == '>6') {
                $query->where('kapasitas_penumpang', '>', 6);
            }
        }

        // Sorting
        $sortBy = $request->input('sort', 'harga_terendah');
        
        switch ($sortBy) {
            case 'harga_tertinggi':
                $query->join('harga', 'kendaraan.id', '=', 'harga.kendaraan_id')
                      ->orderBy('harga.harga_per_hari', 'desc')
                      ->select('kendaraan.*');
                break;
            case 'terpopuler':
                // Bisa ditambahkan logic untuk popularitas (misal: jumlah booking)
                $query->orderBy('created_at', 'desc');
                break;
            case 'harga_terendah':
            default:
                $query->join('harga', 'kendaraan.id', '=', 'harga.kendaraan_id')
                      ->orderBy('harga.harga_per_hari', 'asc')
                      ->select('kendaraan.*');
                break;
        }

        // Ambil hasil
        $kendaraans = $query->get();

        // Hitung total kendaraan
        $totalKendaraan = $kendaraans->count();

        // Ambil kategori yang unik (tanpa duplikat) dan diurutkan berdasarkan nama
        $kategoris = Kategori::orderBy('nama', 'asc')->get()->unique('nama');

        return view('search', compact('kendaraans', 'totalKendaraan', 'tanggal', 'jam', 'durasi', 'kategoris'));
    }
}