@extends('layouts.owner')
@section('title', 'Owner Dashboard - NGABRIDE ONLINE')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, Owner!')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- TOTAL KENDARAAN -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">Total Kendaraan</p>
                <p class="text-3xl font-bold text-gray-800">12</p>
                <p class="text-blue-600 text-sm mt-2">Semua kendaraan</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <!-- SEDANG DISEWA -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">Sedang Disewa</p>
                <p class="text-3xl font-bold text-gray-800">5</p>
                <p class="text-blue-600 text-sm mt-2">2 mobil, 3 motor</p>
            </div>
            <div class="bg-green-100 p-4 rounded-full">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <!-- PELANGGAN AKTIF -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">Pelanggan Aktif</p>
                <p class="text-3xl font-bold text-gray-800">40</p>
                <p class="text-green-600 text-sm mt-2">Total customer</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-full">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <!-- PENDAPATAN -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">Pendapatan Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-800">Rp 8.500.000</p>
                <p class="text-green-600 text-sm mt-2">↑ 15% dari bulan lalu</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-full">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

</div>

<!-- Recent Orders & Vehicle Status -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <!-- PESANAN TERBARU -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h3>
                <span class="text-blue-600 text-sm font-medium">Lihat Semua</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kendaraan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">

                    @foreach ([1,2,3] as $d)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">#ORD-00{{ $d }}</td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            @if($d == 1) Rizky 
                            @elseif($d == 2) Dewi 
                            @else Andi 
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            @if($d == 1) Honda Brio 2022
                            @elseif($d == 2) Yamaha NMax
                            @else Toyota Avanza
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ now()->subDays($d)->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4">
                            @if($d == 1)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktif</span>
                            @elseif($d == 2)
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Selesai</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <span class="text-blue-600 hover:text-blue-800 cursor-pointer">Detail</span>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- STATUS KENDARAAN -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-bold text-gray-800">Status Kendaraan</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Tersedia</span>
                        <span class="text-sm font-bold text-green-600">7 (58%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 58%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Disewa</span>
                        <span class="text-sm font-bold text-blue-600">4 (33%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 33%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Maintenance</span>
                        <span class="text-sm font-bold text-yellow-600">1 (9%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-600 h-2 rounded-full" style="width: 9%"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- REVENUE CHART -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Grafik Pendapatan</h3>
            <select class="px-4 py-2 border rounded-lg text-sm focus:outline-none">
                <option>7 Hari Terakhir</option>
                <option>30 Hari Terakhir</option>
                <option>3 Bulan Terakhir</option>
            </select>
        </div>
    </div>
    <div class="p-6">

        <div class="h-64 flex items-end justify-between space-x-2">

            @foreach([
                ['date' => 'Mon', 'revenue' => 1200000, 'height' => 40],
                ['date' => 'Tue', 'revenue' => 900000, 'height' => 30],
                ['date' => 'Wed', 'revenue' => 1500000, 'height' => 60],
                ['date' => 'Thu', 'revenue' => 800000, 'height' => 25],
                ['date' => 'Fri', 'revenue' => 1100000, 'height' => 45],
                ['date' => 'Sat', 'revenue' => 2000000, 'height' => 80],
                ['date' => 'Sun', 'revenue' => 2500000, 'height' => 100],
            ] as $data)

            <div class="flex-1 bg-blue-600 rounded-t hover:bg-blue-700 transition cursor-pointer relative group" 
                style="height: {{ $data['height'] }}%"
                title="Rp {{ number_format($data['revenue']) }}">
                
                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 
                    bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 
                    group-hover:opacity-100 transition whitespace-nowrap">
                    Rp {{ number_format($data['revenue']) }}
                </div>
            </div>
            @endforeach

        </div>

        <div class="flex justify-between mt-4 text-xs text-gray-600">
            @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d)
                <span>{{ $d }}</span>
            @endforeach
        </div>

    </div>
</div>

@endsection