@extends('layouts.app')

@section('title', 'Contact Messages')

@section('content')
<div class="container">
    <h1>Contact Messages</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ Str::limit($contact->subject, 50) }}</td>
                    <td>{{ $contact->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('dashboard.contact.show', $contact) }}" class="btn btn-sm btn-info">View</a>
                        <form action="{{ route('dashboard.contact.destroy', $contact) }}" method="POST" class="d-inline">
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

    {{ $contacts->links() }}
</div>
@endsection