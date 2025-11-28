<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_booking')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade');
            
            // Tanggal dan Waktu
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('jam_mulai');
            $table->integer('durasi'); // dalam hari
            
            // Harga
            $table->decimal('harga_per_hari', 10, 2);
            $table->decimal('total_harga', 10, 2);
            
            // Detail Penjemputan
            $table->text('catatan')->nullable();
            
            // Pembayaran
            $table->enum('metode_pembayaran', ['transfer', 'cash']);
            $table->enum('status_pembayaran', ['belum_bayar', 'menunggu_verifikasi', 'lunas'])->default('belum_bayar');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamp('tanggal_pembayaran')->nullable();
            
            // Status Booking
            $table->enum('status', ['pending', 'dikonfirmasi', 'dalam_perjalanan', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('alasan_pembatalan')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('kendaraan_id');
            $table->index('status');
            $table->index('status_pembayaran');
            $table->index('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};