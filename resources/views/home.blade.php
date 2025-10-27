@extends('layouts.app')

@section('title', 'Rental Mobil #amanbarengNGABRIDE')

@section('content')
    <!-- Hero Section with Booking Form -->
    <div class="relative bg-gradient-to-br from-indigo-400 to-indigo-600 min-h-[500px]">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=1200" alt="Car Rental"
                class="w-full h-full object-cover opacity-20">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <!-- Left Side - Heading -->
                <div class="text-white lg:w-1/2">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 leading-tight">
                        Kemanapun tujuannya,<br>rental mobil<br>#amanbarengNGABRIDE
                    </h1>
                </div>

                <!-- Right Side - Booking Form -->
                <div class="w-full lg:w-auto lg:min-w-[420px]">
                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                        <!-- Booking Form -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center justify-center relative">
                                <i class="fas fa-key text-indigo-600 mr-2"></i>
                                Lepas Kunci
                                <span
                                    class="absolute bottom-[-8px] left-1/2 transform -translate-x-1/2 w-20 h-0.5 bg-indigo-600 rounded-full"></span>
                            </h3>

                            <form class="space-y-4">
                                <!-- Date and Time -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Tanggal
                                        </label>
                                        <input type="date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm cursor-pointer">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Jam
                                        </label>
                                        <input type="time" value="00:00"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm cursor-pointer">
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Durasi
                                    </label>
                                    <select
                                        class="cursor-pointer w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm cursor-pointer">
                                        <option>1 Hari</option>
                                        <option>2 Hari</option>
                                        <option>3 Hari</option>
                                        <option>1 Minggu</option>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="cursor-pointer w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-lg text-sm">
                                    Cari mobil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-10 text-gray-900">
                Keuntungan rental mobil di <span class="text-indigo-600">NGABRIDE</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-shield-alt text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2 text-gray-900">Dibukukan asuransi</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Perjalanan Anda dijamin lebih aman! NGABRIDE yang sudah dicover asuransi untuk keamanan Anda.
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-tie text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2 text-gray-900">Opsi profesional</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Mobil rental tersedia untuk opsi tanpa atau dengan supir profesional dari NGABRIDE.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-star text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2 text-gray-900">Kualitas tata standar</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Nikmati berbagai promo rental di NGABRIDE, atau dapatkan penawaran terbaik untuk rental Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicle Categories Section -->
    <div class="py-12 sm:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-10 text-gray-900">
                Pilihan Kendaraan Kami
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Category 1 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer border border-gray-200">
                    <div class="relative h-48">
                        <img src="{{ asset('images/Sedan.png') }}"alt="Sedan" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/70 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <h3 class="text-white font-bold text-lg">Sedan</h3>
                            <p class="text-white/90 text-sm">Mulai dari Rp 350K</p>
                        </div>
                    </div>
                </div>

                <!-- Category 2 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer border border-gray-200">
                    <div class="relative h-48">
                        <img src="{{ asset('images/SUV.png') }}" alt="SUV" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/70 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <h3 class="text-white font-bold text-lg">SUV</h3>
                            <p class="text-white/90 text-sm">Mulai dari Rp 500K</p>
                        </div>
                    </div>
                </div>

                <!-- Category 3 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer border border-gray-200">
                    <div class="relative h-48">
                        <img src="{{ asset('images/MPV.png') }}" alt="MPV" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/70 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <h3 class="text-white font-bold text-lg">MPV</h3>
                            <p class="text-white/90 text-sm">Mulai dari Rp 400K</p>
                        </div>
                    </div>
                </div>

                <!-- Category 4 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 cursor-pointer border border-gray-200">
                    <div class="relative h-48">
                        <img src="{{ asset('images/Luxury.png') }}" alt="Luxury" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/70 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <h3 class="text-white font-bold text-lg">Luxury</h3>
                            <p class="text-white/90 text-sm">Mulai dari Rp 800K</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-12 pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Column 1 -->
                <div>
                    <a href="/" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.png') }}" alt="NGABRIDE ONLINE Logo"
                            class="h-12 sm:h-20 md:h-20 w-auto">
                    </a>
                    <p class="text-gray-400 text-sm mb-4">
                        Platform rental kendaraan terpercaya untuk perjalanan Anda
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-400 hover:text-indigo-400 transition">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-indigo-400 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-indigo-400 transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-indigo-400 transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2 - Empty for spacing -->
                <div></div>

                <!-- Column 3 -->
                <div>
                    <h4 class="font-semibold mb-4 text-sm">BLOG</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-indigo-400 transition">Panduan</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Tips & Trik</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Promo</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">GAIKINDO Auto360</a></li>
                    </ul>
                </div>

                <!-- Column 4 -->
                <div>
                    <h4 class="font-semibold mb-4 text-sm">BANTUAN</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-indigo-400 transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-800 pt-6 mt-6">
                <div class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-400">
                    <p>&copy; 2024 NGABRIDE ONLINE. Logo dan Slogan dilindungi.</p>
                    <p class="mt-2 sm:mt-0">Made with <i class="fas fa-heart text-red-500"></i> in Indonesia</p>
                </div>
            </div>
        </div>
    </footer>
@endsection
