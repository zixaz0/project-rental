@extends('layouts.auth')
@section('title', 'Register - NGABRIDE ONLINE')
@section('content')
<!-- Background dengan Gradient yang Sama seperti Home -->
<div class="relative bg-gradient-to-br from-indigo-400 to-indigo-600 min-h-screen flex items-center justify-center py-16 px-4">
    <!-- Background Image dengan Overlay (sama seperti home) -->
    <div class="absolute inset-0 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=1200" alt="Car Rental"
            class="w-full h-full object-cover opacity-20">
    </div>
    
    <div class="relative max-w-2xl w-full space-y-6 z-10">
        <!-- Card Container -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="p-8 sm:p-10">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="mx-auto h-16 w-16 bg-indigo-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                        <i class="fas fa-user-plus text-2xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">
                        Buat Akun Baru
                    </h2>
                    <p class="text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                            Masuk sekarang
                        </a>
                    </p>
                </div>

                <form class="space-y-5" action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input 
                                id="name"
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}"
                                required 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('name') border-red-400 @enderror" 
                                placeholder="Masukkan nama lengkap Anda">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input 
                                id="email"
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('email') border-red-400 @enderror" 
                                placeholder="nama@example.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Grid untuk Phone & Address -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- No. Telepon -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                No. Telepon
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input 
                                    id="phone"
                                    type="text" 
                                    name="phone" 
                                    value="{{ old('phone') }}"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('phone') border-red-400 @enderror" 
                                    placeholder="08123456789">
                            </div>
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <input 
                                    id="address"
                                    type="text" 
                                    name="address" 
                                    value="{{ old('address') }}"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('address') border-red-400 @enderror" 
                                    placeholder="Alamat lengkap">
                            </div>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input 
                                id="password"
                                type="password" 
                                name="password" 
                                required 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('password') border-red-400 @enderror" 
                                placeholder="Minimal 8 karakter">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-check-circle text-gray-400"></i>
                            </div>
                            <input 
                                id="password_confirmation"
                                type="password" 
                                name="password_confirmation" 
                                required 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" 
                                placeholder="Ketik ulang password">
                        </div>
                    </div>

                    <!-- Alert Messages -->
                    @if (session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-start">
                            <i class="fas fa-times-circle text-lg mr-2 mt-0.5"></i>
                            <span class="text-sm">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-start">
                            <i class="fas fa-check-circle text-lg mr-2 mt-0.5"></i>
                            <span class="text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-lg">
                        Daftar Sekarang
                    </button>

                    <!-- Back to Home Link -->
                    <div class="text-center pt-2">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Text -->
        <p class="text-center text-sm text-white/90">
            Dengan mendaftar, Anda menyetujui 
            <a href="#" class="font-semibold hover:underline">Syarat & Ketentuan</a> 
            dan 
            <a href="#" class="font-semibold hover:underline">Kebijakan Privasi</a>
        </p>
    </div>
</div>
@endsection