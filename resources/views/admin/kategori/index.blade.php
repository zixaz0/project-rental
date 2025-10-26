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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kategori as $item)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    <i class="fas fa-tag mr-1"></i>
                                    {{ $item->nama }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700">
                                    {{ Str::limit($item->deskripsi, 80) ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <!-- Edit Button -->
                                    <button type="button"
                                        onclick="confirmEdit({{ $item->id }}, '{{ $item->nama }}')"
                                        class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md transition duration-150"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <!-- Delete Button -->
                                    <form id="delete-form-{{ $item->id }}" 
                                          action="{{ route('admin.kategori.destroy', $item->id) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="confirmDelete({{ $item->id }}, '{{ $item->nama }}')"
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
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
                                    <p class="text-gray-500 text-lg">Belum ada kategori</p>
                                    <a href="{{ route('admin.kategori.create') }}" 
                                       class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Kategori Pertama
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