@extends('layouts.admin')
@section('title', 'Kelola Booking - Admin')
@section('page-title', 'Kelola Booking')
@section('page-subtitle', 'Verifikasi dan kelola semua booking rental kendaraan')

@section('content')
    <!-- Filter & Search Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('admin.bookings.index') }}" method="GET" id="filterForm">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                <!-- Filter -->
                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Bar -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1"></i>Cari Booking
                        </label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Nomor booking, nama customer..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            autocomplete="off">
                    </div>

                    <!-- Filter Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-filter mr-1"></i>Status
                        </label>
                        <select name="status" id="status"
                            class="cursor-pointer w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="dalam_perjalanan" {{ request('status') == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Filter Tanggal -->
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-1"></i>Tanggal Mulai
                        </label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex items-end gap-2">
                    <a href="{{ route('admin.bookings.index') }}"
                        class="inline-flex items-center px-4 py-2 {{ request()->hasAny(['search', 'status', 'tanggal']) ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 hover:bg-gray-500' }} text-white rounded-lg transition duration-150">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $booking->nomor_booking }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->created_at->isoFormat('D MMM Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $booking->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ strtoupper($booking->kendaraan->merk) }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $booking->kendaraan->model }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div>{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->isoFormat('D MMM') }}</div>
                                <div class="text-gray-500">{{ $booking->durasi }} hari</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-green-600">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusConfig = [
                                        'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock'],
                                        'dikonfirmasi' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-check-circle'],
                                        'dalam_perjalanan' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'fa-car'],
                                        'selesai' => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-flag-checkered'],
                                        'dibatalkan' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'fa-times-circle'],
                                    ];
                                    $config = $statusConfig[$booking->status] ?? ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-question'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['class'] }}">
                                    <i class="fas {{ $config['icon'] }} mr-1"></i>
                                    {{ strtoupper(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                    class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md transition duration-150"
                                    title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-gray-300 text-5xl mb-3"></i>
                                    <p class="text-gray-500 text-lg">Belum ada data booking</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($bookings->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $bookings->previousPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                        @endif

                        @if ($bookings->hasMorePages())
                            <a href="{{ $bookings->nextPageUrl() }}"
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
                                <span class="font-medium">{{ $bookings->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $bookings->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $bookings->total() }}</span>
                                booking
                            </p>
                        </div>
                        <div>
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
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

        document.getElementById('tanggal').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    </script>
@endsection