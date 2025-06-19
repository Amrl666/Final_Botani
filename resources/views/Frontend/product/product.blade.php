@extends('layouts.frontend')

@section('title', 'Detail Produk')

@section('content')
<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white rounded-2xl shadow-md overflow-hidden">
            
            <!-- Gambar Produk -->
            <div class="p-4 flex items-center justify-center bg-gray-100">
                @if($product->image && file_exists(public_path('storage/' . $product->image)))
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="object-contain max-h-24 w-auto">
                @else
                    <img src="https://via.placeholder.com/600x400?text=No+Image" alt="No Image"
                        class="object-contain max-h-24 w-auto">
                @endif
            </div>

            <!-- Info Produk -->
            <div class="p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-green-900 mb-4">
                        {{ $product->name ?? 'Nama Produk Tidak Diketahui' }}
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        {{ $product->description ?? 'Deskripsi produk belum tersedia.' }}
                    </p>

                    <div id="price" data-price="{{ $product->price ?? 0 }}" class="text-xl font-semibold text-green-700 mb-6">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Form Pemesanan -->
                <form action="{{ route('order.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $product->id }}">

                    <!-- Nama Pemesan -->
                    <div>
                        <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="nama_pemesan" name="nama_pemesan" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                               required>
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                        <input type="tel" id="telepon" name="telepon" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                               required>
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                        <div class="flex items-center gap-3">
                            <button type="button" id="minus" class="w-9 h-9 border border-gray-300 rounded text-xl hover:bg-gray-100">−</button>
                            <input type="number" id="quantity" name="jumlah_orang"
                                   class="w-16 text-center border border-gray-300 rounded py-1" value="1" min="1">
                            <button type="button" id="plus" class="w-9 h-9 border border-gray-300 rounded text-xl hover:bg-gray-100">+</button>
                        </div>
                    </div>

                    <!-- Total Harga -->
                    <div class="pt-2">
                        <p class="text-lg font-medium text-gray-800">
                            Total: <span id="total">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </p>
                    </div>

                    <!-- Tombol Pesan -->
                    <button type="submit" 
                            class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 transition duration-200">
                        Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const minus = document.getElementById('minus');
    const plus = document.getElementById('plus');
    const quantityInput = document.getElementById('quantity');
    const totalDisplay = document.getElementById('total');
    const priceDiv = document.getElementById('price');

    const price = Number(priceDiv.dataset.price) || 0;

    function updateTotal() {
        let qty = parseInt(quantityInput.value) || 1;
        if (qty < 1) qty = 1;
        quantityInput.value = qty;
        let total = qty * price;
        totalDisplay.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    minus.addEventListener('click', () => {
        let qty = parseInt(quantityInput.value) || 1;
        if (qty > 1) {
            quantityInput.value = qty - 1;
            updateTotal();
        }
    });

    plus.addEventListener('click', () => {
        let qty = parseInt(quantityInput.value) || 1;
        quantityInput.value = qty + 1;
        updateTotal();
    });

    quantityInput.addEventListener('input', updateTotal);
    quantityInput.addEventListener('change', function() {
        if (this.value < 1) this.value = 1;
        updateTotal();
    });

    updateTotal();
});
</script>
@endsection