<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NGABRIDE ONLINE')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-8">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.png') }}" alt="NGABRIDE ONLINE Logo" class="h-12 sm:h-16 md:h-20 w-auto">
                    </a>
                </div>

                <!-- Desktop Right Side -->
                <div class="hidden md:flex items-center space-x-3">
                    @guest
                        <a href="/login"
                            class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 text-sm font-medium transition">
                            Masuk
                        </a>
                        <a href="/register"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium transition">
                            Daftar
                        </a>
                    @endguest

                    @auth
                        <button class="text-gray-700 hover:text-indigo-600 p-2">
                            <i class="fas fa-globe"></i>
                        </button>
                        <button class="text-gray-700 hover:text-indigo-600 p-2">
                            <i class="far fa-bell"></i>
                        </button>
                        
                        <!-- Alpine.js Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=4f46e5&color=fff"
                                    class="w-8 h-8 rounded-full">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <!-- Dropdown -->
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95" 
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100" 
                                x-transition:leave-end="opacity-0 scale-95"
                                @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg py-2 z-50">
                                
                                <!-- Menu Kembali ke Dashboard (Khusus Admin) -->
                                @if(auth()->user()->role === 'admin')
                                    <a href="/admin/dashboard" class="block px-4 py-2 text-sm text-indigo-600 hover:bg-indigo-50 font-medium">
                                        <i class="fas fa-home mr-2"></i> Kembali ke Dashboard
                                    </a>
                                    <hr class="my-2">
                                @endif
                                
                                <button type="button" onclick="showProfile()"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">
                                    <i class="fas fa-user mr-2"></i> Profil
                                </button>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-car mr-2"></i> Pesanan Saya
                                </a>
                                <hr class="my-2">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="button" onclick="confirmLogout()"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 cursor-pointer">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Mobile Right Side -->
                <div class="flex md:hidden items-center space-x-2">
                    @guest
                        <a href="/login"
                            class="border border-gray-300 text-gray-700 px-3 py-1.5 rounded-lg hover:bg-gray-50 text-xs font-medium transition">
                            Masuk
                        </a>
                        <a href="/register"
                            class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 text-xs font-medium transition">
                            Daftar
                        </a>
                    @endguest

                    @auth
                        <button class="text-gray-700 hover:text-indigo-600 p-2">
                            <i class="far fa-bell"></i>
                        </button>
                        <button id="mobile-menu-btn" class="flex items-center space-x-1 px-2 py-1 rounded-lg hover:bg-gray-50">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=4f46e5&color=fff"
                                class="w-8 h-8 rounded-full">
                            <i class="fas fa-chevron-down text-xs text-gray-700"></i>
                        </button>
                    @endauth
                </div>
            </div>

            <!-- Mobile Menu (Only for authenticated users) -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 border-t">
                <div class="flex flex-col space-y-2 pt-4">
                    @auth
                        <!-- Menu Kembali ke Dashboard (Khusus Admin di Mobile) -->
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin/dashboard" class="text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-gauge mr-2"></i> Kembali ke Dashboard
                            </a>
                            <hr class="my-2">
                        @endif
                        
                        <a href="/profile" class="text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <a href="#" class="text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm">
                            <i class="fas fa-car mr-2"></i> Pesanan Saya
                        </a>
                        <hr class="my-2">
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="button" class="w-full text-left text-red-600 hover:bg-red-50 px-4 py-2 rounded-lg text-sm" onclick="confirmLogout()">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Scripts -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Profile Navigation
        function showProfile() {
            window.location.href = '/profile';
        }

        // Logout Confirmation
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: 'Sesi kamu akan berakhir.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form yang ada (bisa dari desktop atau mobile)
                    const form = document.getElementById('logout-form') || document.getElementById('logout-form-mobile');
                    if (form) form.submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>