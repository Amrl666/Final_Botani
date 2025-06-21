@extends('layouts.frontend')
@section('title', 'Riwayat Pemesanan Eduwisata')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 animate-slide-down">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Riwayat Pemesanan Eduwisata</h1>
            <p class="text-gray-600 text-lg mb-4">Lihat semua pemesanan eduwisata Anda</p>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-slide-up">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold">Daftar Pemesanan Eduwisata</h2>
                            <p class="text-green-100 mt-1">Total {{ $orders->count() }} pemesanan</p>
                        </div>
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                            <i class="fas fa-map-marked-alt text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b-2 border-gray-100">
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar-alt mr-2 text-green-500"></i>
                                                Tanggal Pesan
                                            </div>
                                        </th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                            <div class="flex items-center">
                                                <i class="fas fa-map-marked-alt mr-2 text-green-500"></i>
                                                Program
                                            </div>
                                        </th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar-day mr-2 text-green-500"></i>
                                                Tanggal Kunjungan
                                            </div>
                                        </th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                            <div class="flex items-center">
                                                <i class="fas fa-users mr-2 text-green-500"></i>
                                                Jumlah Orang
                                            </div>
                                        </th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                            <div class="flex items-center">
                                                <i class="fas fa-money-bill-wave mr-2 text-green-500"></i>
                                                Total
                                            </div>
                                        </th>
                                        <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                            <div class="flex items-center">
                                                <i class="fas fa-info-circle mr-2 text-green-500"></i>
                                                Status
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $index => $order)
                                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors duration-300 animate-slide-up" 
                                            style="--delay: {{ $index * 0.1 }}s">
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-calendar text-green-600"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                                                        <div class="text-sm text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-map-marked-alt text-blue-600"></i>
                                                    </div>
                                                    <span class="font-medium text-gray-900">{{ $order->eduwisata->name ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-calendar-day text-purple-600"></i>
                                                    </div>
                                                    <div>
                                                        @if($order->tanggal_kunjungan)
                                                            <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($order->tanggal_kunjungan)->format('d M Y') }}</div>
                                                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($order->tanggal_kunjungan)->format('l') }}</div>
                                                        @else
                                                            <span class="text-gray-500">-</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-users text-orange-600"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-gray-900">{{ $order->jumlah_orang ?? '-' }}</span>
                                                        <div class="text-sm text-gray-500">orang</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-money-bill-wave text-yellow-600"></i>
                                                    </div>
                                                    <span class="font-bold text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($order->status == 'confirmed') bg-blue-100 text-blue-800
                                                    @elseif($order->status == 'completed') bg-green-100 text-green-800
                                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    <i class="fas fa-circle mr-2 text-xs"></i>
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-map-marked-alt text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada pemesanan</h3>
                            <p class="text-gray-500 mb-6">Anda belum memiliki riwayat pemesanan eduwisata</p>
                            <a href="{{ route('eduwisata') }}" 
                               class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-map-marked-alt mr-2"></i>
                                Jelajahi Eduwisata
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.animate-fade-in {
    animation: fadeIn 1s ease-out forwards;
}

.animate-slide-down {
    animation: slideDown 1s ease-out forwards;
}

.animate-slide-up {
    opacity: 0;
    animation: slideUp 0.6s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

/* Table hover effects */
tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Status badge animations */
.badge {
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

/* Responsive design */
@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .text-4xl {
        font-size: 2rem;
    }
    
    .p-8 {
        padding: 1.5rem;
    }
    
    .px-6 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    
    .py-4 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    
    .w-10 {
        width: 2rem;
    }
    
    .h-10 {
        height: 2rem;
    }
    
    .text-xl {
        font-size: 1.125rem;
    }
    
    /* Hide some columns on mobile for better readability */
    .table-responsive th:nth-child(3),
    .table-responsive td:nth-child(3) {
        display: none;
    }
}
</style>
@endsection
