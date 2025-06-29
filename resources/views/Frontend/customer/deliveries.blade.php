@extends('layouts.frontend')

@section('title', 'Status Pengiriman')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-truck text-green-600 mr-3"></i>
                Status Pengiriman
            </h1>
            <p class="text-gray-600 text-lg">Lacak status pengiriman pesanan Anda</p>
        </div>

        @if($deliveries->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-truck text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada pengiriman</h3>
                <p class="text-gray-600 mb-6">Pengiriman akan muncul di sini setelah pesanan Anda dikirim.</p>
                <a href="{{ route('product.index_fr') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Belanja Sekarang
                </a>
            </div>
        @else
            <!-- Deliveries List -->
            <div class="space-y-6">
                @foreach($deliveries as $delivery)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <!-- Delivery Header -->
                        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center mb-3 sm:mb-0">
                                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                        <i class="fas fa-box text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold text-lg">
                                            Pesanan #{{ $delivery->order->id }}
                                        </h3>
                                        <p class="text-green-100 text-sm">
                                            <i class="fas fa-barcode mr-1"></i>
                                            {{ $delivery->tracking_number }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    @php
                                        $statusColors = [
                                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                                            'dalam_pengiriman' => 'bg-blue-100 text-blue-800',
                                            'terkirim' => 'bg-green-100 text-green-800',
                                            'diterima' => 'bg-emerald-100 text-emerald-800',
                                            'dibatalkan' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusColor = $statusColors[$delivery->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">
                                        <i class="fas fa-circle mr-2 text-xs"></i>
                                        {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Content -->
                        <div class="p-6">
                            <!-- Info Grid -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                                <!-- Delivery Info -->
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                        <i class="fas fa-info-circle text-green-600 mr-2"></i>
                                        Informasi Pengiriman
                                    </h4>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Kurir:</span>
                                            <span class="font-medium">{{ $delivery->courier_name ?? 'Belum ditentukan' }}</span>
                                        </div>
                                        @if($delivery->courier_phone)
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Telepon:</span>
                                                <span class="font-medium">{{ $delivery->courier_phone }}</span>
                                            </div>
                                        @endif
                                        @if($delivery->estimated_delivery)
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Estimasi:</span>
                                                <span class="font-medium">{{ $delivery->estimated_delivery->format('d M Y') }}</span>
                                            </div>
                                        @endif
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Ongkir:</span>
                                            <span class="font-medium text-green-600">Rp {{ number_format($delivery->shipping_cost, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Address -->
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                                        Alamat Pengiriman
                                    </h4>
                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                        <div class="font-medium text-gray-900 mb-1">
                                            {{ $delivery->shippingAddress->recipient_name ?? 'N/A' }}
                                        </div>
                                        <div class="text-gray-600 text-sm mb-1">
                                            {{ $delivery->shippingAddress->formatted_address ?? 'N/A' }}
                                        </div>
                                        <div class="text-gray-500 text-sm">
                                            <i class="fas fa-phone mr-1"></i>
                                            {{ $delivery->shippingAddress->phone ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                    <i class="fas fa-box text-green-600 mr-2"></i>
                                    Item Pesanan
                                </h4>
                                @if($delivery->order->orderItems->isNotEmpty())
                                    <div class="bg-white rounded-lg overflow-hidden">
                                        <div class="overflow-x-auto">
                                            <table class="w-full">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($delivery->order->orderItems as $item)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-4 py-3">
                                                                <div class="flex items-center">
                                                                    @if($item->product->image)
                                                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                                             alt="{{ $item->product->name }}" 
                                                                             class="w-10 h-10 rounded-lg object-cover mr-3">
                                                                    @else
                                                                        <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                                                            <i class="fas fa-box text-gray-400"></i>
                                                                        </div>
                                                                    @endif
                                                                    <span class="font-medium text-gray-900">{{ $item->product->name }}</span>
                                                                </div>
                                                            </td>
                                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                                {{ $item->quantity }} {{ $item->product->unit }}
                                                            </td>
                                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                                Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}
                                                            </td>
                                                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                                        @if($delivery->order->produk)
                                            <div class="font-medium text-gray-900">{{ $delivery->order->produk->name }}</div>
                                            <div class="text-gray-600 text-sm">Jumlah: {{ $delivery->order->jumlah }} {{ $delivery->order->produk->unit }}</div>
                                            <div class="text-gray-600 text-sm">Harga: Rp {{ number_format($delivery->order->produk->price, 0, ',', '.') }}</div>
                                        @elseif($delivery->order->eduwisata)
                                            <div class="font-medium text-gray-900">{{ $delivery->order->eduwisata->name }}</div>
                                            <div class="text-gray-600 text-sm">Jumlah: {{ $delivery->order->jumlah_orang }} orang</div>
                                            <div class="text-gray-600 text-sm">Harga: Rp {{ number_format($delivery->order->eduwisata->harga, 0, ',', '.') }}</div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Tracking Timeline -->
                            @if($delivery->trackingLogs->isNotEmpty())
                                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                                        <i class="fas fa-history text-green-600 mr-2"></i>
                                        Riwayat Status
                                    </h4>
                                    <div class="space-y-4">
                                        @foreach($delivery->trackingLogs->sortByDesc('tracked_at')->take(5) as $log)
                                            <div class="flex items-start space-x-4">
                                                <div class="flex-shrink-0">
                                                    <div class="w-3 h-3 bg-green-500 rounded-full mt-2"></div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                                                        <div class="flex justify-between items-start mb-2">
                                                            <h5 class="font-medium text-gray-900">{{ $log->description ?? ucfirst(str_replace('_', ' ', $log->status)) }}</h5>
                                                            <span class="text-sm text-gray-500">{{ $log->tracked_at->format('d M Y H:i') }}</span>
                                                        </div>
                                                        @if($log->location)
                                                            <p class="text-sm text-gray-600">
                                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                                {{ $log->location }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-6 border-t border-gray-200">
                                <div class="mb-4 sm:mb-0">
                                    <div class="text-2xl font-bold text-green-600">
                                        Total: Rp {{ number_format($delivery->order->total_harga + $delivery->shipping_cost, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-500">Termasuk ongkos kirim</div>
                                </div>
                                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                    <a href="{{ route('delivery.track', $delivery->tracking_number) }}" 
                                       class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-search mr-2"></i>
                                        Lacak Detail
                                    </a>
                                    <a href="https://wa.me/628553020204?text=Halo, saya ingin menanyakan tentang pengiriman {{ $delivery->tracking_number }}" 
                                       target="_blank"
                                       class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fab fa-whatsapp mr-2"></i>
                                        Tanya via WA
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($deliveries->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $deliveries->links() }}
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