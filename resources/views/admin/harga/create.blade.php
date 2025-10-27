@extends('layouts.admin')

@section('title', 'Tambah Harga - Admin')

@section('page-title', 'Tambah Harga Kendaraan')

@section('page-subtitle', 'Tambahkan harga baru untuk kendaraan')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.harga.index') }}"
                class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-medium">Kembali ke Daftar Harga</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-money-bill mr-3"></i>
                    Form Tambah Harga Baru
                </h3>
            </div>

            <!-- Form Body -->
            <form action="{{ route('admin.harga.store') }}" method="POST" id="hargaForm" class="p-6 space-y-6">
                @csrf

                <!-- Pilih Kendaraan -->
                <div class="mb-6">
                    <label for="kendaraan_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-car mr-1 text-indigo-600"></i>Pilih Kendaraan
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="kendaraan_id" id="kendaraan_id"
                        class="cursor-pointer w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('kendaraan_id') border-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach ($kendaraan as $item)
                            <option value="{{ $item->id }}" data-merk="{{ $item->merk }}"
                                data-model="{{ $item->model }}" data-no-plat="{{ $item->no_plat }}"
                                data-kategori="{{ $item->kategori->nama }}"
                                {{ old('kendaraan_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->merk }} {{ $item->model }} - {{ $item->no_plat }}
                                ({{ $item->kategori->nama }})
                            </option>
                        @endforeach
                    </select>
                    @error('kendaraan_id')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                    @if ($kendaraan->isEmpty())
                        <div class="mt-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-600 mt-0.5 mr-2"></i>
                                <div>
                                    <p class="text-sm text-yellow-800 font-medium">Tidak ada kendaraan tersedia</p>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        Semua kendaraan sudah memiliki harga. Silakan tambah kendaraan baru terlebih dahulu.
                                    </p>
                                    <a href="{{ route('admin.kendaraan.create') }}"
                                        class="mt-2 inline-flex items-center text-sm text-yellow-800 hover:text-yellow-900 font-semibold">
                                        <i class="fas fa-plus mr-1"></i>Tambah Kendaraan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Preview Kendaraan -->
                <div id="kendaraanPreview"
                    class="hidden mb-6 p-4 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg border border-indigo-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-info-circle mr-1 text-indigo-600"></i>Informasi Kendaraan
                    </h4>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600">Merk & Model:</span>
                            <p class="font-semibold text-gray-800" id="previewMerk">-</p>
                        </div>
                        <div>
                            <span class="text-gray-600">No. Plat:</span>
                            <p class="font-mono font-semibold text-gray-800" id="previewNoPlat">-</p>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-600">Kategori:</span>
                            <p class="font-semibold text-gray-800" id="previewKategori">-</p>
                        </div>
                    </div>
                </div>

                <!-- Harga per Hari -->
                <div class="mb-6">
                    <label for="harga_per_hari" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-money-bill-wave mr-1 text-green-600"></i>Harga per Hari
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 font-semibold">Rp</span>
                        <input type="number" name="harga_per_hari" id="harga_per_hari" value="{{ old('harga_per_hari') }}"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('harga_per_hari') border-red-500 @enderror"
                            placeholder="Contoh: 350000" min="0" step="10000" required>
                    </div>
                    @error('harga_per_hari')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-lightbulb mr-1"></i>
                        Harga sewa kendaraan per hari (tanpa titik atau koma)
                    </p>
                    <!-- Preview Harga -->
                    <div id="hargaPreview" class="hidden mt-3 p-3 bg-green-50 rounded-lg border border-green-200">
                        <p class="text-sm text-gray-600">Preview Harga:</p>
                        <p class="text-xl font-bold text-green-600" id="previewHarga">Rp 0</p>
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-info-circle mr-1 text-blue-600"></i>Status Kendaraan
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status"
                        class="cursor-pointer w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('status') border-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Status --</option>
                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>
                            🟢 Tersedia
                        </option>
                        <option value="tidak_tersedia" {{ old('status') == 'tidak_tersedia' ? 'selected' : '' }}>
                            🔴 Tidak Tersedia
                        </option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                            🟡 Pending
                        </option>
                        <option value="disewa" {{ old('status') == 'disewa' ? 'selected' : '' }}>
                            🔵 Disewa
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-lightbulb mr-1"></i>
                        Pilih status ketersediaan kendaraan saat ini
                    </p>
                </div>

                <!-- Info Box -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Informasi Penting:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Setiap kendaraan hanya bisa memiliki satu data harga</li>
                                <li>Harga dapat diubah kapan saja sesuai kebutuhan</li>
                                <li>Status akan mempengaruhi ketersediaan kendaraan untuk disewa</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.harga.index') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition duration-150">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="cursor-pointer inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out"
                        {{ $kendaraan->isEmpty() ? 'disabled' : '' }}>
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview Kendaraan
        document.getElementById('kendaraan_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const preview = document.getElementById('kendaraanPreview');

            if (this.value) {
                const merk = selectedOption.dataset.merk;
                const model = selectedOption.dataset.model;
                const noPlat = selectedOption.dataset.noPlat;
                const kategori = selectedOption.dataset.kategori;

                document.getElementById('previewMerk').textContent = `${merk} ${model}`;
                document.getElementById('previewNoPlat').textContent = noPlat;
                document.getElementById('previewKategori').textContent = kategori;

                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        });

        // Preview Harga dengan Format
        document.getElementById('harga_per_hari').addEventListener('input', function() {
            const harga = parseInt(this.value) || 0;
            const preview = document.getElementById('hargaPreview');
            const previewHarga = document.getElementById('previewHarga');

            if (harga > 0) {
                const formatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(harga);

                previewHarga.textContent = formatted;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        });

        // Form Validation
        document.getElementById('hargaForm').addEventListener('submit', function(e) {
            const kendaraanId = document.getElementById('kendaraan_id').value;
            const harga = document.getElementById('harga_per_hari').value;
            const status = document.getElementById('status').value;

            if (!kendaraanId || !harga || !status) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Data Belum Lengkap',
                    text: 'Mohon lengkapi semua field yang wajib diisi!',
                    confirmButtonColor: '#dc2626'
                });
                return false;
            }

            if (parseInt(harga) < 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Harga Tidak Valid',
                    text: 'Harga tidak boleh kurang dari 0!',
                    confirmButtonColor: '#dc2626'
                });
                return false;
            }
        });
    </script>
@endsection
