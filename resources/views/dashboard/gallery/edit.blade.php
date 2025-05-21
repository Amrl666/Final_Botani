@extends('layouts.app')

@section('title', 'Edit Gallery Item')

@section('content')
<div class="container">
    <h1>Edit Gallery Item</h1>
    
    <form action="{{ route('dashboard.gallery.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="id" value="{{ $gallery->id }}">
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $gallery->title }}" required>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($gallery->image)
                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" width="200" class="mt-2">
            @endif
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Tanggal Galeri</label>
            <input type="date" class="form-control" id="description" name="description" value="{{ old('description', isset($gallery) ? $gallery->description : '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection