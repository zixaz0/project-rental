@extends('layouts.app')

@section('title', 'Profil Saya - NGABRIDE')

@section('content')
<div class="bg-gray-50 min-h-screen py-6 sm:py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Button Kembali -->
        <div class="mb-4">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-100 border border-gray-300 transition shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span class="font-medium">Kembali</span>
            </a>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-start sm:items-center gap-3 sm:gap-4">
                    <div class="bg-blue-100 rounded-lg sm:rounded-full p-3 sm:p-4 flex-shrink-0">
                        <i class="fas fa-user text-blue-600 text-2xl sm:text-3xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">{{ $user->name }}</h1>
                        <p class="text-sm sm:text-base text-gray-600 truncate">{{ $user->email }}</p>
                        <div class="mt-2">
                            {!! $user->getStatusBadge() !!}
                        </div>
                    </div>
                </div>
                @if(!$user->isAdmin())
                    <a href="{{ route('profile.edit') }}" class="w-full sm:w-auto px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center text-sm font-medium">
                        <i class="fas fa-edit mr-2"></i>Edit Profil
                    </a>
                @endif
            </div>
        </div>

        @if($user->isBelumLengkap() && !$user->isDitolak())
            <!-- Alert Belum Lengkap -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 sm:p-6 mb-4 sm:mb-6 rounded-lg shadow-sm">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400 text-xl sm:text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-semibold text-yellow-800 mb-2">
                            Data Belum Lengkap!
                        </h3>
                        <p class="text-xs sm:text-sm text-yellow-700 mb-3 leading-relaxed">
                            Lengkapi data untuk pemesanan. Pastikan dokumen jelas dan sesuai.
                        </p>
                        <a href="{{ route('profile.complete') }}" class="inline-flex items-center px-4 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Lengkapi Data Sekarang
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if($user->isDitolak())
            <!-- Alert Ditolak - Prominent -->
            <div class="bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-400 p-4 sm:p-6 mb-4 sm:mb-6 rounded-xl shadow-md">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="bg-red-500 rounded-full p-2 sm:p-3">
                            <i class="fas fa-times-circle text-white text-xl sm:text-3xl"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg sm:text-xl font-bold text-red-900 mb-2 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            Verifikasi Ditolak!
                        </h3>
                        <p class="text-xs sm:text-sm text-red-800 mb-4 leading-relaxed">
                            Dokumen ditolak. Perbaiki sesuai catatan, lalu upload ulang dokumen yang lebih jelas.
                        </p>
                        
                        @if($user->verification_note)
                            <div class="bg-white border border-red-300 rounded-lg p-3 sm:p-4 mb-4">
                                <div class="flex gap-2 sm:gap-3">
                                    <i class="fas fa-comment-alt text-red-600 text-sm sm:text-base flex-shrink-0 mt-0.5"></i>
                                    <div class="flex-1 min-w-0">
                                        <label class="text-xs sm:text-sm font-bold text-red-900 block mb-2">Alasan Penolakan:</label>
                                        <p class="text-xs sm:text-sm text-gray-800 leading-relaxed">{{ $user->verification_note }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="bg-red-100 border border-red-300 rounded-lg p-3 mb-4">
                            <p class="text-xs font-semibold text-red-800 mb-2 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>
                                Yang perlu dilakukan:
                            </p>
                            <ul class="text-xs text-red-700 space-y-1.5 ml-5 list-disc">
                                <li>Baca alasan penolakan</li>
                                <li>Siapkan foto lebih jelas</li>
                                <li>Pastikan KTP tidak blur</li>
                                <li>Selfie + KTP harus jelas</li>
                                <li>Upload ulang dokumen</li>
                            </ul>
                        </div>

                        <a href="{{ route('profile.complete') }}" class="inline-flex items-center px-4 sm:px-6 py-2.5 sm:py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg shadow-md transition transform hover:scale-105">
                            <i class="fas fa-redo mr-2"></i>
                            Perbaiki & Upload Ulang
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if($user->isMenungguVerifikasi())
            <!-- Alert Menunggu -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 sm:p-6 mb-4 sm:mb-6 rounded-lg shadow-sm">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-blue-400 text-xl sm:text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-semibold text-blue-800 mb-2">
                            Menunggu Verifikasi
                        </h3>
                        <p class="text-xs sm:text-sm text-blue-700 mb-3 leading-relaxed">
                            Dokumen sedang diverifikasi. Proses 1-2 hari kerja. Anda akan diberi notifikasi.
                        </p>
                        <div class="flex items-center text-xs sm:text-sm text-blue-600">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span>Mohon bersabar</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($user->isTerverifikasi())
            <!-- Alert Terverifikasi -->
            <div class="bg-green-50 border-l-4 border-green-400 p-4 sm:p-6 mb-4 sm:mb-6 rounded-lg shadow-sm">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="bg-green-500 rounded-full p-2">
                            <i class="fas fa-check-circle text-white text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-semibold text-green-800 mb-2">
                            Akun Terverifikasi!
                        </h3>
                        <p class="text-xs sm:text-sm text-green-700">
                            Selamat! Anda dapat melakukan pemesanan kendaraan.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Info Akun -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">
            <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                <i class="fas fa-user-circle text-indigo-600"></i>
                <span>Informasi Akun</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label class="text-xs sm:text-sm font-medium text-gray-600 flex items-center gap-2 mb-1">
                        <i class="fas fa-id-badge text-gray-400"></i>
                        Nama Lengkap
                    </label>
                    <p class="text-sm sm:text-base text-gray-900 font-medium truncate">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="text-xs sm:text-sm font-medium text-gray-600 flex items-center gap-2 mb-1">
                        <i class="fas fa-envelope text-gray-400"></i>
                        Email
                    </label>
                    <p class="text-sm sm:text-base text-gray-900 font-medium truncate">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="text-xs sm:text-sm font-medium text-gray-600 flex items-center gap-2 mb-1">
                        <i class="fas fa-phone text-gray-400"></i>
                        No. Telepon
                    </label>
                    <p class="text-sm sm:text-base text-gray-900 font-medium">{{ $user->phone ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs sm:text-sm font-medium text-gray-600 flex items-center gap-2 mb-1">
                        <i class="fas fa-user-tag text-gray-400"></i>
                        Role
                    </label>
                    <p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            <i class="fas {{ $user->isAdmin() ? 'fa-shield-alt' : 'fa-user' }} mr-1"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs sm:text-sm font-medium text-gray-600 flex items-center gap-2 mb-1">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                        Alamat
                    </label>
                    <p class="text-sm sm:text-base text-gray-900">{{ $user->address ?? '-' }}</p>
                </div>
            </div>
        </div>

        @if(in_array($user->status, ['ditolak', 'menunggu_verifikasi', 'terverifikasi']) && $user->nik)
            <!-- Data Identitas -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">
                <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                    <i class="fas fa-id-card text-indigo-600"></i>
                    <span>Data Identitas</span>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-600 flex items-center gap-2 mb-1">
                            <i class="fas fa-credit-card text-gray-400"></i>
                            NIK (KTP)
                        </label>
                        <p class="text-sm sm:text-base text-gray-900 font-mono font-semibold">{{ $user->nik }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-600 flex items-center gap-2 mb-1">
                            <i class="fas fa-calendar text-gray-400"></i>
                            Tanggal Lahir
                        </label>
                        <p class="text-sm sm:text-base text-gray-900 font-medium">{{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-600 flex items-center gap-2 mb-1">
                            <i class="fas fa-venus-mars text-gray-400"></i>
                            Jenis Kelamin
                        </label>
                        <p class="text-sm sm:text-base text-gray-900 font-medium">{{ ucfirst($user->jenis_kelamin) }}</p>
                    </div>
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-600 flex items-center gap-2 mb-1">
                            <i class="fas fa-birthday-cake text-gray-400"></i>
                            Umur
                        </label>
                        <p class="text-sm sm:text-base text-gray-900 font-medium">{{ \Carbon\Carbon::parse($user->tanggal_lahir)->age }} Tahun</p>
                    </div>
                </div>
            </div>

            <!-- Dokumen -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                    <i class="fas fa-file-image text-indigo-600"></i>
                    <span>Dokumen</span>
                </h2>
                
                @if($user->isDitolak())
                    <div class="bg-orange-50 border-l-4 border-orange-400 p-3 sm:p-4 mb-4">
                        <div class="flex gap-2 sm:gap-3">
                            <i class="fas fa-edit text-orange-500 text-base sm:text-xl flex-shrink-0 mt-0.5"></i>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs sm:text-sm font-semibold text-orange-800 mb-1">
                                    Dokumen Perlu Diperbaiki
                                </p>
                                <p class="text-xs text-orange-700">
                                    Klik "Edit Profil" untuk upload ulang dokumen.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Foto KTP -->
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">
                            <i class="fas fa-id-card text-gray-400"></i>
                            Foto KTP
                        </label>
                        @if($user->foto_ktp)
                            <a href="{{ asset('storage/' . $user->foto_ktp) }}" target="_blank" class="block">
                                <img src="{{ asset('storage/' . $user->foto_ktp) }}" alt="KTP" class="w-full h-40 object-cover rounded-lg border-2 border-gray-200 hover:border-indigo-500 hover:opacity-75 transition" onerror="this.src='{{ asset($user->foto_ktp) }}'">
                            </a>
                        @else
                            <div class="w-full h-40 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center">
                                <i class="fas fa-image text-gray-300 text-2xl sm:text-3xl mb-2"></i>
                                <p class="text-gray-400 text-xs">Belum upload</p>
                            </div>
                        @endif
                    </div>

                    <!-- Foto Selfie KTP -->
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">
                            <i class="fas fa-camera text-gray-400"></i>
                            Selfie + KTP
                        </label>
                        @if($user->foto_selfie_ktp)
                            <a href="{{ asset('storage/' . $user->foto_selfie_ktp) }}" target="_blank" class="block">
                                <img src="{{ asset('storage/' . $user->foto_selfie_ktp) }}" alt="Selfie" class="w-full h-40 object-cover rounded-lg border-2 border-gray-200 hover:border-indigo-500 hover:opacity-75 transition" onerror="this.src='{{ asset($user->foto_selfie_ktp) }}'">
                            </a>
                        @else
                            <div class="w-full h-40 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center">
                                <i class="fas fa-image text-gray-300 text-2xl sm:text-3xl mb-2"></i>
                                <p class="text-gray-400 text-xs">Belum upload</p>
                            </div>
                        @endif
                    </div>

                    <!-- Foto SIM -->
                    <div>
                        <label class="text-xs sm:text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">
                            <i class="fas fa-address-card text-gray-400"></i>
                            Foto SIM
                        </label>
                        @if($user->foto_sim)
                            <a href="{{ asset('storage/' . $user->foto_sim) }}" target="_blank" class="block">
                                <img src="{{ asset('storage/' . $user->foto_sim) }}" alt="SIM" class="w-full h-40 object-cover rounded-lg border-2 border-gray-200 hover:border-indigo-500 hover:opacity-75 transition" onerror="this.src='{{ asset($user->foto_sim) }}'">
                            </a>
                        @else
                            <div class="w-full h-40 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center">
                                <i class="fas fa-image text-gray-300 text-2xl sm:text-3xl mb-2"></i>
                                <p class="text-gray-400 text-xs">Tidak ada</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($user->isTerverifikasi() && $user->verification_note)
                    <div class="mt-6 p-4 sm:p-5 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border-2 border-green-300 shadow-sm">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="bg-green-500 rounded-full p-2">
                                    <i class="fas fa-check-circle text-white text-base sm:text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <label class="text-xs sm:text-sm font-bold text-green-900 flex items-center gap-2 mb-2">
                                    <i class="fas fa-comment-dots"></i>
                                    Catatan Verifikasi
                                </label>
                                <p class="text-xs sm:text-sm text-gray-800 leading-relaxed mb-3">{{ $user->verification_note }}</p>
                                @if($user->verified_at)
                                    <div class="flex flex-wrap items-center gap-1 text-xs text-gray-600 bg-white rounded px-3 py-2 border border-green-200">
                                        <i class="fas fa-calendar-check text-green-600"></i>
                                        <span class="break-all">
                                            Diverifikasi <strong>{{ \Carbon\Carbon::parse($user->verified_at)->format('d M Y, H:i') }}</strong>
                                            @if($user->verifiedBy)
                                                oleh <strong>{{ $user->verifiedBy->name }}</strong>
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection