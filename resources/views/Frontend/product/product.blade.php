@extends('layouts.frontend')

@section('title', 'Detail Produk')

@section('content')

<style>
    .product-detail {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        align-items: flex-start;
    }

    .product-image img {
        max-width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .product-info {
        flex: 1;
        min-width: 280px;
    }

    .product-title {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 1rem;
        color: #14532d;
    }

    .product-description {
        font-size: 16px;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .product-price {
        font-size: 24px;
        font-weight: bold;
        color: #198754;
        margin-bottom: 1.5rem;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .quantity-controls input {
        width: 60px;
        text-align: center;
    }

    .total-price {
        font-size: 20px;
        margin-bottom: 1.5rem;
    }
</style>

<section class="py-5">
    <div class="container">
        <div class="product-detail">
            <div class="product-image">
                @if($product->image && file_exists(public_path('storage/' . $product->image)))
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/600x400?text=No+Image" alt="No Image">
                @endif
            </div>

            <div class="product-info">
                <div class="product-title">{{ $product->name ?? 'Nama Produk Tidak Diketahui' }}</div>
                <div class="product-description">
                    {{ $product->description ?? 'Deskripsi produk belum tersedia.' }}
                </div>

                <div class="product-price">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <div class="quantity-controls">
                    <button id="minus" class="btn btn-outline-secondary">-</button>
                    <input type="number" id="quantity" class="form-control" value="0" min="0">
                    <button id="plus" class="btn btn-outline-secondary">+</button>
                </div>

                <div class="total-price">
                    Total: <span id="total">Rp 0</span>
                </div>

                <button class="btn btn-success">Beli Sekarang</button>
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

        const price = {{ $product->price ?? 0 }};

        function updateTotal() {
            const qty = parseInt(quantityInput.value);
            totalDisplay.textContent = 'Rp ' + (qty * price).toLocaleString('id-ID');
        }

        minus.addEventListener('click', () => {
            let qty = parseInt(quantityInput.value);
            if (qty > 0) {
                quantityInput.value = qty - 1;
                updateTotal();
            }
        });

        plus.addEventListener('click', () => {
            let qty = parseInt(quantityInput.value);
            quantityInput.value = qty + 1;
            updateTotal();
        });

        quantityInput.addEventListener('input', updateTotal);
    });
</script>

@endsection
