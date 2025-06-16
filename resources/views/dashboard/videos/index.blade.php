@extends('layouts.app')

@section('title', 'Video Management')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Video Management</h1>
            <p class="text-muted">Manage and organize your video content</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">All Videos</a></li>
                    <li><a class="dropdown-item" href="#">Recent Uploads</a></li>
                    <li><a class="dropdown-item" href="#">Most Viewed</a></li>
                </ul>
            </div>
            <a href="{{ route('dashboard.videos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Video
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
                                <i class="fas fa-video"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Videos</h6>
                            <h2 class="card-title mb-0">{{ $videos->total() }}</h2>
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
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Views</h6>
                            <h2 class="card-title mb-0">1,234</h2>
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
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Duration</h6>
                            <h2 class="card-title mb-0">2h 30m</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Videos Grid -->
    <div class="row g-4">
        @forelse($videos as $video)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 video-card">
                    <div class="video-thumbnail-container">
                        <img src="{{ $video->thumbnail ?? 'https://via.placeholder.com/640x360' }}" 
                             class="card-img-top video-thumbnail" 
                             alt="{{ $video->title }}">
                        <div class="video-duration">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div class="video-overlay">
                            <div class="video-actions">
                                <a href="{{ $video->url }}" 
                                   class="btn btn-light btn-sm" 
                                   data-bs-toggle="tooltip" 
                                   title="Watch Video"
                                   target="_blank">
                                    <i class="fas fa-play"></i>
                                </a>
                                <a href="{{ route('dashboard.videos.edit', $video) }}" 
                                   class="btn btn-light btn-sm" 
                                   data-bs-toggle="tooltip" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.videos.destroy', $video) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-light btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this video?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $video->title }}</h5>
                        <p class="card-text text-muted small mb-2">
                            {{ Str::limit($video->description, 100) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="video-meta">
                                <span class="badge bg-primary">{{ $video->category }}</span>
                                <small class="text-muted ms-2">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $video->created_at->format('d M Y') }}
                                </small>
                            </div>
                            <div class="video-views">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>
                                    {{ number_format($video->views ?? 0) }}
                                </small>
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
                            <i class="fas fa-video fa-3x text-muted"></i>
                        </div>
                        <h4 class="text-muted">No Videos Yet</h4>
                        <p class="text-muted mb-4">Start adding videos to your collection</p>
                        <a href="{{ route('dashboard.videos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add First Video
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $videos->links() }}
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

.video-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.video-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.video-thumbnail-container {
    position: relative;
    overflow: hidden;
    padding-top: 56.25%; /* 16:9 Aspect Ratio */
}

.video-thumbnail {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-duration {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 14px;
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.video-card:hover .video-overlay {
    opacity: 1;
}

.video-actions {
    display: flex;
    gap: 0.5rem;
}

.video-actions .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    transition: transform 0.2s ease;
}

.video-actions .btn:hover {
    transform: scale(1.1);
    background: #fff;
}

.video-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
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