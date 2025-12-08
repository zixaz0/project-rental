@extends('layouts.app')

@section('title', 'Profile Rental - NGABRIDE ONLINE')

@section('content')
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-4">Profile NGABRIDE ONLINE</h1>
            <p class="text-indigo-100 text-lg">Partner terpercaya untuk perjalanan Anda</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- About Section -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-8">
            <div class="flex items-center mb-6">
                <i class="fas fa-building text-indigo-600 text-3xl mr-4"></i>
                <h2 class="text-2xl font-bold text-gray-900">Tentang Kami</h2>
            </div>
            <div class="prose max-w-none text-gray-700 leading-relaxed">
                <p class="mb-4">
                    <strong>NGABRIDE ONLINE</strong> adalah platform rental kendaraan yang telah berpengalaman lebih dari 10 tahun dalam melayani kebutuhan transportasi masyarakat Indonesia. Kami berkomitmen untuk memberikan layanan terbaik dengan armada kendaraan yang terawat dan harga yang kompetitif.
                </p>
                <p class="mb-4">
                    Dengan motto <strong>"#amanbarengNGABRIDE"</strong>, kami selalu mengutamakan keamanan dan kenyamanan pelanggan dalam setiap perjalanan. Semua kendaraan kami dilengkapi dengan asuransi dan dilakukan perawatan berkala untuk memastikan kondisi optimal.
                </p>
                <p>
                    Kami melayani berbagai kebutuhan, mulai dari perjalanan bisnis, liburan keluarga, hingga keperluan event dan acara khusus. Tim profesional kami siap membantu Anda 24/7 untuk memastikan pengalaman rental yang memuaskan.
                </p>
            </div>
        </div>

        <!-- Vision & Mission -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Vision -->
            <div class="bg-indigo-50 rounded-xl p-8 border border-indigo-200">
                <div class="flex items-center mb-4">
                    <i class="fas fa-eye text-indigo-600 text-2xl mr-3"></i>
                    <h3 class="text-xl font-bold text-gray-900">Visi Kami</h3>
                </div>
                <p class="text-gray-700 leading-relaxed">
                    Menjadi platform rental kendaraan terdepan di Indonesia yang memberikan layanan berkualitas tinggi, terpercaya, dan terjangkau bagi seluruh masyarakat Indonesia.
                </p>
            </div>

            <!-- Mission -->
            <div class="bg-indigo-50 rounded-xl p-8 border border-indigo-200">
                <div class="flex items-center mb-4">
                    <i class="fas fa-bullseye text-indigo-600 text-2xl mr-3"></i>
                    <h3 class="text-xl font-bold text-gray-900">Misi Kami</h3>
                </div>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start">
                        <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                        <span>Memberikan layanan rental kendaraan berkualitas</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                        <span>Mengutamakan kepuasan dan keamanan pelanggan</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-indigo-600 mr-2 mt-1"></i>
                        <span>Menyediakan armada terawat dan modern</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Our Values -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-star text-indigo-600 text-2xl mr-3"></i>
                Nilai-Nilai Kami
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Keamanan</h3>
                    <p class="text-gray-600 text-sm">Semua kendaraan diasuransikan dan terawat dengan baik</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Kepercayaan</h3>
                    <p class="text-gray-600 text-sm">Transparansi harga dan layanan yang jujur</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Pelayanan</h3>
                    <p class="text-gray-600 text-sm">Tim support siap membantu Anda 24/7</p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-xl p-8 text-white mb-8">
            <h2 class="text-2xl font-bold mb-8 text-center">NGABRIDE dalam Angka</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">10+</div>
                    <div class="text-indigo-200 text-sm">Tahun Pengalaman</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">500+</div>
                    <div class="text-indigo-200 text-sm">Kendaraan</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">50K+</div>
                    <div class="text-indigo-200 text-sm">Pelanggan Puas</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">15+</div>
                    <div class="text-indigo-200 text-sm">Kota di Indonesia</div>
                </div>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-trophy text-indigo-600 text-2xl mr-3"></i>
                Mengapa Memilih NGABRIDE?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-certificate text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Bersertifikat & Legal</h3>
                        <p class="text-gray-600 text-sm">Terdaftar resmi dan memiliki izin operasional lengkap</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-tools text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Perawatan Berkala</h3>
                        <p class="text-gray-600 text-sm">Semua kendaraan dirawat secara rutin oleh teknisi profesional</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-wallet text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Harga Kompetitif</h3>
                        <p class="text-gray-600 text-sm">Tarif terjangkau dengan berbagai pilihan paket menarik</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clock text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Proses Cepat</h3>
                        <p class="text-gray-600 text-sm">Booking online mudah dan proses persetujuan cepat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials -->
        <div class="bg-gray-50 rounded-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Apa Kata Pelanggan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=4f46e5&color=fff" class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <h4 class="font-bold">Budi Santoso</h4>
                            <div class="text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm italic">"Pelayanan sangat memuaskan! Mobil bersih dan terawat. Pasti akan rental lagi di NGABRIDE."</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Siti+Nurhaliza&background=4f46e5&color=fff" class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <h4 class="font-bold">Siti Nurhaliza</h4>
                            <div class="text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm italic">"Harga terjangkau dengan kualitas premium. Recommended banget untuk liburan keluarga!"</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Andi+Wijaya&background=4f46e5&color=fff" class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <h4 class="font-bold">Andi Wijaya</h4>
                            <div class="text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm italic">"Proses booking mudah dan cepat. Customer service sangat responsif. Top deh!"</p>
                </div>
            </div>
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