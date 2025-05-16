@extends('layouts.frontend')

@section('title', 'Our Products')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="mb-5">Our Products</h1>
        
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                        <p class="fw-bold">Rp {{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-success">Add to Cart</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{ $products->links() }}
    </div>
</section>
@endsection