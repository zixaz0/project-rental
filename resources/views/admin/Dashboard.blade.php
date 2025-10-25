@extends('layouts.admin')

@section('title', 'Admin Dashboard - NGABRIDE ONLINE')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, Admin!')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">Total Kendaraan</p>
                <p class="text-3xl font-bold text-gray-800">48</p>
                <p class="text-green-600 text-sm mt-2">↑ 12% dari bulan lalu</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">Sedang Disewa</p>
                <p class="text-3xl font-bold text-gray-800">23</p>
                <p class="text-blue-600 text-sm mt-2">12 mobil, 11 motor</p>
            </div>
            <div class="bg-green-100 p-4 rounded-full">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">Pelanggan Aktif</p>
                <p class="text-3xl font-bold text-gray-800">156</p>
                <p class="text-green-600 text-sm mt-2">↑ 8% dari bulan lalu</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-full">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm mb-1">Pendapatan Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-800">Rp 45.2jt</p>
                <p class="text-green-600 text-sm mt-2">↑ 23% dari bulan lalu</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-full">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Vehicle Status -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Recent Orders -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h3>
                <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua</a>
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
                    @forelse ([
                        ['id' => '#ORD-001', 'customer' => 'Budi Santoso', 'vehicle' => 'Toyota Avanza', 'date' => '24 Okt 2025', 'status' => 'active'],
                        ['id' => '#ORD-002', 'customer' => 'Siti Aminah', 'vehicle' => 'Honda PCX', 'date' => '23 Okt 2025', 'status' => 'pending'],
                        ['id' => '#ORD-003', 'customer' => 'Ahmad Rizki', 'vehicle' => 'BMW 320i', 'date' => '22 Okt 2025', 'status' => 'active'],
                        ['id' => '#ORD-004', 'customer' => 'Dewi Lestari', 'vehicle' => 'Yamaha Nmax', 'date' => '21 Okt 2025', 'status' => 'completed'],
                        ['id' => '#ORD-005', 'customer' => 'Eko Prasetyo', 'vehicle' => 'Toyota Innova', 'date' => '20 Okt 2025', 'status' => 'active'],
                    ] as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order['id'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order['customer'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order['vehicle'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order['date'] }}</td>
                        <td class="px-6 py-4">
                            @if($order['status'] === 'active')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktif</span>
                            @elseif($order['status'] === 'pending')
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Selesai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <button class="text-blue-600 hover:text-blue-800">Detail</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Vehicle Status -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-bold text-gray-800">Status Kendaraan</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Tersedia</span>
                        <span class="text-sm font-bold text-green-600">25 (52%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 52%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Disewa</span>
                        <span class="text-sm font-bold text-blue-600">23 (48%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 48%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Maintenance</span>
                        <span class="text-sm font-bold text-yellow-600">0 (0%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-600 h-2 rounded-full" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t">
                <h4 class="text-sm font-semibold text-gray-800 mb-3">Quick Actions</h4>
                <div class="space-y-2">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        + Tambah Kendaraan
                    </button>
                    <button class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        📊 Lihat Laporan
                    </button>
                    <button class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                        👥 Kelola Pelanggan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Grafik Pendapatan</h3>
            <select class="px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>7 Hari Terakhir</option>
                <option>30 Hari Terakhir</option>
                <option>3 Bulan Terakhir</option>
            </select>
        </div>
    </div>
    <div class="p-6">
        <div class="h-64 flex items-end justify-between space-x-2">
            @foreach([45, 60, 35, 75, 50, 85, 70] as $height)
            <div class="flex-1 bg-blue-600 rounded-t hover:bg-blue-700 transition cursor-pointer" style="height: {{ $height }}%"></div>
            @endforeach
        </div>
        <div class="flex justify-between mt-4 text-xs text-gray-600">
            <span>Sen</span>
            <span>Sel</span>
            <span>Rab</span>
            <span>Kam</span>
            <span>Jum</span>
            <span>Sab</span>
            <span>Min</span>
        </div>
    </div>
</div>
@endsection