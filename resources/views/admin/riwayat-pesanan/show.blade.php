@extends('layouts.admin')
@section('title', 'Detail Invoice - Admin')
@section('page-title', 'Detail Invoice')
@section('page-subtitle', 'Informasi lengkap invoice dan pembayaran')

@section('content')
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $invoice->nomor_invoice }}</h1>
                <p class="text-gray-600">Dibuat: {{ $invoice->created_at->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</p>
            </div>
            <div>
                @if($invoice->status_pembayaran == 'lunas')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        LUNAS
                    </span>
                @elseif($invoice->status_pembayaran == 'pending')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        PENDING
                    </span>
                @elseif($invoice->status_pembayaran == 'dibatalkan')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                        DIBATALKAN
                    </span>
                @else
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                        BELUM BAYAR
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-bold text-gray-900 mb-4">Aksi</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.riwayat-pesanan.index') }}" 
                class="cursor-pointer px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-medium transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('admin.riwayat-pesanan.export-pdf', $invoice->id) }}" 
                class="cursor-pointer px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                <i class="fas fa-file-pdf mr-2"></i>Export PDF
            </a>
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
                    <p class="font-medium text-gray-900">{{ $invoice->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium text-gray-900">{{ $invoice->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">No. Telepon</p>
                    <p class="font-medium text-gray-900">{{ $invoice->user->phone ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-file-invoice text-gray-600 mr-2"></i>Informasi Invoice
            </h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Kode Booking</p>
                    <p class="font-medium text-gray-900">{{ $invoice->booking->kode_booking }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal Invoice</p>
                    <p class="font-medium text-gray-900">{{ $invoice->created_at->isoFormat('D MMMM Y - HH:mm') }} WIB</p>
                </div>
                @if($invoice->tanggal_pembayaran)
                <div>
                    <p class="text-sm text-gray-600">Tanggal Pembayaran</p>
                    <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($invoice->tanggal_pembayaran)->isoFormat('D MMMM Y - HH:mm') }} WIB</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Kendaraan Info -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-car text-gray-600 mr-2"></i>Informasi Kendaraan
        </h3>
        <div class="flex gap-4 mb-4">
            @if($invoice->booking->kendaraan->foto)
                <img src="{{ asset($invoice->booking->kendaraan->foto) }}" 
                    class="w-32 h-24 object-cover rounded-lg border border-gray-200"
                    alt="{{ $invoice->booking->mobil->nama_mobil }}">
            @else
                <div class="w-32 h-24 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                    <i class="fas fa-car text-gray-400 text-3xl"></i>
                </div>
            @endif
            <div class="flex-1">
                <h4 class="font-bold text-gray-900 text-lg">{{ strtoupper($invoice->booking->mobil->nama_mobil) }}</h4>
                <p class="text-sm text-gray-600 mb-2">{{ $invoice->booking->mobil->merek }} - {{ $invoice->booking->mobil->tahun }}</p>
                <div class="flex gap-2">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $invoice->booking->mobil->no_plat }}
                    </span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                        {{ $invoice->booking->mobil->transmisi }}
                    </span>
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
                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($invoice->booking->tanggal_mulai)->isoFormat('D MMMM Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Tanggal Selesai</span>
                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($invoice->booking->tanggal_selesai)->isoFormat('D MMMM Y') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Lama Sewa</span>
                    <span class="font-medium text-gray-900">{{ $invoice->booking->lama_sewa }} Hari</span>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Harga per Hari</span>
                    <span class="font-medium text-gray-900">Rp {{ number_format($invoice->booking->mobil->harga_sewa, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium text-gray-900">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        @if($invoice->booking->catatan)
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Catatan:</strong> {{ $invoice->booking->catatan }}
            </p>
        </div>
        @endif
    </div>

    <!-- Ringkasan Pembayaran -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-money-bill-wave text-gray-600 mr-2"></i>Ringkasan Pembayaran
        </h3>
        <div class="space-y-3">
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Subtotal Rental</span>
                <span class="font-medium text-gray-900">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
            </div>
            
            @if($invoice->biaya_tambahan > 0)
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Biaya Tambahan</span>
                <span class="font-medium text-gray-900">Rp {{ number_format($invoice->biaya_tambahan, 0, ',', '.') }}</span>
            </div>
            @endif

            @if($invoice->diskon > 0)
            <div class="flex justify-between py-2 border-b bg-green-50">
                <span class="text-gray-600">Diskon</span>
                <span class="font-medium text-green-600">- Rp {{ number_format($invoice->diskon, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="flex justify-between py-2 pt-4 border-t-2">
                <span class="font-semibold text-gray-900 text-lg">Total Invoice</span>
                <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($invoice->total_invoice, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
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
</script>
@endpush