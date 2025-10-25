@extends('layouts.app')

@section('title', 'Register - NGABRIDE ONLINE')

@section('content')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Navbar -->
<nav class="bg-white/90 backdrop-blur-lg shadow-lg sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="NGABRIDE ONLINE Logo" class="h-24 w-auto transition-all duration-300 group-hover:scale-110 drop-shadow-lg">
                </a>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 transition-all duration-300 font-semibold group">
                    <i class="fas fa-home text-lg group-hover:scale-110 transition-transform"></i>
                    <span>Home</span>
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Background dengan Gradient & Patterns -->
<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 flex items-center justify-center py-16 px-4 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-gradient-to-br from-pink-400 to-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    
    <div class="max-w-2xl w-full space-y-8 relative z-10">
        <!-- Card Container -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-10 border border-white/50 transform hover:scale-[1.01] transition-all duration-300">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-20 w-20 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-3xl flex items-center justify-center mb-6 shadow-2xl transform hover:rotate-6 transition-all duration-300">
                    <i class="fas fa-user-plus text-3xl text-white"></i>
                </div>
                <h2 class="text-4xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-3">
                    Buat Akun Baru
                </h2>
                <p class="text-gray-600 text-lg">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-purple-600 transition-colors duration-300 underline decoration-2 underline-offset-4">
                        Masuk sekarang
                    </a>
                </p>
            </div>

            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                
                <!-- Nama Lengkap -->
                <div class="transform hover:scale-[1.02] transition-all duration-200">
                    <label for="name" class="block text-sm font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-user text-indigo-500 mr-2"></i>
                        Nama Lengkap
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user text-indigo-400 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                        <input 
                            id="name"
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}"
                            required 
                            class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300 @error('name') border-red-400 @enderror bg-white/70 backdrop-blur-sm font-medium hover:border-indigo-300" 
                            placeholder="Masukkan nama lengkap Anda">
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center animate-pulse">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="transform hover:scale-[1.02] transition-all duration-200">
                    <label for="email" class="block text-sm font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>
                        Email Address
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-indigo-400 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                        <input 
                            id="email"
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300 @error('email') border-red-400 @enderror bg-white/70 backdrop-blur-sm font-medium hover:border-indigo-300" 
                            placeholder="nama@example.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center animate-pulse">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Grid untuk Phone & Address -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- No. Telepon -->
                    <div class="transform hover:scale-[1.02] transition-all duration-200">
                        <label for="phone" class="block text-sm font-bold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-phone text-indigo-500 mr-2"></i>
                            No. Telepon 
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-indigo-400 group-focus-within:text-indigo-600 transition-colors"></i>
                            </div>
                            <input 
                                id="phone"
                                type="text" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300 @error('phone') border-red-400 @enderror bg-white/70 backdrop-blur-sm font-medium hover:border-indigo-300" 
                                placeholder="08123456789">
                        </div>
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600 flex items-center animate-pulse">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="transform hover:scale-[1.02] transition-all duration-200">
                        <label for="address" class="block text-sm font-bold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>
                            Alamat 
                        </label>
                        <div class="relative group">
                            <div class="absolute top-4 left-0 pl-4 pointer-events-none">
                                <i class="fas fa-map-marker-alt text-indigo-400 group-focus-within:text-indigo-600 transition-colors"></i>
                            </div>
                            <input 
                                id="address"
                                type="text" 
                                name="address" 
                                value="{{ old('address') }}"
                                class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300 @error('address') border-red-400 @enderror bg-white/70 backdrop-blur-sm font-medium hover:border-indigo-300" 
                                placeholder="Alamat lengkap">
                        </div>
                        @error('address')
                            <p class="mt-2 text-sm text-red-600 flex items-center animate-pulse">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="transform hover:scale-[1.02] transition-all duration-200">
                    <label for="password" class="block text-sm font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-lock text-indigo-500 mr-2"></i>
                        Password
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-indigo-400 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                        <input 
                            id="password"
                            type="password" 
                            name="password" 
                            required 
                            class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300 @error('password') border-red-400 @enderror bg-white/70 backdrop-blur-sm font-medium hover:border-indigo-300" 
                            placeholder="Minimal 8 karakter">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center animate-pulse">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="transform hover:scale-[1.02] transition-all duration-200">
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-check-circle text-indigo-500 mr-2"></i>
                        Konfirmasi Password
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-check-circle text-indigo-400 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                        <input 
                            id="password_confirmation"
                            type="password" 
                            name="password_confirmation" 
                            required 
                            class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300 bg-white/70 backdrop-blur-sm font-medium hover:border-indigo-300" 
                            placeholder="Ketik ulang password">
                    </div>
                </div>

                <!-- Alert Messages -->
                @if (session('error'))
                    <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-800 px-5 py-4 rounded-2xl flex items-start shadow-lg animate-shake">
                        <i class="fas fa-times-circle text-xl mr-3 mt-0.5"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-800 px-5 py-4 rounded-2xl flex items-start shadow-lg animate-bounce">
                        <i class="fas fa-check-circle text-xl mr-3 mt-0.5"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Submit Button -->
                <button type="submit" class="group relative w-full py-4 px-6 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-bold rounded-2xl transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-purple-500/50 overflow-hidden">
                    <span class="relative flex items-center justify-center text-lg">
                        <i class="fas fa-user-plus mr-3 text-xl"></i>
                        Daftar Sekarang
                        <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform text-xl"></i>
                    </span>
                    <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></div>
                </button>

                <!-- Back to Home Link -->
                <div class="text-center pt-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition-all duration-300 font-semibold group text-base">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-2 transition-transform"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer Text -->
        <p class="text-center text-sm text-gray-700 bg-white/60 backdrop-blur-sm rounded-2xl py-4 px-6 shadow-lg">
            Dengan mendaftar, Anda menyetujui 
            <a href="#" class="text-indigo-600 hover:text-purple-600 font-bold underline decoration-2 underline-offset-2 transition-colors">Syarat & Ketentuan</a> 
            dan 
            <a href="#" class="text-indigo-600 hover:text-purple-600 font-bold underline decoration-2 underline-offset-2 transition-colors">Kebijakan Privasi</a>
        </p>
    </div>
</div>

<style>
    @keyframes blob {
        0%, 100% {
            transform: translate(0px, 0px) scale(1);
        }
        33% {
            transform: translate(40px, -60px) scale(1.15);
        }
        66% {
            transform: translate(-30px, 30px) scale(0.95);
        }
    }
    
    .animate-blob {
        animation: blob 8s infinite ease-in-out;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }
</style>
@endsection