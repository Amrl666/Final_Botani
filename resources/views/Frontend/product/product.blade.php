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

                    <!-- Quantity -->
                    <div class="flex items-center gap-3 mb-4">
                        <button id="minus" class="w-9 h-9 border border-gray-300 rounded text-xl hover:bg-gray-100">−</button>
                        <input type="number" id="quantity"
                               class="w-16 text-center border border-gray-300 rounded py-1" value="0" min="0">
                        <button id="plus" class="w-9 h-9 border border-gray-300 rounded text-xl hover:bg-gray-100">+</button>
                    </div>

                    <!-- Total -->
                    <div class="text-base font-medium text-gray-800 mb-6">
                        Total: <span id="total">Rp 0</span>
                    </div>
                </div>

                <!-- Tombol WhatsApp -->
                <button class="bg-green-500 text-white w-full py-2 rounded-md hover:bg-green-600 transition duration-200">
                    Beli Sekarang
                </button>
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
    const buyButton = document.querySelector('button.bg-green-500');

    const price = Number(priceDiv.dataset.price) || 0;

    function updateTotal() {
        let qty = parseInt(quantityInput.value) || 0;
        let total = qty * price;
        totalDisplay.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    minus.addEventListener('click', () => {
        let qty = parseInt(quantityInput.value) || 0;
        if (qty > 0) {
            quantityInput.value = qty - 1;
            updateTotal();
        }
    });

    plus.addEventListener('click', () => {
        let qty = parseInt(quantityInput.value) || 0;
        quantityInput.value = qty + 1;
        updateTotal();
    });

    quantityInput.addEventListener('input', updateTotal);

    buyButton.addEventListener('click', () => {
        const qty = parseInt(quantityInput.value) || 0;
        const name = "{{ $product->name }}";
        const priceFormatted = price.toLocaleString('id-ID');
        const total = qty * price;

        if (qty <= 0) {
            alert('Silakan pilih jumlah terlebih dahulu.');
            return;
        }

        const message = 
`Halo, saya ingin memesan produk berikut:
- Produk: ${name}
- Harga satuan: Rp ${priceFormatted}
- Jumlah: ${qty}
- Total: Rp ${total.toLocaleString('id-ID')}`;

        const waNumber = "628553020204";
        const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;
        window.open(waUrl, '_blank');
    });

    updateTotal();
});
</script>
@endsection
