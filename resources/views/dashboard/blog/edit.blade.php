@extends('layouts.app')

@section('title', 'Edit Blog Post')

@section('content')
<div class="container">
    <h1>Edit Blog Post</h1>
    
    <form action="{{ route('dashboard.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}" required>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="100" class="mt-2">
            @endif
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ $blog->content }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</div>
@endsection