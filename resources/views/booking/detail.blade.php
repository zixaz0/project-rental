@extends('layouts.app')

@section('title', 'Detail Booking - NGABRIDE')

@section('content')
<div class="bg-gray-50 min-h-screen py-4 sm:py-8">
    <div class="max-w-5xl mx-auto px-3 sm:px-4 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start gap-3 sm:gap-4">
                <div class="w-full sm:w-auto">
                    <div class="flex items-center gap-2 sm:gap-3 mb-2 flex-wrap">
                        <h1 class="text-lg sm:text-2xl font-bold text-gray-900">{{ $booking->nomor_booking }}</h1>
                        @if($booking->status == 'pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs sm:text-sm font-semibold rounded-full whitespace-nowrap">
                                PENDING
                            </span>
                        @elseif($booking->status == 'dikonfirmasi')
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs sm:text-sm font-semibold rounded-full whitespace-nowrap">
                                DIKONFIRMASI
                            </span>
                        @elseif($booking->status == 'dalam_perjalanan')
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs sm:text-sm font-semibold rounded-full whitespace-nowrap">
                                DALAM PERJALANAN
                            </span>
                        @elseif($booking->status == 'selesai')
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs sm:text-sm font-semibold rounded-full whitespace-nowrap">
                                SELESAI
                            </span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs sm:text-sm font-semibold rounded-full whitespace-nowrap">
                                DIBATALKAN
                            </span>
                        @endif
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600">Dibuat: {{ $booking->created_at->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
                <div class="w-full sm:w-auto text-left sm:text-right">
                    <p class="text-xs sm:text-sm text-gray-600 mb-1">Total Pembayaran</p>
                    <p class="text-2xl sm:text-3xl font-bold text-indigo-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Status Pembayaran -->
        @if($booking->status_pembayaran == 'belum_bayar')
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
                <div class="flex items-start gap-2 sm:gap-3">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 text-sm sm:text-base"></i>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-yellow-900 mb-2 text-sm sm:text-base">Menunggu Pembayaran</h3>
                        @if($booking->metode_pembayaran == 'cash')
                            <p class="text-xs sm:text-sm text-yellow-800">Silakan datang ke lokasi rental pada tanggal yang telah ditentukan untuk melakukan pembayaran cash.</p>
                        @else
                            <p class="text-xs sm:text-sm text-yellow-800 mb-3">Silakan lakukan transfer dan upload bukti pembayaran.</p>
                            <button class="w-full sm:w-auto px-4 py-2 bg-yellow-600 text-white rounded-lg text-xs sm:text-sm font-medium hover:bg-yellow-700 transition">
                                <i class="fas fa-upload mr-2"></i>Upload Bukti Transfer
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @elseif($booking->status_pembayaran == 'menunggu_verifikasi')
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
                <div class="flex items-start gap-2 sm:gap-3">
                    <i class="fas fa-clock text-blue-600 mt-1 text-sm sm:text-base"></i>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-blue-900 mb-1 text-sm sm:text-base">Menunggu Verifikasi</h3>
                        <p class="text-xs sm:text-sm text-blue-800">Pembayaran Anda sedang diverifikasi oleh admin. Mohon tunggu maksimal 2x24 jam.</p>
                    </div>
                </div>
            </div>
        @elseif($booking->status_pembayaran == 'lunas')
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
                <div class="flex items-start gap-2 sm:gap-3">
                    <i class="fas fa-check-circle text-green-600 mt-1 text-sm sm:text-base"></i>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-green-900 mb-1 text-sm sm:text-base">Pembayaran Lunas</h3>
                        <p class="text-xs sm:text-sm text-green-800">Pembayaran telah dikonfirmasi. Terima kasih!</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Informasi Kendaraan -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4">Informasi Kendaraan</h2>
            <div class="flex flex-col md:flex-row gap-4 sm:gap-6">
                <div class="w-full md:w-1/3">
                    <img src="{{ asset($booking->kendaraan->foto) }}" 
                        alt="{{ $booking->kendaraan->merk }}"
                        class="w-full h-40 sm:h-48 object-contain bg-gray-50 rounded-lg p-3 sm:p-4">
                </div>
                <div class="w-full md:w-2/3">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">
                        {{ strtoupper($booking->kendaraan->merk . ' ' . $booking->kendaraan->model) }}
                    </h3>
                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-users mr-2 sm:mr-3 text-indigo-600 text-sm sm:text-base"></i>
                            <div>
                                <p class="text-xs text-gray-600">Kapasitas</p>
                                <p class="font-medium text-sm sm:text-base">{{ $booking->kendaraan->kapasitas_penumpang }} Kursi</p>
                            </div>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-cog mr-2 sm:mr-3 text-indigo-600 text-sm sm:text-base"></i>
                            <div>
                                <p class="text-xs text-gray-600">Transmisi</p>
                                <p class="font-medium text-sm sm:text-base">{{ ucfirst($booking->kendaraan->transmisi) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-calendar mr-2 sm:mr-3 text-indigo-600 text-sm sm:text-base"></i>
                            <div>
                                <p class="text-xs text-gray-600">Tahun</p>
                                <p class="font-medium text-sm sm:text-base">{{ $booking->kendaraan->tahun }}</p>
                            </div>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-palette mr-2 sm:mr-3 text-indigo-600 text-sm sm:text-base"></i>
                            <div>
                                <p class="text-xs text-gray-600">Warna</p>
                                <p class="font-medium text-sm sm:text-base">{{ $booking->kendaraan->warna }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="px-2 sm:px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                            <i class="fas fa-shield-alt mr-1"></i>Asuransi Comprehensive
                        </span>
                        <span class="px-2 sm:px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                            <i class="fas fa-headset mr-1"></i>Layanan 24 Jam
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
            <!-- Detail Rental -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4">Detail Rental</h2>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b text-sm sm:text-base">
                        <span class="text-gray-600">Tanggal Mulai</span>
                        <span class="font-medium text-gray-900 text-right">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->isoFormat('D MMMM Y') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b text-sm sm:text-base">
                        <span class="text-gray-600">Tanggal Selesai</span>
                        <span class="font-medium text-gray-900 text-right">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->isoFormat('D MMMM Y') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b text-sm sm:text-base">
                        <span class="text-gray-600">Jam Mulai</span>
                        <span class="font-medium text-gray-900">{{ $booking->jam_mulai }} WIB</span>
                    </div>
                    <div class="flex justify-between py-2 border-b text-sm sm:text-base">
                        <span class="text-gray-600">Durasi</span>
                        <span class="font-medium text-gray-900">{{ $booking->durasi }} Hari</span>
                    </div>
                    <div class="flex justify-between py-2 text-sm sm:text-base">
                        <span class="text-gray-600">Alamat Penjemputan</span>
                        <span class="font-medium text-gray-900 text-right max-w-[60%] sm:max-w-xs break-words">{{ $booking->alamat_penjemputan }}</span>
                    </div>
                </div>
            </div>

            <!-- Detail Pembayaran -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4">Detail Pembayaran</h2>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b text-sm sm:text-base">
                        <span class="text-gray-600">Harga per Hari</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($booking->harga_per_hari, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b text-sm sm:text-base">
                        <span class="text-gray-600">Durasi</span>
                        <span class="font-medium text-gray-900">{{ $booking->durasi }} Hari</span>
                    </div>
                    <div class="flex justify-between py-2 border-b text-sm sm:text-base">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b text-sm sm:text-base">
                        <span class="text-gray-600">Metode Pembayaran</span>
                        <span class="font-medium text-gray-900 capitalize">
                            {{ $booking->metode_pembayaran == 'cash' ? 'Bayar di Tempat' : 'Transfer Bank' }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2 pt-4 border-t-2">
                        <span class="font-semibold text-gray-900 text-sm sm:text-base">Total</span>
                        <span class="text-xl sm:text-2xl font-bold text-indigo-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Catatan -->
        @if($booking->catatan)
        <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-3">Catatan</h2>
            <p class="text-sm sm:text-base text-gray-700 bg-gray-50 p-3 sm:p-4 rounded-lg break-words">{{ $booking->catatan }}</p>
        </div>
        @endif

        <!-- Alasan Pembatalan -->
        @if($booking->status == 'dibatalkan' && $booking->alasan_pembatalan)
        <div class="bg-red-50 border border-red-200 rounded-lg sm:rounded-xl p-4 sm:p-6 mb-4 sm:mb-6">
            <h2 class="text-lg sm:text-xl font-bold text-red-900 mb-3">Alasan Pembatalan</h2>
            <p class="text-sm sm:text-base text-red-800 break-words">{{ $booking->alasan_pembatalan }}</p>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('booking.my-bookings') }}" 
                class="flex-1 text-center px-4 sm:px-6 py-2.5 sm:py-3 border border-gray-300 rounded-lg font-semibold text-sm sm:text-base text-gray-700 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
            </a>

            @if(in_array($booking->status, ['pending', 'dikonfirmasi']))
                <button onclick="cancelBooking('{{ $booking->id }}')" 
                    class="cursor-pointer flex-1 text-center px-4 sm:px-6 py-2.5 sm:py-3 bg-red-600 text-white rounded-lg font-semibold text-sm sm:text-base hover:bg-red-700 transition">
                    <i class="fas fa-times mr-2"></i>Batalkan Booking
                </button>
            @endif

            @if($booking->status == 'selesai')
                <button class="flex-1 text-center px-4 sm:px-6 py-2.5 sm:py-3 bg-indigo-600 text-white rounded-lg font-semibold text-sm sm:text-base hover:bg-indigo-700 transition">
                    <i class="fas fa-star mr-2"></i>Beri Ulasan
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-4 sm:p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Batalkan Booking</h3>
        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">Apakah Anda yakin ingin membatalkan booking ini? Tindakan ini tidak dapat dibatalkan.</p>
        
        <form id="cancelForm" method="POST" action="{{ route('booking.cancel', $booking->id) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                    Alasan Pembatalan <span class="text-red-500">*</span>
                </label>
                <textarea name="alasan_pembatalan" rows="3" required
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Masukkan alasan pembatalan booking"></textarea>
            </div>

            <div class="flex gap-2 sm:gap-3">
                <button type="button" onclick="closeCancelModal()"
                    class="flex-1 px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 px-3 sm:px-4 py-2 text-sm sm:text-base bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Ya, Batalkan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function cancelBooking(bookingId) {
        const modal = document.getElementById('cancelModal');
        modal.classList.remove('hidden');
    }

    function closeCancelModal() {
        const modal = document.getElementById('cancelModal');
        modal.classList.add('hidden');
    }

    // Close modal on outside click
    document.getElementById('cancelModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCancelModal();
        }
    });
</script>
@endsection