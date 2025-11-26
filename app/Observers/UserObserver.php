<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "saving" event.
     * Otomatis update status berdasarkan kelengkapan data
     */
    public function saving(User $user): void
    {
        // Skip untuk admin
        if ($user->role === 'admin') {
            return;
        }

        // Jangan ubah status jika sedang diverifikasi atau ditolak oleh admin
        // Cek apakah status diubah manual oleh admin
        if ($user->isDirty('status') && in_array($user->status, ['terverifikasi', 'ditolak', 'menunggu_verifikasi'])) {
            // Jika admin yang ubah status, biarkan
            return;
        }

        // Cek kelengkapan data
        $isDataComplete = $this->checkDataComplete($user);

        // Auto-update status berdasarkan kelengkapan data
        if ($isDataComplete) {
            // Jika data lengkap dan status masih belum_lengkap atau ditolak, ubah ke menunggu_verifikasi
            if (in_array($user->status, ['belum_lengkap', 'ditolak'])) {
                $user->status = 'menunggu_verifikasi';
                $user->is_complete = true;
            }
        } else {
            // Jika data tidak lengkap, set ke belum_lengkap
            if (!in_array($user->status, ['terverifikasi', 'menunggu_verifikasi', 'ditolak'])) {
                $user->status = 'belum_lengkap';
                $user->is_complete = false;
            }
        }
    }

    /**
     * Cek apakah data user sudah lengkap
     */
    private function checkDataComplete(User $user): bool
    {
        // Data yang wajib diisi
        $requiredFields = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'nik' => $user->nik,
            'tanggal_lahir' => $user->tanggal_lahir,
            'jenis_kelamin' => $user->jenis_kelamin,
            'foto_ktp' => $user->foto_ktp,
            'foto_selfie_ktp' => $user->foto_selfie_ktp,
        ];

        // Cek apakah semua field wajib sudah terisi
        foreach ($requiredFields as $field => $value) {
            if (empty($value)) {
                return false;
            }
        }

        return true;
    }
}