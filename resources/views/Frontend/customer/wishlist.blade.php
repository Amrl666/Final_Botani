@extends('layouts.frontend')

@section('title', 'Wishlist Saya')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-heart text-red-500 mr-3"></i>
                Wishlist Saya
            </h1>
            <p class="text-gray-600 text-lg">Produk yang Anda simpan untuk dibeli nanti</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3 text-lg"></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-3 text-lg"></i>
                <p class="text-blue-800 font-medium">{{ session('info') }}</p>
            </div>
        @endif

        @if($wishlist->count() > 0)
            <!-- Wishlist Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlist as $product)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Product Image -->
                        <div class="relative">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-box text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                            
                            <!-- Featured Badge -->
                            @if($product->featured)
                                <div class="absolute top-3 left-3 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                                    <i class="fas fa-star mr-1"></i>
                                    Featured
                                </div>
                            @endif
                            
                            <!-- Remove Button -->
                            <div class="absolute top-3 right-3">
                                <form action="{{ route('customer.wishlist.remove', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-colors duration-200 shadow-lg"
                                            onclick="return confirm('Hapus dari wishlist?')">
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Stock Status -->
                            <div class="absolute bottom-3 left-3">
                                @if($product->stock <= 0)
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Habis
                                    </span>
                                @elseif($product->stock <= 10)
                                    <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Stok Menipis
                                    </span>
                                @else
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Tersedia
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Product Content -->
                        <div class="p-6">
                            <!-- Product Info -->
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                            </div>
                            
                            <!-- Price and Unit -->
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="text-2xl font-bold text-green-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm text-gray-500 ml-1">
                                        / {{ $product->unit }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-600">
                                        Stok: {{ $product->stock }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $product->unit }}
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="{{ $product->min_increment }}">
                                        <button type="submit" 
                                                class="w-full bg-green-600 text-white py-3 px-4 rounded-xl hover:bg-green-700 transition-colors duration-200 font-semibold flex items-center justify-center">
                                            <i class="fas fa-shopping-cart mr-2"></i>
                                            Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button disabled 
                                            class="w-full bg-gray-400 text-white py-3 px-4 rounded-xl cursor-not-allowed font-semibold flex items-center justify-center">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        Stok Habis
                                    </button>
                                @endif

                                <a href="{{ route('product.show', $product) }}" 
                                   class="block w-full text-center bg-blue-600 text-white py-3 px-4 rounded-xl hover:bg-blue-700 transition-colors duration-200 font-semibold flex items-center justify-center">
                                    <i class="fas fa-eye mr-2"></i>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($wishlist->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $wishlist->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-3xl text-red-500"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Wishlist Kosong</h3>
                <p class="text-gray-600 mb-6">Anda belum menambahkan produk ke wishlist.</p>
                <a href="{{ route('product.index_fr') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>

<style>
/* Custom pagination styles */
.pagination {
    @apply flex items-center space-x-1;
}

.pagination .page-item {
    @apply inline-flex;
}

.pagination .page-link {
    @apply px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors;
}

.pagination .page-item.active .page-link {
    @apply bg-green-600 border-green-600 text-white hover:bg-green-700;
}

.pagination .page-item.disabled .page-link {
    @apply text-gray-400 cursor-not-allowed hover:bg-white hover:text-gray-400;
}

/* Line clamp utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 