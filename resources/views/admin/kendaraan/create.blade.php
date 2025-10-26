@extends('layouts.admin')

@section('title', 'Tambah Kendaraan - Admin')

@section('page-title', 'Tambah Kendaraan')

@section('page-subtitle', 'Tambahkan kendaraan baru ke dalam sistem')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.kendaraan.index') }}"
                class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-medium">Kembali ke Daftar Kendaraan</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-car-side mr-3"></i>
                    Form Tambah Kendaraan Baru
                </h3>
            </div>

            <!-- Form Body -->
            <form action="{{ route('admin.kendaraan.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-6">
                @csrf

                <!-- Kategori -->
                <div>
                    <label for="kategori_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori Kendaraan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="kategori_id" id="kategori_id"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kategori_id') border-red-500 @enderror"
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('kategori_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Merk & Model -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Merk -->
                    <div>
                        <label for="merk" class="block text-sm font-semibold text-gray-700 mb-2">
                            Merk Kendaraan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-car absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="merk" id="merk" value="{{ old('merk') }}"
                                placeholder="Contoh: Toyota, Honda, Suzuki"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('merk') border-red-500 @enderror"
                                required>
                        </div>
                        @error('merk')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Model -->
                    <div>
                        <label for="model" class="block text-sm font-semibold text-gray-700 mb-2">
                            Model/Tipe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-car-side absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="model" id="model" value="{{ old('model') }}"
                                placeholder="Contoh: Avanza, Brio, Ertiga"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('model') border-red-500 @enderror"
                                required>
                        </div>
                        @error('model')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tahun & No Plat -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tahun -->
                    <div>
                        <label for="tahun" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tahun Pembuatan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i
                                class="far fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="number" name="tahun" id="tahun" value="{{ old('tahun') }}"
                                placeholder="Contoh: 2023" min="1900" max="{{ date('Y') + 1 }}"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('tahun') border-red-500 @enderror"
                                required>
                        </div>
                        @error('tahun')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No Plat -->
                    <div>
                        <label for="no_plat" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Plat <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-id-card absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="no_plat" id="no_plat" value="{{ old('no_plat') }}"
                                placeholder="Contoh: D 1234 AB"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 uppercase @error('no_plat') border-red-500 @enderror"
                                required>
                        </div>
                        @error('no_plat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Warna -->
                    <div>
                        <label for="warna" class="block text-sm font-semibold text-gray-700 mb-2">
                            Warna Kendaraan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-palette absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="warna" id="warna" value="{{ old('warna') }}"
                                placeholder="Contoh: Hitam, Putih, Silver"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('warna') border-red-500 @enderror"
                                required>
                        </div>
                        @error('warna')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transmisi -->
                    <div>
                        <label for="transmisi" class="block text-sm font-semibold text-gray-700 mb-2">
                            Transmisi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-cog absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="transmisi" id="transmisi"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('transmisi') border-red-500 @enderror"
                                required>
                                <option value="">-- Pilih Transmisi --</option>
                                <option value="Automatic" {{ old('transmisi') == 'Automatic' ? 'selected' : '' }}>Automatic
                                </option>
                                <option value="Manual" {{ old('transmisi') == 'Manual' ? 'selected' : '' }}>Manual
                                </option>
                            </select>
                        </div>
                        @error('transmisi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kapasitas Penumpang -->
                    <div>
                        <label for="kapasitas_penumpang" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kapasitas Penumpang <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-users absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="number" name="kapasitas_penumpang" id="kapasitas_penumpang"
                                value="{{ old('kapasitas_penumpang') }}" placeholder="Contoh: 7" min="1"
                                max="50"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kapasitas_penumpang') border-red-500 @enderror"
                                required>
                        </div>
                        @error('kapasitas_penumpang')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Foto -->
                <div>
                    <label for="foto" class="block text-sm font-semibold text-gray-700 mb-2">
                        Foto Kendaraan <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <div class="flex items-center justify-center w-full">
                            <label for="foto"
                                class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                                </div>
                                <input id="foto" name="foto" type="file" class="hidden"
                                    accept="image/png,image/jpeg,image/jpg" onchange="previewImage(event)" required>
                            </label>
                        </div>
                        <!-- Preview Image -->
                        <div id="preview-container" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                            <div class="border-2 border-indigo-300 rounded-lg p-2 bg-indigo-50"
                                style="display: inline-block; max-width: 100%;">
                                <img id="preview-image" src="" alt="Preview" class="rounded-md"
                                    style="max-height: 192px; max-width: 400px; width: auto; height: auto; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                    @error('foto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Keterangan <span class="text-gray-400 text-xs">(Opsional)</span>
                    </label>
                    <textarea name="keterangan" id="keterangan" rows="4"
                        placeholder="Tambahkan keterangan atau catatan khusus untuk kendaraan ini..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 pt-6"></div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.kendaraan.index') }}"
                        class="inline-flex items-center px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition duration-150">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="cursor-pointer inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Kendaraan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Preview image before upload
            function previewImage(event) {
                const file = event.target.files[0];
                const previewContainer = document.getElementById('preview-container');
                const previewImage = document.getElementById('preview-image');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            }

            // Auto uppercase for no_plat
            document.getElementById('no_plat').addEventListener('input', function(e) {
                e.target.value = e.target.value.toUpperCase();
            });

            // Show validation errors with SweetAlert
            @if ($errors->any())
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '• {{ $error }}\n';
                @endforeach

                Swal.fire({
                    title: 'Validasi Gagal!',
                    html: '<div style="text-align: left; white-space: pre-line;">' + errorMessages + '</div>',
                    icon: 'error',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'text-left'
                    }
                });
            @endif
        </script>
    @endpush
@endsection
