@extends('layouts.app')

@section('title', 'Manajemen Video')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Manajemen Video</h1>
            <p class="text-muted">Kelola video dan konten multimedia</p>
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
                <i class="fas fa-plus me-2"></i>Tambah Video
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 animate-fade-in" style="--delay: 0.1s">
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
            <div class="card h-100 animate-fade-in" style="--delay: 0.2s">
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
            <div class="card h-100 animate-fade-in" style="--delay: 0.3s">
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
            <div class="col-md-6 col-lg-4 animate-slide-up" style="--delay: {{ $loop->iteration * 0.1 }}s">
                <div class="card h-100 video-card">
                    <div class="video-thumbnail-container">
                        <video class="w-100" controls preload="metadata" poster="https://via.placeholder.com/640x360" style="background:#000; min-height:180px;">
                            <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="video-duration">
                            <i class="fas fa-play-circle"></i>
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
                            <div class="video-actions">
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
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 animate-fade-in" style="--delay: 0.5s">
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
/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fade-in {
    opacity: 0;
    animation: fadeIn 0.6s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.animate-slide-up {
    opacity: 0;
    animation: slideUp 0.6s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.animate-scale-in {
    animation: scaleIn 0.6s ease-out forwards;
}

/* Stats Icons */
.stats-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 24px;
    transition: all 0.3s ease;
}

.stats-icon:hover {
    transform: scale(1.1);
}

/* Video Cards */
.video-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    position: relative;
}

.video-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.video-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
    transition: left 0.5s ease;
    z-index: 1;
}

.video-card:hover::before {
    left: 100%;
}

.video-thumbnail-container {
    position: relative;
    overflow: hidden;
    padding-top: 56.25%; /* 16:9 Aspect Ratio */
}
.video-thumbnail-container video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
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
    z-index: 2;
}
.video-overlay {
    position: absolute;
    bottom: 10px;
    left: 10px;
    z-index: 3;
    background: rgba(255,255,255,0.85);
    border-radius: 8px;
    padding: 4px 8px;
    display: flex;
    gap: 0.5rem;
    opacity: 1;
    align-items: center;
    pointer-events: auto;
}
.video-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

/* Badge Styles */
.badge {
    font-weight: 500;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.bg-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
}

/* Card Styles */
.card {
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border-radius: 1rem;
    overflow: hidden;
}

.card-body {
    padding: 1.5rem;
}

/* Button Styles */
.btn {
    border-radius: 0.5rem;
    padding: 0.625rem 1.25rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(5, 150, 105, 0.3);
}

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    background: transparent;
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .video-actions .btn {
        width: 35px;
        height: 35px;
    }
    
    .video-duration {
        font-size: 12px;
        padding: 2px 6px;
    }
}

/* Loading States */
.loading {
    position: relative;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 1rem;
    height: 1rem;
    margin: -0.5rem 0 0 -0.5rem;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Focus styles for accessibility */
.video-actions .btn:focus,
.btn:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}
</style>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Add loading states to forms
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                }
            });
        });

        // Add hover effects to video cards
        const videoCards = document.querySelectorAll('.video-card');
        videoCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('.animate-fade-in, .animate-slide-up').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endpush
@endsection