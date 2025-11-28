@extends('layouts.admin')
@section('title', 'Kelola User - Admin')
@section('page-title', 'Kelola User')
@section('page-subtitle', 'Kelola dan verifikasi data customer')

@section('content')
    <!-- Filter & Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total User</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Verified Users -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Terverifikasi</p>
                    <p class="text-2xl font-bold text-green-600">{{ $verifiedUsers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Verification -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pendingUsers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Rejected Users -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Ditolak</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $rejectedUsers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Incomplete Data -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Belum Lengkap</p>
                    <p class="text-2xl font-bold text-red-600">{{ $incompleteUsers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" id="filterForm">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                <!-- Filter -->
                <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Bar -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1"></i>Cari User
                        </label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Nama, email, NIK..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            autocomplete="off">
                    </div>

                    <!-- Filter Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-tag mr-1"></i>Role
                        </label>
                        <select name="role" id="role"
                            class="cursor-pointer w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        </select>
                    </div>

                    <!-- Filter Status Verifikasi -->
                    <div>
                        <label for="verification_status" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-check-double mr-1"></i>Status
                        </label>
                        <select name="verification_status" id="verification_status"
                            class="cursor-pointer w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">Semua Status</option>
                            <option value="terverifikasi" {{ request('verification_status') == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="menunggu_verifikasi" {{ request('verification_status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="ditolak" {{ request('verification_status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="belum_lengkap" {{ request('verification_status') == 'belum_lengkap' ? 'selected' : '' }}>Belum Lengkap</option>
                        </select>
                    </div>

                    <!-- Filter Jenis Kelamin -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-venus-mars mr-1"></i>Jenis Kelamin
                        </label>
                        <select name="gender" id="gender"
                            class="cursor-pointer w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">Semua</option>
                            <option value="laki-laki" {{ request('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ request('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-end gap-2">
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center px-4 py-2 {{ request()->hasAny(['search', 'role', 'verification_status', 'gender']) ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 hover:bg-gray-500' }} text-white rounded-lg transition duration-150">
                        <i class="fas fa-times mr-2"></i>
                        Clear Filter
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-600 font-semibold text-sm">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <i class="fas fa-phone text-gray-400 mr-1"></i>
                                    {{ $user->phone ?? '-' }}
                                </div>
                                <div class="text-sm text-gray-500 max-w-xs truncate" title="{{ $user->address }}">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                    {{ $user->address ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->nik)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-mono font-semibold bg-gray-800 text-white">
                                        {{ $user->nik }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->role == 'admin')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-shield-alt mr-1"></i>
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-user mr-1"></i>
                                        Customer
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->role == 'admin')
                                    <span class="text-sm text-gray-400">-</span>
                                @else
                                    @php
                                        $statusConfig = [
                                            'belum_lengkap' => ['color' => 'red', 'icon' => 'exclamation-circle', 'text' => 'Belum Lengkap'],
                                            'menunggu_verifikasi' => ['color' => 'yellow', 'icon' => 'clock', 'text' => 'Menunggu'],
                                            'terverifikasi' => ['color' => 'green', 'icon' => 'check-double', 'text' => 'Terverifikasi'],
                                            'ditolak' => ['color' => 'orange', 'icon' => 'times-circle', 'text' => 'Ditolak'],
                                        ];
                                        $config = $statusConfig[$user->status] ?? $statusConfig['belum_lengkap'];
                                    @endphp
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800">
                                            <i class="fas fa-{{ $config['icon'] }} mr-1"></i>
                                            {{ $config['text'] }}
                                        </span>
                                        @if($user->status == 'terverifikasi' && $user->verified_at)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ \Carbon\Carbon::parse($user->verified_at)->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    @php
                                        $userData = [
                                            'id' => $user->id,
                                            'name' => $user->name,
                                            'email' => $user->email,
                                            'phone' => $user->phone ?? '-',
                                            'address' => $user->address ?? '-',
                                            'nik' => $user->nik ?? '-',
                                            'tanggal_lahir' => $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d/m/Y') : '-',
                                            'jenis_kelamin' => $user->jenis_kelamin ? ucfirst($user->jenis_kelamin) : '-',
                                            'role' => ucfirst($user->role),
                                            'status' => $user->status,
                                            'status_text' => $user->getStatusText(),
                                            'verified_at' => $user->verified_at ? \Carbon\Carbon::parse($user->verified_at)->format('d/m/Y H:i') : '-',
                                            'verified_by_name' => $user->verifiedBy->name ?? '-',
                                            'verification_note' => $user->verification_note ?? 'Tidak ada catatan',
                                            'foto_ktp' => $user->foto_ktp ? asset($user->foto_ktp) : null,
                                            'foto_selfie_ktp' => $user->foto_selfie_ktp ? asset($user->foto_selfie_ktp) : null,
                                            'foto_sim' => $user->foto_sim ? asset($user->foto_sim) : null,
                                        ];
                                    @endphp
                                    
                                    <!-- Detail Button -->
                                    <button type="button" onclick='showUserDetail(@json($userData))'
                                        class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md transition duration-150"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Verify & Reject Button (Only for menunggu_verifikasi) -->
                                    @if($user->role == 'customer' && $user->status == 'menunggu_verifikasi')
                                        <button type="button" onclick='showVerifyModal(@json($userData))'
                                            class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded-md transition duration-150"
                                            title="Verifikasi">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" onclick='showRejectModal(@json($userData))'
                                            class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md transition duration-150"
                                            title="Tolak Verifikasi">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif

                                    <!-- Unverify Button (Only for terverifikasi) -->
                                    @if($user->role == 'customer' && $user->status == 'terverifikasi')
                                        <button type="button" onclick="confirmUnverify({{ $user->id }}, '{{ $user->name }}')"
                                            class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md transition duration-150"
                                            title="Batalkan Verifikasi">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    @endif

                                    <!-- Delete Button (Cannot delete self) -->
                                    @if($user->id != auth()->id())
                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                class="cursor-pointer inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md transition duration-150"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-users text-gray-300 text-5xl mb-3"></i>
                                    <p class="text-gray-500 text-lg">Belum ada data user</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($users->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                        @endif

                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        @else
                            <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                Next
                            </span>
                        @endif
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Menampilkan
                                <span class="font-medium">{{ $users->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $users->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $users->total() }}</span>
                                user
                            </p>
                        </div>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Auto submit filter
        document.getElementById('search').addEventListener('input', function() {
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        });

        ['role', 'verification_status', 'gender'].forEach(id => {
            document.getElementById(id).addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });

        // Show User Detail
        function showUserDetail(data) {
            let documentsHtml = '';
            
            if (data.foto_ktp || data.foto_selfie_ktp || data.foto_sim) {
                documentsHtml = `
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-id-card text-indigo-600 mr-2"></i>
                            Dokumen
                        </h4>
                        <div class="grid ${data.foto_sim ? 'grid-cols-3' : 'grid-cols-2'} gap-3">
                            ${data.foto_ktp ? `
                                <div>
                                    <p class="text-xs text-gray-600 mb-2">Foto KTP</p>
                                    <img src="${data.foto_ktp}" alt="KTP" 
                                        class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-80 transition border-2 border-gray-200"
                                        onclick="window.open('${data.foto_ktp}', '_blank')"
                                        title="Klik untuk memperbesar">
                                </div>
                            ` : ''}
                            ${data.foto_selfie_ktp ? `
                                <div>
                                    <p class="text-xs text-gray-600 mb-2">Selfie dengan KTP</p>
                                    <img src="${data.foto_selfie_ktp}" alt="Selfie KTP" 
                                        class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-80 transition border-2 border-gray-200"
                                        onclick="window.open('${data.foto_selfie_ktp}', '_blank')"
                                        title="Klik untuk memperbesar">
                                </div>
                            ` : ''}
                            ${data.foto_sim ? `
                                <div>
                                    <p class="text-xs text-gray-600 mb-2">Foto SIM</p>
                                    <img src="${data.foto_sim}" alt="SIM" 
                                        class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-80 transition border-2 border-gray-200"
                                        onclick="window.open('${data.foto_sim}', '_blank')"
                                        title="Klik untuk memperbesar">
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            }

            const statusColor = {
                'belum_lengkap': 'red',
                'menunggu_verifikasi': 'yellow',
                'terverifikasi': 'green',
                'ditolak': 'orange'
            };

            Swal.fire({
                title: '<div class="text-2xl font-bold text-gray-800"><i class="fas fa-user-circle mr-2 text-indigo-600"></i>Detail User</div>',
                html: `
                    <div class="text-left">
                        <!-- User Info -->
                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-4 rounded-lg mb-4">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">${data.name}</h3>
                            <p class="text-sm text-gray-600">${data.email}</p>
                        </div>

                        <!-- Personal Info -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Role</p>
                                <p class="font-semibold text-gray-800">${data.role}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">NIK</p>
                                <p class="font-mono font-semibold text-gray-800">${data.nik}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Tanggal Lahir</p>
                                <p class="font-semibold text-gray-800">${data.tanggal_lahir}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Jenis Kelamin</p>
                                <p class="font-semibold text-gray-800">${data.jenis_kelamin}</p>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-green-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Telepon</span>
                                </div>
                                <span class="font-semibold text-gray-800">${data.phone}</span>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-map-marker-alt text-red-600 mr-3"></i>
                                    <span class="text-sm text-gray-600">Alamat</span>
                                </div>
                                <p class="text-sm text-gray-800 ml-8">${data.address}</p>
                            </div>
                        </div>

                        ${documentsHtml}

                        <!-- Status -->
                        <div class="bg-${statusColor[data.status]}-50 p-4 rounded-lg mb-4">
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-clipboard-check text-${statusColor[data.status]}-600 mr-2"></i>
                                Status: ${data.status_text}
                            </h4>
                            ${data.status === 'terverifikasi' ? `
                                <div class="border-t pt-2 mt-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Diverifikasi Oleh</span>
                                        <span class="text-sm text-gray-800">${data.verified_by_name}</span>
                                    </div>
                                </div>
                            ` : ''}
                        </div>

                        ${data.verification_note && data.verification_note !== 'Tidak ada catatan' ? `
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                                    <i class="fas fa-comment-alt text-gray-600 mr-2"></i>
                                    Catatan
                                </h4>
                                <p class="text-sm text-gray-700">${data.verification_note}</p>
                            </div>
                        ` : ''}
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: false,
                width: '800px',
                customClass: {
                    popup: 'swal-detail-modal',
                    htmlContainer: 'swal-html-container'
                }
            });
        }

        // Show Verify Modal
        function showVerifyModal(data) {
            Swal.fire({
                title: '<div class="text-xl font-bold text-gray-800">Verifikasi User</div>',
                html: `
                    <div class="text-left mb-4">
                        <div class="bg-gray-100 p-4 rounded-lg mb-4">
                            <p class="font-semibold text-gray-800 text-lg">${data.name}</p>
                            <p class="text-sm text-gray-600">${data.email}</p>
                            <p class="text-sm text-gray-600 mt-1">NIK: <span class="font-mono font-bold">${data.nik}</span></p>
                        </div>

                        ${data.foto_ktp || data.foto_selfie_ktp || data.foto_sim ? `
                            <div class="mb-4">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Dokumen:</p>
                                <div class="grid ${data.foto_sim ? 'grid-cols-3' : 'grid-cols-2'} gap-2">
                                    ${data.foto_ktp ? `
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">KTP</p>
                                            <img src="${data.foto_ktp}" alt="KTP" 
                                                class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-80 border-2 border-gray-200"
                                                onclick="window.open('${data.foto_ktp}', '_blank')"
                                                title="Klik untuk memperbesar">
                                        </div>
                                    ` : ''}
                                    ${data.foto_selfie_ktp ? `
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">Selfie KTP</p>
                                            <img src="${data.foto_selfie_ktp}" alt="Selfie" 
                                                class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-80 border-2 border-gray-200"
                                                onclick="window.open('${data.foto_selfie_ktp}', '_blank')"
                                                title="Klik untuk memperbesar">
                                        </div>
                                    ` : ''}
                                    ${data.foto_sim ? `
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">SIM</p>
                                            <img src="${data.foto_sim}" alt="SIM" 
                                                class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-80 border-2 border-gray-200"
                                                onclick="window.open('${data.foto_sim}', '_blank')"
                                                title="Klik untuk memperbesar">
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        ` : ''}

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan Verifikasi <span class="text-red-500">*</span>
                            </label>
                            <textarea id="verification_note" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Contoh: Data sudah sesuai dan valid. Dokumen lengkap dan jelas."></textarea>
                        </div>

                        <div class="bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                Pastikan semua dokumen dan data sudah benar sebelum memverifikasi
                            </p>
                        </div>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-check mr-2"></i>Verifikasi',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true,
                focusCancel: true,
                width: '600px',
                preConfirm: () => {
                    const note = document.getElementById('verification_note').value;
                    if (!note.trim()) {
                        Swal.showValidationMessage('Catatan verifikasi harus diisi!');
                        return false;
                    }
                    return { note: note };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    verifyUser(data.id, result.value.note);
                }
            });
        }

        // Show Reject Modal
        function showRejectModal(data) {
            Swal.fire({
                title: '<div class="text-xl font-bold text-red-800">Tolak Verifikasi</div>',
                html: `
                    <div class="text-left mb-4">
                        <div class="bg-red-50 border border-red-200 p-4 rounded-lg mb-4">
                            <p class="font-semibold text-gray-800 text-lg">${data.name}</p>
                            <p class="text-sm text-gray-600">${data.email}</p>
                            <p class="text-sm text-gray-600 mt-1">NIK: <span class="font-mono font-bold">${data.nik}</span></p>
                        </div>

                        ${data.foto_ktp || data.foto_selfie_ktp || data.foto_sim ? `
                            <div class="mb-4">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Dokumen yang akan dihapus:</p>
                                <div class="grid ${data.foto_sim ? 'grid-cols-3' : 'grid-cols-2'} gap-2">
                                    ${data.foto_ktp ? `
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">KTP</p>
                                            <img src="${data.foto_ktp}" alt="KTP" 
                                                class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-80 border-2 border-red-200"
                                                onclick="window.open('${data.foto_ktp}', '_blank')"
                                                title="Klik untuk memperbesar">
                                        </div>
                                    ` : ''}
                                    ${data.foto_selfie_ktp ? `
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">Selfie KTP</p>
                                            <img src="${data.foto_selfie_ktp}" alt="Selfie" 
                                                class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-80 border-2 border-red-200"
                                                onclick="window.open('${data.foto_selfie_ktp}', '_blank')"
                                                title="Klik untuk memperbesar">
                                        </div>
                                    ` : ''}
                                    ${data.foto_sim ? `
                                        <div>
                                            <p class="text-xs text-gray-600 mb-1">SIM</p>
                                            <img src="${data.foto_sim}" alt="SIM" 
                                                class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-80 border-2 border-red-200"
                                                onclick="window.open('${data.foto_sim}', '_blank')"
                                                title="Klik untuk memperbesar">
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        ` : ''}

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alasan Penolakan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="reject_note" rows="4"
                                class="w-full px-3 py-2 border border-red-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Contoh: Foto KTP tidak jelas/buram. Foto selfie tidak sesuai dengan KTP. Mohon upload ulang dengan foto yang lebih jelas."></textarea>
                        </div>

                        <div class="bg-red-50 border border-red-200 p-3 rounded-lg">
                            <p class="text-sm text-red-800 font-semibold mb-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Peringatan!
                            </p>
                            <ul class="text-xs text-red-700 space-y-1 ml-5 list-disc">
                                <li>User harus melengkapi data dari awal</li>
                                <li>Semua dokumen yang sudah diupload akan dihapus</li>
                                <li>Status akan berubah menjadi "Ditolak"</li>
                            </ul>
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-times mr-2"></i>Tolak Verifikasi',
                cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>Batal',
                reverseButtons: true,
                focusCancel: true,
                width: '600px',
                preConfirm: () => {
                    const note = document.getElementById('reject_note').value;
                    if (!note.trim()) {
                        Swal.showValidationMessage('Alasan penolakan harus diisi!');
                        return false;
                    }
                    return { note: note };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    rejectVerification(data.id, result.value.note);
                }
            });
        }

        // Verify User
        function verifyUser(userId, note) {
            Swal.fire({
                title: 'Memverifikasi...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${userId}/verify`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const noteInput = document.createElement('input');
            noteInput.type = 'hidden';
            noteInput.name = 'verification_note';
            noteInput.value = note;
            
            form.appendChild(csrfToken);
            form.appendChild(noteInput);
            document.body.appendChild(form);
            form.submit();
        }

        // Reject Verification
        function rejectVerification(userId, note) {
            Swal.fire({
                title: 'Menolak Verifikasi...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${userId}/reject`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const noteInput = document.createElement('input');
            noteInput.type = 'hidden';
            noteInput.name = 'reject_note';
            noteInput.value = note;
            
            form.appendChild(csrfToken);
            form.appendChild(noteInput);
            document.body.appendChild(form);
            form.submit();
        }

        // Confirm Unverify
        function confirmUnverify(userId, userName) {
            Swal.fire({
                title: 'Batalkan Verifikasi?',
                html: `
                    <div class="text-left">
                        <p class="mb-2">Anda yakin ingin membatalkan verifikasi untuk:</p>
                        <div class="bg-gray-100 p-3 rounded-lg mb-3">
                            <p class="font-semibold text-gray-800">${userName}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alasan Pembatalan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="unverify_note" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="Contoh: Ditemukan ketidaksesuaian data, perlu verifikasi ulang."></textarea>
                        </div>

                        <div class="bg-yellow-50 p-3 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                User ini akan kembali ke status "Menunggu Verifikasi"
                            </p>
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#eab308',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-undo mr-2"></i>Ya, Batalkan',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true,
                focusCancel: true,
                preConfirm: () => {
                    const note = document.getElementById('unverify_note').value;
                    if (!note.trim()) {
                        Swal.showValidationMessage('Alasan pembatalan harus diisi!');
                        return false;
                    }
                    return { note: note };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    unverifyUser(userId, result.value.note);
                }
            });
        }

        // Unverify User
        function unverifyUser(userId, note) {
            Swal.fire({
                title: 'Membatalkan Verifikasi...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${userId}/unverify`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const noteInput = document.createElement('input');
            noteInput.type = 'hidden';
            noteInput.name = 'verification_note';
            noteInput.value = note;
            
            form.appendChild(csrfToken);
            form.appendChild(noteInput);
            document.body.appendChild(form);
            form.submit();
        }

        // Confirm Delete
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Hapus User?',
                html: `
                    <div class="text-left">
                        <p class="mb-2">Anda yakin ingin menghapus user:</p>
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <p class="font-semibold text-gray-800">${userName}</p>
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
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        }
    </script>

    <style>
        .swal-wide {
            width: 600px !important;
        }

        .swal-detail-modal {
            border-radius: 1rem !important;
        }

        .swal-html-container {
            margin: 0 !important;
            padding: 1rem !important;
        }
    </style>
@endsection 