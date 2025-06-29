@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Detail Pembayaran</h2>
                    <a href="{{ route('dashboard.payments.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pembayaran
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Payment Information -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pembayaran</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Order ID</label>
                                <p class="mt-1 text-sm text-gray-900">#{{ $payment->order->id }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($payment->payment_method) }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
                                <p class="mt-1 text-2xl font-bold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <div class="mt-1">
                                    @if($payment->status === 'paid')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Sudah Dibayar
                                        </span>
                                    @elseif($payment->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($payment->status === 'failed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            Gagal
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            @if($payment->paid_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Verifikasi</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->paid_at->format('d/m/Y H:i') }}</p>
                            </div>
                            @endif

                            @if($payment->notes)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->notes }}</p>
                            </div>
                            @endif
                        </div>

                        @if($payment->status === 'pending')
                        <div class="mt-6 flex space-x-3">
                            <form action="{{ route('dashboard.payments.verify', $payment) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors"
                                        onclick="return confirm('Verifikasi pembayaran ini?')">
                                    <i class="fas fa-check mr-2"></i>Verifikasi Pembayaran
                                </button>
                            </form>
                            <form action="{{ route('dashboard.payments.reject', $payment) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors"
                                        onclick="return confirm('Tolak pembayaran ini?')">
                                    <i class="fas fa-times mr-2"></i>Tolak Pembayaran
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>

                    <!-- Order Information -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pesanan</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Pemesan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->order->nama_pemesan }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->order->telepon }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->order->alamat ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Pesanan</label>
                                <div class="mt-1">
                                    @if($payment->order->status === 'selesai')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    @elseif($payment->order->status === 'disetujui')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Disetujui
                                        </span>
                                    @elseif($payment->order->status === 'menunggu_konfirmasi')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Menunggu Konfirmasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($payment->order->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pesanan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->order->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            @if($payment->order->keterangan)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catatan Pesanan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->order->keterangan }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Order Items -->
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Detail Produk</h4>
                            
                            @if($payment->order->orderItems->isNotEmpty())
                                <div class="space-y-3">
                                    @foreach($payment->order->orderItems as $item)
                                    <div class="flex items-center space-x-3 p-3 bg-white rounded border">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-12 h-12 object-cover rounded">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $item->quantity }} {{ $item->product->unit }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-3 bg-white rounded border">
                                    @if($payment->order->produk)
                                        <p class="text-sm font-medium text-gray-900">{{ $payment->order->produk->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $payment->order->jumlah }} {{ $payment->order->produk->unit }}</p>
                                    @elseif($payment->order->eduwisata)
                                        <p class="text-sm font-medium text-gray-900">{{ $payment->order->eduwisata->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $payment->order->jumlah_orang }} orang</p>
                                        @if($payment->order->tanggal_kunjungan)
                                            <p class="text-sm text-gray-500">{{ $payment->order->tanggal_kunjungan->format('d/m/Y') }}</p>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Payment Proof -->
                @if($payment->payment_proof)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Bukti Pembayaran</h3>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" 
                             alt="Bukti Pembayaran" 
                             class="max-w-md rounded-lg shadow-sm">
                        <div class="mt-4">
                            <a href="{{ asset('storage/' . $payment->payment_proof) }}" 
                               target="_blank"
                               class="text-blue-600 hover:text-blue-900 text-sm">
                                Lihat Gambar Penuh
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 