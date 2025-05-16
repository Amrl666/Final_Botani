@extends('layouts.app')

@section('title', 'Add Video')

@section('content')
<div class="container">
    <h1>Add New Video</h1>
    
    <form action="{{ route('dashboard.videos.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        
        <div class="mb-3">
            <label for="video" class="form-label">Video URL</label>
            <input type="url" class="form-control" id="video" name="video" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Video</button>
    </form>
</div>
@endsection