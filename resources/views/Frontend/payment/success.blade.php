@extends('layouts.frontend')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Success Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-8 text-center">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-white text-3xl"></i>
                </div>
                <h1 class="text-white font-bold text-2xl mb-2">Pembayaran Berhasil!</h1>
                <p class="text-green-100">Pesanan #{{ $order->id }} telah berhasil diproses</p>
            </div>

            <div class="p-6">
                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-shopping-bag text-green-600 mr-2"></i>
                        Detail Pesanan
                    </h3>
                    
                    @if($order->orderItems->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                    <div class="flex items-center space-x-3">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-12 h-12 object-cover rounded-lg">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-box text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->quantity }} {{ $item->product->unit }}</p>
                                        </div>
                                    </div>
                                    <span class="font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-3">
                                @if($order->produk)
                                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-seedling text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $order->produk->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->jumlah }} {{ $order->produk->unit }}</p>
                                    </div>
                                @elseif($order->eduwisata)
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-map-marked-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $order->eduwisata->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->jumlah_orang }} orang</p>
                                    </div>
                                @endif
                            </div>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Status -->
                @if($order->payment)
                    <div class="bg-blue-50 rounded-xl p-6 mb-6 border border-blue-200">
                        <h3 class="font-semibold text-blue-900 mb-4 flex items-center">
                            <i class="fas fa-credit-card text-blue-600 mr-2"></i>
                            Status Pembayaran
                        </h3>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-blue-800">Metode Pembayaran</p>
                                <p class="font-semibold text-blue-900">{{ ucfirst($order->payment->payment_method) }}</p>
                            </div>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-2"></i>
                                Menunggu Verifikasi
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Next Steps -->
                <div class="bg-green-50 rounded-xl p-6 mb-6 border border-green-200">
                    <h3 class="font-semibold text-green-900 mb-4 flex items-center">
                        <i class="fas fa-list-check text-green-600 mr-2"></i>
                        Langkah Selanjutnya
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-white text-xs font-bold">1</span>
                            </div>
                            <p class="text-green-800">Admin akan memverifikasi pembayaran Anda dalam waktu 1x24 jam</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-white text-xs font-bold">2</span>
                            </div>
                            <p class="text-green-800">Anda akan menerima notifikasi status pesanan via WhatsApp</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-white text-xs font-bold">3</span>
                            </div>
                            <p class="text-green-800">Pesanan akan diproses dan dikirim setelah pembayaran dikonfirmasi</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <a href="{{ route('customer.orders') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-colors">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Lihat Riwayat Pesanan
                    </a>
                    
                    <a href="{{ route('product.index_fr') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Lanjutkan Belanja
                    </a>
                </div>

                <!-- Contact Info -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-headset text-gray-600 mr-2"></i>
                        Butuh Bantuan?
                    </h3>
                    <p class="text-gray-600 mb-4">Jika ada pertanyaan tentang pesanan atau pembayaran, silakan hubungi kami:</p>
                    
                    <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                        <a href="https://wa.me/628553020204?text=Halo, saya ingin menanyakan tentang pesanan #{{ $order->id }}" 
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fab fa-whatsapp mr-2"></i>
                            WhatsApp
                        </a>
                        
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone mr-2"></i>
                            <span>0855-3020-204</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 