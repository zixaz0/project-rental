@extends('layouts.admin')

@section('title', 'Edit Harga - Admin')

@section('page-title', 'Edit Harga Kendaraan')

@section('page-subtitle', 'Perbarui harga dan status kendaraan')

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
            <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-edit mr-3"></i>
                    Form Edit Harga
                </h3>
            </div>

            <form action="{{ route('admin.harga.update', $harga->id) }}" method="POST" id="hargaForm" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Info Kendaraan (Read Only) -->
                <div class="mb-6 p-4 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg border border-indigo-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-car mr-2 text-indigo-600"></i>Informasi Kendaraan
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Foto Kendaraan -->
                        @if ($harga->kendaraan->foto)
                            <div class="col-span-full flex justify-center mb-2">
                                <img src="{{ asset($harga->kendaraan->foto) }}"
                                    alt="{{ $harga->kendaraan->merk }} {{ $harga->kendaraan->model }}"
                                    class="w-full max-h-48 object-contain rounded-lg"
                                    onerror="this.src='{{ asset('images/no-image.png') }}'">
                            </div>
                        @endif

                        <div>
                            <span class="text-xs text-gray-600">Merk & Model</span>
                            <p class="font-semibold text-gray-800 text-lg">
                                {{ $harga->kendaraan->merk }} {{ $harga->kendaraan->model }}
                            </p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-600">No. Plat</span>
                            <p
                                class="font-mono font-semibold text-gray-800 bg-gray-800 text-white px-3 py-1 rounded inline-block">
                                {{ $harga->kendaraan->no_plat }}
                            </p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-600">Kategori</span>
                            <p class="font-semibold text-gray-800">
                                <i class="fas fa-tag mr-1 text-indigo-600"></i>
                                {{ $harga->kendaraan->kategori->nama }}
                            </p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-600">Transmisi</span>
                            <p class="font-semibold text-gray-800">
                                <i class="fas fa-cog mr-1"></i>
                                {{ $harga->kendaraan->transmisi }}
                            </p>
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
                        <input type="number" name="harga_per_hari" id="harga_per_hari"
                            value="{{ old('harga_per_hari', $harga->harga_per_hari) }}"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('harga_per_hari') border-red-500 @enderror"
                            placeholder="Contoh: 350000" min="0" step="10000" required>
                    </div>
                    @error('harga_per_hari')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror

                    <!-- Perbandingan Harga -->
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <span class="text-gray-600">Harga Lama:</span>
                                <p class="font-semibold text-gray-700">
                                    Rp {{ number_format($harga->harga_per_hari, 0, ',', '.') }}
                                </p>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                            <div>
                                <span class="text-gray-600">Harga Baru:</span>
                                <p class="font-bold text-green-600" id="previewHargaBaru">
                                    Rp {{ number_format($harga->harga_per_hari, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <div id="selisihHarga" class="hidden mt-2 pt-2 border-t border-gray-200">
                            <p class="text-xs text-gray-600">Selisih:
                                <span id="selisihValue" class="font-semibold"></span>
                            </p>
                        </div>
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
                        <option value="tersedia" {{ old('status', $harga->status) == 'tersedia' ? 'selected' : '' }}>
                            🟢 Tersedia
                        </option>
                        <option value="tidak_tersedia"
                            {{ old('status', $harga->status) == 'tidak_tersedia' ? 'selected' : '' }}>
                            🔴 Tidak Tersedia
                        </option>
                        <option value="pending" {{ old('status', $harga->status) == 'pending' ? 'selected' : '' }}>
                            🟡 Pending
                        </option>
                        <option value="disewa" {{ old('status', $harga->status) == 'disewa' ? 'selected' : '' }}>
                            🔵 Disewa
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror

                    <!-- Status Perubahan -->
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <span class="text-gray-600">Status Lama:</span>
                                <p class="font-semibold text-gray-700">
                                    {{ ucfirst(str_replace('_', ' ', $harga->status)) }}
                                </p>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                            <div>
                                <span class="text-gray-600">Status Baru:</span>
                                <p class="font-bold text-blue-600" id="previewStatusBaru">
                                    {{ ucfirst(str_replace('_', ' ', $harga->status)) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Warning Box untuk Status Disewa -->
                <div id="warningDisewa" class="hidden mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5 mr-3"></i>
                        <div class="text-sm text-yellow-800">
                            <p class="font-semibold mb-1">Perhatian!</p>
                            <p>Kendaraan dengan status "Disewa" tidak dapat disewakan kepada customer lain. Pastikan status
                                ini sesuai dengan kondisi aktual.</p>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Informasi Update:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Perubahan harga akan langsung berlaku untuk penyewaan baru</li>
                                <li>Status kendaraan mempengaruhi ketersediaan untuk disewa</li>
                                <li>Pastikan data yang diubah sudah sesuai dan benar</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Update -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h5 class="text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-history mr-1"></i>Riwayat Update
                    </h5>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600">Dibuat:</span>
                            <p class="font-medium text-gray-800">{{ $harga->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Terakhir Diupdate:</span>
                            <p class="font-medium text-gray-800">{{ $harga->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.harga.index') }}"
                        class="cursor-pointer inline-flex items-center px-5 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition duration-150">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="cursor-pointer inline-flex items-center px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                        <i class="fas fa-save mr-2"></i>
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const hargaLama = {{ $harga->harga_per_hari }};
        const statusLama = '{{ $harga->status }}';

        // Preview Harga Baru & Selisih
        document.getElementById('harga_per_hari').addEventListener('input', function() {
            const hargaBaru = parseInt(this.value) || 0;
            const previewHargaBaru = document.getElementById('previewHargaBaru');
            const selisihContainer = document.getElementById('selisihHarga');
            const selisihValue = document.getElementById('selisihValue');

            if (hargaBaru > 0) {
                const formatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(hargaBaru);

                previewHargaBaru.textContent = formatted;

                // Hitung selisih
                const selisih = hargaBaru - hargaLama;
                if (selisih !== 0) {
                    const selisihFormatted = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        signDisplay: 'always'
                    }).format(selisih);

                    const selisihClass = selisih > 0 ? 'text-green-600' : 'text-red-600';
                    const selisihIcon = selisih > 0 ? '↑' : '↓';

                    selisihValue.innerHTML =
                        `<span class="${selisihClass}">${selisihIcon} ${selisihFormatted}</span>`;
                    selisihContainer.classList.remove('hidden');
                } else {
                    selisihContainer.classList.add('hidden');
                }
            } else {
                const formattedLama = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(hargaLama);
                previewHargaBaru.textContent = formattedLama;
                selisihContainer.classList.add('hidden');
            }
        });

        // Preview Status Baru
        document.getElementById('status').addEventListener('change', function() {
            const statusBaru = this.value;
            const previewStatusBaru = document.getElementById('previewStatusBaru');
            const warningDisewa = document.getElementById('warningDisewa');

            if (statusBaru) {
                const statusText = this.options[this.selectedIndex].text;
                previewStatusBaru.textContent = statusText.trim();

                // Tampilkan warning jika status disewa
                if (statusBaru === 'disewa') {
                    warningDisewa.classList.remove('hidden');
                } else {
                    warningDisewa.classList.add('hidden');
                }
            } else {
                const statusLamaText = '{{ ucfirst(str_replace('_', ' ', $harga->status)) }}';
                previewStatusBaru.textContent = statusLamaText;
                warningDisewa.classList.add('hidden');
            }
        });

        // Check initial status
        if (statusLama === 'disewa') {
            document.getElementById('warningDisewa').classList.remove('hidden');
        }

        // Form Validation
        document.getElementById('hargaForm').addEventListener('submit', function(e) {
            const harga = document.getElementById('harga_per_hari').value;
            const status = document.getElementById('status').value;

            if (!harga || !status) {
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

            // Konfirmasi jika ada perubahan signifikan
            const hargaBaru = parseInt(harga);
            const selisihPersen = Math.abs((hargaBaru - hargaLama) / hargaLama * 100);

            if (selisihPersen > 50) {
                e.preventDefault();
                Swal.fire({
                    title: 'Perubahan Harga Signifikan',
                    html: `
                        <div class="text-left">
                            <p class="mb-2">Harga berubah lebih dari 50%:</p>
                            <div class="bg-gray-100 p-3 rounded-lg mb-3">
                                <p class="text-sm">Harga Lama: <span class="font-bold">Rp ${hargaLama.toLocaleString('id-ID')}</span></p>
                                <p class="text-sm">Harga Baru: <span class="font-bold text-green-600">Rp ${hargaBaru.toLocaleString('id-ID')}</span></p>
                            </div>
                            <p class="text-sm text-yellow-600">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Pastikan harga yang diinput sudah benar
                            </p>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#eab308',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Cek Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
                return false;
            }
        });
    </script>
@endsection
