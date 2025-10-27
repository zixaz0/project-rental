@extends('layouts.admin')

@section('title', 'Data Harga - Admin')

@section('page-title', 'Data Harga Kendaraan')

@section('page-subtitle', 'Kelola harga dan status kendaraan rental')

@section('content')
    <!-- noUiSlider Library - PINDAH KE ATAS DULU -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css">

    <!-- Filter & Action Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <form action="{{ route('admin.harga.index') }}" method="GET" id="filterForm">
            <!-- Baris 1: Search + Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Search Bar -->
                <div>
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-search mr-2"></i>Cari Kendaraan
                    </label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Merk, model, no. plat..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        autocomplete="off">
                </div>

                <!-- Filter Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-info-circle mr-2"></i>Status
                    </label>
                    <select name="status" id="status"
                        class="cursor-pointer w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}> 🟢 Tersedia
                        </option>
                        <option value="tidak_tersedia" {{ request('status') == 'tidak_tersedia' ? 'selected' : '' }}> 🔴
                            Tidak
                            Tersedia</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}> 🟡 Pending</option>
                        <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}> 🔵 Disewa</option>
                    </select>
                </div>
            </div>

            <!-- Baris 2: Harga + Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Range Slider Harga -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-money-bill-wave mr-2"></i>Harga
                    </label>
                    <div class="border border-gray-300 rounded-lg p-4">
                        <div id="hargaDisplay" class="text-center text-sm font-semibold text-indigo-600 mb-2">
                            Rp 0 - Rp 5.000.000
                        </div>
                        <div id="hargaSlider" class="h-2 mb-3"></div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Rp 0</span>
                            <span>Rp 5.000.000</span>
                        </div>
                    </div>
                    <input type="hidden" name="harga_min" id="harga_min" value="{{ request('harga_min', 0) }}">
                    <input type="hidden" name="harga_max" id="harga_max" value="{{ request('harga_max', 5000000) }}">
                </div>

                <!-- Dropdown Kategori -->
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tags mr-2"></i>Kategori
                    </label>
                    <select name="kategori" id="kategori"
                        class="cursor-pointer w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}" {{ request('kategori') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tombol Aksi - PINDAHKAN KE LUAR GRID -->
            <div class="flex flex-wrap justify-end gap-3 pt-3 border-t border-gray-100">
                @php
                    $hasActiveFilter =
                        request()->filled('search') ||
                        request()->filled('status') ||
                        request()->filled('kategori') ||
                        request('harga_min', 0) != 0 ||
                        request('harga_max', 5000000) != 5000000;
                @endphp

                <a href="{{ route('admin.harga.index') }}"
                    class="inline-flex items-center px-5 py-2.5 {{ $hasActiveFilter ? 'bg-red-600 hover:bg-red-700' : 'bg-gray-400 cursor-not-allowed opacity-60' }} text-white font-medium rounded-lg shadow-sm transition">
                    <i class="fas fa-times mr-2"></i> Clear Filter
                </a>

                <a href="{{ route('admin.harga.create') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-sm transition">
                    <i class="fas fa-plus mr-2"></i> Tambah Harga
                </a>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Plat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga/Hari</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($harga as $item)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loop->iteration + ($harga->currentPage() - 1) * $harga->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->kendaraan->foto)
                                    <img src="{{ asset($item->kendaraan->foto) }}"
                                        alt="{{ $item->kendaraan->merk }} {{ $item->kendaraan->model }}"
                                        class="w-24 h-16 rounded-lg object-cover shadow-sm"
                                        onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                                @else
                                    <div class="w-24 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $item->kendaraan->merk }}</div>
                                <div class="text-sm text-gray-500">{{ $item->kendaraan->model }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    <i class="fas fa-tag mr-1"></i>
                                    {{ $item->kendaraan->kategori->nama }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-md text-xs font-mono font-semibold bg-gray-800 text-white">
                                    {{ $item->kendaraan->no_plat }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-green-600">
                                    Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusConfig = [
                                        'tersedia' => [
                                            'class' => 'bg-green-100 text-green-800',
                                            'icon' => 'fa-check-circle',
                                        ],
                                        'tidak_tersedia' => [
                                            'class' => 'bg-red-100 text-red-800',
                                            'icon' => 'fa-times-circle',
                                        ],
                                        'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock'],
                                        'disewa' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-key'],
                                    ];
                                    $config = $statusConfig[$item->status] ?? [
                                        'class' => 'bg-gray-100 text-gray-800',
                                        'icon' => 'fa-question',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['class'] }}">
                                    <i class="fas {{ $config['icon'] }} mr-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    @php
                                        $detailData = [
                                            'id' => $item->id,
                                            'merk' => $item->kendaraan->merk,
                                            'model' => $item->kendaraan->model,
                                            'no_plat' => $item->kendaraan->no_plat,
                                            'kategori' => $item->kendaraan->kategori->nama,
                                            'harga' => number_format($item->harga_per_hari, 0, ',', '.'),
                                            'status' => ucfirst(str_replace('_', ' ', $item->status)),
                                            'foto' => $item->kendaraan->foto
                                                ? asset($item->kendaraan->foto)
                                                : asset('images/no-image.png'),
                                            'created_at' => $item->created_at->format('d M Y H:i'),
                                            'updated_at' => $item->updated_at->format('d M Y H:i'),
                                        ];
                                    @endphp
                                    <button type="button" onclick='showDetail(@json($detailData))'
                                        class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-indigo run bu-500 hover:bg-indigo-600 text-white rounded-md transition duration-150"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button"
                                        onclick="confirmEdit({{ $item->id }}, '{{ $item->kendaraan->merk }} {{ $item->kendaraan->model }}', '{{ $item->kendaraan->no_plat }}')"
                                        class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md transition duration-150"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}"
                                        action="{{ route('admin.harga.destroy', $item->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->kendaraan->merk }} {{ $item->kendaraan->model }}', '{{ $item->kendaraan->no_plat }}')"
                                            class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md transition duration-150"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-money-bill-wave text-gray-300 text-5xl mb-3"></i>
                                    <p class="text-gray-500 text-lg">Belum ada data harga</p>
                                    <a href="{{ route('admin.harga.create') }}"
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Harga Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($harga->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($harga->onFirstPage())
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $harga->previousPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                        @endif

                        @if ($harga->hasMorePages())
                            <a href="{{ $harga->nextPageUrl() }}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        @else
                            <span
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                Next
                            </span>
                        @endif
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Menampilkan
                                <span class="font-medium">{{ $harga->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $harga->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $harga->total() }}</span>
                                data harga
                            </p>
                        </div>
                        <div>
                            {{ $harga->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .swal-detail-modal {
            border-radius: 1rem !important;
        }

        .swal-html-container {
            margin: 0 !important;
            padding: 1rem !important;
        }

        /* noUiSlider Custom Styling */
        .noUi-target {
            background: #e5e7eb !important;
            border: none !important;
            box-shadow: none !important;
            height: 6px !important;
            border-radius: 4px !important;
        }

        .noUi-connect {
            background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%) !important;
        }

        .noUi-handle {
            width: 16px !important;
            height: 16px !important;
            border-radius: 50% !important;
            background: #4f46e5 !important;
            border: 2px solid white !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2) !important;
            cursor: grab !important;
            right: -7px !important;
            top: -4px !important;
        }

        .noUi-handle:before,
        .noUi-handle:after {
            display: none !important;
        }

        .noUi-handle:hover {
            background: #4338ca !important;
            transform: scale(1.15) !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3) !important;
        }

        .noUi-handle:active {
            background: #3730a3 !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.35) !important;
            cursor: grabbing !important;
            transform: scale(1.2) !important;
        }

        .noUi-horizontal .noUi-tooltip {
            display: none !important;
        }

        /* Smooth transition */
        .noUi-handle {
            transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease !important;
        }

        /* Fix z-index untuk handle */
        .noUi-horizontal .noUi-handle {
            outline: none !important;
        }

        /* Pastikan touch area cukup besar untuk mobile */
        .noUi-touch-area {
            height: 100% !important;
            width: 100% !important;
        }
    </style>

    <!-- Load noUiSlider Library SEBELUM script dijalankan -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>

    <script>
        // Tunggu DOM dan Library loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Pastikan noUiSlider sudah loaded
            if (typeof noUiSlider === 'undefined') {
                console.error('noUiSlider library tidak berhasil dimuat!');
                return;
            }

            // Debounce function untuk search
            let searchTimeout;
            const searchInput = document.getElementById('search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        document.getElementById('filterForm').submit();
                    }, 500);
                });
            }

            // Auto submit saat filter berubah
            const statusSelect = document.getElementById('status');
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    document.getElementById('filterForm').submit();
                });
            }

            // Initialize Range Slider
            const hargaSlider = document.getElementById('hargaSlider');
            const hargaDisplay = document.getElementById('hargaDisplay');
            const hargaMinInput = document.getElementById('harga_min');
            const hargaMaxInput = document.getElementById('harga_max');

            if (!hargaSlider) {
                console.error('Element hargaSlider tidak ditemukan');
                return;
            }

            // Destroy existing slider if any
            if (hargaSlider.noUiSlider) {
                hargaSlider.noUiSlider.destroy();
            }

            // Get current values from hidden inputs
            const currentMin = parseInt(hargaMinInput.value) || 0;
            const currentMax = parseInt(hargaMaxInput.value) || 5000000;

            // Create slider
            try {
                noUiSlider.create(hargaSlider, {
                    start: [currentMin, currentMax],
                    connect: true,
                    step: 50000,
                    range: {
                        'min': 0,
                        'max': 5000000
                    },
                    format: {
                        to: function(value) {
                            return Math.round(value);
                        },
                        from: function(value) {
                            return Number(value);
                        }
                    }
                });

                console.log('✅ Slider berhasil diinisialisasi');

                // Format Rupiah function
                const formatRupiah = (angka) => {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(angka);
                };

                // Update display and hidden inputs
                hargaSlider.noUiSlider.on('update', function(values, handle) {
                    const min = parseInt(values[0]);
                    const max = parseInt(values[1]);

                    hargaDisplay.textContent = `${formatRupiah(min)} - ${formatRupiah(max)}`;
                    hargaMinInput.value = min;
                    hargaMaxInput.value = max;
                });

                // Submit form on slider change (with debounce)
                let sliderTimeout;
                hargaSlider.noUiSlider.on('change', function(values) {
                    clearTimeout(sliderTimeout);
                    sliderTimeout = setTimeout(() => {
                        // Cek apakah nilai slider berbeda dari default
                        const min = parseInt(values[0]);
                        const max = parseInt(values[1]);

                        // Hanya submit jika nilai berubah dari default (0 - 5000000)
                        if (min !== 0 || max !== 5000000) {
                            document.getElementById('filterForm').submit();
                        }
                    }, 800);
                });

            } catch (error) {
                console.error('❌ Error saat membuat slider:', error);
            }
        });

        // Show Detail Function
        function showDetail(data) {
            Swal.fire({
                title: '<div class="text-2xl font-bold text-gray-800"><i class="fas fa-money-bill-wave mr-2 text-green-600"></i>Detail Harga</div>',
                html: `
                    <div class="text-left">
                        <!-- Foto Kendaraan -->
                        <div class="mb-4 flex justify-center bg-gray-100 rounded-lg p-4">
                            <img src="${data.foto}" alt="${data.merk} ${data.model}" 
                                class="w-full max-h-80 object-contain rounded-lg"
                                onerror="this.src='{{ asset('images/no-image.png') }}'">
                        </div>

                        <!-- Informasi Kendaraan -->
                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-4 rounded-lg mb-4">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">${data.merk} ${data.model}</h3>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">No. Plat</p>
                                    <p class="font-mono font-bold text-sm bg-gray-800 text-white px-3 py-1 rounded inline-block">${data.no_plat}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Kategori</p>
                                    <p class="font-semibold text-gray-800"><i class="fas fa-tag mr-1"></i>${data.kategori}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Harga -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border-2 border-green-200">
                                <div class="flex items-center">
                                    <i class="fas fa-money-bill-wave text-green-600 text-2xl mr-3"></i>
                                    <span class="text-sm text-gray-600">Harga per Hari</span>
                                </div>
                                <span class="font-bold text-green-600 text-2xl">Rp ${data.harga}</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Status</span>
                                </div>
                                <span class="font-semibold text-gray-800">${data.status}</span>
                            </div>
                        </div>

                        <!-- Waktu Update -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-gray-600 mb-1">Dibuat</p>
                                    <p class="font-semibold text-gray-800">${data.created_at}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 mb-1">Terakhir Diupdate</p>
                                    <p class="font-semibold text-gray-800">${data.updated_at}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                width: '700px',
                customClass: {
                    popup: 'swal-detail-modal',
                    htmlContainer: 'swal-html-container'
                }
            });
        }

        // Confirm Edit
        function confirmEdit(id, namaKendaraan, noPlat) {
            Swal.fire({
                title: 'Edit Harga?',
                html: `
                    <div class="text-left">
                        <p class="mb-2">Anda akan mengedit harga kendaraan:</p>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <p class="font-semibold text-gray-800">${namaKendaraan}</p>
                            <p class="text-sm text-gray-600">No. Plat: <span class="font-mono font-bold">${noPlat}</span></p>
                        </div>
                        <p class="mt-3 text-blue-600 text-sm">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pastikan data yang akan diubah sudah benar
                        </p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#eab308',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-edit mr-2"></i>Ya, Edit!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/harga/${id}/edit`;
                }
            });
        }

        // Confirm Delete
        function confirmDelete(id, namaKendaraan, noPlat) {
            Swal.fire({
                title: 'Hapus Harga?',
                html: `
                    <div class="text-left">
                        <p class="mb-2">Anda yakin ingin menghapus harga kendaraan:</p>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <p class="font-semibold text-gray-800">${namaKendaraan}</p>
                            <p class="text-sm text-gray-600">No. Plat: <span class="font-mono font-bold">${noPlat}</span></p>
                        </div>
                        <p class="mt-3 text-red-600 text-sm">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Data yang dihapus tidak dapat dikembalikan!
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
