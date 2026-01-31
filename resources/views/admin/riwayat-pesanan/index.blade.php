@extends('layouts.admin')
@section('title', 'Riwayat Pesanan - Admin')
@section('page-title', 'Riwayat Pesanan')
@section('page-subtitle', 'Kelola semua riwayat transaksi dan invoice')

@section('content')

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('admin.riwayat-pesanan.index') }}" method="GET" id="filterForm">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                <!-- Filter -->
                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Bar -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1"></i>Cari Invoice
                        </label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Nomor invoice, nama customer..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            autocomplete="off">
                    </div>

                    <!-- Filter Status Pembayaran -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-filter mr-1"></i>Status Pembayaran
                        </label>
                        <select name="status" id="status"
                            class="cursor-pointer w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">Semua Status</option>
                            <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="belum_bayar" {{ request('status') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Filter Tanggal -->
                    <div>
                        <label for="dari_tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-1"></i>Tanggal Invoice
                        </label>
                        <input type="date" name="dari_tanggal" id="dari_tanggal" value="{{ request('dari_tanggal') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex items-end gap-2">
                    <a href="{{ route('admin.riwayat-pesanan.index') }}"
                        class="inline-flex items-center px-4 py-2 {{ request()->hasAny(['search', 'status', 'dari_tanggal']) ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 hover:bg-gray-500' }} text-white rounded-lg transition duration-150">
                        <i class="fas fa-times mr-2"></i>
                        Clear Filter
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loop->iteration + ($invoices->currentPage() - 1) * $invoices->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $invoice->nomor_invoice }}</div>
                                <div class="text-xs text-gray-500">{{ $invoice->created_at->isoFormat('D MMM Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $invoice->user->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $invoice->user->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $invoice->booking->nomor_booking ?? '-' }}</div>
                                @if($invoice->booking && $invoice->booking->kendaraan)
                                <div class="text-xs text-gray-500">{{ $invoice->booking->kendaraan->merk }} {{ $invoice->booking->kendaraan->model }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div>{{ $invoice->created_at->isoFormat('D MMM Y') }}</div>
                                @if($invoice->hari_keterlambatan > 0)
                                <div class="text-orange-600 text-xs">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>Denda {{ $invoice->hari_keterlambatan }} hari
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-green-600">
                                Rp {{ number_format($invoice->total_invoice, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusConfig = [
                                        'lunas' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle'],
                                        'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock'],
                                        'belum_bayar' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'fa-times-circle'],
                                        'dibatalkan' => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-ban'],
                                    ];
                                    $config = $statusConfig[$invoice->status_pembayaran] ?? ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-question'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['class'] }}">
                                    <i class="fas {{ $config['icon'] }} mr-1"></i>
                                    {{ strtoupper(str_replace('_', ' ', $invoice->status_pembayaran)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.riwayat-pesanan.show', $invoice->id) }}" 
                                        class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md transition duration-150"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.riwayat-pesanan.export-pdf', $invoice->id) }}" 
                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md transition duration-150"
                                        title="Export PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-gray-300 text-5xl mb-3"></i>
                                    <p class="text-gray-500 text-lg">Belum ada data riwayat pesanan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($invoices->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($invoices->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $invoices->previousPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                        @endif

                        @if ($invoices->hasMorePages())
                            <a href="{{ $invoices->nextPageUrl() }}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        @else
                            <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                Next
                            </span>
                        @endif
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Menampilkan
                                <span class="font-medium">{{ $invoices->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $invoices->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $invoices->total() }}</span>
                                invoice
                            </p>
                        </div>
                        <div>
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
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

    // Debounce function untuk search (realtime)
    let searchTimeout;
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });

    // Auto submit saat status atau tanggal berubah
    document.getElementById('status').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });

    document.getElementById('dari_tanggal').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
</script>
@endpush