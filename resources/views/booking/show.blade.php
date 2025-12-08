@extends('layouts.app')
@section('title', 'Booking - NGABRIDE')
@section('content')
    <div class="bg-gray-50 min-h-screen py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Summary Box - Mobile First (muncul di atas pada mobile) -->
                <div class="lg:col-span-1 lg:order-2">
                    <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-4 sm:p-6 lg:sticky lg:top-6">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4">Ringkasan Pesanan</h3>
                        
                        <!-- Car Info -->
                        <div class="mb-3 sm:mb-4 pb-3 sm:pb-4 border-b">
                            <img src="{{ asset($kendaraan->foto) }}" alt="{{ $kendaraan->merk }} {{ $kendaraan->model }}"
                                class="w-full h-32 sm:h-40 object-contain mb-2 sm:mb-3 bg-gray-50 rounded-lg p-2">
                            
                            <!-- Kategori & Jenis Badges -->
                            <div class="mb-2 flex flex-wrap gap-1.5">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    <i class="fas fa-tag mr-1 text-xs"></i>
                                    {{ $kendaraan->kategori->nama }}
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-car mr-1 text-xs"></i>
                                    {{ ucfirst($kendaraan->kategori->jenis) }}
                                </span>
                            </div>

                            <h4 class="font-bold text-sm sm:text-base text-gray-900 mb-3">
                                {{ strtoupper($kendaraan->merk . ' ' . $kendaraan->model) }}
                            </h4>

                            <!-- Spesifikasi Detail -->
                            <div class="space-y-2 text-xs sm:text-sm">
                                <div class="flex items-center text-gray-600">
                                    <div class="w-6 text-center">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <span class="ml-2">{{ $kendaraan->kapasitas_penumpang }} Penumpang</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <div class="w-6 text-center">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <span class="ml-2">Transmisi {{ ucfirst($kendaraan->transmisi) }}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <div class="w-6 text-center">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <span class="ml-2">Tahun {{ $kendaraan->tahun }}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <div class="w-6 text-center">
                                        <i class="fas fa-palette"></i>
                                    </div>
                                    <span class="ml-2">Warna {{ ucfirst($kendaraan->warna) }}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <div class="w-6 text-center">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <span class="ml-2">{{ $kendaraan->no_plat }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Price Details -->
                        <div class="space-y-2 sm:space-y-3 mb-3 sm:mb-4">
                            <div class="flex justify-between text-xs sm:text-sm">
                                <span class="text-gray-600">Harga per hari</span>
                                <span class="font-medium">Rp {{ number_format($hargaPerHari, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-xs sm:text-sm">
                                <span class="text-gray-600">Durasi</span>
                                <span class="font-medium">{{ $durasi }} Hari</span>
                            </div>
                            <div class="border-t pt-2 sm:pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-sm sm:text-base text-gray-900">Total</span>
                                    <span class="text-xl sm:text-2xl font-bold text-indigo-600">
                                        Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-2 sm:p-3">
                            <p class="text-xs font-semibold text-green-800 mb-2">Sudah Termasuk:</p>
                            <div class="text-xs text-green-800 space-y-1">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle mr-2 text-xs"></i>
                                    <span>Asuransi comprehensive</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle mr-2 text-xs"></i>
                                    <span>Layanan darurat 24 jam</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle mr-2 text-xs"></i>
                                    <span>Mobil pengganti jika dibutuhkan</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle mr-2 text-xs"></i>
                                    <span>Bisa refund (sesuai ketentuan)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan Kendaraan -->
                        @if($kendaraan->keterangan)
                        <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-2 sm:p-3">
                            <p class="text-xs font-semibold text-blue-800 mb-1">Informasi Tambahan:</p>
                            <p class="text-xs text-blue-800">{{ $kendaraan->keterangan }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Form Booking -->
                <div class="lg:col-span-2 lg:order-1">
                    <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-4 sm:p-6">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Detail Pemesanan</h2>

                        @if (session('error'))
                            <div
                                class="mb-4 bg-red-50 border border-red-200 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded-lg text-sm">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-circle mt-0.5 mr-2 text-xs sm:text-sm"></i>
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

                            <!-- Detail Kendaraan Section -->
                            <div class="mb-4 sm:mb-6">
                                <h3 class="font-semibold text-sm sm:text-base text-gray-900 mb-3 sm:mb-4 flex items-center">
                                    <i class="fas fa-car mr-2 text-indigo-600"></i>
                                    Detail Kendaraan
                                </h3>
                                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-lg p-3 sm:p-4">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">Kategori</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $kendaraan->kategori->nama }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">Jenis</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ ucfirst($kendaraan->kategori->jenis) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">Merek & Model</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $kendaraan->merk }} {{ $kendaraan->model }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">Tahun</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $kendaraan->tahun }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">Warna</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ ucfirst($kendaraan->warna) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">No. Polisi</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $kendaraan->no_plat }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">Transmisi</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ ucfirst($kendaraan->transmisi) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">Kapasitas</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $kendaraan->kapasitas_penumpang }} Penumpang</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Rental -->
                            <div class="mb-4 sm:mb-6">
                                <h3 class="font-semibold text-sm sm:text-base text-gray-900 mb-3 sm:mb-4 flex items-center">
                                    <i class="fas fa-calendar-check mr-2 text-indigo-600"></i>
                                    Informasi Rental
                                </h3>
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 bg-gray-50 p-3 sm:p-4 rounded-lg">
                                    <div>
                                        <label class="text-xs sm:text-sm text-gray-600 flex items-center">
                                            <i class="far fa-calendar mr-1.5 text-xs"></i>
                                            Tanggal Mulai
                                        </label>
                                        <p class="font-medium text-sm sm:text-base text-gray-900 mt-1">
                                            {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs sm:text-sm text-gray-600 flex items-center">
                                            <i class="far fa-clock mr-1.5 text-xs"></i>
                                            Jam Mulai
                                        </label>
                                        <p class="font-medium text-sm sm:text-base text-gray-900 mt-1">{{ $jam }} WIB</p>
                                    </div>
                                    <div>
                                        <label class="text-xs sm:text-sm text-gray-600 flex items-center">
                                            <i class="far fa-calendar-check mr-1.5 text-xs"></i>
                                            Tanggal Selesai
                                        </label>
                                        <p class="font-medium text-sm sm:text-base text-gray-900 mt-1">
                                            {{ $tanggalSelesai->isoFormat('dddd, D MMMM Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs sm:text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-hourglass-half mr-1.5 text-xs"></i>
                                            Durasi
                                        </label>
                                        <p class="font-medium text-sm sm:text-base text-gray-900 mt-1">{{ $durasi }} Hari</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Lokasi Rental -->
                            <div class="mb-4 sm:mb-6 bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4">
                                <h3 class="font-semibold text-sm sm:text-base text-blue-900 mb-2 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-xs sm:text-sm"></i>
                                    Lokasi Pengambilan Kendaraan
                                </h3>
                                <p class="text-xs sm:text-sm text-blue-800">
                                    Silakan datang ke kantor rental <strong>NGABRIDE</strong> pada tanggal dan jam yang telah ditentukan
                                    untuk mengambil kendaraan. Pastikan membawa dokumen yang diperlukan (KTP, SIM, dan bukti pembayaran jika sudah transfer).
                                </p>
                            </div>

                            <!-- Catatan -->
                            <div class="mb-4 sm:mb-6">
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-comment-alt mr-1.5"></i>
                                    Catatan (Opsional)
                                </label>
                                <textarea name="catatan" rows="3"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="Contoh: Saya memerlukan baby seat, atau ada permintaan khusus lainnya...">{{ old('catatan') }}</textarea>
                            </div>

                            <!-- Metode Pembayaran -->
                            <div class="mb-4 sm:mb-6">
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2 sm:mb-3">
                                    <i class="fas fa-credit-card mr-1.5"></i>
                                    Metode Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-2 sm:space-y-3">
                                    <label
                                        class="flex items-center p-3 sm:p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition active:bg-gray-50">
                                        <input type="radio" name="metode_pembayaran" value="cash" required
                                            class="mr-2 sm:mr-3 text-indigo-600 w-4 h-4">
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex-1">
                                                <span class="font-medium text-sm sm:text-base text-gray-900 block">Bayar di
                                                    Tempat (Cash)</span>
                                                <p class="text-xs sm:text-sm text-gray-600 mt-0.5">Bayar langsung saat ambil kendaraan di lokasi rental</p>
                                            </div>
                                            <i class="fas fa-money-bill-wave text-green-600 text-xl sm:text-2xl ml-2"></i>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 sm:p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition active:bg-gray-50">
                                        <input type="radio" name="metode_pembayaran" value="transfer" required
                                            class="mr-2 sm:mr-3 text-indigo-600 w-4 h-4">
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex-1">
                                                <span class="font-medium text-sm sm:text-base text-gray-900 block">Transfer
                                                    Bank</span>
                                                <p class="text-xs sm:text-sm text-gray-600 mt-0.5">Transfer ke rekening rental (detail rekening akan dikirim)</p>
                                            </div>
                                            <i class="fas fa-university text-blue-600 text-xl sm:text-2xl ml-2"></i>
                                        </div>
                                    </label>
                                </div>
                                @error('metode_pembayaran')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Syarat & Ketentuan -->
                            <div class="mb-4 sm:mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-3 sm:p-4">
                                <label class="flex items-start cursor-pointer">
                                    <input type="checkbox" required class="mt-0.5 sm:mt-1 mr-2 sm:mr-3 text-indigo-600 w-4 h-4">
                                    <span class="text-xs sm:text-sm text-gray-700">
                                        Saya telah membaca dan menyetujui <a href="#"
                                            class="text-indigo-600 hover:underline font-semibold">syarat dan ketentuan</a>
                                        yang berlaku di NGABRIDE, termasuk kebijakan pembatalan dan pengembalian
                                    </span>
                                </label>
                            </div>

                            <!-- Submit Button - Fixed on Mobile -->
                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                                <a href="{{ route('search') }}"
                                    class="order-2 sm:order-1 flex-1 text-center px-4 sm:px-6 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg font-semibold text-sm sm:text-base text-gray-700 hover:bg-gray-50 transition">
                                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                                </a>
                                <button type="submit"
                                    class="order-1 sm:order-2 cursor-pointer flex-1 bg-indigo-600 text-white py-2.5 sm:py-3 rounded-lg font-semibold text-sm sm:text-base hover:bg-indigo-700 active:bg-indigo-800 transition shadow-lg">
                                    <i class="fas fa-check-circle mr-2"></i>Konfirmasi Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Space for Mobile -->
        <div class="h-4 sm:h-0"></div>
    </div>
@endsection