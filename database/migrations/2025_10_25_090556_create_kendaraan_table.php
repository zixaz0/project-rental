<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('merk');
            $table->string('model');
            $table->year('tahun');
            $table->string('no_plat')->unique();
            $table->string('warna')->nullable();
            $table->enum('transmisi', ['Automatic', 'Manual']); // 🔥 kolom baru
            $table->integer('kapasitas_penumpang')->nullable();
            $table->text('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
