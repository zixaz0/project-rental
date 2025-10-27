@extends('layouts.admin')

@section('title', 'Edit Kategori - Admin')

@section('page-title', 'Edit Kategori')

@section('page-subtitle', 'Perbarui informasi kategori kendaraan')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.kategori.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="font-medium">Kembali ke Management Kategori</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-edit mr-3"></i>
                Form Edit Kategori
            </h3>
        </div>

        <!-- Form Body -->
        <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Kategori -->
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama', $kategori->nama) }}"
                           placeholder="Contoh: Mobil, Motor, Sepeda"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('nama') border-red-500 @enderror"
                           required
                           autofocus>
                </div>
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Masukkan nama kategori kendaraan</p>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi <span class="text-gray-400 text-xs">(Opsional)</span>
                </label>
                <textarea name="deskripsi" 
                          id="deskripsi" 
                          rows="5"
                          placeholder="Tambahkan deskripsi untuk kategori ini..."
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 resize-none @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Jelaskan kategori ini secara singkat (maksimal 500 karakter)</p>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 pt-6"></div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.kategori.index') }}" 
                   class="inline-flex items-center px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition duration-150">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow-md transition duration-150">
                    <i class="fas fa-save mr-2"></i>
                    Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection