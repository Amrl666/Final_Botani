@extends('layouts.app')

@section('title', 'Eduwisata')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Eduwisata</h1>
        <a href="{{ route('dashboard.eduwisata.create') }}" class="btn btn-primary">Add New</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Image</th>
                    <th>Schedules</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eduwisatas as $eduwisata)
                <tr>
                    <td>{{ $eduwisata->name }}</td>
                    <td>{{ $eduwisata->location }}</td>
                    <td>
                        @if($eduwisata->image)
                            <img src="{{ asset('storage/' . $eduwisata->image) }}" alt="{{ $eduwisata->name }}" width="50">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('dashboard.eduwisata.schedule', $eduwisata) }}" class="btn btn-sm btn-info">
                            Schedules ({{ $eduwisata->schedules->count() }})
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('dashboard.eduwisata.edit', $eduwisata) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('dashboard.eduwisata.destroy', $eduwisata) }}" method="POST" class="d-inline">
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

    {{-- Pagination --}}
    {{ $eduwisatas->links() }}
</div>
@endsection
