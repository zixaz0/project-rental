@extends('layouts.app')

@section('title', 'Booking Saya - NGABRIDE')

@section('content')
<div class="bg-gray-50 min-h-screen py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1 sm:mb-2">Booking Saya</h1>
            <p class="text-sm sm:text-base text-gray-600">Kelola semua pesanan rental kendaraan Anda</p>
        </div>

        @if(session('success'))
            <div class="mb-4 sm:mb-6 bg-green-50 border border-green-200 text-green-700 px-3 sm:px-4 py-3 rounded-lg">
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle mt-0.5 text-sm sm:text-base"></i>
                    <span class="text-sm sm:text-base">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 text-red-700 px-3 sm:px-4 py-3 rounded-lg">
                <div class="flex items-start gap-2">
                    <i class="fas fa-exclamation-circle mt-0.5 text-sm sm:text-base"></i>
                    <span class="text-sm sm:text-base">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Filter Tabs -->
        <div class="mb-4 sm:mb-6">
            <div class="border-b border-gray-200 overflow-x-auto scrollbar-hide">
                <nav class="flex space-x-4 sm:space-x-8 min-w-max px-1">
                    <button onclick="filterBookings('all')" 
                        class="filter-tab py-3 sm:py-4 px-1 border-b-2 border-indigo-600 font-medium text-xs sm:text-sm text-indigo-600 whitespace-nowrap">
                        Semua
                    </button>
                    <button onclick="filterBookings('pending')" 
                        class="filter-tab py-3 sm:py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        Pending
                    </button>
                    <button onclick="filterBookings('dikonfirmasi')" 
                        class="filter-tab py-3 sm:py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        Dikonfirmasi
                    </button>
                    <button onclick="filterBookings('dalam_perjalanan')" 
                        class="filter-tab py-3 sm:py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        Dalam Perjalanan
                    </button>
                    <button onclick="filterBookings('selesai')" 
                        class="filter-tab py-3 sm:py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        Selesai
                    </button>
                    <button onclick="filterBookings('dibatalkan')" 
                        class="filter-tab py-3 sm:py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                        Dibatalkan
                    </button>
                </nav>
            </div>
        </div>

        <!-- Booking List -->
        <div class="space-y-3 sm:space-y-4">
            @forelse($bookings as $booking)
                <div class="booking-card bg-white rounded-lg sm:rounded-xl shadow-md overflow-hidden hover:shadow-lg transition" 
                     data-status="{{ $booking->status }}">
                    <div class="p-4 sm:p-6">
                        <!-- Header -->
                        <div class="flex flex-col sm:flex-row justify-between items-start mb-4 pb-3 sm:pb-4 border-b gap-3 sm:gap-4">
                            <div class="w-full sm:w-auto">
                                <div class="flex items-center gap-2 sm:gap-3 mb-2 flex-wrap">
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900">{{ $booking->nomor_booking }}</h3>
                                    @if($booking->status == 'pending')
                                        <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full whitespace-nowrap">
                                            PENDING
                                        </span>
                                    @elseif($booking->status == 'dikonfirmasi')
                                        <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full whitespace-nowrap">
                                            DIKONFIRMASI
                                        </span>
                                    @elseif($booking->status == 'dalam_perjalanan')
                                        <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full whitespace-nowrap">
                                            DALAM PERJALANAN
                                        </span>
                                    @elseif($booking->status == 'selesai')
                                        <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full whitespace-nowrap">
                                            SELESAI
                                        </span>
                                    @else
                                        <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full whitespace-nowrap">
                                            DIBATALKAN
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs sm:text-sm text-gray-600">
                                    Dibuat: {{ $booking->created_at->isoFormat('D MMMM Y') }}
                                </p>
                            </div>
                            <div class="w-full sm:w-auto text-left sm:text-right">
                                <div class="text-xl sm:text-2xl font-bold text-indigo-600">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </div>
                                <div class="text-xs sm:text-sm text-gray-600">Total Pembayaran</div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="grid md:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Kendaraan Info -->
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-3 text-sm sm:text-base">Informasi Kendaraan</h4>
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <img src="{{ asset($booking->kendaraan->foto) }}" 
                                        alt="{{ $booking->kendaraan->merk }}"
                                        class="w-20 sm:w-24 h-16 sm:h-20 object-contain bg-gray-50 rounded-lg p-2 flex-shrink-0">
                                    <div class="min-w-0 flex-1">
                                        <h5 class="font-bold text-gray-900 text-sm sm:text-base break-words">
                                            {{ strtoupper($booking->kendaraan->merk . ' ' . $booking->kendaraan->model) }}
                                        </h5>
                                        <div class="flex gap-2 sm:gap-3 text-xs text-gray-600 mt-1">
                                            <span class="whitespace-nowrap"><i class="fas fa-users mr-1"></i>{{ $booking->kendaraan->kapasitas_penumpang }}</span>
                                            <span class="whitespace-nowrap"><i class="fas fa-cog mr-1"></i>{{ ucfirst($booking->kendaraan->transmisi) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Rental Info -->
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-3 text-sm sm:text-base">Detail Rental</h4>
                                <div class="space-y-2 text-xs sm:text-sm">
                                    <div class="flex justify-between gap-2">
                                        <span class="text-gray-600 whitespace-nowrap">Tanggal Mulai:</span>
                                        <span class="font-medium text-right">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->isoFormat('D MMM Y') }}</span>
                                    </div>
                                    <div class="flex justify-between gap-2">
                                        <span class="text-gray-600 whitespace-nowrap">Tanggal Selesai:</span>
                                        <span class="font-medium text-right">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->isoFormat('D MMM Y') }}</span>
                                    </div>
                                    <div class="flex justify-between gap-2">
                                        <span class="text-gray-600 whitespace-nowrap">Jam:</span>
                                        <span class="font-medium">{{ $booking->jam_mulai }} WIB</span>
                                    </div>
                                    <div class="flex justify-between gap-2">
                                        <span class="text-gray-600 whitespace-nowrap">Durasi:</span>
                                        <span class="font-medium">{{ $booking->durasi }} Hari</span>
                                    </div>
                                    <div class="flex justify-between gap-2">
                                        <span class="text-gray-600 whitespace-nowrap">Pembayaran:</span>
                                        <span class="font-medium capitalize text-right">
                                            {{ $booking->metode_pembayaran == 'cash' ? 'Bayar di Tempat' : 'Transfer Bank' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-3 mt-4 sm:mt-6 pt-3 sm:pt-4 border-t">
                            <a href="{{ route('booking.detail', $booking->id) }}" 
                                class="flex-1 sm:flex-none text-center px-4 sm:px-6 py-2 border border-gray-300 rounded-lg text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 transition whitespace-nowrap">
                                <i class="fas fa-eye mr-2"></i>Lihat Detail
                            </a>

                            @if(in_array($booking->status, ['pending', 'dikonfirmasi']))
                                <button onclick="cancelBooking('{{ $booking->id }}', '{{ $booking->nomor_booking }}')" 
                                    class="cursor-pointer flex-1 sm:flex-none text-center px-4 sm:px-6 py-2 bg-red-600 text-white rounded-lg text-xs sm:text-sm font-medium hover:bg-red-700 transition whitespace-nowrap">
                                    <i class="fas fa-times mr-2"></i>Batalkan
                                </button>
                            @endif

                            @if($booking->status == 'selesai')
                                <button class="flex-1 sm:flex-none text-center px-4 sm:px-6 py-2 bg-indigo-600 text-white rounded-lg text-xs sm:text-sm font-medium hover:bg-indigo-700 transition whitespace-nowrap">
                                    <i class="fas fa-star mr-2"></i>Beri Ulasan
                                </button>
                            @endif
                        </div>

                        <!-- Catatan Pembatalan -->
                        @if($booking->status == 'dibatalkan' && $booking->alasan_pembatalan)
                            <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-3">
                                <p class="text-xs sm:text-sm text-red-800 break-words">
                                    <strong>Alasan Pembatalan:</strong><br>
                                    {{ $booking->alasan_pembatalan }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg sm:rounded-xl shadow-md p-8 sm:p-12 text-center">
                    <i class="fas fa-inbox text-gray-300 text-5xl sm:text-6xl mb-4"></i>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Belum Ada Booking</h3>
                    <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">Anda belum memiliki riwayat booking kendaraan</p>
                    <a href="{{ route('search') }}" 
                        class="inline-block px-5 sm:px-6 py-2.5 sm:py-3 bg-indigo-600 text-white rounded-lg text-sm sm:text-base font-semibold hover:bg-indigo-700 transition">
                        <i class="fas fa-search mr-2"></i>Cari Kendaraan
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
            <div class="mt-6 sm:mt-8">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-4 sm:p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Batalkan Booking</h3>
        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">Apakah Anda yakin ingin membatalkan booking ini? Tindakan ini tidak dapat dibatalkan.</p>
        
        <form id="cancelForm" method="POST">
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

<style>
    /* Hide scrollbar for tabs */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    // Filter Bookings
    function filterBookings(status) {
        const cards = document.querySelectorAll('.booking-card');
        const tabs = document.querySelectorAll('.filter-tab');
        
        // Update active tab
        tabs.forEach(tab => {
            tab.classList.remove('border-indigo-600', 'text-indigo-600');
            tab.classList.add('border-transparent', 'text-gray-500');
        });
        event.target.classList.remove('border-transparent', 'text-gray-500');
        event.target.classList.add('border-indigo-600', 'text-indigo-600');
        
        // Filter cards
        cards.forEach(card => {
            if (status === 'all') {
                card.style.display = 'block';
            } else {
                if (card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }

    // Cancel Booking
    function cancelBooking(bookingId, nomorBooking) {
        const modal = document.getElementById('cancelModal');
        const form = document.getElementById('cancelForm');
        form.action = `/booking/${bookingId}/cancel`;
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