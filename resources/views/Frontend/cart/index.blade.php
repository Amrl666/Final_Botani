@extends('layouts.frontend')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Keranjang Belanja</h1>
            <p class="text-gray-600">Kelola produk yang ingin Anda beli</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($cartItems->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                            <div class="flex-shrink-0">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-seedling text-2xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $item->product->description }}</p>
                                <p class="text-green-600 font-semibold">Rp {{ number_format($item->product->price, 0, ',', '.') }}/kg</p>
                            </div>

                            <div class="flex items-center space-x-2">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number"
                                            name="quantity"
                                            value="{{ $item->quantity }}"
                                            min="1"
                                            max="{{ $item->product->stock }}"
                                            class="w-16 px-2 py-1 border border-gray-300 rounded text-center">
                                            <button type="submit" class=" hover:text-white hover:bg-green-700 font-semibold py-2 px-6 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
                                                <i class="fas fa-sync-alt"></i> <span>Update</span>
                                            </button>
                                </form>
                            </div>

                            <div class="text-right">
                                <p class="text-lg font-bold text-green-600">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $item->quantity }} kg</p>
                            </div>

                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 p-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-50 p-6 border-t">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-800">Total:</span>
                        <span class="text-2xl font-bold text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex space-x-4">
                        <form action="{{ route('cart.clear') }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                                Kosongkan Keranjang
                            </button>
                        </form>

                        <button onclick="showCheckoutForm()"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                            Lanjutkan ke Pembayaran
                        </button>
                    </div>
                </div>
            </div>

            <div id="checkoutForm" class="hidden mt-8 bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Pemesanan</h2>

                <form action="{{ route('order.checkout-cart') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Pemesan *
                            </label>
                            <input type="text"
                                    name="nama_pemesan"
                                    id="nama_pemesan"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor HP *
                            </label>
                            <input type="tel"
                                    name="telepon"
                                    id="telepon"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Pengiriman *
                            </label>
                            <textarea name="alamat"
                                            id="alamat"
                                            rows="3"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan (Opsional)
                            </label>
                            <textarea name="keterangan"
                                            id="keterangan"
                                            rows="2"
                                            placeholder="Catatan tambahan untuk pesanan..."
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <button type="button"
                                onclick="hideCheckoutForm()"
                                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                            Batal
                        </button>

                        <button type="submit"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                            Pesan Sekarang
                        </button>
                    </div>
                </form>
            </div>

        @else
            <div class="text-center py-12">
                <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md mx-auto">
                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Keranjang Belanja Kosong</h3>
                    <p class="text-gray-600 mb-6">Belum ada produk yang ditambahkan ke keranjang</p>
                    <a href="{{ route('product.index_fr') }}"
                       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                        Mulai Belanja
                    </a>
                </div>
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
</script>
@endsection