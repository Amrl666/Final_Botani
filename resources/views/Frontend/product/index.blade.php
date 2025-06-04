@extends('layouts.frontend')

@section('title', 'Produk Terbaik')

@section('content')
<section class="py-6 px-4 max-w-7xl mx-auto">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">PRODUK TERBAIK</h2>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($products as $product)
        <a href="{{ route('product.show', $product->id) }}" class="group">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-200 flex flex-col justify-between h-full">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-20 object-cover">
                @endif

                <div class="p-2 space-y-1">
                    <p class="text-xs text-green-600 font-semibold">Rp {{ number_format($product->price, 0) }}/Kg</p>
                    <h6 class="text-sm font-medium text-gray-800 leading-tight truncate">{{ $product->name }}</h6>
                </div>

                <div class="px-2 pb-2 mt-auto flex justify-between items-center">
                    <a href="{{ route('product.show', $product->id) }}"
                       class="text-xs bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md transition duration-200">
                        Beli Sekarang
                    </a>
                    <button class="text-green-600 hover:text-green-700">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-6 flex justify-center">
        {{ $products->links() }}
    </div>
</section>
@endsection
