@extends('layouts.app')

@section('title', 'Videos')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Videos</h1>
        <a href="{{ route('dashboard.videos.create') }}" class="btn btn-primary">Add New Video</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Video</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($videos as $video)
                <tr>
                    <td>{{ $video->title }}</td>
                    <td>{{ Str::limit($video->video, 50) }}</td>
                    <td>
                        <a href="{{ route('dashboard.videos.edit', $video) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('dashboard.videos.destroy', $video) }}" method="POST" class="d-inline">
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

    {{ $videos->links() }}
</div>
@endsection