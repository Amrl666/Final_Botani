@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gallery Items</h1>
        <a href="{{ route('dashboard.gallery.create') }}" class="btn btn-primary">Add New Item</a>
    </div>

    <div class="row">
        @foreach($galleries as $gallery)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top" alt="{{ $gallery->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $gallery->title }}</h5>
                    <p class="card-text">{{ Str::limit($gallery->description, 100) }}</p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard.gallery.edit', $gallery) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('dashboard.gallery.destroy', $gallery) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $galleries->links() }}
</div>
@endsection