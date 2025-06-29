@extends('layouts.frontend')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-shopping-cart text-green-600 mr-3"></i>
                Keranjang Belanja
            </h1>
            <p class="text-gray-600 text-lg">Kelola produk yang ingin Anda beli</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3 text-lg"></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-3 text-lg"></i>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        @if($cartItems->count() > 0)
            <!-- Cart Items -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                    <h2 class="text-white font-bold text-xl flex items-center">
                        <i class="fas fa-box mr-3"></i>
                        Item Keranjang ({{ $cartItems->count() }})
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-6">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0 mb-4 lg:mb-0">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="w-24 h-24 object-cover rounded-xl shadow-md">
                                        @else
                                            <div class="w-24 h-24 bg-gray-200 rounded-xl flex items-center justify-center shadow-md">
                                                <i class="fas fa-seedling text-3xl text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1 mb-4 lg:mb-0">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $item->product->name }}</h3>
                                        <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $item->product->description }}</p>
                                        <div class="flex items-center space-x-4">
                                            <span class="text-green-600 font-semibold">
                                                Rp {{ number_format($item->product->price, 0, ',', '.') }}/{{ $item->product->unit ?? 'satuan' }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                Stok: {{ $item->product->stock }} {{ $item->product->unit ?? 'satuan' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-3">
                                            @csrf
                                            @method('PUT')
                                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                                <button type="button" 
                                                        onclick="decreaseQuantity(this)"
                                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-minus text-sm"></i>
                                                </button>
                                                <input type="number"
                                                       name="quantity"
                                                       value="{{ $item->quantity }}"
                                                       min="{{ $item->product->min_increment ?? 1 }}"
                                                       max="{{ $item->product->stock }}"
                                                       step="{{ $item->product->min_increment ?? 1 }}"
                                                       class="w-16 px-3 py-2 text-center border-0 focus:ring-0 focus:outline-none">
                                                <button type="button" 
                                                        onclick="increaseQuantity(this)"
                                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-plus text-sm"></i>
                                                </button>
                                            </div>
                                            <button type="submit" 
                                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                                <i class="fas fa-sync-alt mr-2"></i>
                                                Update
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Price and Actions -->
                                    <div class="flex flex-col items-end space-y-3">
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-green-600">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </p>
                                            <p class="text-sm text-gray-500">{{ $item->quantity }} {{ $item->product->unit ?? 'satuan' }}</p>
                                        </div>
                                        
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center"
                                                    onclick="return confirm('Yakin ingin menghapus item ini?')">
                                                <i class="fas fa-trash mr-2"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="bg-gray-50 px-6 py-6 border-t border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div class="text-center lg:text-left">
                            <p class="text-lg font-medium text-gray-700">Total {{ $cartItems->count() }} item</p>
                            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                            <form action="{{ route('cart.clear') }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors flex items-center justify-center"
                                        onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                                    <i class="fas fa-trash mr-2"></i>
                                    Kosongkan Keranjang
                                </button>
                            </form>

                            <button onclick="showCheckoutForm()"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors flex items-center justify-center">
                                <i class="fas fa-credit-card mr-2"></i>
                                Lanjutkan ke Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div id="checkoutForm" class="hidden bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-white font-bold text-xl flex items-center">
                        <i class="fas fa-credit-card mr-3"></i>
                        Form Pemesanan
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('order.checkout-cart') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-1"></i>
                                    Nama Pemesan *
                                </label>
                                <input type="text"
                                       name="nama_pemesan"
                                       id="nama_pemesan"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                       placeholder="Masukkan nama lengkap">
                            </div>

                            <div>
                                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-1"></i>
                                    Nomor HP *
                                </label>
                                @if(auth('customer')->check())
                                    <input type="tel"
                                           name="telepon"
                                           id="telepon"
                                           value="{{ auth('customer')->user()->phone }}"
                                           readonly
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed">
                                    <span class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Nomor HP diambil dari profil Anda
                                    </span>
                                @else
                                    <input type="tel"
                                           name="telepon"
                                           id="telepon"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                           placeholder="Masukkan nomor telepon">
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Alamat Pengiriman *
                                </label>
                                <textarea name="alamat"
                                          id="alamat"
                                          rows="3"
                                          required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                          placeholder="Masukkan alamat lengkap pengiriman"></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Keterangan (Opsional)
                                </label>
                                <textarea name="keterangan"
                                          id="keterangan"
                                          rows="2"
                                          placeholder="Catatan tambahan untuk pesanan..."
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"></textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                            <button type="button"
                                    onclick="hideCheckoutForm()"
                                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </button>

                            <button type="submit"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors flex items-center justify-center">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Pesan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-cart text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Keranjang Belanja Kosong</h3>
                <p class="text-gray-600 mb-6">Belum ada produk yang ditambahkan ke keranjang</p>
                <a href="{{ route('product.index_fr') }}"
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function showCheckoutForm() {
    document.getElementById('checkoutForm').classList.remove('hidden');
    document.getElementById('checkoutForm').scrollIntoView({ behavior: 'smooth' });
}

function hideCheckoutForm() {
    document.getElementById('checkoutForm').classList.add('hidden');
}

function increaseQuantity(button) {
    const input = button.parentElement.querySelector('input');
    const currentValue = parseInt(input.value);
    const maxValue = parseInt(input.max);
    const step = parseInt(input.step);
    
    if (currentValue + step <= maxValue) {
        input.value = currentValue + step;
    }
}

function decreaseQuantity(button) {
    const input = button.parentElement.querySelector('input');
    const currentValue = parseInt(input.value);
    const minValue = parseInt(input.min);
    const step = parseInt(input.step);
    
    if (currentValue - step >= minValue) {
        input.value = currentValue - step;
    }
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection