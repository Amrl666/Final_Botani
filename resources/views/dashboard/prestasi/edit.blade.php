@extends('layouts.app')

@section('title', 'Edit Prestasi')

@section('content')
<div class="container">
    <h1>Edit Prestasi</h1>
    
    <form action="{{ route('dashboard.prestasi.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="id" value="{{ $prestasi->id }}">
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $prestasi->title }}" required>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($prestasi->image)
                <img src="{{ asset('storage/' . $prestasi->image) }}" alt="{{ $prestasi->title }}" width="100" class="mt-2">
            @endif
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ $prestasi->content }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection