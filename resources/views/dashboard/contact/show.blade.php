@extends('layouts.app')

@section('title', 'Message Details')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Message from: {{ $contact->name }}</h2>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Email:</strong> {{ $contact->email }}
            </div>
            <div class="mb-3">
                <strong>Subject:</strong> {{ $contact->subject }}
            </div>
            <div class="mb-3">
                <strong>Message:</strong>
                <p>{{ $contact->message }}</p>
            </div>
            <div class="text-muted">
                Received on: {{ $contact->created_at->format('F j, Y \a\t g:i a') }}
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('dashboard.contact.messages') }}" class="btn btn-secondary">Back to Messages</a>
        </div>
    </div>
</div>
@endsection