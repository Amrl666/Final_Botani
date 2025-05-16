@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container">
    <h1>Edit Product</h1>
    
    <form action="{{ route('dashboard.product.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $product->description }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100" class="mt-2">
            @endif
        </div>
        
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
        </div>
        
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="featured" name="featured" {{ $product->featured ? 'checked' : '' }}>
            <label class="form-check-label" for="featured">Featured Product</label>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection