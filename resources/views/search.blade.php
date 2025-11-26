@extends('layouts.app')

@section('title', 'Cari Mobil - NGABRIDE')

@section('content')
    <!-- Search Header -->
    <div class="bg-gradient-to-br from-indigo-400 to-indigo-600 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Rental Harian</h2>
                
                <div class="flex flex-wrap items-center gap-4 text-sm">
                    <div class="flex items-center">
                        <i class="far fa-calendar mr-2 text-gray-600"></i>
                        <span>{{ $tanggal }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="far fa-clock mr-2 text-gray-600"></i>
                        <span>{{ $jam }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt mr-2 text-gray-600"></i>
                        <span>{{ $durasi }} Hari</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Info Banner -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Semua kendaraan sudah termasuk</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm text-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Layanan darurat 24 jam
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Asuransi comprehensive
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Bisa refund
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Mobil pengganti jika dibutuhkan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('search') }}" id="filterForm">
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Sidebar Filter -->
                    <div class="lg:w-80 flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-gray-900">Filter</h3>
                                <a href="{{ route('search') }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">Reset</a>
                            </div>

                            <!-- Price Filter -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-900 mb-4">Harga</h4>
                                <div class="space-y-3">
                                    <input type="range" name="harga_max" id="priceRange" min="0" max="4000000" 
                                        value="{{ request('harga_max', 4000000) }}" 
                                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600"
                                        onchange="updatePriceLabel(); document.getElementById('filterForm').submit();">
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Rp 0</span>
                                        <span id="maxPriceLabel">Rp {{ number_format(request('harga_max', 4000000), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Capacity Filter -->
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-4">Kapasitas penumpang</h4>
                                <div class="flex gap-2">
                                    <button type="button" onclick="setKapasitas('4')" 
                                        class="cursor-pointer px-4 py-2 border border-gray-300 rounded-lg text-sm hover:border-blue-600 hover:text-blue-600 transition {{ request('kapasitas') == '4' ? 'border-blue-600 text-blue-600 bg-blue-50' : '' }}">
                                        4 Kursi
                                    </button>
                                    <button type="button" onclick="setKapasitas('5-6')" 
                                        class="cursor-pointer px-4 py-2 border border-gray-300 rounded-lg text-sm hover:border-blue-600 hover:text-blue-600 transition {{ request('kapasitas') == '5-6' ? 'border-blue-600 text-blue-600 bg-blue-50' : '' }}">
                                        5-6 Kursi
                                    </button>
                                    <button type="button" onclick="setKapasitas('>6')" 
                                        class="cursor-pointer px-4 py-2 border border-gray-300 rounded-lg text-sm hover:border-blue-600 hover:text-blue-600 transition {{ request('kapasitas') == '>6' ? 'border-blue-600 text-blue-600 bg-blue-50' : '' }}">
                                        >6 Kursi
                                    </button>
                                </div>
                                <input type="hidden" name="kapasitas" id="kapasitasInput" value="{{ request('kapasitas') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Results -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Urutkan</h2>
                            </div>
                            <select name="sort" class="cursor-pointer px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                onchange="document.getElementById('filterForm').submit();">
                                <option value="harga_terendah" {{ request('sort') == 'harga_terendah' ? 'selected' : '' }}>Harga terendah</option>
                                <option value="harga_tertinggi" {{ request('sort') == 'harga_tertinggi' ? 'selected' : '' }}>Harga tertinggi</option>
                                <option value="terpopuler" {{ request('sort') == 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>

                        <div class="text-sm text-gray-600 mb-6">
                            Menampilkan {{ $totalKendaraan }} kendaraan
                        </div>

                        <!-- Car List -->
                        <div class="space-y-4">
                            @forelse($kendaraans as $kendaraan)
                                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                                    <div class="flex flex-col md:flex-row">
                                        <div class="md:w-64 h-48 md:h-auto bg-gray-100">
                                            <img src="{{ asset($kendaraan->foto) }}" 
                                                alt="{{ $kendaraan->merk }} {{ $kendaraan->model }}" 
                                                class="w-full h-full object-contain p-4">
                                        </div>
                                        <div class="flex-1 p-6">
                                            <div class="flex justify-between items-start mb-4">
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ strtoupper($kendaraan->merk . ' ' . $kendaraan->model) }}</h3>
                                                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-users mr-2"></i>
                                                            <span>{{ $kendaraan->kapasitas_penumpang }} Kursi</span>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <i class="fas fa-shield-alt mr-2"></i>
                                                            <span>Asuransi</span>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <i class="fas fa-cog mr-2"></i>
                                                            <span>{{ ucfirst($kendaraan->transmisi) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 flex items-center text-sm text-green-600">
                                                        <i class="fas fa-check-circle mr-2"></i>
                                                        <span>Tahun {{ $kendaraan->tahun }} - {{ $kendaraan->warna }}</span>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-2xl font-bold text-orange-600">
                                                        Rp {{ number_format($kendaraan->harga->harga_per_hari, 0, ',', '.') }}
                                                    </div>
                                                    <div class="text-sm text-gray-600">/ Hari</div>
                                                    <button type="button" onclick="checkUserStatus({{ $kendaraan->id }})"
                                                        class="mt-4 inline-block px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
                                                        Pesan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                                    <i class="fas fa-car text-gray-300 text-5xl mb-4"></i>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak ada kendaraan ditemukan</h3>
                                    <p class="text-gray-600">Coba ubah filter pencarian Anda</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs untuk mempertahankan parameter -->
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                <input type="hidden" name="jam" value="{{ $jam }}">
                <input type="hidden" name="durasi" value="{{ $durasi }}">
            </form>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function updatePriceLabel() {
            const priceRange = document.getElementById('priceRange');
            const maxPriceLabel = document.getElementById('maxPriceLabel');
            const value = parseInt(priceRange.value);
            maxPriceLabel.textContent = 'Rp ' + value.toLocaleString('id-ID');
        }

        function setKapasitas(value) {
            document.getElementById('kapasitasInput').value = value;
            document.getElementById('filterForm').submit();
        }

        function checkUserStatus(kendaraanId) {
            @auth
                @if(Auth::user()->is_complete)
                    // User sudah lengkap, lanjut ke halaman booking
                    window.location.href = `/booking/${kendaraanId}`;
                @else
                    // User belum lengkap data
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        html: 'Anda harus melengkapi data diri terlebih dahulu sebelum melakukan pemesanan.<br><br>Silakan lengkapi data diri Anda.',
                        showCancelButton: true,
                        confirmButtonText: 'Lengkapi Sekarang',
                        cancelButtonText: 'Nanti',
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#6b7280'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('profile.complete') }}';
                        }
                    });
                @endif
            @else
                // User belum login
                Swal.fire({
                    icon: 'info',
                    title: 'Login Terlebih Dahulu',
                    text: 'Anda harus login terlebih dahulu untuk melakukan pemesanan.',
                    showCancelButton: true,
                    confirmButtonText: 'Login',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#6b7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('login') }}';
                    }
                });
            @endauth
        }
    </script>
@endsection