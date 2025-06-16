@extends('layouts.app')

@section('title', 'Message Details')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Message Details</h1>
            <p class="text-muted">View and manage message details</p>
        </div>
        <div class="d-flex gap-2">
            <a href="mailto:{{ $contact->email }}" class="btn btn-primary">
                <i class="fas fa-reply me-2"></i>Reply
            </a>
            <a href="{{ route('dashboard.contact.messages') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Messages
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Message Details -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-3">
                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $contact->name }}</h5>
                            <p class="text-muted mb-0">{{ $contact->email }}</p>
                        </div>
                    </div>

                    <div class="message-header mb-4">
                        <h4 class="mb-2">{{ $contact->subject }}</h4>
                        <div class="d-flex align-items-center text-muted">
                            <i class="far fa-clock me-2"></i>
                            {{ $contact->created_at->format('F j, Y \a\t g:i a') }}
                        </div>
                    </div>

                    <div class="message-content">
                        <div class="card bg-light">
                            <div class="card-body">
                                {{ $contact->message }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Actions -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Message Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-check me-2"></i>Mark as Read
                        </button>
                        <button class="btn btn-outline-success">
                            <i class="fas fa-star me-2"></i>Mark as Important
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="fas fa-archive me-2"></i>Archive Message
                        </button>
                        <form action="{{ route('dashboard.contact.destroy', $contact) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this message?')">
                                <i class="fas fa-trash me-2"></i>Delete Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Message Info -->
            <div class="card mt-4">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Message Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Status</span>
                            <span class="badge bg-warning">Unread</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Message ID</span>
                            <span class="text-dark">#{{ $contact->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">IP Address</span>
                            <span class="text-dark">192.168.1.1</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Browser</span>
                            <span class="text-dark">Chrome</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 20px;
}

.message-content {
    font-size: 1rem;
    line-height: 1.6;
}

.list-group-item {
    border: none;
    padding: 0.75rem 0;
}

.list-group-item:not(:last-child) {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.btn {
    padding: 0.5rem 1rem;
    font-weight: 500;
}

.btn i {
    width: 16px;
}
</style>
@endsection