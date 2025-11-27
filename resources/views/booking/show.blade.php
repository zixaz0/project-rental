@extends('layouts.app')

@section('title', 'Booking - NGABRIDE')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Booking -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Pemesanan</h2>

                    @if(session('error'))
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="kendaraan_id" value="{{ $kendaraan->id }}">
                        <input type="hidden" name="tanggal_mulai" value="{{ $tanggal }}">
                        <input type="hidden" name="jam_mulai" value="{{ $jam }}">
                        <input type="hidden" name="durasi" value="{{ $durasi }}">

                        <!-- Info Rental -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-4">Informasi Rental</h3>
                            <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                                <div>
                                    <label class="text-sm text-gray-600">Tanggal Mulai</label>
                                    <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Jam Mulai</label>
                                    <p class="font-medium text-gray-900">{{ $jam }} WIB</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Tanggal Selesai</label>
                                    <p class="font-medium text-gray-900">{{ $tanggalSelesai->isoFormat('dddd, D MMMM Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Durasi</label>
                                    <p class="font-medium text-gray-900">{{ $durasi }} Hari</p>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat Penjemputan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Penjemputan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat_penjemputan" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Masukkan alamat lengkap untuk penjemputan kendaraan">{{ old('alamat_penjemputan') }}</textarea>
                            @error('alamat_penjemputan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea name="catatan" rows="2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Tambahkan catatan khusus jika ada">{{ old('catatan') }}</textarea>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                    <input type="radio" name="metode_pembayaran" value="cash" required class="mr-3 text-indigo-600">
                                    <div class="flex items-center justify-between w-full">
                                        <div>
                                            <span class="font-medium text-gray-900">Bayar di Tempat (Cash)</span>
                                            <p class="text-sm text-gray-600">Bayar langsung saat mengambil kendaraan</p>
                                        </div>
                                        <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                    <input type="radio" name="metode_pembayaran" value="transfer" required class="mr-3 text-indigo-600">
                                    <div class="flex items-center justify-between w-full">
                                        <div>
                                            <span class="font-medium text-gray-900">Transfer Bank</span>
                                            <p class="text-sm text-gray-600">Transfer ke rekening rental</p>
                                        </div>
                                        <i class="fas fa-university text-blue-600 text-2xl"></i>
                                    </div>
                                </label>
                            </div>
                            @error('metode_pembayaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Syarat & Ketentuan -->
                        <div class="mb-6">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" required class="mt-1 mr-3 text-indigo-600">
                                <span class="text-sm text-gray-700">
                                    Saya menyetujui <a href="#" class="text-indigo-600 hover:underline">syarat dan ketentuan</a> 
                                    yang berlaku di NGABRIDE
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-3">
                            <a href="{{ route('search') }}" 
                                class="flex-1 text-center px-6 py-3 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition">
                                Kembali
                            </a>
                            <button type="submit"
                                class="flex-1 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-lg">
                                Konfirmasi Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Box -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>

                    <!-- Car Info -->
                    <div class="mb-4 pb-4 border-b">
                        <img src="{{ asset($kendaraan->foto) }}" 
                            alt="{{ $kendaraan->merk }} {{ $kendaraan->model }}"
                            class="w-full h-40 object-contain mb-3 bg-gray-50 rounded-lg p-2">
                        <h4 class="font-bold text-gray-900">{{ strtoupper($kendaraan->merk . ' ' . $kendaraan->model) }}</h4>
                        <div class="mt-2 space-y-1 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2 w-4"></i>
                                <span>{{ $kendaraan->kapasitas_penumpang }} Kursi</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-cog mr-2 w-4"></i>
                                <span>{{ ucfirst($kendaraan->transmisi) }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2 w-4"></i>
                                <span>Tahun {{ $kendaraan->tahun }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Price Details -->
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Harga per hari</span>
                            <span class="font-medium">Rp {{ number_format($hargaPerHari, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Durasi</span>
                            <span class="font-medium">{{ $durasi }} Hari</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-indigo-600">
                                    Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <div class="text-xs text-green-800 space-y-1">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Asuransi comprehensive</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Layanan 24 jam</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Mobil pengganti</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection