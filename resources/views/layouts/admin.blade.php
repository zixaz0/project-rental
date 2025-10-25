<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - NGABRIDE ONLINE')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Tooltip Styles */
        .nav-tooltip {
            position: relative;
        }

        .nav-tooltip .tooltip-content {
            visibility: hidden;
            opacity: 0;
            position: fixed;
            left: calc(80px + 12px);
            transform: translateY(-50%);
            background-color: #1f2937;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            white-space: nowrap;
            font-size: 13px;
            font-weight: 500;
            z-index: 99999;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nav-tooltip .tooltip-content::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #1f2937;
        }

        .nav-tooltip:hover .tooltip-content {
            visibility: visible;
            opacity: 1;
        }

        /* Hide tooltips on mobile and when sidebar is open */
        @media (max-width: 768px) {
            .nav-tooltip .tooltip-content {
                display: none !important;
            }
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 antialiased" x-data="{
    sidebarOpen: window.innerWidth >= 768 ? (JSON.parse(localStorage.getItem('sidebarOpen')) ?? true) : false,
    mobileMenuOpen: false,
    toggleSidebar() {
        if (window.innerWidth >= 768) {
            this.sidebarOpen = !this.sidebarOpen;
            localStorage.setItem('sidebarOpen', JSON.stringify(this.sidebarOpen));
        } else {
            this.mobileMenuOpen = !this.mobileMenuOpen;
        }
    },
    closeMobileMenu() {
        this.mobileMenuOpen = false;
    }
}" x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', JSON.stringify(val)));
window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
        mobileMenuOpen = false;
        sidebarOpen = JSON.parse(localStorage.getItem('sidebarOpen')) ?? true;
    } else {
        sidebarOpen = false;
    }
});">

    <!-- Mobile Overlay -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="closeMobileMenu()"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 z-30 md:hidden" x-cloak>
    </div>

    <!-- Sidebar -->
    <aside
        :class="{
            'w-64': sidebarOpen && window.innerWidth >= 768,
            'w-20': !sidebarOpen && window.innerWidth >= 768,
            'translate-x-0': mobileMenuOpen || window.innerWidth >= 768,
            '-translate-x-full': !mobileMenuOpen && window.innerWidth < 768
        }"
        class="fixed left-0 top-0 h-full bg-white text-gray-800 flex flex-col shadow-lg border-r border-gray-200 z-40"
        style="transition: width 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);">

        <!-- Logo Section -->
        <div class="h-16 flex items-center border-b border-gray-200 flex-shrink-0 bg-white px-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="NGABRIDE Logo" class="object-contain"
                    style="transition: height 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);"
                    :style="(sidebarOpen || mobileMenuOpen) ? 'height: 44px' : 'height: 36px'">
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak x-transition
                    class="text-2xl font-bold text-indigo-600 tracking-tight">
                    NGABRIDE
                </span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 mt-4 px-3 space-y-1 overflow-y-auto custom-scrollbar">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" @click="window.innerWidth < 768 && closeMobileMenu()"
                class="nav-tooltip flex items-center rounded-lg group relative {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                :class="(sidebarOpen || mobileMenuOpen) ? 'px-4 py-3' : 'px-4 py-3 justify-center'"
                style="transition: all 0.2s ease;">
                <i class="fas fa-house text-lg"></i>
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak x-transition
                    class="ml-3 font-medium text-sm whitespace-nowrap">Dashboard</span>
                <span x-show="!sidebarOpen && !mobileMenuOpen" class="tooltip-content">Dashboard</span>
            </a>

            <!-- Kendaraan -->
            <a href="#" @click="window.innerWidth < 768 && closeMobileMenu()"
                class="nav-tooltip flex items-center rounded-lg group relative text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                :class="(sidebarOpen || mobileMenuOpen) ? 'px-4 py-3' : 'px-4 py-3 justify-center'"
                style="transition: all 0.2s ease;">
                <i class="fas fa-car text-lg"></i>
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak x-transition
                    class="ml-3 font-medium text-sm whitespace-nowrap">Kendaraan</span>
                <span x-show="!sidebarOpen && !mobileMenuOpen" class="tooltip-content">Kendaraan</span>
            </a>

            <!-- Pesanan -->
            <a href="#" @click="window.innerWidth < 768 && closeMobileMenu()"
                class="nav-tooltip flex items-center rounded-lg group relative text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                :class="(sidebarOpen || mobileMenuOpen) ? 'px-4 py-3' : 'px-4 py-3 justify-center'"
                style="transition: all 0.2s ease;">
                <i class="fas fa-file-invoice text-lg"></i>
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak x-transition
                    class="ml-3 font-medium text-sm whitespace-nowrap">Pesanan</span>
                <span x-show="!sidebarOpen && !mobileMenuOpen" class="tooltip-content">Pesanan</span>
            </a>

            <!-- Pelanggan -->
            <a href="#" @click="window.innerWidth < 768 && closeMobileMenu()"
                class="nav-tooltip flex items-center rounded-lg group relative text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                :class="(sidebarOpen || mobileMenuOpen) ? 'px-4 py-3' : 'px-4 py-3 justify-center'"
                style="transition: all 0.2s ease;">
                <i class="fas fa-users text-lg"></i>
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak x-transition
                    class="ml-3 font-medium text-sm whitespace-nowrap">Pelanggan</span>
                <span x-show="!sidebarOpen && !mobileMenuOpen" class="tooltip-content">Pelanggan</span>
            </a>

            <!-- Laporan Keuangan -->
            <a href="#" @click="window.innerWidth < 768 && closeMobileMenu()"
                class="nav-tooltip flex items-center rounded-lg group relative text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                :class="(sidebarOpen || mobileMenuOpen) ? 'px-4 py-3' : 'px-4 py-3 justify-center'"
                style="transition: all 0.2s ease;">
                <i class="fas fa-chart-line text-lg"></i>
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak x-transition
                    class="ml-3 font-medium text-sm whitespace-nowrap">Laporan Keuangan</span>
                <span x-show="!sidebarOpen && !mobileMenuOpen" class="tooltip-content">Laporan Keuangan</span>
            </a>

            <!-- Pengaturan -->
            <a href="#" @click="window.innerWidth < 768 && closeMobileMenu()"
                class="nav-tooltip flex items-center rounded-lg group relative text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                :class="(sidebarOpen || mobileMenuOpen) ? 'px-4 py-3' : 'px-4 py-3 justify-center'"
                style="transition: all 0.2s ease;">
                <i class="fas fa-gear text-lg"></i>
                <span x-show="sidebarOpen || mobileMenuOpen" x-cloak x-transition
                    class="ml-3 font-medium text-sm whitespace-nowrap">Pengaturan</span>
                <span x-show="!sidebarOpen && !mobileMenuOpen" class="tooltip-content">Pengaturan</span>
            </a>
        </nav>

        <!-- Logout Button (Bottom of Sidebar) -->
        <div class="p-3 border-t border-gray-200 flex-shrink-0 bg-white">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()"
                    class="nav-tooltip w-full bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center shadow-md hover:shadow-lg relative group cursor-pointer"
                    :class="(sidebarOpen || mobileMenuOpen) ? 'px-4 py-2.5 justify-center' : 'p-2.5 justify-center'"
                    style="transition: all 0.2s ease;">
                    <i class="fas fa-right-from-bracket text-base"></i>
                    <span x-show="sidebarOpen || mobileMenuOpen" x-cloak x-transition
                        class="ml-2 font-medium text-sm whitespace-nowrap cursor-pointer">Keluar</span>
                    <span x-show="!sidebarOpen && !mobileMenuOpen" class="tooltip-content">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="min-h-screen"
        :style="window.innerWidth >= 768 ? (sidebarOpen ? 'margin-left: 256px' : 'margin-left: 80px') : 'margin-left: 0'"
        style="transition: margin-left 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);">

        <!-- Header -->
        <header class="bg-white shadow-sm h-16 fixed top-0 right-0 z-30"
            :style="window.innerWidth >= 768 ? (sidebarOpen ? 'left: 256px' : 'left: 80px') : 'left: 0'"
            style="transition: left 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);">
            <div class="h-full flex items-center justify-between px-4 md:px-6">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <!-- Toggle Sidebar Button -->
                    <button @click="toggleSidebar()"
                        class="text-gray-600 hover:text-indigo-600 p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 cursor-pointer">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="hidden sm:block border-l border-gray-300 h-8"></div>

                    <!-- Page Title -->
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    </div>
                </div>

                <div class="flex items-center space-x-2 md:space-x-3">
                    <!-- Time Display (Desktop) -->
                    <div class="hidden lg:block text-xs md:text-sm font-medium text-gray-600" id="datetime"></div>

                    <!-- Globe Icon -->
                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-globe text-base md:text-lg"></i>
                    </button>

                    <!-- View Website -->
                    <a href="{{ route('home') }}" target="_blank"
                        class="hidden md:flex items-center space-x-2 text-gray-600 hover:text-indigo-600 text-sm font-medium transition-colors px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-external-link-alt"></i>
                        <span>Lihat Website</span>
                    </a>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-2 focus:outline-none hover:bg-gray-100 rounded-lg px-2 py-1 transition-colors">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=6366f1&color=fff"
                                alt="avatar" class="w-8 h-8 rounded-full object-cover ring-2 ring-gray-200">
                            <span
                                class="hidden sm:inline text-sm font-medium text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500 transition-transform duration-200"
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95" @click.away="open = false"
                            class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-xl py-2 z-50">

                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Admin' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5 truncate">
                                    {{ auth()->user()->email ?? 'admin@ngabride.com' }}</p>
                            </div>

                            <!-- Profile Button -->
                            <button type="button" onclick="showProfile()"
                                class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors flex items-center gap-3">
                                <i class="fas fa-user w-4"></i>
                                <span>Profil Saya</span>
                            </button>

                            <div class="border-t border-gray-100 my-1"></div>

                            <!-- Logout Button -->
                            <button type="button" onclick="confirmLogout()"
                                class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center gap-3">
                                <i class="fas fa-sign-out-alt w-4"></i>
                                <span>Keluar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Breadcrumb/Subtitle -->
        <div class="bg-white px-4 md:px-6 py-3 border-b border-gray-200 mt-16">
            <p class="text-gray-600 text-xs md:text-sm">@yield('page-subtitle', 'Selamat datang kembali!')</p>
        </div>

        <!-- Main Content Area -->
        <main class="bg-gray-50 p-4 md:p-6 min-h-[calc(100vh-8rem)]">
            <!-- Success Message -->
            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm flex items-start">
                    <i class="fas fa-circle-check mr-3 text-xl flex-shrink-0 mt-0.5"></i>
                    <span class="text-sm md:text-base">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div
                    class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm flex items-start">
                    <i class="fas fa-triangle-exclamation mr-3 text-xl flex-shrink-0 mt-0.5"></i>
                    <span class="text-sm md:text-base">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Update DateTime
        function updateDateTime() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            const formatted =
                `${days[now.getDay()]}, ${String(now.getDate()).padStart(2, '0')} ${months[now.getMonth()]} ${now.getFullYear()} | ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}:${String(now.getSeconds()).padStart(2, '0')}`;
            const datetimeEl = document.getElementById('datetime');
            if (datetimeEl) datetimeEl.innerText = formatted;
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

    <script>
        // SweetAlert for session messages
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: @json(session('success')),
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: @json(session('error')),
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        @endif
    </script>

    <script>
        // Logout Confirmation
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: 'Sesi kamu akan berakhir.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6366f1',
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Show Profile Modal
        function showProfile() {
            Swal.fire({
                title: 'Profil Saya',
                html: `
                    <div class="flex flex-col items-center space-y-6 py-4">
                        <!-- Avatar -->
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=6366f1&color=fff&size=150"
                                alt="avatar" class="w-32 h-32 rounded-full shadow-2xl border-4 border-indigo-100">
                            <div class="absolute bottom-0 right-0 bg-green-500 w-6 h-6 rounded-full border-4 border-white"></div>
                        </div>
                        
                        <!-- Info Card -->
                        <div class="w-full bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl p-6 space-y-4">
                            <div class="flex items-center gap-3 pb-3 border-b border-indigo-200">
                                <i class="fas fa-user text-indigo-600 text-lg"></i>
                                <div class="text-left flex-1">
                                    <p class="text-xs text-gray-500 font-medium">Nama Lengkap</p>
                                    <p class="font-bold text-gray-800 text-base">{{ auth()->user()->name ?? 'Admin' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3 pb-3 border-b border-indigo-200">
                                <i class="fas fa-envelope text-indigo-600 text-lg"></i>
                                <div class="text-left flex-1">
                                    <p class="text-xs text-gray-500 font-medium">Email</p>
                                    <p class="font-bold text-gray-800 text-base">{{ auth()->user()->email ?? 'admin@ngabride.com' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <i class="fas fa-id-badge text-indigo-600 text-lg"></i>
                                <div class="text-left flex-1">
                                    <p class="text-xs text-gray-500 font-medium">Role</p>
                                    <p class="font-bold text-gray-800 text-base">Administrator</p>
                                </div>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="flex items-center gap-2 bg-green-50 px-4 py-2 rounded-full">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-semibold text-green-700">Status: Aktif</span>
                        </div>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: '<i class="fas fa-times mr-2"></i>Tutup',
                confirmButtonColor: '#6366f1',
                width: 500,
                customClass: {
                    popup: 'rounded-3xl shadow-2xl',
                    confirmButton: 'px-6 py-3 rounded-xl font-semibold'
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
