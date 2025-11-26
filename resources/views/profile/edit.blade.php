@extends('layouts.app')

@section('title', 'Edit Profil - NGABRIDE')

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
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">Edit Profil</h1>
                        <p class="text-sm sm:text-base text-gray-600 mt-1">Update informasi profil Anda</p>
                    </div>
                </div>
                <div class="sm:flex-shrink-0">
                    {!! $user->getStatusBadge() !!}
                </div>
            </div>
        </div>

        <!-- Alert Info -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 sm:mb-6 rounded-lg">
            <div class="flex gap-3">
                <i class="fas fa-info-circle text-blue-400 text-lg sm:text-xl flex-shrink-0 mt-0.5"></i>
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-blue-700 leading-relaxed">
                        <strong class="font-semibold">Catatan:</strong> Data identitas (NIK, Tanggal Lahir, Jenis Kelamin) tidak bisa diubah. Hubungi admin jika ada kesalahan.
                    </p>
                </div>
            </div>
        </div>

        @if($user->isDitolak())
            <!-- Alert Ditolak -->
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 sm:mb-6 rounded-lg">
                <div class="flex gap-3">
                    <i class="fas fa-exclamation-triangle text-red-400 text-lg sm:text-xl flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm text-red-700 font-semibold mb-2">Dokumen Ditolak!</p>
                        <p class="text-xs sm:text-sm text-red-600">Perbaiki sesuai catatan di bawah.</p>
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

        <!-- Form Edit -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            @csrf
            @method('PUT')

            <!-- Data Akun -->
            <div class="mb-6 sm:mb-8">
                <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                    <i class="fas fa-user-circle text-blue-600 text-sm sm:text-base"></i>
                    <span>Data Akun</span>
                </h2>
                
                <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4">
                    <!-- Nama -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            placeholder="Nama lengkap" required>
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                            placeholder="email@example.com" required>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Data Kontak -->
            <div class="mb-6 sm:mb-8">
                <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                    <i class="fas fa-address-book text-blue-600 text-sm sm:text-base"></i>
                    <span>Data Kontak</span>
                </h2>
                
                <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4">
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
                    </div>

                    <!-- Role (readonly) -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Role</label>
                        <input type="text" value="{{ ucfirst($user->role) }}" disabled
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                    </div>

                    <!-- Alamat -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" rows="3"
                            class="w-full px-3 sm:px-4 py-2 sm:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
                            placeholder="Alamat lengkap" required>{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            @if($user->hasCompleteProfile())
                <!-- Data Identitas (Readonly) -->
                <div class="mb-6 sm:mb-8">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fas fa-id-card text-blue-600 text-sm sm:text-base"></i>
                        <span>Data Identitas</span>
                        <span class="ml-auto text-xs text-gray-500 font-normal">(Tidak bisa diubah)</span>
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">NIK (KTP)</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $user->nik }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Lahir</label>
                            <p class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Kelamin</label>
                            <p class="text-sm text-gray-900 font-medium">{{ ucfirst($user->jenis_kelamin) }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                            <div>{!! $user->getStatusBadge() !!}</div>
                        </div>
                    </div>

                    <div class="mt-3 flex gap-2 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-sm flex-shrink-0 mt-0.5"></i>
                        <p class="text-xs text-yellow-800">
                            Hubungi admin untuk perubahan data identitas.
                        </p>
                    </div>
                </div>

                <!-- Update Dokumen -->
                <div class="mb-6 sm:mb-8">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fas fa-file-upload text-blue-600 text-sm sm:text-base"></i>
                        <span>Update Dokumen</span>
                    </h2>
                    
                    <!-- Alert Warning -->
                    <div class="mb-4 flex gap-2 bg-orange-50 border border-orange-200 rounded-lg p-3 sm:p-4">
                        <i class="fas fa-info-circle text-orange-600 text-sm sm:text-base flex-shrink-0 mt-0.5"></i>
                        <p class="text-xs sm:text-sm text-orange-800">
                            <strong>Perhatian:</strong> Mengubah dokumen KTP/Selfie akan reset status ke "Menunggu Verifikasi".
                        </p>
                    </div>

                    <div class="space-y-5 sm:space-y-6">
                        <!-- Foto KTP -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Foto KTP Saat Ini</label>
                            @if($user->foto_ktp)
                                <div class="mb-4">
                                    <img src="{{ asset($user->foto_ktp) }}" alt="KTP" class="max-w-full sm:max-w-xs rounded border">
                                </div>
                            @endif
                            
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Upload Foto Baru</label>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <label class="cursor-pointer flex-shrink-0">
                                    <input type="file" name="foto_ktp" accept="image/*" class="hidden" id="foto_ktp_edit" onchange="previewImageEdit(this, 'preview_ktp_edit')">
                                    <div class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium text-center sm:text-left">
                                        <i class="fas fa-upload mr-2"></i>Pilih File Baru
                                    </div>
                                </label>
                                <span class="text-xs sm:text-sm text-gray-600 truncate" id="filename_ktp_edit">Tidak ada file</span>
                            </div>
                            <div id="preview_ktp_edit" class="mt-3 hidden">
                                <p class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Preview:</p>
                                <img src="" alt="Preview" class="max-w-full sm:max-w-xs rounded border">
                            </div>
                            @error('foto_ktp')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1.5 text-xs text-gray-500">JPG/PNG, max 2MB</p>
                        </div>

                        <!-- Foto Selfie dengan KTP -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Foto Selfie dengan KTP Saat Ini</label>
                            @if($user->foto_selfie_ktp)
                                <div class="mb-4">
                                    <img src="{{ asset($user->foto_selfie_ktp) }}" alt="Selfie" class="max-w-full sm:max-w-xs rounded border">
                                </div>
                            @endif
                            
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Upload Foto Baru</label>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <label class="cursor-pointer flex-shrink-0">
                                    <input type="file" name="foto_selfie_ktp" accept="image/*" class="hidden" id="foto_selfie_edit" onchange="previewImageEdit(this, 'preview_selfie_edit')">
                                    <div class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium text-center sm:text-left">
                                        <i class="fas fa-upload mr-2"></i>Pilih File Baru
                                    </div>
                                </label>
                                <span class="text-xs sm:text-sm text-gray-600 truncate" id="filename_selfie_edit">Tidak ada file</span>
                            </div>
                            <div id="preview_selfie_edit" class="mt-3 hidden">
                                <p class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Preview:</p>
                                <img src="" alt="Preview" class="max-w-full sm:max-w-xs rounded border">
                            </div>
                            @error('foto_selfie_ktp')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1.5 text-xs text-gray-500">Wajah dan KTP jelas</p>
                        </div>

                        <!-- Foto SIM -->
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Foto SIM Saat Ini</label>
                            @if($user->foto_sim)
                                <div class="mb-4">
                                    <img src="{{ asset($user->foto_sim) }}" alt="SIM" class="max-w-full sm:max-w-xs rounded border">
                                </div>
                            @else
                                <p class="text-xs sm:text-sm text-gray-500 mb-4">Belum ada SIM</p>
                            @endif
                            
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Upload Foto Baru</label>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <label class="cursor-pointer flex-shrink-0">
                                    <input type="file" name="foto_sim" accept="image/*" class="hidden" id="foto_sim_edit" onchange="previewImageEdit(this, 'preview_sim_edit')">
                                    <div class="px-4 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-medium text-center sm:text-left">
                                        <i class="fas fa-upload mr-2"></i>Pilih File Baru
                                    </div>
                                </label>
                                <span class="text-xs sm:text-sm text-gray-600 truncate" id="filename_sim_edit">Tidak ada file</span>
                            </div>
                            <div id="preview_sim_edit" class="mt-3 hidden">
                                <p class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Preview:</p>
                                <img src="" alt="Preview" class="max-w-full sm:max-w-xs rounded border">
                            </div>
                            @error('foto_sim')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3 pt-6 border-t">
                <a href="{{ route('profile.show') }}" class="w-full sm:w-auto px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center text-sm font-medium order-2 sm:order-1">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <div class="flex flex-col-reverse sm:flex-row gap-3 order-1 sm:order-2">
                    <a href="{{ route('profile.show') }}" class="w-full sm:w-auto px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center text-sm font-medium">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center text-sm font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

        <!-- Keamanan Akun -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mt-4 sm:mt-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900">Keamanan Akun</h2>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">Kelola password dan keamanan</p>
                </div>
                <button onclick="alert('Fitur ganti password coming soon!')" class="w-full sm:w-auto px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                    <i class="fas fa-key mr-2"></i>Ganti Password
                </button>
            </div>
        </div>
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

<script>
function previewImageEdit(input, previewId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const img = preview.querySelector('img');
    
    const filenameId = 'filename_' + previewId.split('_')[1] + '_' + previewId.split('_')[2];
    const filenameSpan = document.getElementById(filenameId);
    
    if (file) {
        filenameSpan.textContent = file.name.length > 30 ? file.name.substring(0, 30) + '...' : file.name;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        filenameSpan.textContent = 'Tidak ada file';
        preview.classList.add('hidden');
    }
}
</script>
@endsection