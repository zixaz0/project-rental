@extends('layouts.app')

@section('title', 'Lengkapi Data Diri - NGABRIDE')

@section('content')
<div class="bg-gray-50 min-h-screen py-6 sm:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-start sm:items-center gap-3 sm:gap-4">
                    <div class="bg-blue-100 rounded-lg sm:rounded-full p-2.5 sm:p-3 flex-shrink-0">
                        <i class="fas fa-user-edit text-blue-600 text-xl sm:text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">Lengkapi Data Diri</h1>
                        <p class="text-sm sm:text-base text-gray-600 mt-1">Lengkapi data untuk pemesanan kendaraan</p>
                    </div>
                </div>
                <div class="sm:flex-shrink-0">
                    {!! $user->getStatusBadge() !!}
                </div>
            </div>
        </div>

        <!-- Alert Info -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 sm:mb-6 rounded-lg">
            <div class="flex gap-3">
                <i class="fas fa-exclamation-triangle text-yellow-400 text-lg sm:text-xl flex-shrink-0 mt-0.5"></i>
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-yellow-700 leading-relaxed">
                        <strong class="font-semibold">Penting!</strong> Data akan diverifikasi admin. Pastikan semua benar dan sesuai dokumen asli.
                    </p>
                </div>
            </div>
        </div>

        @if($user->isDitolak())
            <!-- Alert Ditolak -->
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 sm:mb-6 rounded-lg">
                <div class="flex gap-3">
                    <i class="fas fa-times-circle text-red-400 text-lg sm:text-xl flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm text-red-700 font-semibold mb-2">Dokumen Sebelumnya Ditolak!</p>
                        <p class="text-xs sm:text-sm text-red-600">Silakan perbaiki sesuai catatan admin.</p>
                        @if($user->verification_note)
                            <div class="mt-3 p-3 bg-white rounded border border-red-200">
                                <p class="text-xs font-medium text-red-900 mb-1">Alasan Penolakan:</p>
                                <p class="text-xs text-red-700">{{ $user->verification_note }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('profile.store.complete') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            @csrf

            <!-- Data Kontak -->
            <div class="mb-6 sm:mb-8">
                <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                    <i class="fas fa-address-book text-blue-600 text-sm sm:text-base"></i>
                    <span>Data Kontak</span>
                </h2>
                
                <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4">
                    <!-- Nama (readonly) -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" value="{{ $user->name }}" disabled
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                        <p class="mt-1.5 text-xs text-gray-500">Edit di halaman profil</p>
                    </div>

                    <!-- Email (readonly) -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                        <p class="mt-1.5 text-xs text-gray-500">Edit di halaman profil</p>
                    </div>

                    <!-- No. Telepon -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            No. Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                            placeholder="08123456789" required>
                        @error('phone')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-gray-500">Nomor WhatsApp aktif</p>
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" rows="3"
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
                            placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan" required>{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-gray-500">Sesuai KTP atau domisili</p>
                    </div>
                </div>
            </div>

            <!-- Data Identitas -->
            <div class="mb-6 sm:mb-8">
                <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                    <i class="fas fa-id-card text-blue-600 text-sm sm:text-base"></i>
                    <span>Data Identitas</span>
                </h2>
                
                <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4">
                    <!-- NIK -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            NIK (KTP) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" maxlength="16"
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nik') border-red-500 @enderror"
                            placeholder="16 digit NIK" required>
                        @error('nik')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-gray-500">16 digit sesuai KTP</p>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                            max="{{ date('Y-m-d', strtotime('-17 years')) }}"
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror"
                            required>
                        @error('tanggal_lahir')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-gray-500">Minimal 17 tahun</p>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin"
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jenis_kelamin') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Upload Dokumen -->
            <div class="mb-6 sm:mb-8">
                <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                    <i class="fas fa-file-upload text-blue-600 text-sm sm:text-base"></i>
                    <span>Upload Dokumen</span>
                </h2>
                
                <div class="space-y-5 sm:space-y-6">
                    <!-- Foto KTP -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Foto KTP <span class="text-red-500">*</span>
                        </label>
                        
                        @if($user->foto_ktp)
                            <div class="mb-3 p-3 bg-gray-50 rounded-lg border">
                                <p class="text-xs text-gray-600 mb-2">Foto Sebelumnya:</p>
                                <img src="{{ asset($user->foto_ktp) }}" alt="KTP Lama" class="max-w-full sm:max-w-xs rounded border">
                            </div>
                        @endif
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <label class="cursor-pointer flex-shrink-0">
                                <input type="file" name="foto_ktp" accept="image/*" class="hidden" id="foto_ktp" onchange="previewImage(this, 'preview_ktp')" required>
                                <div class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium text-center sm:text-left">
                                    <i class="fas fa-upload mr-2"></i>Pilih File
                                </div>
                            </label>
                            <span class="text-xs sm:text-sm text-gray-600 truncate" id="filename_ktp">Belum ada file</span>
                        </div>
                        <div id="preview_ktp" class="mt-3 hidden">
                            <p class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Preview:</p>
                            <img src="" alt="Preview KTP" class="max-w-full sm:max-w-xs rounded border">
                        </div>
                        @error('foto_ktp')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-gray-500">JPG/PNG, max 2MB. Pastikan jelas.</p>
                    </div>

                    <!-- Foto Selfie dengan KTP -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Foto Selfie dengan KTP <span class="text-red-500">*</span>
                        </label>
                        
                        @if($user->foto_selfie_ktp)
                            <div class="mb-3 p-3 bg-gray-50 rounded-lg border">
                                <p class="text-xs text-gray-600 mb-2">Foto Sebelumnya:</p>
                                <img src="{{ asset($user->foto_selfie_ktp) }}" alt="Selfie Lama" class="max-w-full sm:max-w-xs rounded border">
                            </div>
                        @endif
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <label class="cursor-pointer flex-shrink-0">
                                <input type="file" name="foto_selfie_ktp" accept="image/*" class="hidden" id="foto_selfie_ktp" onchange="previewImage(this, 'preview_selfie')" required>
                                <div class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium text-center sm:text-left">
                                    <i class="fas fa-upload mr-2"></i>Pilih File
                                </div>
                            </label>
                            <span class="text-xs sm:text-sm text-gray-600 truncate" id="filename_selfie">Belum ada file</span>
                        </div>
                        <div id="preview_selfie" class="mt-3 hidden">
                            <p class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Preview:</p>
                            <img src="" alt="Preview Selfie" class="max-w-full sm:max-w-xs rounded border">
                        </div>
                        @error('foto_selfie_ktp')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-gray-500">Wajah dan KTP terlihat jelas.</p>
                    </div>

                    <!-- Foto SIM -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Foto SIM <span class="text-gray-400 text-xs">(Opsional)</span>
                        </label>
                        
                        @if($user->foto_sim)
                            <div class="mb-3 p-3 bg-gray-50 rounded-lg border">
                                <p class="text-xs text-gray-600 mb-2">Foto Sebelumnya:</p>
                                <img src="{{ asset($user->foto_sim) }}" alt="SIM Lama" class="max-w-full sm:max-w-xs rounded border">
                            </div>
                        @endif
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <label class="cursor-pointer flex-shrink-0">
                                <input type="file" name="foto_sim" accept="image/*" class="hidden" id="foto_sim" onchange="previewImage(this, 'preview_sim')">
                                <div class="px-4 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-medium text-center sm:text-left">
                                    <i class="fas fa-upload mr-2"></i>Pilih File
                                </div>
                            </label>
                            <span class="text-xs sm:text-sm text-gray-600 truncate" id="filename_sim">Belum ada file</span>
                        </div>
                        <div id="preview_sim" class="mt-3 hidden">
                            <p class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Preview:</p>
                            <img src="" alt="Preview SIM" class="max-w-full sm:max-w-xs rounded border">
                        </div>
                        @error('foto_sim')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-gray-500">Dapat mempercepat verifikasi.</p>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex gap-3">
                    <i class="fas fa-info-circle text-blue-600 text-lg flex-shrink-0 mt-0.5"></i>
                    <div class="text-xs sm:text-sm text-blue-800 flex-1 min-w-0">
                        <p class="font-semibold mb-2">Setelah submit data:</p>
                        <ul class="space-y-1.5 ml-4">
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 flex-shrink-0">•</span>
                                <span>Status menjadi "Menunggu Verifikasi"</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 flex-shrink-0">•</span>
                                <span>Verifikasi dalam 1x24 jam</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 flex-shrink-0">•</span>
                                <span>Notifikasi hasil verifikasi</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 flex-shrink-0">•</span>
                                <span>Bisa upload ulang jika ditolak</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t">
                <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center text-sm font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Batal
                </a>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center text-sm font-medium">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim untuk Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert -->
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#2563eb'
    });
</script>
@endif

@if(session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#dc2626'
    });
</script>
@endif

<script>
function previewImage(input, previewId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const img = preview.querySelector('img');
    
    const filenameId = 'filename_' + previewId.split('_')[1];
    const filenameSpan = document.getElementById(filenameId);
    
    if (file) {
        if (file.size > 2048 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar!',
                text: 'Ukuran file maksimal 2MB',
                confirmButtonColor: '#dc2626'
            });
            input.value = '';
            filenameSpan.textContent = 'Belum ada file';
            preview.classList.add('hidden');
            return;
        }
        
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Format Tidak Valid!',
                text: 'Hanya JPG, JPEG, dan PNG',
                confirmButtonColor: '#dc2626'
            });
            input.value = '';
            filenameSpan.textContent = 'Belum ada file';
            preview.classList.add('hidden');
            return;
        }
        
        filenameSpan.textContent = file.name.length > 30 ? file.name.substring(0, 30) + '...' : file.name;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        filenameSpan.textContent = 'Belum ada file';
        preview.classList.add('hidden');
    }
}
</script>
@endsection