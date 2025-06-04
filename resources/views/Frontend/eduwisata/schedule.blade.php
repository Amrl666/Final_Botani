@extends('layouts.frontend')

@section('title', 'Detail Eduwisata')

@section('content')
<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2">
                    @if($eduwisata->image && file_exists(public_path('storage/' . $eduwisata->image)))
                        <img src="{{ asset('storage/' . $eduwisata->image) }}" alt="{{ $eduwisata->name }}"
                             class="object-cover w-full h-96 md:h-full">
                    @else
                        <img src="https://via.placeholder.com/600x400?text=No+Image"
                             alt="Default Image"
                             class="object-cover w-full h-96 md:h-full">
                    @endif
                </div>
                <div class="md:w-1/2 p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $eduwisata->name ?? 'Nama Tidak Diketahui' }}</h2>
                        <p class="text-gray-600 mb-4">{{ $eduwisata->description ?? 'Deskripsi belum tersedia.' }}</p>
                        
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-700 mb-2">Harga per Orang:</h3>
                            <div class="text-gray-700 font-medium text-lg">
                                Rp {{ number_format($eduwisata->harga, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Simpan harga dalam data attribute agar bisa diakses JS -->
                        <div id="price" data-price="{{ $eduwisata->harga }}" class="hidden"></div>

                        <div class="flex items-center gap-2 mb-4">
                            <button id="minus" class="bg-gray-200 px-3 py-1 rounded text-lg">−</button>
                            <input type="number" id="quantity" class="w-16 text-center border rounded px-2 py-1" value="0" min="0">
                            <button id="plus" class="bg-gray-200 px-3 py-1 rounded text-lg">+</button>
                        </div>

                        <!-- Input tanggal -->
                        <div class="mb-4">
                            <label for="date" class="font-semibold text-gray-700 mb-2 block">Pilih Tanggal:</label>
                            <input type="date" id="date" class="border rounded px-3 py-2 w-full" min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="text-lg font-semibold text-green-600 mb-4">
                            <span id="total">Rp 0</span>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <a href="{{ route('eduwisata') }}" class="text-sm text-gray-600 hover:text-gray-800">← Kembali</a>
                        <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Beli Sekarang</button>
                    </div>
                </div>
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
    const dateInput = document.getElementById('date');
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
        const date = dateInput.value;
        const name = "{{ $eduwisata->name }}";
        const priceFormatted = price.toLocaleString('id-ID');
        const total = qty * price;

        if (qty <= 0) {
            alert('Silakan pilih jumlah orang terlebih dahulu.');
            return;
        }

        if (!date) {
            alert('Silakan pilih tanggal terlebih dahulu.');
            return;
        }

        // Format tanggal agar lebih mudah dibaca (optional)
        const dateObj = new Date(date);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const dateFormatted = dateObj.toLocaleDateString('id-ID', options);

        // Format pesan WhatsApp
        const message = 
`Halo, saya ingin memesan paket Eduwisata:
- Paket: ${name}
- Harga per orang: Rp ${priceFormatted}
- Jumlah orang: ${qty}
- Total harga: Rp ${total.toLocaleString('id-ID')}
- Tanggal kunjungan: ${dateFormatted}`;

        // Nomor WhatsApp tujuan (ubah sesuai nomor yang diinginkan, pakai format internasional tanpa tanda +)
        const waNumber = "628553020204";

        // Encode message agar URL valid
        const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`;

        // Buka WhatsApp di tab baru
        window.open(waUrl, '_blank');
    });

    updateTotal(); // initial update
});
</script>
@endsection
