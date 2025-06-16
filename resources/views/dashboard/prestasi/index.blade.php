@extends('layouts.app')

@section('title', 'Achievement Management')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Achievement Management</h1>
            <p class="text-muted">Manage and showcase your achievements and awards</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">All Achievements</a></li>
                    <li><a class="dropdown-item" href="#">Recent Awards</a></li>
                    <li><a class="dropdown-item" href="#">By Category</a></li>
                </ul>
            </div>
            <a href="{{ route('dashboard.prestasi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Achievement
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
                                <i class="fas fa-trophy"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Achievements</h6>
                            <h2 class="card-title mb-0">{{ $prestasis->total() }}</h2>
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
                                <i class="fas fa-medal"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">This Year</h6>
                            <h2 class="card-title mb-0">{{ $prestasis->where('year', date('Y'))->count() }}</h2>
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
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Featured</h6>
                            <h2 class="card-title mb-0">{{ $prestasis->where('is_featured', true)->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements Grid -->
    <div class="row g-4">
        @forelse($prestasis as $prestasi)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 achievement-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="achievement-icon me-3">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">{{ $prestasi->title }}</h5>
                                <p class="text-muted small mb-0">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $prestasi->year }}
                                </p>
                            </div>
                        </div>
                        <p class="card-text">{{ Str::limit($prestasi->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="achievement-meta">
                                <span class="badge bg-primary">{{ $prestasi->category }}</span>
                                @if($prestasi->is_featured)
                                    <span class="badge bg-warning">Featured</span>
                                @endif
                            </div>
                            <div class="achievement-actions">
                                <a href="{{ route('dashboard.prestasi.edit', $prestasi) }}" 
                                   class="btn btn-sm btn-light" 
                                   data-bs-toggle="tooltip" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.prestasi.destroy', $prestasi) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-light" 
                                            data-bs-toggle="tooltip" 
                                            title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this achievement?')">
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
                            <i class="fas fa-trophy fa-3x text-muted"></i>
                        </div>
                        <h4 class="text-muted">No Achievements Yet</h4>
                        <p class="text-muted mb-4">Start adding your achievements and awards</p>
                        <a href="{{ route('dashboard.prestasi.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add First Achievement
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $prestasis->links() }}
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

.achievement-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.achievement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.achievement-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bs-primary);
    color: white;
    border-radius: 12px;
    font-size: 24px;
}

.achievement-meta {
    display: flex;
    gap: 0.5rem;
}

.achievement-actions {
    display: flex;
    gap: 0.5rem;
}

.achievement-actions .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: transform 0.2s ease;
}

.achievement-actions .btn:hover {
    transform: scale(1.1);
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection
