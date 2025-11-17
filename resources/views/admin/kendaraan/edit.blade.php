@extends('layouts.admin')
@section('title', 'Edit Kendaraan - Admin')
@section('page-title', 'Edit Kendaraan')
@section('page-subtitle', 'Perbarui informasi kendaraan')

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
            <div class="px-6 py-4 bg-gradient-to-r from-yellow-600 to-yellow-700 border-b border-indigo-700">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-edit mr-2"></i>
                    Form Edit Kendaraan
                </h3>
            </div>

            <form id="formEditKendaraan" action="{{ route('admin.kendaraan.update', $kendaraan->id) }}" method="POST"
                enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Kategori & Jenis (Side by Side) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kategori -->
                    <div>
                        <label for="kategori_nama" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori Kendaraan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="kategori_nama" id="kategori_nama" onchange="loadJenis()"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kategori_id') border-red-500 @enderror"
                                required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriUnique as $nama)
                                    <option value="{{ $nama }}" 
                                        {{ old('kategori_nama', $kendaraan->kategori->nama) == $nama ? 'selected' : '' }}>
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('kategori_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis (Dynamically Loaded) -->
                    <div>
                        <label for="kategori_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Kendaraan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-list absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="kategori_id" id="kategori_id"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kategori_id') border-red-500 @enderror"
                                required>
                                <option value="">-- Pilih Kategori Dulu --</option>
                            </select>
                        </div>
                        @error('kategori_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Merk & Model -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="merk" class="block text-sm font-semibold text-gray-700 mb-2">
                            Merk Kendaraan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-car absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="merk" id="merk" value="{{ old('merk', $kendaraan->merk) }}"
                                placeholder="Contoh: Toyota, Honda, Suzuki"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('merk') border-red-500 @enderror"
                                required>
                        </div>
                        @error('merk')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="model" class="block text-sm font-semibold text-gray-700 mb-2">
                            Model/Tipe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-car-side absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="model" id="model" value="{{ old('model', $kendaraan->model) }}"
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
                    <div>
                        <label for="tahun" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tahun Pembuatan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="far fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $kendaraan->tahun) }}"
                                min="1900" max="{{ date('Y') + 1 }}" placeholder="{{ date('Y') }}"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('tahun') border-red-500 @enderror"
                                required>
                        </div>
                        @error('tahun')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_plat" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Plat <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-id-card absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="no_plat" id="no_plat"
                                value="{{ old('no_plat', $kendaraan->no_plat) }}" placeholder="Contoh: B 1234 XYZ"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 uppercase @error('no_plat') border-red-500 @enderror"
                                required>
                        </div>
                        @error('no_plat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Warna, Transmisi & Kapasitas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Warna -->
                    <div>
                        <label for="warna" class="block text-sm font-semibold text-gray-700 mb-2">
                            Warna Kendaraan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-palette absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="warna" id="warna" value="{{ old('warna', $kendaraan->warna) }}"
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
                                <option value="Manual"
                                    {{ old('transmisi', $kendaraan->transmisi) == 'Manual' ? 'selected' : '' }}>Manual</option>
                                <option value="Automatic"
                                    {{ old('transmisi', $kendaraan->transmisi) == 'Automatic' ? 'selected' : '' }}>Automatic
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
                                value="{{ old('kapasitas_penumpang', $kendaraan->kapasitas_penumpang) }}" min="1"
                                max="50" placeholder="Contoh: 7"
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
                        Foto Kendaraan
                    </label>

                    <!-- Preview Foto Lama -->
                    @if ($kendaraan->foto)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                            <div class="border-2 border-gray-300 rounded-lg p-2 bg-gray-50"
                                style="display: inline-block; max-width: 100%;">
                                <img src="{{ asset($kendaraan->foto) }}"
                                    alt="{{ $kendaraan->merk }} {{ $kendaraan->model }}" class="rounded-md"
                                    style="max-height: 192px; max-width: 400px; width: auto; height: auto; object-fit: contain;"
                                    id="previewFotoLama"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Foto+Tidak+Ditemukan';">
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center justify-center w-full">
                        <label for="foto"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">
                                    <span class="font-semibold">Klik untuk upload foto baru</span>
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                            </div>
                            <input id="foto" name="foto" type="file" class="hidden"
                                accept="image/png,image/jpeg,image/jpg" onchange="previewImage(event)">
                        </label>
                    </div>

                    <!-- Preview Foto Baru -->
                    <div id="previewContainer" class="mt-3 hidden">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview foto baru:</p>
                        <div class="border-2 border-indigo-300 rounded-lg p-2 bg-indigo-50"
                            style="display: inline-block; max-width: 100%;">
                            <img id="previewFoto" class="rounded-md"
                                style="max-height: 192px; max-width: 400px; width: auto; height: auto; object-fit: contain;">
                        </div>
                    </div>

                    <p class="mt-2 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Kosongkan jika tidak ingin mengubah foto
                    </p>
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
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none @error('keterangan') border-red-500 @enderror">{{ old('keterangan', $kendaraan->keterangan) }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 pt-6"></div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.kendaraan.index') }}"
                        class="inline-flex items-center px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition duration-150">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="button" onclick="confirmUpdate()"
                        class="cursor-pointer inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Data kategori dari backend
            const kategoriData = @json($kategoriByNama);
            const currentKategoriId = {{ old('kategori_id', $kendaraan->kategori_id) }};
            const currentKategoriNama = '{{ old('kategori_nama', $kendaraan->kategori->nama) }}';

            // Load jenis berdasarkan kategori yang dipilih
            function loadJenis() {
                const kategoriNama = document.getElementById('kategori_nama').value;
                const jenisSelect = document.getElementById('kategori_id');
                
                // Reset dropdown jenis
                jenisSelect.innerHTML = '<option value="">-- Pilih Jenis --</option>';
                
                if (kategoriNama && kategoriData[kategoriNama]) {
                    // Enable dropdown jenis
                    jenisSelect.disabled = false;
                    jenisSelect.classList.remove('bg-gray-50');
                    
                    // Populate jenis options
                    kategoriData[kategoriNama].forEach(function(item) {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.jenis;
                        jenisSelect.appendChild(option);
                    });
                } else {
                    // Disable dropdown jenis
                    jenisSelect.disabled = true;
                    jenisSelect.classList.add('bg-gray-50');
                }
            }

            // Load data saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function() {
                // Load jenis berdasarkan kategori yang sudah dipilih
                loadJenis();
                
                // Set selected jenis
                setTimeout(function() {
                    document.getElementById('kategori_id').value = currentKategoriId;
                }, 100);
            });

            // Preview Foto
            function previewImage(event) {
                const input = event.target;
                const previewContainer = document.getElementById('previewContainer');
                const previewFoto = document.getElementById('previewFoto');
                const previewFotoLama = document.getElementById('previewFotoLama');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewFoto.src = e.target.result;
                        previewContainer.classList.remove('hidden');

                        // Sembunyikan foto lama dengan efek fade
                        if (previewFotoLama) {
                            previewFotoLama.parentElement.style.opacity = '0.4';
                        }
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    previewContainer.classList.add('hidden');

                    // Tampilkan kembali foto lama
                    if (previewFotoLama) {
                        previewFotoLama.parentElement.style.opacity = '1';
                    }
                }
            }

            // Auto uppercase untuk no_plat
            document.getElementById('no_plat').addEventListener('input', function(e) {
                e.target.value = e.target.value.toUpperCase();
            });

            // Konfirmasi Update dengan SweetAlert
            function confirmUpdate() {
                const form = document.getElementById('formEditKendaraan');

                // Validasi form dulu
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const merk = document.getElementById('merk').value;
                const model = document.getElementById('model').value;
                const noPlat = document.getElementById('no_plat').value;
                const tahun = document.getElementById('tahun').value;
                const warna = document.getElementById('warna').value;
                const foto = document.getElementById('foto').files[0];

                let fotoInfo = foto ? '<span class="text-green-600">✓ Foto baru akan diupload</span>' :
                    '<span class="text-gray-600">Foto tidak diubah</span>';

                Swal.fire({
                    title: 'Konfirmasi Perubahan',
                    html: `
                        <div class="text-left">
                            <p class="mb-3 text-gray-700 font-medium">Apakah Anda yakin ingin menyimpan perubahan data kendaraan berikut?</p>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kendaraan:</span>
                                    <span class="font-semibold text-gray-800">${merk} ${model}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">No. Plat:</span>
                                    <span class="font-mono font-bold text-gray-800">${noPlat}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tahun:</span>
                                    <span class="font-semibold text-gray-800">${tahun}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Warna:</span>
                                    <span class="font-semibold text-gray-800">${warna}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Foto:</span>
                                    ${fotoInfo}
                                </div>
                            </div>
                            <p class="mt-3 text-blue-600 text-sm">
                                <i class="fas fa-info-circle mr-1"></i>
                                Pastikan semua data sudah benar sebelum menyimpan
                            </p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Simpan!',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Cek Lagi',
                    reverseButtons: true,
                    focusCancel: true,
                    width: '600px',
                    customClass: {
                        popup: 'swal-wide',
                        confirmButton: 'px-6 py-2.5',
                        cancelButton: 'px-6 py-2.5'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loading
                        Swal.fire({
                            title: 'Menyimpan Perubahan...',
                            html: '<div class="text-gray-600">Mohon tunggu, sedang memproses data</div>',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form
                        form.submit();
                    }
                });
            }

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

        <style>
            .swal-wide {
                max-width: 600px !important;
            }
        </style>
    @endpush
@endsection