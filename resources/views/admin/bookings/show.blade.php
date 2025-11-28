@extends('layouts.admin')
@section('title', 'Detail Booking - Admin')
@section('page-title', 'Detail Booking')
@section('page-subtitle', 'Informasi lengkap booking dan verifikasi')

@section('content')
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $booking->nomor_booking }}</h1>
                <p class="text-gray-600">Dibuat: {{ $booking->created_at->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</p>
            </div>
            <div>
                @if($booking->status == 'pending')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        PENDING
                    </span>
                @elseif($booking->status == 'dikonfirmasi')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                        DIKONFIRMASI
                    </span>
                @elseif($booking->status == 'dalam_perjalanan')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        DALAM PERJALANAN
                    </span>
                @elseif($booking->status == 'selesai')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                        SELESAI
                    </span>
                @else
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                        DIBATALKAN
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-bold text-gray-900 mb-4">Aksi</h3>
        <div class="flex flex-wrap gap-3">
            @if($booking->status == 'pending')
                <button onclick="confirmBooking()" 
                    class="cursor-pointer px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition">
                    <i class="fas fa-check mr-2"></i>Konfirmasi Booking
                </button>
            @endif

            @if($booking->status == 'dikonfirmasi')
                <button onclick="startTrip()" 
                    class="cursor-pointer px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">
                    <i class="fas fa-play mr-2"></i>Mulai Perjalanan
                </button>
            @endif

            @if($booking->status == 'dalam_perjalanan')
                <button onclick="openCompleteModal()" 
                    class="cursor-pointer px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition">
                    <i class="fas fa-flag-checkered mr-2"></i>Selesaikan & Buat Invoice
                </button>
            @endif

            @if(in_array($booking->status, ['pending', 'dikonfirmasi']))
                <button onclick="openCancelModal()" 
                    class="cursor-pointer px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                    <i class="fas fa-times mr-2"></i>Batalkan Booking
                </button>
            @endif
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user text-gray-600 mr-2"></i>Informasi Customer
            </h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="font-medium text-gray-900">{{ $booking->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium text-gray-900">{{ $booking->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">No. Telepon</p>
                    <p class="font-medium text-gray-900">{{ $booking->user->phone ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Kendaraan Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-car text-gray-600 mr-2"></i>Informasi Kendaraan
            </h3>
            <div class="flex gap-4 mb-4">
                <img src="{{ asset($booking->kendaraan->foto) }}" 
                    class="w-24 h-20 object-contain bg-gray-50 rounded border border-gray-200">
                <div>
                    <h4 class="font-bold text-gray-900">{{ strtoupper($booking->kendaraan->merk . ' ' . $booking->kendaraan->model) }}</h4>
                    <p class="text-sm text-gray-600">{{ $booking->kendaraan->no_plat }}</p>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Status Kendaraan:</span>
                    <span class="font-medium capitalize text-gray-900">{{ $booking->kendaraan->harga->status }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Rental Details -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-calendar-alt text-gray-600 mr-2"></i>Detail Rental
        </h3>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Tanggal Mulai</span>
                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->isoFormat('D MMMM Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Tanggal Selesai</span>
                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->isoFormat('D MMMM Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Jam Mulai</span>
                    <span class="font-medium text-gray-900">{{ $booking->jam_mulai }} WIB</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Durasi</span>
                    <span class="font-medium text-gray-900">{{ $booking->durasi }} Hari</span>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Harga per Hari</span>
                    <span class="font-medium text-gray-900">Rp {{ number_format($booking->harga_per_hari, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Metode Pembayaran</span>
                    <span class="font-medium text-gray-900 capitalize">{{ $booking->metode_pembayaran == 'cash' ? 'Cash' : 'Transfer' }}</span>
                </div>
                <div class="flex justify-between py-2 pt-4 border-t-2">
                    <span class="font-semibold text-gray-900">Total</span>
                    <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice (if exists) -->
    @if($booking->invoice)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-file-invoice text-gray-600 mr-2"></i>Invoice
        </h3>
        <div class="space-y-3">
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Nomor Invoice</span>
                <span class="font-medium text-gray-900">{{ $booking->invoice->nomor_invoice }}</span>
            </div>
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Subtotal Rental</span>
                <span class="font-medium text-gray-900">Rp {{ number_format($booking->invoice->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($booking->invoice->hari_keterlambatan > 0)
            <div class="flex justify-between py-2 border-b bg-yellow-50">
                <span class="text-gray-600">Denda Keterlambatan ({{ $booking->invoice->hari_keterlambatan }} hari)</span>
                <span class="font-medium text-red-600">Rp {{ number_format($booking->invoice->denda_keterlambatan, 0, ',', '.') }}</span>
            </div>
            @endif
            @if($booking->invoice->biaya_tambahan > 0)
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Biaya Tambahan</span>
                <span class="font-medium text-gray-900">Rp {{ number_format($booking->invoice->biaya_tambahan, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between py-2 pt-4 border-t-2">
                <span class="font-semibold text-gray-900">Total Invoice</span>
                <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($booking->invoice->total_invoice, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Forms for submission -->
    <form id="confirmForm" action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" style="display:none;">
        @csrf
    </form>
    <form id="startTripForm" action="{{ route('admin.bookings.start-trip', $booking->id) }}" method="POST" style="display:none;">
        @csrf
    </form>
    <form id="completeForm" action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="tanggal_pengembalian" id="hiddenTanggalPengembalian">
        <input type="hidden" name="biaya_tambahan" id="hiddenBiayaTambahan">
        <input type="hidden" name="keterangan_biaya_tambahan" id="hiddenKeteranganBiaya">
    </form>
    <form id="cancelForm" action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="alasan_pembatalan" id="hiddenAlasanPembatalan">
    </form>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .swal2-popup {
        font-family: inherit;
    }
    .swal2-input, .swal2-textarea {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.75rem;
        font-size: 0.875rem;
    }
    .swal2-input:focus, .swal2-textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Session Messages
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#10b981',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'OK'
        });
    @endif

    // Confirm Booking
    function confirmBooking() {
        Swal.fire({
            title: 'Konfirmasi Booking',
            text: 'Status kendaraan akan diubah menjadi DISEWA. Lanjutkan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Konfirmasi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('confirmForm').submit();
            }
        });
    }

    // Start Trip
    function startTrip() {
        Swal.fire({
            title: 'Mulai Perjalanan',
            text: 'Mulai perjalanan sekarang?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Mulai',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('startTripForm').submit();
            }
        });
    }

    // Complete Booking Modal
    async function openCompleteModal() {
        const { value: formValues } = await Swal.fire({
            title: 'Selesaikan Booking',
            html: `
                <div class="text-left space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Pengembalian <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_pengembalian" value="{{ date('Y-m-d') }}" 
                            class="swal2-input w-full" style="margin: 0; width: 100%;">
                        <p class="text-xs text-gray-500 mt-1">Tanggal selesai: {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->isoFormat('D MMMM Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Biaya Tambahan (Opsional)
                        </label>
                        <input type="number" id="biaya_tambahan" min="0" step="1000" placeholder="0" 
                            class="swal2-input w-full" style="margin: 0; width: 100%;">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Keterangan Biaya Tambahan
                        </label>
                        <textarea id="keterangan_biaya" rows="2" 
                            class="swal2-textarea w-full" style="margin: 0; width: 100%;"
                            placeholder="Contoh: Biaya perbaikan spion kanan"></textarea>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <p class="text-xs text-yellow-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            Denda keterlambatan 50% dari harga per hari akan dihitung otomatis.
                        </p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Selesaikan',
            cancelButtonText: 'Batal',
            width: '600px',
            preConfirm: () => {
                const tanggal = document.getElementById('tanggal_pengembalian').value;
                const biaya = document.getElementById('biaya_tambahan').value;
                const keterangan = document.getElementById('keterangan_biaya').value;
                
                if (!tanggal) {
                    Swal.showValidationMessage('Tanggal pengembalian wajib diisi');
                    return false;
                }
                
                return {
                    tanggal_pengembalian: tanggal,
                    biaya_tambahan: biaya || 0,
                    keterangan_biaya_tambahan: keterangan
                };
            }
        });

        if (formValues) {
            document.getElementById('hiddenTanggalPengembalian').value = formValues.tanggal_pengembalian;
            document.getElementById('hiddenBiayaTambahan').value = formValues.biaya_tambahan;
            document.getElementById('hiddenKeteranganBiaya').value = formValues.keterangan_biaya_tambahan;
            document.getElementById('completeForm').submit();
        }
    }

    // Cancel Booking Modal
    async function openCancelModal() {
        const { value: alasan } = await Swal.fire({
            title: 'Batalkan Booking',
            html: `
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Pembatalan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="alasan_pembatalan" rows="3" 
                        class="swal2-textarea w-full" style="margin: 0; width: 100%;"
                        placeholder="Masukkan alasan pembatalan"></textarea>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Batal',
            width: '500px',
            preConfirm: () => {
                const alasan = document.getElementById('alasan_pembatalan').value;
                if (!alasan) {
                    Swal.showValidationMessage('Alasan pembatalan wajib diisi');
                    return false;
                }
                return alasan;
            }
        });

        if (alasan) {
            document.getElementById('hiddenAlasanPembatalan').value = alasan;
            document.getElementById('cancelForm').submit();
        }
    }
</script>
@endpush