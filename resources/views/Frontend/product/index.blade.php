@extends('layouts.frontend')

@section('title', 'Produk Terbaik')

@section('content')
<section class="py-5">
    <div class="row mb-5">
    <div class="col-12 text-center">
        <h2 class="fw-bold">PRODUK TERBAIK</h2>
    </div>
    </div>
            @foreach($products as $product)
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                    @endif
                    <div class="card-body p-3">
                        <p class="fw-bold mb-1 text-success">Rp {{ number_format($product->price, 0) }}/Kg</p>
                        <h6 class="mb-1">{{ $product->name }}</h6>
                        <div class="d-flex align-items-center mb-1">
                            <div class="text-warning me-1">
                                ★★★★☆
                            </div>
                            <small class="text-muted">4.0</small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-end">
                        <button class="btn btn-outline-success btn-sm rounded-circle">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</section>
@endsection
