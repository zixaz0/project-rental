@extends('layouts.admin')
@section('title', 'Riwayat Pesanan - Admin')
@section('page-title', 'Riwayat Pesanan')
@section('page-subtitle', 'Kelola semua riwayat transaksi dan pembayaran')

@section('content')
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Pendapatan -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-2">Total Pendapatan (Lunas)</p>
                    <h3 class="text-3xl font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-check-circle text-4xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pending -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium mb-2">Pending</p>
                    <h3 class="text-3xl font-bold">Rp {{ number_format($totalPending, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-clock text-4xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Belum Bayar -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-2">Belum Bayar</p>
                    <h3 class="text-3xl font-bold">Rp {{ number_format($totalBelumBayar, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-exclamation-circle text-4xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-filter mr-2 text-indigo-600"></i>Filter & Pencarian
        </h3>
        <form method="GET" action="{{ route('admin.riwayat-pesanan.index') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Status Pembayaran -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-money-check-alt mr-1"></i>Status Pembayaran
                    </label>
                    <select name="status" class="cursor-pointer w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="belum_bayar" {{ request('status') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <!-- Dari Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-1"></i>Dari Tanggal
                    </label>
                    <input type="date" name="dari_tanggal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" value="{{ request('dari_tanggal') }}">
                </div>

                <!-- Sampai Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-check mr-1"></i>Sampai Tanggal
                    </label>
                    <input type="date" name="sampai_tanggal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" value="{{ request('sampai_tanggal') }}">
                </div>

                <!-- Pencarian -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i>Pencarian
                    </label>
                    <input type="text" name="search" id="search" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Cari invoice, booking..." value="{{ request('search') }}" autocomplete="off">
                </div>
            </div>

            <div class="flex gap-2 mt-4">
                <button type="submit" class="inline-flex items-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.riwayat-pesanan.index') }}" class="inline-flex items-center px-5 py-2 {{ request()->hasAny(['status', 'dari_tanggal', 'sampai_tanggal', 'search']) ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 hover:bg-gray-500' }} text-white font-semibold rounded-lg shadow-md transition duration-150">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($invoices as $invoice)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <!-- Left Section: Info Utama -->
                        <div class="flex-1">
                            <div class="flex items-start gap-4">
                                <!-- Icon/Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white">
                                        <i class="fas fa-file-invoice text-2xl"></i>
                                    </div>
                                </div>

                                <!-- Invoice Info -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-xl font-bold text-gray-800">{{ $invoice->nomor_invoice }}</h3>
                                        @if($invoice->status_pembayaran == 'lunas')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Lunas
                                            </span>
                                        @elseif($invoice->status_pembayaran == 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        @elseif($invoice->status_pembayaran == 'belum_bayar')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i>Belum Bayar
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                                <i class="fas fa-ban mr-1"></i>Dibatalkan
                                            </span>
                                        @endif
                                        @if($invoice->hari_keterlambatan > 0)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Denda {{ $invoice->hari_keterlambatan }} hari
                                            </span>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-ticket-alt w-5 text-indigo-500"></i>
                                            <span class="ml-2">{{ $invoice->booking->kode_booking ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-user w-5 text-purple-500"></i>
                                            <span class="ml-2">{{ $invoice->user->name ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-car w-5 text-blue-500"></i>
                                            <span class="ml-2">{{ $invoice->booking->mobil->nama_mobil ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-calendar w-5 text-green-500"></i>
                                            <span class="ml-2">{{ $invoice->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Section: Total & Actions -->
                        <div class="flex flex-col items-end gap-4">
                            <!-- Total -->
                            <div class="text-right">
                                <p class="text-sm text-gray-500 mb-1">Total Invoice</p>
                                <p class="text-3xl font-bold text-green-600">
                                    Rp {{ number_format($invoice->total_invoice, 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <button type="button" 
                                        onclick="showDetail({{ $invoice->id }})"
                                        class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg transition duration-150"
                                        title="Detail">
                                    <i class="fas fa-eye mr-2"></i>Detail
                                </button>
                                <button type="button" 
                                        class="cursor-pointer inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition duration-150"
                                        onclick="openUpdateModal({{ $invoice->id }}, '{{ $invoice->status_pembayaran }}')"
                                        title="Update Status">
                                    <i class="fas fa-edit mr-2"></i>Update
                                </button>
                                <a href="{{ route('admin.riwayat-pesanan.export-pdf', $invoice->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition duration-150"
                                   title="Export PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Rincian (Expandable) -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <button type="button" 
                                onclick="toggleDetail({{ $invoice->id }})"
                                class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            <i class="fas fa-chevron-down mr-1" id="chevron-{{ $invoice->id }}"></i>
                            Lihat Rincian Biaya
                        </button>
                        <div id="detail-{{ $invoice->id }}" class="hidden mt-3 bg-gray-50 rounded-lg p-4">
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-semibold">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                                </div>
                                @if($invoice->denda_keterlambatan > 0)
                                <div class="flex justify-between text-orange-600">
                                    <span>Denda Keterlambatan ({{ $invoice->hari_keterlambatan }} hari)</span>
                                    <span class="font-semibold">Rp {{ number_format($invoice->denda_keterlambatan, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                @if($invoice->biaya_tambahan > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        Biaya Tambahan
                                        @if($invoice->keterangan_biaya_tambahan)
                                            <span class="text-xs">({{ $invoice->keterangan_biaya_tambahan }})</span>
                                        @endif
                                    </span>
                                    <span class="font-semibold">Rp {{ number_format($invoice->biaya_tambahan, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between pt-2 border-t border-gray-300 text-base">
                                    <span class="font-bold text-gray-800">TOTAL</span>
                                    <span class="font-bold text-green-600">Rp {{ number_format($invoice->total_invoice, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12">
                <div class="flex flex-col items-center justify-center">
                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-xl mb-2">Belum ada riwayat pesanan</p>
                    <p class="text-gray-400 text-sm">Data riwayat pesanan akan muncul di sini</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($invoices->hasPages())
        <div class="mt-6">
            {{ $invoices->links() }}
        </div>
    @endif

    <script>
        // Toggle Detail Rincian
        function toggleDetail(id) {
            const detail = document.getElementById('detail-' + id);
            const chevron = document.getElementById('chevron-' + id);
            
            if (detail.classList.contains('hidden')) {
                detail.classList.remove('hidden');
                chevron.classList.remove('fa-chevron-down');
                chevron.classList.add('fa-chevron-up');
            } else {
                detail.classList.add('hidden');
                chevron.classList.remove('fa-chevron-up');
                chevron.classList.add('fa-chevron-down');
            }
        }

        // Show Detail dengan SweetAlert
        function showDetail(id) {
            window.location.href = `/admin/riwayat-pesanan/${id}`;
        }

        // Open Update Modal
        function openUpdateModal(invoiceId, currentStatus) {
            Swal.fire({
                title: 'Update Status Pembayaran',
                html: `
                    <form id="updateStatusForm" action="/admin/riwayat-pesanan/${invoiceId}/update-status" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Pembayaran</label>
                            <select name="status_pembayaran" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                                <option value="pending" ${currentStatus == 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="lunas" ${currentStatus == 'lunas' ? 'selected' : ''}>Lunas</option>
                                <option value="belum_bayar" ${currentStatus == 'belum_bayar' ? 'selected' : ''}>Belum Bayar</option>
                                <option value="dibatalkan" ${currentStatus == 'dibatalkan' ? 'selected' : ''}>Dibatalkan</option>
                            </select>
                            <p class="mt-2 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Jika status diubah menjadi "Lunas", tanggal pembayaran akan otomatis tercatat.
                            </p>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-save mr-2"></i>Update',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true,
                preConfirm: () => {
                    document.getElementById('updateStatusForm').submit();
                }
            });
        }

        // Auto submit on filter change
        document.querySelectorAll('select[name="status"]').forEach(select => {
            select.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });

        // Debounce search
        let searchTimeout;
        document.getElementById('search').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        });

        // Success notification
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection