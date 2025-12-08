<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua kategori dan kelompokkan berdasarkan nama
        $kategori = Kategori::orderBy('nama')->get()->groupBy('nama');

        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'jenis' => [
                'required',
                'string',
                'max:500',
                // Jenis hanya harus unique untuk kombinasi nama + jenis yang sama
                Rule::unique('kategori')->where(function ($query) use ($request) {
                    return $query->where('nama', $request->nama);
                })
            ],
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.max' => 'Nama kategori maksimal 100 karakter',
            'jenis.required' => 'Jenis kategori wajib diisi',
            'jenis.max' => 'Jenis maksimal 500 karakter',
            'jenis.unique' => 'Jenis kategori sudah terdaftar untuk kategori ini',
        ]);

        try {
            Kategori::create($validated);
            
            return redirect()
                ->route('admin.kategori.index')
                ->with('success', 'Kategori berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return view('admin.kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'jenis' => [
                'required',
                'string',
                'max:500',
                // Jenis hanya harus unique untuk kombinasi nama + jenis yang sama, kecuali untuk record ini sendiri
                Rule::unique('kategori')
                    ->where(function ($query) use ($request) {
                        return $query->where('nama', $request->nama);
                    })
                    ->ignore($kategori->id)
            ],
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.max' => 'Nama kategori maksimal 100 karakter',
            'jenis.required' => 'Jenis kategori wajib diisi',
            'jenis.max' => 'Jenis maksimal 500 karakter',
            'jenis.unique' => 'Jenis kategori sudah terdaftar untuk kategori ini',
        ]);

        try {
            $kategori->update($validated);
            
            return redirect()
                ->route('admin.kategori.index')
                ->with('success', 'Kategori berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        try {
            // Cek apakah kategori memiliki kendaraan
            if ($kategori->kendaraan()->count() > 0) {
                return redirect()
                    ->route('admin.kategori.index')
                    ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki kendaraan!');
            }

            $kategori->delete();
            
            return redirect()
                ->route('admin.kategori.index')
                ->with('success', 'Kategori berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.kategori.index')
                ->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}