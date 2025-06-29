@extends('layouts.frontend')

@section('title', 'Proses Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-credit-card text-green-600 mr-3"></i>
                Proses Pembayaran
            </h1>
            <p class="text-gray-600 text-lg">Pesanan #{{ $order->id }}</p>
        </div>

        <!-- Payment Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h2 class="text-white font-bold text-xl flex items-center">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    Ringkasan Pesanan
                </h2>
            </div>

            <div class="p-6">
                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    @if($order->orderItems->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                                    <div class="flex items-center space-x-4">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-box text-gray-400 text-xl"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $item->product->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $item->quantity }} {{ $item->product->unit }}</p>
                                            <p class="text-sm text-gray-500">@ Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-4">
                                @if($order->produk)
                                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-seedling text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $order->produk->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $order->jumlah }} {{ $order->produk->unit }}</p>
                                        <p class="text-sm text-gray-500">@ Rp {{ number_format($order->produk->price, 0, ',', '.') }}</p>
                                    </div>
                                @elseif($order->eduwisata)
                                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-map-marked-alt text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $order->eduwisata->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $order->jumlah_orang }} orang</p>
                                        @if($order->tanggal_kunjungan)
                                            <p class="text-sm text-gray-500">{{ $order->tanggal_kunjungan->format('d M Y') }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-semibold text-gray-900">Total Pembayaran</span>
                            <span class="text-3xl font-bold text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <form action="{{ route('payment.process', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Payment Method Selection -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-credit-card mr-1"></i>
                                Metode Pembayaran
                            </label>
                            <select name="payment_method" id="payment_method" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('payment_method') border-red-500 @enderror">
                                <option value="">Pilih metode pembayaran</option>
                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                                <option value="ewallet" {{ old('payment_method') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Transfer Details -->
                        <div id="transfer_details" class="hidden">
                            <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                                <h4 class="font-semibold text-blue-900 mb-4 flex items-center">
                                    <i class="fas fa-university text-blue-600 mr-2"></i>
                                    Informasi Transfer Bank
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                                        <p class="text-sm text-blue-600">Bank</p>
                                        <p class="font-semibold text-blue-900">BCA</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                                        <p class="text-sm text-blue-600">No. Rekening</p>
                                        <p class="font-semibold text-blue-900">1234567890</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                                        <p class="text-sm text-blue-600">Atas Nama</p>
                                        <p class="font-semibold text-blue-900">Kelompok Tani Winongo Asri</p>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                                        <p class="text-sm text-blue-600">Jumlah Transfer</p>
                                        <p class="font-semibold text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COD Details -->
                        <div id="cod_details" class="hidden">
                            <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
                                <h4 class="font-semibold text-yellow-900 mb-4 flex items-center">
                                    <i class="fas fa-money-bill-wave text-yellow-600 mr-2"></i>
                                    Informasi Cash on Delivery (COD)
                                </h4>
                                <div class="bg-white rounded-lg p-4 border border-yellow-200">
                                    <p class="text-yellow-800 mb-3">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Pembayaran dilakukan saat barang diterima.
                                    </p>
                                    <p class="font-semibold text-yellow-900">
                                        Siapkan uang tunai sebesar: <span class="text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- E-Wallet Details -->
                        <div id="ewallet_details" class="hidden">
                            <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                                <h4 class="font-semibold text-green-900 mb-4 flex items-center">
                                    <i class="fas fa-mobile-alt text-green-600 mr-2"></i>
                                    Informasi E-Wallet
                                </h4>
                                <div class="bg-white rounded-lg p-4 border border-green-200">
                                    <p class="text-green-800">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Pembayaran akan diproses melalui sistem e-wallet. Anda akan menerima instruksi pembayaran setelah mengirimkan pesanan ini.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Proof Section -->
                        <div id="payment_proof_section" class="hidden">
                            <div>
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-3">
                                    <i class="fas fa-upload mr-1"></i>
                                    Bukti Pembayaran
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-green-400 transition-colors">
                                    <input type="file" name="payment_proof" id="payment_proof" accept="image/*"
                                           class="hidden" @error('payment_proof') border-red-500 @enderror>
                                    <label for="payment_proof" class="cursor-pointer">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-600 mb-2">Klik untuk upload bukti pembayaran</p>
                                        <p class="text-sm text-gray-500">Format: JPG, PNG (maksimal 2MB)</p>
                                    </label>
                                </div>
                                @error('payment_proof')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-sticky-note mr-1"></i>
                                Catatan (Opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('notes') border-red-500 @enderror"
                                      placeholder="Tambahkan catatan untuk admin...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('customer.orders') }}" 
                               class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-xl hover:bg-gray-700 transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-colors">
                                <i class="fas fa-credit-card mr-2"></i>
                                Proses Pembayaran
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('payment_method').addEventListener('change', function() {
    const method = this.value;
    const transferDetails = document.getElementById('transfer_details');
    const codDetails = document.getElementById('cod_details');
    const ewalletDetails = document.getElementById('ewallet_details');
    const paymentProofSection = document.getElementById('payment_proof_section');

    // Hide all details
    transferDetails.classList.add('hidden');
    codDetails.classList.add('hidden');
    ewalletDetails.classList.add('hidden');
    paymentProofSection.classList.add('hidden');

    // Show relevant details
    if (method === 'transfer') {
        transferDetails.classList.remove('hidden');
        paymentProofSection.classList.remove('hidden');
    } else if (method === 'cod') {
        codDetails.classList.remove('hidden');
    } else if (method === 'ewallet') {
        ewalletDetails.classList.remove('hidden');
        paymentProofSection.classList.remove('hidden');
    }
});

// File upload preview
document.getElementById('payment_proof').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const label = this.parentElement.querySelector('label');
        label.innerHTML = `
            <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
            <p class="text-gray-600 mb-2">File terpilih: ${file.name}</p>
            <p class="text-sm text-gray-500">Klik untuk ganti file</p>
        `;
    }
});
</script>
@endsection 