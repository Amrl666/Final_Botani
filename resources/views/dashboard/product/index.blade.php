@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-md mx-auto mt-10">
  <div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Gambar Produk -->
    <div class="h-64 w-full overflow-hidden">
      @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
      @else
        <div class="flex items-center justify-center h-full bg-gray-100 text-gray-400">
          No Image Available
        </div>
      @endif
    </div>

    <!-- Isi Card -->
    <div class="p-6 space-y-4">
      <h2 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h2>
      <p class="text-sm text-gray-500">{{ $product->category ?? 'Uncategorized' }}</p>

      <p class="text-gray-700 leading-relaxed">
        {{ $product->description ?? 'No description available.' }}
      </p>

      <div class="flex justify-between items-center mt-4">
        <span class="text-xl font-semibold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
        <span class="text-sm font-medium {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
          {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Stok Habis' }}
        </span>
      </div>

      <div>
        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
          {{ $product->featured ? 'bg-yellow-300 text-yellow-900' : 'bg-gray-200 text-gray-600' }}">
          {{ $product->featured ? 'Featured' : 'Regular' }}
        </span>
      </div>

      <button
        class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-md transition duration-300
        disabled:opacity-50 disabled:cursor-not-allowed"
        {{ $product->stock > 0 ? '' : 'disabled' }}>
        {{ $product->stock > 0 ? 'Beli Sekarang' : 'Stok Habis' }}
      </button>
    </div>
  </div>
</div>
@endsection
