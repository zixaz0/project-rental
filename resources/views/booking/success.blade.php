@extends('layouts.app')

@section('title', 'Booking Berhasil - NGABRIDE')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <i class="fas fa-check-circle text-green-600 text-5xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Berhasil!</h1>
            <p class="text-gray-600">Terima kasih telah melakukan pemesanan di NGABRIDE</p>
        </div>

        <!-- Booking Details Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                <div class="flex justify-between items-center text-white">
                    <div>
                        <p class="text-sm opacity-90">Nomor Booking</p>
                        <p class="text-2xl font-bold">{{ $booking->nomor_booking }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-4 py-2 bg-yellow-400 text-yellow-900 rounded-full text-sm font-semibold">
                            {{ strtoupper($booking->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Kendaraan Info -->
                <div class="mb-6 pb-6 border-b">
                    <h3 class="font-bold text-gray-900 mb-4">Informasi Kendaraan</h3>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset($booking->kendaraan->foto) }}" 
                            alt="{{ $booking->kendaraan->merk }}"
                            class="w-32 h-24 object-contain bg-gray-50 rounded-lg p-2">
                        <div>
                            <h4 class="font-bold text-lg text-gray-900">
                                {{ strtoupper($booking->kendaraan->merk . ' ' . $booking->kendaraan->model) }}
                            </h4>
                            <div class="flex gap-4 text-sm text-gray-600 mt-1">
                                <span><i class="fas fa-users mr-1"></i>{{ $booking->kendaraan->kapasitas_penumpang }} Kursi</span>
                                <span><i class="fas fa-cog mr-1"></i>{{ ucfirst($booking->kendaraan->transmisi) }}</span>
                                <span><i class="fas fa-calendar mr-1"></i>{{ $booking->kendaraan->tahun }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rental Details -->
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-bold text-gray-900 mb-3">Detail Rental</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Mulai:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->isoFormat('D MMM Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Selesai:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->isoFormat('D MMM Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jam Mulai:</span>
                                <span class="font-medium">{{ $booking->jam_mulai }} WIB</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Durasi:</span>
                                <span class="font-medium">{{ $booking->durasi }} Hari</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-900 mb-3">Detail Pembayaran</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Harga per hari:</span>
                                <span class="font-medium">Rp {{ number_format($booking->harga_per_hari, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Durasi:</span>
                                <span class="font-medium">{{ $booking->durasi }} Hari</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t">
                                <span class="font-semibold text-gray-900">Total:</span>
                                <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-gray-600">Metode Pembayaran:</span>
                                <span class="font-medium capitalize">{{ $booking->metode_pembayaran == 'cash' ? 'Bayar di Tempat' : 'Transfer Bank' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat Penjemputan -->
                <div class="mb-6">
                    <h3 class="font-bold text-gray-900 mb-2">Alamat Penjemputan</h3>
                    <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">
                        {{ $booking->alamat_penjemputan }}
                    </p>
                </div>

                @if($booking->catatan)
                <div class="mb-6">
                    <h3 class="font-bold text-gray-900 mb-2">Catatan</h3>
                    <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">
                        {{ $booking->catatan }}
                    </p>
                </div>
                @endif

                <!-- Instructions -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-bold text-blue-900 mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Langkah Selanjutnya
                    </h3>
                    <ol class="list-decimal list-inside space-y-2 text-sm text-blue-900">
                        @if($booking->metode_pembayaran == 'cash')
                            <li>Datang ke lokasi rental NGABRIDE pada tanggal dan jam yang telah ditentukan</li>
                            <li>Lakukan pembayaran langsung di tempat (Cash)</li>
                            <li>Tunjukkan nomor booking <strong>{{ $booking->nomor_booking }}</strong> kepada petugas</li>
                            <li>Petugas akan melakukan verifikasi dan kendaraan siap digunakan</li>
                        @else
                            <li>Transfer pembayaran sebesar <strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong> ke rekening rental</li>
                            <li>Upload bukti transfer melalui halaman "Booking Saya"</li>
                            <li>Tunggu verifikasi dari admin (maksimal 2x24 jam)</li>
                            <li>Datang ke lokasi rental pada tanggal yang telah ditentukan dengan membawa nomor booking</li>
                        @endif
                        <li>Jangan lupa membawa KTP/SIM asli dan uang deposit jika diperlukan</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="/" 
                class="flex-1 text-center px-6 py-3 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition">
                <i class="fas fa-home mr-2"></i>Kembali ke Home
            </a>
            <a href="{{ route('booking.my-bookings') }}" 
                class="flex-1 text-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition shadow-lg">
                <i class="fas fa-list mr-2"></i>Lihat Booking Saya
            </a>
        </div>

        <!-- Contact Info -->
        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Ada pertanyaan? Hubungi kami di <a href="tel:+6281234567890" class="text-indigo-600 hover:underline">+62 812-3456-7890</a></p>
        </div>
    </div>
</div>
@endsection