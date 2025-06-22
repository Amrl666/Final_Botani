@extends('layouts.frontend')
@section('title', 'Riwayat Pemesanan Produk')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 animate-slide-down">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Riwayat Pemesanan Produk</h1>
            <p class="text-gray-600 text-lg mb-4">Lihat semua pemesanan produk Anda</p>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-slide-up">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold">Daftar Pemesanan</h2>
                            <p class="text-green-100 mt-1">Total {{ $orders->count() }} pemesanan</p>
                        </div>
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    @if($orders->count() > 0)
                        <div class="space-y-6">
                            @foreach($orders as $index => $order)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-all duration-300 animate-slide-up" 
                                     style="--delay: {{ $index * 0.1 }}s">
                                    
                                    <!-- Order Header -->
                                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-shopping-cart text-green-600"></i>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">
                                                    Order #{{ $order->id }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $order->created_at->format('d M Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            <div class="font-bold text-green-600 text-lg">
                                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                            </div>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                @if($order->status == 'menunggu') bg-yellow-100 text-yellow-800
                                                @elseif($order->status == 'disetujui') bg-blue-100 text-blue-800
                                                @elseif($order->status == 'selesai') bg-green-100 text-green-800
                                                @elseif($order->status == 'ditolak') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                <i class="fas fa-circle mr-2 text-xs"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Order Items -->
                                    @if($order->orderItems->count() > 0)
                                        <div class="space-y-3">
                                            <h4 class="font-semibold text-gray-800 mb-3">Produk yang Dipesan:</h4>
                                            @foreach($order->orderItems as $item)
                                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                            <i class="fas fa-box text-blue-600"></i>
                                                        </div>
                                                        <div>
                                                            <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                                                            <div class="text-sm text-gray-500">{{ $item->quantity }} kg x Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="font-semibold text-green-600">
                                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <!-- Legacy single product display -->
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-box text-blue-600"></i>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $order->produk->name ?? 'Produk' }}</div>
                                                    <div class="text-sm text-gray-500">{{ $order->jumlah ?? 0 }} kg</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Order Details -->
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-500">Alamat:</span>
                                                <span class="text-gray-900">{{ $order->alamat ?? '-' }}</span>
                                            </div>
                                            @if($order->keterangan)
                                                <div>
                                                    <span class="text-gray-500">Keterangan:</span>
                                                    <span class="text-gray-900">{{ $order->keterangan }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-shopping-bag text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada pemesanan</h3>
                            <p class="text-gray-500 mb-6">Anda belum memiliki riwayat pemesanan produk</p>
                            <a href="{{ route('product.index_fr') }}" 
                               class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Mulai Belanja
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

/* Card hover effects */
.border:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
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
}
</style>
@endsection