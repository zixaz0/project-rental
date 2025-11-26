<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Halaman untuk lengkapi data
     */
    public function completeProfile()
    {
        $user = Auth::user();
        
        // Kalau data sudah lengkap, redirect ke home
        if ($user->is_complete) {
            return redirect()->route('home')->with('info', 'Data Anda sudah lengkap');
        }
        
        return view('profile.complete', compact('user'));
    }
    
    /**
     * Proses simpan data lengkap
     */
    public function storeCompleteProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'nik' => 'required|string|size:16|unique:users,nik,' . $user->id,
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_selfie_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_sim' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'phone.required' => 'Nomor telepon wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'foto_ktp.required' => 'Foto KTP wajib diupload',
            'foto_ktp.image' => 'File harus berupa gambar',
            'foto_ktp.max' => 'Ukuran file maksimal 2MB',
            'foto_selfie_ktp.required' => 'Foto selfie dengan KTP wajib diupload',
        ]);
        
        // Buat folder kalau belum ada
        $ktpPath = public_path('documents/ktp');
        $selfiePath = public_path('documents/selfie');
        $simPath = public_path('documents/sim');
        
        if (!File::exists($ktpPath)) {
            File::makeDirectory($ktpPath, 0755, true);
        }
        if (!File::exists($selfiePath)) {
            File::makeDirectory($selfiePath, 0755, true);
        }
        if (!File::exists($simPath)) {
            File::makeDirectory($simPath, 0755, true);
        }
        
        // Upload foto KTP
        if ($request->hasFile('foto_ktp')) {
            $fotoKtp = $request->file('foto_ktp');
            $fotoKtpName = 'ktp_' . $user->id . '_' . time() . '.' . $fotoKtp->getClientOriginalExtension();
            $fotoKtp->move($ktpPath, $fotoKtpName);
            $validated['foto_ktp'] = 'documents/ktp/' . $fotoKtpName;
        }
        
        // Upload foto selfie dengan KTP
        if ($request->hasFile('foto_selfie_ktp')) {
            $fotoSelfie = $request->file('foto_selfie_ktp');
            $fotoSelfieName = 'selfie_' . $user->id . '_' . time() . '.' . $fotoSelfie->getClientOriginalExtension();
            $fotoSelfie->move($selfiePath, $fotoSelfieName);
            $validated['foto_selfie_ktp'] = 'documents/selfie/' . $fotoSelfieName;
        }
        
        // Upload foto SIM (opsional)
        if ($request->hasFile('foto_sim')) {
            $fotoSim = $request->file('foto_sim');
            $fotoSimName = 'sim_' . $user->id . '_' . time() . '.' . $fotoSim->getClientOriginalExtension();
            $fotoSim->move($simPath, $fotoSimName);
            $validated['foto_sim'] = 'documents/sim/' . $fotoSimName;
        }
        
        // Set status menjadi menunggu_verifikasi
        $validated['is_complete'] = true;
        $validated['status'] = 'menunggu_verifikasi';
        
        // Update user
        $user->update($validated);
        
        return redirect()->route('home')->with('success', 'Data berhasil dilengkapi! Silakan tunggu verifikasi dari admin.');
    }
    
    /**
     * Halaman lihat profil
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
    
    /**
     * Halaman edit profil (untuk data yang sudah lengkap)
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    
    /**
     * Update profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_selfie_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_sim' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Buat folder kalau belum ada
        $ktpPath = public_path('documents/ktp');
        $selfiePath = public_path('documents/selfie');
        $simPath = public_path('documents/sim');
        
        if (!File::exists($ktpPath)) {
            File::makeDirectory($ktpPath, 0755, true);
        }
        if (!File::exists($selfiePath)) {
            File::makeDirectory($selfiePath, 0755, true);
        }
        if (!File::exists($simPath)) {
            File::makeDirectory($simPath, 0755, true);
        }
        
        $documentChanged = false;
        
        // Upload foto KTP baru (kalau ada)
        if ($request->hasFile('foto_ktp')) {
            // Hapus foto lama kalau ada
            if ($user->foto_ktp && File::exists(public_path($user->foto_ktp))) {
                File::delete(public_path($user->foto_ktp));
            }
            
            $fotoKtp = $request->file('foto_ktp');
            $fotoKtpName = 'ktp_' . $user->id . '_' . time() . '.' . $fotoKtp->getClientOriginalExtension();
            $fotoKtp->move($ktpPath, $fotoKtpName);
            $validated['foto_ktp'] = 'documents/ktp/' . $fotoKtpName;
            
            $documentChanged = true;
        }
        
        // Upload foto selfie KTP baru (kalau ada)
        if ($request->hasFile('foto_selfie_ktp')) {
            // Hapus foto lama kalau ada
            if ($user->foto_selfie_ktp && File::exists(public_path($user->foto_selfie_ktp))) {
                File::delete(public_path($user->foto_selfie_ktp));
            }
            
            $fotoSelfie = $request->file('foto_selfie_ktp');
            $fotoSelfieName = 'selfie_' . $user->id . '_' . time() . '.' . $fotoSelfie->getClientOriginalExtension();
            $fotoSelfie->move($selfiePath, $fotoSelfieName);
            $validated['foto_selfie_ktp'] = 'documents/selfie/' . $fotoSelfieName;
            
            $documentChanged = true;
        }
        
        // Upload foto SIM baru (kalau ada)
        if ($request->hasFile('foto_sim')) {
            // Hapus foto lama kalau ada
            if ($user->foto_sim && File::exists(public_path($user->foto_sim))) {
                File::delete(public_path($user->foto_sim));
            }
            
            $fotoSim = $request->file('foto_sim');
            $fotoSimName = 'sim_' . $user->id . '_' . time() . '.' . $fotoSim->getClientOriginalExtension();
            $fotoSim->move($simPath, $fotoSimName);
            $validated['foto_sim'] = 'documents/sim/' . $fotoSimName;
        }
        
        // Reset verifikasi kalau dokumen berubah
        if ($documentChanged) {
            $validated['is_verified'] = false;
            $validated['status'] = 'menunggu_verifikasi';
            $validated['verified_at'] = null;
            $validated['verified_by'] = null;
            $validated['verification_note'] = null;
        }
        
        $user->update($validated);
        
        $message = 'Profil berhasil diperbarui';
        if ($documentChanged) {
            $message .= '. Dokumen Anda akan diverifikasi ulang oleh admin.';
        }
        
        return redirect()->route('profile.show')->with('success', $message);
    }
}