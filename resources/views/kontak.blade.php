@extends('layouts.app')

@section('title', 'Kontak Kami - NGABRIDE ONLINE')

@section('content')
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-4">Hubungi Kami</h1>
            <p class="text-indigo-100 text-lg">Kami siap membantu Anda 24/7</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>
                    
                    <!-- Success Alert (Hidden by default) -->
                    <div id="successAlert" class="hidden mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.</span>
                        </div>
                    </div>

                    <form id="contactForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="John Doe">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="john@example.com">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    No. Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="08123456789">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Subjek <span class="text-red-500">*</span>
                                </label>
                                <select name="subject" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">Pilih Subjek</option>
                                    <option value="rental">Pertanyaan Rental</option>
                                    <option value="booking">Status Booking</option>
                                    <option value="payment">Pembayaran</option>
                                    <option value="complaint">Keluhan</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pesan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="message" rows="6" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="space-y-6">
                <!-- Office Info -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-indigo-600 mr-3"></i>
                        Kantor Kami
                    </h3>
                    <div class="space-y-4 text-gray-700">
                        <div>
                            <p class="font-medium mb-1">Alamat</p>
                            <p class="text-sm">Jl. Raya Cimahi No. 123<br>Cimahi, Jawa Barat 40512<br>Indonesia</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Details -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-phone text-indigo-600 mr-3"></i>
                        Kontak Langsung
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Telepon</p>
                            <a href="tel:+6222123456" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                (022) 123-456
                            </a>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">WhatsApp</p>
                            <a href="https://wa.me/6281234567890" target="_blank" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                +62 812-3456-7890
                            </a>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Email</p>
                            <a href="mailto:info@ngabride.com" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                info@ngabride.com
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="bg-indigo-50 rounded-xl border border-indigo-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-clock text-indigo-600 mr-3"></i>
                        Jam Operasional
                    </h3>
                    <div class="space-y-2 text-gray-700">
                        <div class="flex justify-between">
                            <span class="text-sm">Senin - Jumat</span>
                            <span class="text-sm font-medium">05:00 - 23:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm">Sabtu - Minggu</span>
                            <span class="text-sm font-medium">05:00 - 23:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm">Customer Service</span>
                            <span class="text-sm font-medium text-indigo-600">24/7</span>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-share-nodes text-indigo-600 mr-3"></i>
                        Media Sosial
                    </h3>
                    <div class="flex space-x-3">
                        <a href="#" class="w-12 h-12 bg-indigo-600 text-white rounded-lg flex items-center justify-center hover:bg-indigo-700 transition">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-indigo-600 text-white rounded-lg flex items-center justify-center hover:bg-indigo-700 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-indigo-600 text-white rounded-lg flex items-center justify-center hover:bg-indigo-700 transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-indigo-600 text-white rounded-lg flex items-center justify-center hover:bg-indigo-700 transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="mt-12 bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-location-dot text-indigo-600 mr-3"></i>
                    Lokasi Kantor
                </h2>
            </div>
            <div class="h-96 bg-gray-200">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56211042377!2d107.47709895!3d-6.87232395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e5c90452d4eb%3A0x4027a76e352e4f0!2sCimahi%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1234567890"
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>

        <!-- FAQ Quick Links -->
        <div class="mt-12 bg-indigo-50 border border-indigo-200 rounded-xl p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Butuh Jawaban Cepat?</h2>
                <p class="text-gray-600">Mungkin pertanyaan Anda sudah terjawab di FAQ kami</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="#" class="bg-white p-4 rounded-lg hover:shadow-md transition text-center">
                    <i class="fas fa-question-circle text-indigo-600 text-2xl mb-2"></i>
                    <p class="text-sm font-medium text-gray-900">FAQ Umum</p>
                </a>
                <a href="#" class="bg-white p-4 rounded-lg hover:shadow-md transition text-center">
                    <i class="fas fa-file-contract text-indigo-600 text-2xl mb-2"></i>
                    <p class="text-sm font-medium text-gray-900">Syarat & Ketentuan</p>
                </a>
                <a href="#" class="bg-white p-4 rounded-lg hover:shadow-md transition text-center">
                    <i class="fas fa-shield-halved text-indigo-600 text-2xl mb-2"></i>
                    <p class="text-sm font-medium text-gray-900">Kebijakan Privasi</p>
                </a>
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

@push('scripts')
<script>
    // Contact Form Handler
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show success alert
        const successAlert = document.getElementById('successAlert');
        successAlert.classList.remove('hidden');
        
        // Reset form
        this.reset();
        
        // Scroll to top to show alert
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Hide alert after 5 seconds
        setTimeout(function() {
            successAlert.classList.add('hidden');
        }, 5000);
    });
</script>
@endpush