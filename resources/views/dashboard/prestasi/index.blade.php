@extends('layouts.app')

@section('title', 'Prestasi')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Prestasi</h1>
        <a href="{{ route('dashboard.prestasi.create') }}" class="btn btn-primary">Create New</a>
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
                @foreach($prestasis as $prestasi)
                <tr>
                    <td>{{ $prestasi->title }}</td>
                    <td>
                        @if($prestasi->image)
                            <img src="{{ asset('storage/' . $prestasi->image) }}" alt="{{ $prestasi->title }}" width="50">
                        @endif
                    </td>
                    <td>{{ $prestasi->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('dashboard.prestasi.edit', $prestasi) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('dashboard.prestasi.destroy', $prestasi) }}" method="POST" class="d-inline">
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

    {{ $prestasis->links() }}
</div>
@endsection