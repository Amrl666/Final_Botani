@extends('layouts.frontend')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-shopping-bag text-green-600 mr-3"></i>
                Riwayat Pesanan
            </h1>
            <p class="text-gray-600 text-lg">Lihat semua pesanan yang telah Anda buat</p>
        </div>

        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-bag text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada pesanan</h3>
                <p class="text-gray-600 mb-6">Mulai berbelanja untuk melihat riwayat pesanan Anda.</p>
                <a href="{{ route('product.index_fr') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Mulai Berbelanja
                </a>
            </div>
        @else
            <!-- Orders List -->
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <!-- Order Header -->
                        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center mb-3 sm:mb-0">
                                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold text-lg">
                                            Pesanan #{{ $order->id }}
                                        </h3>
                                        <p class="text-green-100 text-sm">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @php
                                        $statusColors = [
                                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                                            'disetujui' => 'bg-blue-100 text-blue-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">
                                        <i class="fas fa-circle mr-2 text-xs"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <div class="text-right">
                                        <div class="text-white font-bold text-lg">
                                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Content -->
                        <div class="p-6">
                            <!-- Order Items -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-box text-green-600 mr-2"></i>
                                    Item Pesanan
                                </h4>
                                
                                @if($order->orderItems->isNotEmpty())
                                    <div class="space-y-3">
                                        @foreach($order->orderItems as $item)
                                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="w-16 h-16 object-cover rounded-lg">
                                                @else
                                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-box text-gray-400 text-xl"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-1">
                                                    <h5 class="font-medium text-gray-900">{{ $item->product->name }}</h5>
                                                    <p class="text-sm text-gray-600">{{ $item->quantity }} {{ $item->product->unit }}</p>
                                                    <p class="text-sm text-gray-500">@ Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                                        @if($order->produk)
                                            @if($order->produk->image)
                                                <img src="{{ asset('storage/' . $order->produk->image) }}" 
                                                     alt="{{ $order->produk->name }}" 
                                                     class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-box text-gray-400 text-xl"></i>
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <h5 class="font-medium text-gray-900">{{ $order->produk->name }}</h5>
                                                <p class="text-sm text-gray-600">{{ $order->jumlah }} {{ $order->produk->unit }}</p>
                                                <p class="text-sm text-gray-500">@ Rp {{ number_format($order->produk->price, 0, ',', '.') }}</p>
                                            </div>
                                        @elseif($order->eduwisata)
                                            <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-map-marked-alt text-blue-600 text-xl"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="font-medium text-gray-900">{{ $order->eduwisata->name }}</h5>
                                                <p class="text-sm text-gray-600">{{ $order->jumlah_orang }} orang</p>
                                                @if($order->tanggal_kunjungan)
                                                    <p class="text-sm text-gray-500">{{ $order->tanggal_kunjungan->format('d M Y') }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Order Details -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                                @if($order->keterangan)
                                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                        <h5 class="font-semibold text-blue-900 mb-2 flex items-center">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Catatan Pesanan
                                        </h5>
                                        <p class="text-blue-800">{{ $order->keterangan }}</p>
                                    </div>
                                @endif

                                @if($order->alamat)
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <h5 class="font-semibold text-gray-900 mb-2 flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            Alamat Pengiriman
                                        </h5>
                                        <p class="text-gray-700">{{ $order->alamat }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Payment Status -->
                            @if($order->payment)
                                <div class="mb-6">
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <h5 class="font-semibold text-gray-900 mb-3 flex items-center">
                                            <i class="fas fa-credit-card text-green-600 mr-2"></i>
                                            Status Pembayaran
                                        </h5>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                                    @if($order->payment->status === 'paid') bg-green-100 text-green-800
                                                    @elseif($order->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    <i class="fas fa-circle mr-2 text-xs"></i>
                                                    {{ ucfirst($order->payment->status) }}
                                                </span>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-600">Total Pembayaran</p>
                                                <p class="font-semibold text-gray-900">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-6 border-t border-gray-200">
                                <div class="mb-4 sm:mb-0">
                                    <div class="text-2xl font-bold text-green-600">
                                        Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-500">Total pesanan</div>
                                </div>
                                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                    @if($order->status === 'menunggu' && !$order->payment)
                                        <a href="{{ route('payment.show', $order) }}" 
                                           class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                                            <i class="fas fa-credit-card mr-2"></i>
                                            Bayar Sekarang
                                        </a>
                                    @endif
                                    
                                    @if($order->delivery)
                                        <a href="{{ route('delivery.track', $order->delivery->tracking_number) }}" 
                                           class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-truck mr-2"></i>
                                            Lacak Pengiriman
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('customer.deliveries') }}" 
                                       class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                        <i class="fas fa-list mr-2"></i>
                                        Lihat Pengiriman
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<style>
/* Custom pagination styles */
.pagination {
    @apply flex items-center space-x-1;
}

.pagination .page-item {
    @apply inline-flex;
}

.pagination .page-link {
    @apply px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors;
}

.pagination .page-item.active .page-link {
    @apply bg-green-600 border-green-600 text-white hover:bg-green-700;
}

.pagination .page-item.disabled .page-link {
    @apply text-gray-400 cursor-not-allowed hover:bg-white hover:text-gray-400;
}
</style>
@endsection 