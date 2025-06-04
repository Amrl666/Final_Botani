@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Prestasi</h1>
        <button type="submit" class="btn btn-primary">Update</button>

        <a href="{{ route('dashboard.prestasi.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
    
    <form action="{{ route('dashboard.prestasi.update', $prestasi) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input 
                type="text" 
                class="form-control @error('title') is-invalid @enderror" 
                id="title" 
                name="title" 
                value="{{ old('title', $prestasi->title) }}" 
                required
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input 
                type="file" 
                class="form-control @error('image') is-invalid @enderror" 
                id="image" 
                name="image"
            >
            @if($prestasi->image)
                <img src="{{ asset('storage/' . $prestasi->image) }}" alt="{{ $prestasi->title }}" width="100" class="mt-2">
            @endif
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea 
                class="form-control @error('content') is-invalid @enderror" 
                id="content" 
                name="content" 
                rows="5" 
                required
            >{{ old('content', $prestasi->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
    </form>
</div>
@endsection
