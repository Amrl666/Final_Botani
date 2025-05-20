@extends('layouts.app')

@section('title', 'Edit Eduwisata')

@section('content')
<div class="container">
    <h1>Edit Eduwisata</h1>
    
    <form action="{{ route('dashboard.eduwisata.update', $eduwisata->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $eduwisata->name }}" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $eduwisata->description }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $eduwisata->location }}" required>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($eduwisata->image)
                <img src="{{ asset('storage/' . $eduwisata->image) }}" alt="{{ $eduwisata->name }}" width="100" class="mt-2">
            @endif
        </div>
        
        <button type="submit" class="btn btn-primary">Update Eduwisata</button>
    </form>
</div>
@endsection