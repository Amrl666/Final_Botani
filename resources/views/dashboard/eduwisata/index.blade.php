@extends('layouts.app')

@section('title', 'Eduwisata Management')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Eduwisata Management</h1>
            <p class="text-muted">Manage educational tourism programs and schedules</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.eduwisata.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Program
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Programs</h6>
                            <h2 class="card-title mb-0">{{ $eduwisatas->total() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Active Schedules</h6>
                            <h2 class="card-title mb-0">12</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Participants</h6>
                            <h2 class="card-title mb-0">156</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Programs Grid -->
    <div class="row g-4">
        @forelse($eduwisatas as $eduwisata)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 program-card">
                    @if($eduwisata->image)
                        <img src="{{ asset('storage/' . $eduwisata->image) }}" 
                             alt="{{ $eduwisata->name }}" 
                             class="card-img-top program-image">
                    @else
                        <div class="card-img-top program-image-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $eduwisata->name }}</h5>
                            <span class="badge bg-primary">{{ $eduwisata->schedules->count() }} Schedules</span>
                        </div>
                        <p class="card-text text-muted">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $eduwisata->location }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('dashboard.eduwisata.schedule', $eduwisata) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-calendar-alt me-2"></i>View Schedules
                            </a>
                            <div class="btn-group">
                                <a href="{{ route('dashboard.eduwisata.edit', $eduwisata->id) }}" 
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.eduwisata.destroy', $eduwisata->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Are you sure you want to delete this program?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-map-marked-alt fa-3x text-muted"></i>
                        </div>
                        <h4 class="text-muted">No Programs Yet</h4>
                        <p class="text-muted mb-4">Start creating your first educational tourism program</p>
                        <a href="{{ route('dashboard.eduwisata.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create First Program
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $eduwisatas->links() }}
    </div>
</div>

<style>
.stats-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 24px;
}

.program-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.program-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.program-image {
    height: 200px;
    object-fit: cover;
}

.program-image-placeholder {
    height: 200px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 2rem;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

.btn-group .btn i {
    font-size: 0.875rem;
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>
@endsection
