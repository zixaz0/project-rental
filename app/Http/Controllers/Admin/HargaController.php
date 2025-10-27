<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Harga;
use App\Models\Kendaraan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HargaController extends Controller
{
public function index(Request $request)
    {
        $query = Harga::with('kendaraan.kategori');

        // Filter Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('kendaraan', function($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('no_plat', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function($subQ) use ($search) {
                      $subQ->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->whereHas('kendaraan', function($q) use ($request) {
                $q->where('kategori_id', $request->kategori);
            });
        }
        
        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Range Harga
        if ($request->filled('harga_min')) {
            $query->where('harga_per_hari', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_per_hari', '<=', $request->harga_max);
        }

        $harga = $query->latest()->paginate(10);
        
        // TAMBAHKAN INI - Kirim data kategori ke view
        $kategori = Kategori::orderBy('nama')->get();

        return view('admin.harga.index', compact('harga', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil kendaraan yang belum punya harga
        $kendaraan = Kendaraan::whereDoesntHave('harga')->with('kategori')->get();
        
        return view('admin.harga.create', compact('kendaraan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id|unique:harga,kendaraan_id',
            'harga_per_hari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,tidak_tersedia,pending,disewa'
        ], [
            'kendaraan_id.required' => 'Kendaraan harus dipilih',
            'kendaraan_id.exists' => 'Kendaraan tidak valid',
            'kendaraan_id.unique' => 'Kendaraan sudah memiliki harga',
            'harga_per_hari.required' => 'Harga per hari harus diisi',
            'harga_per_hari.numeric' => 'Harga harus berupa angka',
            'harga_per_hari.min' => 'Harga tidak boleh kurang dari 0',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            DB::beginTransaction();

            Harga::create($validated);

            DB::commit();

            return redirect()
                ->route('admin.harga.index')
                ->with('success', 'Data harga berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data harga: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Harga $harga)
    {
        $harga->load('kendaraan.kategori');
        return view('admin.harga.show', compact('harga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Harga $harga)
    {
        $harga->load('kendaraan.kategori');
        return view('admin.harga.edit', compact('harga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Harga $harga)
    {
        $validated = $request->validate([
            'harga_per_hari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,tidak_tersedia,pending,disewa'
        ], [
            'harga_per_hari.required' => 'Harga per hari harus diisi',
            'harga_per_hari.numeric' => 'Harga harus berupa angka',
            'harga_per_hari.min' => 'Harga tidak boleh kurang dari 0',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            DB::beginTransaction();

            $harga->update($validated);

            DB::commit();

            return redirect()
                ->route('admin.harga.index')
                ->with('success', 'Data harga berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data harga: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Harga $harga)
    {
        try {
            DB::beginTransaction();

            $harga->delete();

            DB::commit();

            return redirect()
                ->route('admin.harga.index')
                ->with('success', 'Data harga berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data harga: ' . $e->getMessage());
        }
    }
}