@extends('layouts.frontend')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Wishlist Saya
                    </h3>
                    @if($wishlist->isNotEmpty())
                        <form action="{{ route('wishlist.clear') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Yakin ingin mengosongkan wishlist?')"
                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                                Kosongkan Wishlist
                            </button>
                        </form>
                    @endif
                </div>

                @if($wishlist->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Wishlist kosong</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai menambahkan produk ke wishlist Anda.</p>
                        <div class="mt-6">
                            <a href="{{ route('product.index_fr') }}" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Produk
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($wishlist as $product)
                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif

                                <div class="p-4">
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">{{ $product->name }}</h4>
                                    <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $product->description }}</p>
                                    
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-lg font-bold text-gray-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ $product->unit }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-sm text-gray-500">
                                            Stok: {{ $product->stock }} {{ $product->unit }}
                                        </span>
                                        @if($product->stock <= 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Habis
                                            </span>
                                        @elseif($product->stock <= 10)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Stok Menipis
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Tersedia
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex space-x-2">
                                        @if($product->stock > 0)
                                            <a href="{{ route('product.order_now', $product) }}" 
                                               class="flex-1 bg-green-600 text-white py-2 px-3 rounded-md text-sm font-medium hover:bg-green-700 transition-colors text-center">
                                                Beli Sekarang
                                            </a>
                                        @else
                                            <button disabled 
                                                    class="flex-1 bg-gray-300 text-gray-500 py-2 px-3 rounded-md text-sm font-medium cursor-not-allowed">
                                                Stok Habis
                                            </button>
                                        @endif
                                        
                                        <form action="{{ route('wishlist.remove', $product) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="bg-red-600 text-white p-2 rounded-md hover:bg-red-700 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $wishlist->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 