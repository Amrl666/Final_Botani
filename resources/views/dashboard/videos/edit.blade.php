@extends('layouts.app')

@section('title', 'Edit Video')

@section('content')
<div class="container">
    <h1>Edit Video</h1>
    
    <form action="{{ route('dashboard.videos.update', $video) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $video->title }}" required>
        </div>
        
        <div class="mb-3">
            <label for="video" class="form-label">Video URL</label>
            <input type="url" class="form-control" id="video" name="video" value="{{ $video->video }}" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $video->description }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Video</button>
    </form>
</div>
@endsection