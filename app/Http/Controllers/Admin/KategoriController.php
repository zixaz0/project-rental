<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::latest()->get();
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
            'deskripsi' => 'nullable|string|max:500',
        ], [
            'nama.required' => 'Nama kategori wajib diisi',
            'nama.max' => 'Nama kategori maksimal 100 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
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
            'nama' => 'required|string|max:100' . $kategori->id,
            'deskripsi' => 'nullable|string|max:500',
        ], [
            'nama.required' => 'Nama kategori wajib diisi',

            'nama.max' => 'Nama kategori maksimal 100 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
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