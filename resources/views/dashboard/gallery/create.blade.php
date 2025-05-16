@extends('layouts.app')

@section('title', 'Add Gallery Item')

@section('content')
<div class="container">
    <h1>Add New Gallery Item</h1>
    
    <form action="{{ route('dashboard.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
</div>
@endsection