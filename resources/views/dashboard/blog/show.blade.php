@extends('layouts.app')

@section('title', $blog->title)

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>{{ $blog->title }}</h1>
        </div>
        <div class="card-body">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid mb-4">
            @endif
            
            <div class="content">
                {!! nl2br(e($blog->content)) !!}
            </div>
        </div>
        <div class="card-footer text-muted">
            Posted on {{ $blog->created_at->format('F j, Y') }}
        </div>
    </div>
    
    <a href="{{ route('dashboard.blog.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection