<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice')->unique();
            $table->foreignId('booking_id')->constrained('booking')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Biaya
            $table->decimal('subtotal', 10, 2); // Total harga rental
            $table->decimal('denda_keterlambatan', 10, 2)->default(0); // Denda per hari
            $table->integer('hari_keterlambatan')->default(0); // Jumlah hari telat
            $table->decimal('biaya_tambahan', 10, 2)->default(0); // Biaya lain (rusak, dll)
            $table->text('keterangan_biaya_tambahan')->nullable();
            $table->decimal('total_invoice', 10, 2); // Grand total
            
            // Status
            $table->enum('status_pembayaran', ['belum_bayar', 'dibayar', 'lunas'])->default('belum_bayar');
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->timestamp('tanggal_jatuh_tempo')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('booking_id');
            $table->index('user_id');
            $table->index('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};