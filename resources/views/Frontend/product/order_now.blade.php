@extends('layouts.frontend')

@section('title', $product->name)

@section('content')

<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-8 animate-slide-down">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li>
                    <a href="{{ route('product.index_fr') }}" class="hover:text-green-600 transition-colors duration-200">
                        Produk
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li class="text-gray-800 font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Product Image -->
                <div class="animate-slide-right">
                    <div class="relative aspect-square rounded-xl overflow-hidden group">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-seedling text-6xl text-gray-400"></i>
                            </div>
                        @endif
                        
                        @if($product->featured)
                            <div class="absolute top-4 left-4">
                                <span class="bg-yellow-400 text-yellow-900 text-sm font-bold px-4 py-2 rounded-full">
                                    Produk Unggulan
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="animate-slide-left">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-center space-x-4 mb-6">
                        <span class="text-3xl font-bold text-green-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            Stok: {{ $product->stock }} {{ $product->unit ?? 'satuan' }}
                        </span>
                    </div>

                    <div class="prose prose-green max-w-none mb-8">
                        <p class="text-gray-600">{{ $product->description }}</p>
                    </div>

                    @if($product->stock > 0)
                      
                        <!-- Direct Order Section -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pesan Langsung</h3>
                            <form id="orderForm" action="{{ route('order.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $product->id }}">
                                    
                                    <div class="flex flex-col space-y-2">
                                        <label for="nama_pemesan" class="text-sm font-medium text-gray-700">Nama Pemesan</label>
                                        <input type="text" 
                                               name="nama_pemesan" 
                                               id="nama_pemesan" 
                                               required
                                               class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <label for="telepon" class="text-sm font-medium text-gray-700">Nomor HP</label>
                                        <input type="tel" 
                                               name="telepon" 
                                               id="telepon" 
                                               required
                                               class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <label for="alamat" class="text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                                        <textarea name="alamat" 
                                                  id="alamat" 
                                                  rows="3" 
                                                  required
                                                  class="form-textarea rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200"></textarea>
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <label for="jumlah" class="text-sm font-medium text-gray-700">Jumlah ({{ $product->unit ?? 'satuan' }})</label>
                                        <input type="number" 
                                        name="jumlah" 
                                        id="jumlah" 
                                        min="{{ $product->min_increment ?? 1 }}" 
                                        max="{{ $product->stock }}"
                                        value="{{ old('jumlah', $jumlah ?? ($product->min_increment ?? 1)) }}"
                                        step="{{ $product->min_increment ?? 1 }}"
                                        required
                                        class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <label class="text-sm font-medium text-gray-700">Total Harga</label>
                                        <div id="totalHarga" class="font-bold text-green-700 text-lg">
                                            @php
                                                $initialQty = $jumlah ?? 1;
                                                $breakdown = $product->getBundleBreakdown($initialQty);
                                                
                                                if ($breakdown['bundles'] > 0) {
                                                    echo 'Rp ' . number_format($breakdown['total'], 0, ',', '.') . 
                                                         '<br><span class="text-sm text-orange-600">Bundle: ' . $breakdown['bundles'] . 'x' . $product->bundle_quantity;
                                                    if ($breakdown['remaining'] > 0) {
                                                        echo ' + ' . $breakdown['remaining'] . ' satuan';
                                                    }
                                                    echo '</span>';
                                                } else {
                                                    echo 'Rp ' . number_format($breakdown['total'], 0, ',', '.');
                                                }
                                            @endphp
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300 transform hover:scale-105">
                                        Pesan Sekarang
                                    </button>
                                </form>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                            <p class="text-red-800 font-medium">Maaf, stok produk ini sedang habis</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes slideRight {
    from { transform: translateX(-20px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideLeft {
    from { transform: translateX(20px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.animate-fade-in {
    animation: fadeIn 1s ease-out forwards;
}

.animate-slide-down {
    animation: slideDown 1s ease-out forwards;
}

.animate-slide-right {
    animation: slideRight 1s ease-out forwards;
}

.animate-slide-left {
    animation: slideLeft 1s ease-out forwards;
}

.form-input, .form-textarea {
    transition: all 0.3s ease;
}

.form-input:focus, .form-textarea:focus {
    transform: translateY(-2px);
}

button[type="submit"] {
    transition: all 0.3s ease;
}

button[type="submit"]:active {
    transform: scale(0.95);
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const jumlahInput = document.getElementById('jumlah');
    const cartQuantityInput = document.getElementById('cart_quantity');
    const maxStock = {{ $product->stock }};
    
    if (jumlahInput) {
        jumlahInput.addEventListener('input', () => {
            if (parseInt(jumlahInput.value) > maxStock) {
                jumlahInput.value = maxStock;
            }
        });
    }

    if (cartQuantityInput) {
        cartQuantityInput.addEventListener('input', () => {
            if (parseInt(cartQuantityInput.value) > maxStock) {
                cartQuantityInput.value = maxStock;
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const jumlahInput = document.getElementById('jumlah');
    const totalHargaDiv = document.getElementById('totalHarga');
    const hargaProduk = {{ $product->price }};
    const hasBundle = {{ $product->hasBundle() ? 'true' : 'false' }};
    const bundleQuantity = {{ $product->bundle_quantity ?? 0 }};
    const bundlePrice = {{ $product->bundle_price ?? 0 }};
    
    if(jumlahInput && totalHargaDiv) {
        function updateTotal() {
            var qty = parseInt(jumlahInput.value) || 1;
            var total = 0;
            
            if (hasBundle && bundleQuantity > 0) {
                // Calculate bundle pricing
                var completeBundles = Math.floor(qty / bundleQuantity);
                var remainingItems = qty % bundleQuantity;
                
                var bundleTotal = completeBundles * bundlePrice;
                var regularTotal = remainingItems * hargaProduk;
                total = bundleTotal + regularTotal;
                
                // Show bundle info if applicable
                if (completeBundles > 0) {
                    let bundleText = 'Bundle: ' + completeBundles + 'x' + bundleQuantity;
                    if (remainingItems > 0) {
                        bundleText += ' + ' + remainingItems + ' satuan';
                    }
                    totalHargaDiv.innerHTML = 'Rp ' + total.toLocaleString('id-ID') + 
                        '<br><span class="text-sm text-orange-600">' + bundleText + '</span>';
                } else {
                    totalHargaDiv.textContent = 'Rp ' + total.toLocaleString('id-ID');
                }
            } else {
                total = hargaProduk * qty;
                totalHargaDiv.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
        }
        jumlahInput.addEventListener('input', updateTotal);
        updateTotal();
    }
});


</script>
@endpush
@endsection