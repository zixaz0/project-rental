@extends('layouts.admin')
@section('title', 'Management Kategori - Admin')
@section('page-title', 'Management Kategori')
@section('page-subtitle', 'Kelola semua kategori kendaraan rental Anda')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-end">
            <a href="{{ route('admin.kategori.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>
                Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" colspan="2">Jenis</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kategori as $namaKategori => $group)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <!-- Nomor urut -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $loop->iteration }}
                            </td>

                            <!-- Nama Kategori -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                                    <i class="fas fa-tag mr-2"></i>
                                    {{ $namaKategori }}
                                </span>
                            </td>

                            <!-- Daftar Jenis dengan Dropdown -->
                            <td class="px-6 py-4" colspan="2">
                                <div x-data="{ open: false }" class="space-y-2">
                                    <!-- Trigger Button -->
                                    <button @click="open = !open"
                                        class="cursor-pointer inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold transition group">
                                        <!-- Ikon caret -->
                                        <i :class="open ? 'fas fa-caret-down' : 'fas fa-caret-right'"
                                            class="mr-2 transform transition-transform duration-300"></i>
                                        <span>{{ $group->count() }} Jenis</span>
                                    </button>

                                    <!-- List Jenis -->
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 -translate-y-2"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 -translate-y-2" 
                                         class="ml-6 space-y-2 mt-2">
                                        @foreach ($group as $item)
                                            <div class="flex justify-between items-center bg-gray-50 px-4 py-3 rounded-lg shadow-sm hover:bg-gray-100 transition">
                                                <span class="text-gray-800 font-medium">{{ $item->jenis }}</span>
                                                
                                                <div class="flex items-center gap-2">
                                                    <!-- Tombol Edit -->
                                                    <button type="button"
                                                        onclick="confirmEdit({{ $item->id }}, '{{ $item->nama }}')"
                                                        class="cursor-pointer group relative flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full shadow-md transition">
                                                        <i class="fas fa-edit text-sm"></i>
                                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                                            Edit
                                                        </span>
                                                    </button>

                                                    <!-- Tombol Hapus -->
                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('admin.kategori.destroy', $item->id) }}"
                                                        method="POST" 
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->nama }}')"
                                                            class="cursor-pointer group relative flex items-center justify-center w-9 h-9 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-md transition cursor-pointer">
                                                            <i class="fas fa-trash text-sm"></i>
                                                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                                                Hapus
                                                            </span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <i class="fas fa-folder-open text-gray-300 text-6xl"></i>
                                    <p class="text-gray-500 text-lg font-medium">Belum ada kategori</p>
                                    <a href="{{ route('admin.kategori.create') }}" 
                                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition">
                                        <i class="fas fa-plus"></i>
                                        <span>Tambah Kategori Pertama</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Konfirmasi Edit
    function confirmEdit(id, namaKategori) {
        Swal.fire({
            title: 'Edit Kategori?',
            html: `
                <div class="text-left">
                    <p class="mb-2">Anda akan mengedit kategori:</p>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <p class="font-semibold text-gray-800">${namaKategori}</p>
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
                window.location.href = `/admin/kategori/${id}/edit`;
            }
        });
    }

    // Konfirmasi Delete
    function confirmDelete(id, namaKategori) {
        Swal.fire({
            title: 'Hapus Kategori?',
            html: `
                <div class="text-left">
                    <p class="mb-2">Anda yakin ingin menghapus kategori:</p>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <p class="font-semibold text-gray-800">${namaKategori}</p>
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
</style>
@endsection