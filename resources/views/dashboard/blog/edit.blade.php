@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Blog Post</h1>
        <div>
            <button form="editPostForm" type="submit" class="btn btn-primary me-2">Simpan</button>
            <a href="{{ route('dashboard.blog.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </div>
    
    <form id="editPostForm" action="{{ route('dashboard.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input 
                type="text" 
                class="form-control @error('title') is-invalid @enderror" 
                id="title" 
                name="title" 
                value="{{ old('title', $blog->title) }}" 
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
                accept="image/*"
            >
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="240" class="mt-3 rounded">
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
                rows="6" 
                required
            >{{ old('content', $blog->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </form>
</div>
@endsection
