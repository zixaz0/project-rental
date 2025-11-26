<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== ADMIN ACCOUNT ====================
        // Admin - Data lengkap & terverifikasi
        $admin = User::create([
            'name' => 'Admin NGABRIDE',
            'email' => 'admin@ngabride.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'terverifikasi',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1, Bandung, Jawa Barat',
            'nik' => '3273010101900001',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'laki-laki',
            'is_complete' => true,
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        // ==================== CUSTOMER ACCOUNTS ====================
        
        // 1. Customer - BELUM LENGKAP (Baru register)
        User::create([
            'name' => 'Customer Baru',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'status' => 'belum_lengkap',
            'is_complete' => false,
            'is_verified' => false,
        ]);

        // 2. Customer - MENUNGGU VERIFIKASI (Data sudah lengkap, belum dicek admin)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'status' => 'menunggu_verifikasi',
            'phone' => '082345678901',
            'address' => 'Jl. Merdeka No. 45, Bandung, Jawa Barat 40115',
            'nik' => '3273020202920002',
            'tanggal_lahir' => '1992-02-02',
            'jenis_kelamin' => 'laki-laki',
            'foto_ktp' => 'documents/ktp/ktp_dummy_budi.jpg',
            'foto_selfie_ktp' => 'documents/selfie/selfie_dummy_budi.jpg',
            'foto_sim' => 'documents/sim/sim_dummy_budi.jpg',
            'is_complete' => true,
            'is_verified' => false,
        ]);

        // 3. Customer - TERVERIFIKASI (Bisa langsung booking)
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'status' => 'terverifikasi',
            'phone' => '083456789012',
            'address' => 'Jl. Sudirman No. 88, Bandung, Jawa Barat 40263',
            'nik' => '3273030303930003',
            'tanggal_lahir' => '1993-03-03',
            'jenis_kelamin' => 'perempuan',
            'foto_ktp' => 'documents/ktp/ktp_dummy_siti.jpg',
            'foto_selfie_ktp' => 'documents/selfie/selfie_dummy_siti.jpg',
            'foto_sim' => 'documents/sim/sim_dummy_siti.jpg',
            'is_complete' => true,
            'is_verified' => true,
            'verified_at' => now()->subDays(3),
            'verified_by' => $admin->id,
            'verification_note' => 'Data valid dan dokumen jelas. Verifikasi berhasil.',
        ]);

        // 4. Customer - DITOLAK (Dokumen tidak valid)
        User::create([
            'name' => 'Ahmad Maulana',
            'email' => 'ahmad@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'status' => 'ditolak',
            'phone' => '084567890123',
            'address' => 'Jl. Gatot Subroto No. 12, Bandung, Jawa Barat 40262',
            'nik' => '3273040404940004',
            'tanggal_lahir' => '1994-04-04',
            'jenis_kelamin' => 'laki-laki',
            'foto_ktp' => 'documents/ktp/ktp_dummy_ahmad.jpg',
            'foto_selfie_ktp' => 'documents/selfie/selfie_dummy_ahmad.jpg',
            'is_complete' => true,
            'is_verified' => false,
            'verification_note' => 'Foto KTP kurang jelas dan blur. Mohon upload ulang dengan resolusi lebih tinggi dan pencahayaan yang baik.',
        ]);

        // 5. Customer - TERVERIFIKASI (dengan SIM)
        User::create([
            'name' => 'Rina Wijaya',
            'email' => 'rina@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'status' => 'terverifikasi',
            'phone' => '085678901234',
            'address' => 'Jl. Asia Afrika No. 99, Bandung, Jawa Barat 40111',
            'nik' => '3273050505950005',
            'tanggal_lahir' => '1995-05-05',
            'jenis_kelamin' => 'perempuan',
            'foto_ktp' => 'documents/ktp/ktp_dummy_rina.jpg',
            'foto_selfie_ktp' => 'documents/selfie/selfie_dummy_rina.jpg',
            'foto_sim' => 'documents/sim/sim_dummy_rina.jpg',
            'is_complete' => true,
            'is_verified' => true,
            'verified_at' => now()->subDays(1),
            'verified_by' => $admin->id,
            'verification_note' => 'Semua dokumen valid dan lengkap termasuk SIM.',
        ]);

        // 6. Customer - MENUNGGU VERIFIKASI (baru submit hari ini)
        User::create([
            'name' => 'Dedi Kurniawan',
            'email' => 'dedi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'status' => 'menunggu_verifikasi',
            'phone' => '086789012345',
            'address' => 'Jl. Cihampelas No. 77, Bandung, Jawa Barat 40131',
            'nik' => '3273060606960006',
            'tanggal_lahir' => '1996-06-06',
            'jenis_kelamin' => 'laki-laki',
            'foto_ktp' => 'documents/ktp/ktp_dummy_dedi.jpg',
            'foto_selfie_ktp' => 'documents/selfie/selfie_dummy_dedi.jpg',
            'is_complete' => true,
            'is_verified' => false,
        ]);

        // 7. Customer - BELUM LENGKAP (ada data tapi belum upload dokumen)
        User::create([
            'name' => 'Fitri Handayani',
            'email' => 'fitri@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'status' => 'belum_lengkap',
            'phone' => '087890123456',
            'address' => 'Jl. Dago No. 55, Bandung, Jawa Barat 40135',
            'is_complete' => false,
            'is_verified' => false,
        ]);

        // 8. Customer - DITOLAK (foto selfie tidak sesuai)
        User::create([
            'name' => 'Bambang Sutrisno',
            'email' => 'bambang@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'status' => 'ditolak',
            'phone' => '088901234567',
            'address' => 'Jl. Buah Batu No. 33, Bandung, Jawa Barat 40286',
            'nik' => '3273070707970007',
            'tanggal_lahir' => '1997-07-07',
            'jenis_kelamin' => 'laki-laki',
            'foto_ktp' => 'documents/ktp/ktp_dummy_bambang.jpg',
            'foto_selfie_ktp' => 'documents/selfie/selfie_dummy_bambang.jpg',
            'is_complete' => true,
            'is_verified' => false,
            'verification_note' => 'Foto selfie tidak menunjukkan wajah dan KTP dengan jelas. KTP tidak terlihat pada foto. Silakan upload ulang dengan KTP yang terlihat jelas di samping wajah Anda.',
        ]);

        $this->command->info('✓ 8 users berhasil dibuat (1 Admin + 7 Customer dengan berbagai status)');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('==================');
        $this->command->info('Admin: admin@ngabride.com / password');
        $this->command->info('Customer (Belum Lengkap): customer@gmail.com / password');
        $this->command->info('Customer (Menunggu Verifikasi): budi@gmail.com / password');
        $this->command->info('Customer (Terverifikasi): siti@gmail.com / password');
        $this->command->info('Customer (Ditolak): ahmad@gmail.com / password');
    }
}