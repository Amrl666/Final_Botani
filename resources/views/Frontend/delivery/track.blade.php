@extends('layouts.frontend')

@section('title', 'Lacak Pengiriman')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-truck text-green-600 mr-3"></i>
                Lacak Pengiriman
            </h1>
            <p class="text-gray-600 text-lg">Pantau status pengiriman pesanan Anda</p>
        </div>

        <!-- Tracking Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Tracking Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-barcode text-white text-2xl"></i>
                    </div>
                    <h2 class="text-white font-bold text-2xl mb-2">{{ $delivery->tracking_number }}</h2>
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
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">
                        <i class="fas fa-circle mr-2 text-xs"></i>
                        {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <!-- Delivery Information Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Delivery Info -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-green-600 mr-2"></i>
                            Informasi Pengiriman
                        </h3>
                        <div class="space-y-3">
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
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkir:</span>
                                <span class="font-medium text-green-600">Rp {{ number_format($delivery->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            @if($delivery->estimated_delivery)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Estimasi:</span>
                                    <span class="font-medium">{{ $delivery->estimated_delivery->format('d M Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-shopping-bag text-green-600 mr-2"></i>
                            Informasi Pesanan
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pemesan:</span>
                                <span class="font-medium">{{ $delivery->order->nama_pemesan }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total:</span>
                                <span class="font-medium text-green-600">Rp {{ number_format($delivery->order->total_harga + $delivery->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Alamat:</span>
                                <span class="font-medium text-right">{{ $delivery->shippingAddress->formatted_address ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tracking Timeline -->
                <div class="mb-8">
                    <h3 class="font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-history text-green-600 mr-2"></i>
                        Riwayat Pengiriman
                    </h3>
                    
                    @if($delivery->trackingLogs->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($delivery->trackingLogs->sortByDesc('tracked_at') as $log)
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-4 h-4 bg-green-500 rounded-full mt-3"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                                            <div class="flex justify-between items-start mb-3">
                                                <h4 class="font-semibold text-gray-900">{{ $log->description ?? ucfirst(str_replace('_', ' ', $log->status)) }}</h4>
                                                <span class="text-sm text-gray-500">{{ $log->tracked_at->format('d M Y H:i') }}</span>
                                            </div>
                                            @if($log->location)
                                                <p class="text-sm text-gray-600 flex items-center">
                                                    <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>
                                                    {{ $log->location }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-xl p-8 text-center">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clock text-gray-400 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Belum ada riwayat tracking</h4>
                            <p class="text-gray-600">Riwayat pengiriman akan muncul di sini setelah status diperbarui</p>
                        </div>
                    @endif
                </div>

                <!-- Contact Information -->
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                    <h3 class="font-semibold text-blue-900 mb-4 flex items-center">
                        <i class="fas fa-headset text-blue-600 mr-2"></i>
                        Butuh Bantuan?
                    </h3>
                    <p class="text-blue-800 mb-4">Jika ada pertanyaan tentang pengiriman, silakan hubungi kami:</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-phone text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Telepon</p>
                                    <p class="text-lg font-semibold text-blue-600">0855-3020-204</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fab fa-whatsapp text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">WhatsApp</p>
                                    <p class="text-lg font-semibold text-green-600">0855-3020-204</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="https://wa.me/628553020204?text=Halo, saya ingin menanyakan tentang pengiriman {{ $delivery->tracking_number }}" 
                           target="_blank"
                           class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Tanya via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 