@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Blog Posts</h1>
        <a href="{{ route('dashboard.blog.create') }}" class="btn btn-primary">Create New Post</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                <tr>
                    <td>{{ $blog->title }}</td>
                    <td>
                        @if($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="50">
                        @endif
                    </td>
                    <td>{{ $blog->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('dashboard.blog.edit', $blog) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('dashboard.blog.destroy', $blog) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $blogs->links() }}
</div>
@endsection