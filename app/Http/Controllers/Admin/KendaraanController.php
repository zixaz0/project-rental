<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Kategori;
use App\Models\Harga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kendaraan::with(['kategori', 'harga']);

    // Filter Search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('merk', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%")
              ->orWhere('no_plat', 'like', "%{$search}%");
        });
    }

    // Filter Kategori
    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    // Filter Transmisi
    if ($request->filled('transmisi')) {
        $query->where('transmisi', $request->transmisi);
    }

    $kendaraan = $query->paginate(10);
    $kategori = Kategori::all();

    return view('admin.kendaraan.index', compact('kendaraan', 'kategori'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.kendaraan.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        // Validasi input (HANYA DATA KENDARAAN)
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'no_plat' => 'required|string|unique:kendaraan,no_plat',
            'warna' => 'required|string|max:50',
            'transmisi' => 'required|string',
            'kapasitas_penumpang' => 'required|integer|min:1|max:50',
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'keterangan' => 'nullable|string',
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
            'merk.required' => 'Merk kendaraan wajib diisi',
            'model.required' => 'Model kendaraan wajib diisi',
            'tahun.required' => 'Tahun pembuatan wajib diisi',
            'tahun.min' => 'Tahun tidak valid',
            'tahun.max' => 'Tahun tidak valid',
            'no_plat.required' => 'Nomor plat wajib diisi',
            'no_plat.unique' => 'Nomor plat sudah terdaftar',
            'warna.required' => 'Warna kendaraan wajib diisi',
            'kapasitas_penumpang.required' => 'Kapasitas penumpang wajib diisi',
            'transmisi.required' => 'Transmisi kendaraan wajib diisi',
            'kapasitas_penumpang.min' => 'Kapasitas minimal 1 orang',
            'kapasitas_penumpang.max' => 'Kapasitas maksimal 50 orang',
            'foto.required' => 'Foto kendaraan wajib diupload',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus JPEG, JPG, atau PNG',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

           try {
        // Upload foto ke storage/app/public/kendaraan
            if ($request->hasFile('foto')) {
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $namaFile = time() . '_' . $foto->getClientOriginalName();
                $tujuanUpload = public_path('uploads/kendaraan');

                // pastikan foldernya ada
                if (!file_exists($tujuanUpload)) {
                    mkdir($tujuanUpload, 0777, true);
                }

                // pindahkan file
                $foto->move($tujuanUpload, $namaFile);

                // simpan path relatif ke database
                $fotoPath = 'uploads/kendaraan/' . $namaFile;
            }
        }

        // Simpan data kendaraan
        $kendaraan = Kendaraan::create([
            'kategori_id' => $validated['kategori_id'],
            'merk' => $validated['merk'],
            'model' => $validated['model'],
            'tahun' => $validated['tahun'],
            'no_plat' => strtoupper($validated['no_plat']),
            'warna' => $validated['warna'],
            'transmisi' => $validated['transmisi'],
            'kapasitas_penumpang' => $validated['kapasitas_penumpang'],
            'foto' => $fotoPath,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan!');

    } catch (\Exception $e) {
        // Hapus foto jika ada error
        if (isset($fotoPath)) {
            Storage::disk('public')->delete($fotoPath);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Gagal menambahkan kendaraan: ' . $e->getMessage());
    }
    }

    public function edit($id)
    {
        $kendaraan = Kendaraan::with('harga')->findOrFail($id);
        $kategori = Kategori::all();
        return view('admin.kendaraan.edit', compact('kendaraan', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        // Validasi input (HANYA DATA KENDARAAN)
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'no_plat' => 'required|string|unique:kendaraan,no_plat,' . $id,
            'warna' => 'required|string|max:50',
            'transmisi' => 'required|string',
            'kapasitas_penumpang' => 'required|integer|min:1|max:50',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'keterangan' => 'nullable|string',
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
            'merk.required' => 'Merk kendaraan wajib diisi',
            'model.required' => 'Model kendaraan wajib diisi',
            'tahun.required' => 'Tahun pembuatan wajib diisi',
            'no_plat.required' => 'Nomor plat wajib diisi',
            'no_plat.unique' => 'Nomor plat sudah terdaftar',
            'warna.required' => 'Warna kendaraan wajib diisi',
            'transmisi.required' => 'Transmisi kendaraan wajib diisi',
            'kapasitas_penumpang.required' => 'Kapasitas penumpang wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus JPEG, JPG, atau PNG',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        try {
            $fotoPath = $kendaraan->foto; // Default pakai foto lama

            // Upload foto baru jika ada
            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($kendaraan->foto && file_exists(public_path($kendaraan->foto))) {
                    unlink(public_path($kendaraan->foto));
                }

                // Upload foto baru
                $foto = $request->file('foto');
                $namaFile = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('uploads/kendaraan'), $namaFile);
                $fotoPath = 'uploads/kendaraan/' . $namaFile;
            }

            // Update data kendaraan
            $kendaraan->update([
                'kategori_id' => $validated['kategori_id'],
                'merk' => $validated['merk'],
                'model' => $validated['model'],
                'tahun' => $validated['tahun'],
                'no_plat' => strtoupper($validated['no_plat']),
                'warna' => $validated['warna'],
                'transmisi' => $validated['transmisi'],
                'kapasitas_penumpang' => $validated['kapasitas_penumpang'],
                'foto' => $fotoPath,
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            return redirect()
                ->route('admin.kendaraan.index')
                ->with('success', 'Kendaraan berhasil diperbarui!');

        } catch (\Exception $e) {
            // Hapus foto baru jika ada error
            if (isset($fotoPath) && $fotoPath !== $kendaraan->foto && file_exists(public_path($fotoPath))) {
                unlink(public_path($fotoPath));
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kendaraan: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $kendaraan = Kendaraan::findOrFail($id);

            // Hapus foto jika ada
            if ($kendaraan->foto && file_exists(public_path($kendaraan->foto))) {
                unlink(public_path($kendaraan->foto));
            }

            // Hapus kendaraan
            $kendaraan->delete();

            return redirect()
                ->route('admin.kendaraan.index')
                ->with('success', 'Kendaraan berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.kendaraan.index')
                ->with('error', 'Gagal menghapus kendaraan: ' . $e->getMessage());
        }
    }
}