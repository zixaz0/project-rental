@extends('layouts.admin')

@section('title', 'Data Kendaraan - Admin')

@section('page-title', 'Data Kendaraan')

@section('page-subtitle', 'Kelola semua kendaraan rental Anda')

@section('content')
    <!-- Filter & Action Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('admin.kendaraan.index') }}" method="GET" id="filterForm">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                <!-- Filter Controls -->
                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Bar -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1"></i>Cari Kendaraan
                        </label>
                        <input type="text" 
                            name="search" 
                            id="search" 
                            value="{{ request('search') }}"
                            placeholder="Merk, model, no. plat..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            autocomplete="off">
                    </div>

                    <!-- Filter Kategori -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1"></i>Kategori
                        </label>
                        <select name="kategori" 
                            id="kategori"
                            class="cursor-pointer w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Transmisi -->
                    <div>
                        <label for="transmisi" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-cog mr-1"></i>Transmisi
                        </label>
                        <select name="transmisi" 
                            id="transmisi"
                            class="cursor-pointer w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">Semua Transmisi</option>
                            <option value="Manual" {{ request('transmisi') == 'Manual' ? 'selected' : '' }}>Manual</option>
                            <option value="Automatic" {{ request('transmisi') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-end gap-2">
                    <a href="{{ route('admin.kendaraan.index') }}" 
                        class="inline-flex items-center px-4 py-2 {{ request()->hasAny(['search', 'kategori', 'transmisi']) ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 hover:bg-gray-500' }} text-white rounded-lg transition duration-150">
                        <i class="fas fa-times mr-2"></i>
                        Clear Filter
                    </a>
                    <a href="{{ route('admin.kendaraan.create') }}"
                        class="inline-flex items-center px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Kendaraan
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transmisi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Plat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga/Hari</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kendaraan as $item)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loop->iteration + ($kendaraan->currentPage() - 1) * $kendaraan->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->foto)
                                    <img src="{{ asset($item->foto) }}" alt="{{ $item->merk }} {{ $item->model }}"
                                        class="w-24 h-16 rounded-lg object-cover shadow-sm"
                                        onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                                @else
                                    <div class="w-24 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    <i class="fas fa-tag mr-1"></i>
                                    {{ $item->kategori->nama }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $item->merk }}</div>
                                <div class="text-sm text-gray-500">{{ $item->model }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-md text-xs font-mono font-semibold bg-gray-800 text-white">
                                    {{ $item->transmisi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-md text-xs font-mono font-semibold bg-gray-800 text-white">
                                    {{ $item->no_plat }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                                {{ $item->tahun }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                Rp {{ number_format($item->harga->harga_per_hari ?? 0, 0, ',', '.') }}
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
                                    $status = $item->harga->status ?? 'tidak_tersedia';
                                    $config = $statusConfig[$status] ?? [
                                        'class' => 'bg-gray-100 text-gray-800',
                                        'icon' => 'fa-question',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['class'] }}">
                                    <i class="fas {{ $config['icon'] }} mr-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    @php
                                        $detailData = [
                                            'id' => $item->id,
                                            'merk' => $item->merk,
                                            'model' => $item->model,
                                            'no_plat' => $item->no_plat,
                                            'tahun' => $item->tahun,
                                            'warna' => $item->warna ?? '-',
                                            'transmisi' => $item->transmisi,
                                            'kapasitas' => $item->kapasitas_penumpang ?? '-',
                                            'kategori' => $item->kategori->nama,
                                            'harga' => number_format($item->harga->harga_per_hari ?? 0, 0, ',', '.'),
                                            'status' => ucfirst(str_replace('_', ' ', $status)),
                                            'foto' => $item->foto ? asset($item->foto) : asset('images/no-image.png'),
                                            'keterangan' => $item->keterangan ?? 'Tidak ada keterangan'
                                        ];
                                    @endphp
                                    <button type="button"
                                        onclick='showDetail(@json($detailData))'
                                        class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md transition duration-150"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button"
                                        onclick="confirmEdit({{ $item->id }}, '{{ $item->merk }} {{ $item->model }}', '{{ $item->no_plat }}')"
                                        class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md transition duration-150"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" 
                                        action="{{ route('admin.kendaraan.destroy', $item->id) }}" 
                                        method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->merk }} {{ $item->model }}', '{{ $item->no_plat }}')"
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
                            <td colspan="10" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-car text-gray-300 text-5xl mb-3"></i>
                                    <p class="text-gray-500 text-lg">Belum ada data kendaraan</p>
                                    <a href="{{ route('admin.kendaraan.create') }}"
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Kendaraan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($kendaraan->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($kendaraan->onFirstPage())
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $kendaraan->previousPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                        @endif

                        @if ($kendaraan->hasMorePages())
                            <a href="{{ $kendaraan->nextPageUrl() }}"
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
                                <span class="font-medium">{{ $kendaraan->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $kendaraan->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $kendaraan->total() }}</span>
                                kendaraan
                            </p>
                        </div>
                        <div>
                            {{ $kendaraan->links() }}
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
            }, 500); // Delay 500ms setelah user selesai mengetik
        });

        // Auto submit saat kategori atau transmisi berubah
        document.getElementById('kategori').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('transmisi').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        // Fungsi Show Detail
        function showDetail(data) {
            Swal.fire({
                title: '<div class="text-2xl font-bold text-gray-800"><i class="fas fa-car mr-2 text-indigo-600"></i>Detail Kendaraan</div>',
                html: `
                    <div class="text-left">
                        <!-- Foto Kendaraan -->
                        <div class="mb-4 flex justify-center bg-gray-100 rounded-lg p-4">
                            <img src="${data.foto}" alt="${data.merk} ${data.model}" 
                                class="w-full max-h-80 object-contain rounded-lg"
                                onerror="this.src='{{ asset('images/no-image.png') }}'">
                        </div>

                        <!-- Informasi Utama -->
                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-4 rounded-lg mb-4">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">${data.merk} ${data.model}</h3>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Transmisi</p>
                                    <p class="font-mono font-bold text-sm bg-gray-800 text-white px-3 py-1 rounded inline-block">${data.transmisi}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">No. Plat</p>
                                    <p class="font-mono font-bold text-sm bg-gray-800 text-white px-3 py-1 rounded inline-block">${data.no_plat}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Tahun</p>
                                    <p class="font-semibold text-gray-800"><i class="far fa-calendar-alt mr-1"></i>${data.tahun}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Warna</p>
                                    <p class="font-semibold text-gray-800"><i class="fas fa-palette mr-1"></i>${data.warna}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Informasi -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-tag text-indigo-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Kategori</span>
                                </div>
                                <span class="font-semibold text-gray-800">${data.kategori}</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-users text-purple-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Kapasitas Penumpang</span>
                                </div>
                                <span class="font-semibold text-gray-800">${data.kapasitas} Orang</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-money-bill-wave text-green-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Harga per Hari</span>
                                </div>
                                <span class="font-bold text-green-600 text-lg">Rp ${data.harga}</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Status</span>
                                </div>
                                <span class="font-semibold text-gray-800">${data.status}</span>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-align-left text-blue-600 mr-2"></i>
                                Keterangan
                            </h4>
                            <p class="text-sm text-gray-700 leading-relaxed">${data.keterangan}</p>
                        </div>
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                width: '800px',
                customClass: {
                    popup: 'swal-detail-modal',
                    htmlContainer: 'swal-html-container'
                }
            });
        }

        // Konfirmasi Edit
        function confirmEdit(id, namaKendaraan, noPlat) {
            Swal.fire({
                title: 'Edit Kendaraan?',
                html: `
                    <div class="text-left">
                        <p class="mb-2">Anda akan mengedit data kendaraan:</p>
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
                focusCancel: true,
                customClass: {
                    popup: 'swal-wide',
                    confirmButton: 'px-6 py-2',
                    cancelButton: 'px-6 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/kendaraan/${id}/edit`;
                }
            });
        }

        // Konfirmasi Delete
        function confirmDelete(id, namaKendaraan, noPlat) {
            Swal.fire({
                title: 'Hapus Kendaraan?',
                html: `
                    <div class="text-left">
                        <p class="mb-2">Anda yakin ingin menghapus kendaraan:</p>
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
                focusCancel: true,
                customClass: {
                    popup: 'swal-wide',
                    confirmButton: 'px-6 py-2',
                    cancelButton: 'px-6 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    <style>
        .swal-wide {
            width: 600px !important;
        }

        .swal-detail-modal {
            border-radius: 1rem !important;
        }

        .swal-html-container {
            margin: 0 !important;
            padding: 1rem !important;
        }
    </style>
@endsection