@extends('layouts.app')

@section('title', 'Harga Rental - NGABRIDE ONLINE')

@section('content')
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-4">Daftar Harga Rental</h1>
            <p class="text-indigo-100 text-lg">Pilih kendaraan sesuai kebutuhan dan budget Anda</p>
        </div>
    </div>

    <!-- Price List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Sedan Category -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-car text-indigo-600 mr-3"></i>
                Sedan
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Honda Civic -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/Sedan.png') }}" alt="Honda Civic" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Honda Civic</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 5 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Manual/Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 350.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>

                <!-- Toyota Camry -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/Sedan.png') }}" alt="Toyota Camry" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Toyota Camry</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 5 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 400.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>

                <!-- Honda Accord -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/Sedan.png') }}" alt="Honda Accord" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Honda Accord</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 5 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 380.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SUV Category -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-truck-pickup text-indigo-600 mr-3"></i>
                SUV
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Toyota Fortuner -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/SUV.png') }}" alt="Toyota Fortuner" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Toyota Fortuner</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 7 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 550.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>

                <!-- Mitsubishi Pajero -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/SUV.png') }}" alt="Mitsubishi Pajero" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Mitsubishi Pajero</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 7 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 600.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>

                <!-- Honda CR-V -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/SUV.png') }}" alt="Honda CR-V" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Honda CR-V</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 7 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 500.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MPV Category -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-van-shuttle text-indigo-600 mr-3"></i>
                MPV
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Toyota Avanza -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/MPV.png') }}" alt="Toyota Avanza" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Toyota Avanza</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 7 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Manual/Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 350.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>

                <!-- Honda Mobilio -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/MPV.png') }}" alt="Honda Mobilio" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Honda Mobilio</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 7 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Manual/Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 320.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>

                <!-- Toyota Innova -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/MPV.png') }}" alt="Toyota Innova" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Toyota Innova</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 7 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Manual/Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 450.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Luxury Category -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-gem text-indigo-600 mr-3"></i>
                Luxury
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Mercedes-Benz E-Class -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/Luxury.png') }}" alt="Mercedes-Benz E-Class" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Mercedes-Benz E-Class</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 5 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 1.200.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>

                <!-- BMW 5 Series -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/Luxury.png') }}" alt="BMW 5 Series" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">BMW 5 Series</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 5 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 1.100.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>

                <!-- Audi A6 -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200">
                    <img src="{{ asset('images/Luxury.png') }}" alt="Audi A6" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Audi A6</h3>
                        <div class="flex items-center text-gray-600 text-sm mb-4">
                            <i class="fas fa-users mr-2"></i> 5 Penumpang
                            <i class="fas fa-gear ml-4 mr-2"></i> Automatic
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-2xl font-bold text-indigo-600">Rp 1.000.000</p>
                            <p class="text-gray-500 text-sm">per hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-indigo-900 mb-3">
                <i class="fas fa-info-circle mr-2"></i>
                Informasi Penting
            </h3>
            <ul class="space-y-2 text-gray-700">
                <li class="flex items-start">
                    <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                    <span>Harga sudah termasuk asuransi dasar</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                    <span>Gratis antar jemput dalam kota (radius 5km)</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                    <span>Opsi dengan driver tersedia (tambahan Rp 150.000/hari)</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                    <span>Diskon hingga 20% untuk rental 7 hari atau lebih</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-12 pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="NGABRIDE ONLINE Logo" class="h-12 sm:h-20 md:h-20 w-auto mb-4">
                    <p class="text-gray-400 text-sm mb-4">Platform rental kendaraan terpercaya untuk perjalanan Anda</p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-400 hover:text-indigo-400 transition"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-indigo-400 transition"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-indigo-400 transition"><i class="fab fa-twitter text-xl"></i></a>
                    </div>
                </div>
                <div></div>
                <div>
                    <h4 class="font-semibold mb-4 text-sm">BLOG</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-indigo-400 transition">Panduan</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Tips & Trik</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Promo</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-sm">BANTUAN</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-indigo-400 transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 mt-6">
                <div class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-400">
                    <p>&copy; 2024 NGABRIDE ONLINE. Logo dan Slogan dilindungi.</p>
                    <p class="mt-2 sm:mt-0">Made with <i class="fas fa-heart text-red-500"></i> in Indonesia</p>
                </div>
            </div>
        </div>
    </footer>
@endsection