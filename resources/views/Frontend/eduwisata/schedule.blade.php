@extends('layouts.frontend')

@section('title', 'Detail Eduwisata')

@section('content')

<style>
    /* Tambahkan CSS sesuai kebutuhan */
</style>

<section class="py-5">
    <div class="container">
        <div class="detail-wrapper">
            <div>
                @if($eduwisata->image && file_exists(public_path('storage/' . $eduwisata->image)))
                    <img src="{{ asset('storage/' . $eduwisata->image) }}" alt="{{ $eduwisata->name }}" class="detail-image">
                @else
                    <img src="https://via.placeholder.com/600x400?text=No+Image" class="detail-image" alt="Default Image">
                @endif
            </div>
            <div class="detail-info">
                <div class="detail-title">{{ $eduwisata->name ?? 'Nama Program Tidak Diketahui' }}</div>
                <div class="detail-description">
                    {{ $eduwisata->description ?? 'Deskripsi belum tersedia untuk program ini.' }}
                </div>

                <div class="price-breakdown mb-3">
                    <strong>Harga per Orang:</strong>
                    <ul>
                        <li>Rp10.000 (≥ 20 orang)</li>
                        <li>Rp12.000 (10–19 orang)</li>
                        <li>Rp14.000 (&lt; 10 orang)</li>
                    </ul>
                </div>

                <div class="quantity-controls">
                    <button id="minus" class="btn btn-outline-secondary">-</button>
                    <input type="number" id="quantity" class="form-control" value="0" min="0">
                    <button id="plus" class="btn btn-outline-secondary">+</button>
                </div>

                <div class="total-price">
                    Total: <span id="total">Rp 0</span>
                </div>
                 <div class="mt-4">
                    <a href="{{ route('eduwisata') }}" class="btn btn-outline-success">Back to Eduwisata</a>
                </div>
                <button class="btn btn-success">Beli Sekarang</button>
            </div>
        </div>
    </div>
</section>

<script>
// document.addEventListener('DOMContentLoaded', function () {
//     const minus = document.getElementById('minus');
//     const plus = document.getElementById('plus');
//     const quantityInput = document.getElementById('quantity');
//     const totalDisplay = document.getElementById('total');

//     function updateTotal() {
//         let qty = parseInt(quantityInput.value) || 0; // Pastikan tidak NaN
//         let totalPrice = 0; // Harga paket default

//         // Tetapkan harga berdasarkan jumlah orang
//         if (qty >= 20) {
//             totalPrice = 10000; // Rp10.000 untuk ≥ 20 orang (satu paket)
//         } else if (qty >= 10) {
//             totalPrice = 12000; // Rp12.000 untuk 10–19 orang (satu paket)
//         } else if (qty > 0) {
//             totalPrice = 14000; // Rp14.000 untuk < 10 orang (satu paket)
//         }

//         // Tampilkan total harga paket
//         totalDisplay.textContent = `Total: Rp ${totalPrice.toLocaleString('id-ID')}`;
//     }

//     minus.addEventListener('click', () => {
//         let qty = parseInt(quantityInput.value) || 0;
//         if (qty > 0) {
//             quantityInput.value = qty - 1;
//             updateTotal();
//         }
//     });

//     plus.addEventListener('click', () => {
//         let qty = parseInt(quantityInput.value) || 0;
//         quantityInput.value = qty + 1;
//         updateTotal();
//     });

//     quantityInput.addEventListener('input', updateTotal);
// });

document.addEventListener('DOMContentLoaded', function () {
    const minus = document.getElementById('minus');
    const plus = document.getElementById('plus');
    const quantityInput = document.getElementById('quantity');
    const totalDisplay = document.getElementById('total');

    function updateTotal() {
        let qty = parseInt(quantityInput.value) || 0; // Pastikan tidak NaN
        let price = 0; // Default harga

        if (qty >= 20) {
            price = 10000; // Rp10.000 untuk ≥ 20 orang
        } else if (qty >= 10) {
            price = 12000; // Rp12.000 untuk 10–19 orang
        } else if (qty > 0) {
            price = 14000; // Rp14.000 untuk < 10 orang
        }

        totalDisplay.textContent = `Total: Rp ${price.toLocaleString('id-ID')} x ${qty} = Rp ${(qty * price).toLocaleString('id-ID')}`;
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
});


</script>

@endsection
