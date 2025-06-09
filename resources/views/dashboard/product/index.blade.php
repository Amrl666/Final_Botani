@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<style>
  .productContainer {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    padding: 20px 0;
  }

  .productCard {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s ease;
  }

  .productCard:hover {
    transform: scale(1.03);
  }

  .productImage {
    width: 100%;
    height: 160px;
    object-fit: cover;
  }

  .productContent {
    padding: 15px 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .productTitle {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d3748; /* gray-800 */
    margin-bottom: 8px;
  }

  .productCategory {
    font-size: 0.9rem;
    color: #718096; /* gray-500 */
    margin-bottom: 12px;
  }

  .productPriceStock {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
  }

  .productPrice {
    font-weight: 600;
    color: #3182ce; /* blue-600 */
  }

  .productStock {
    font-weight: 600;
  }

  .text-green {
    color: #38a169; /* green-600 */
  }

  .text-red {
    color: #e53e3e; /* red-600 */
  }

  .productActions {
    display: flex;
    gap: 10px;
  }

  .btn-edit {
    background-color: #f6ad55; /* orange-400 */
    color: white;
    padding: 6px 12px;
    border-radius: 0.375rem;
    border: none;
    cursor: pointer;
    font-weight: 600;
    flex: 1;
    text-align: center;
    text-decoration: none;
  }

  .btn-edit:hover {
    background-color: #dd6b20; /* orange-600 */
  }

  .btn-delete {
    background-color: #fc8181; /* red-400 */
    color: white;
    padding: 6px 12px;
    border-radius: 0.375rem;
    border: none;
    cursor: pointer;
    font-weight: 600;
    flex: 1;
  }

  .btn-delete:hover {
    background-color: #c53030; /* red-700 */
  }
</style>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4 px-4">
    <h1>Daftar Produk</h1>
    <a href="{{ route('dashboard.product.create') }}" class="btn btn-primary">Tambah Produk Baru</a>
  </div>

  @if($products->count() == 0)
    <p class="text-center text-gray-600">Belum ada produk.</p>
  @else
    <div class="productContainer">
      @foreach($products as $product)
        <div class="productCard">
          @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="productImage" />
          @else
            <div class="productImage" style="background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #718096;">
              No Image
            </div>
          @endif
          <div class="productContent">
            <div>
              <h2 class="productTitle">{{ $product->name }}</h2>
              <p class="productCategory">{{ $product->category ?? 'Uncategorized' }}</p>
              <div class="productPriceStock">
                <span class="productPrice">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="productStock {{ $product->stock > 0 ? 'text-green' : 'text-red' }}">
                  {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Stok Habis' }}
                </span>
              </div>
            </div>
            <div class="productActions">
              <a href="{{ route('dashboard.product.edit', $product) }}" class="btn-edit">Edit</a>
              <form action="{{ route('dashboard.product.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');" style="flex:1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">Hapus</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-8 px-4">
      {{ $products->links() }}
    </div>
  @endif
</div>
@endsection
