@extends('layouts.app')

@section('title', 'Gallery Management')

@section('content')
<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes scaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @keyframes zoomIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .animate-slide-up {
        animation: slideUp 0.6s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .animate-scale-in {
        animation: scaleIn 0.6s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .animate-zoom-in {
        animation: zoomIn 0.6s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .stats-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 24px;
        transition: transform 0.3s ease;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.1);
    }

    .gallery-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .gallery-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .gallery-image-container {
        position: relative;
        overflow: hidden;
        padding-top: 75%; /* 4:3 Aspect Ratio */
    }

    .gallery-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-card:hover .gallery-image {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-actions {
        display: flex;
        gap: 0.75rem;
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }

    .gallery-card:hover .gallery-actions {
        transform: translateY(0);
    }

    .gallery-actions .btn {
        width: 40px;
        height: 40px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.95);
        color: #333;
        border: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .gallery-actions .btn:hover {
        transform: scale(1.15);
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .gallery-actions .btn:first-child:hover {
        background: #28a745;
        color: white;
    }

    .gallery-actions .btn:nth-child(2):hover {
        background: #007bff;
        color: white;
    }

    .gallery-actions .btn:last-child:hover {
        background: #dc3545;
        color: white;
    }

    .btn {
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .dropdown-menu {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .card {
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border-radius: 1rem;
    }

    .empty-state {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 1rem;
        padding: 3rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 4rem;
        color: #adb5bd;
        margin-bottom: 1.5rem;
    }
</style>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in" style="--delay: 0.1s">
        <div>
            <h1 class="h3 mb-0">Gallery Management</h1>
            <p class="text-muted">Kelola galeri foto dan konten media Anda</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-images me-2"></i>Semua Gambar</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-clock me-2"></i>Upload Terbaru</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>Paling Dilihat</a></li>
                </ul>
            </div>
            <a href="{{ route('dashboard.gallery.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Gambar
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stats-card animate-fade-in" style="--delay: 0.2s">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-images"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Gambar</h6>
                        <h2 class="mb-0">{{ $galleries->total() }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card animate-fade-in" style="--delay: 0.3s">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Dilihat</h6>
                        <h2 class="mb-0">2,345</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card animate-fade-in" style="--delay: 0.4s">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Bulan Ini</h6>
                        <h2 class="mb-0">{{ $galleries->where('created_at', '>=', now()->startOfMonth())->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="row g-4">
        @forelse($galleries as $gallery)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="gallery-card animate-zoom-in" style="--delay: {{ $loop->iteration * 0.1 }}s">
                    <div class="gallery-image-container">
                        <img src="{{ asset('storage/' . $gallery->image) }}" 
                             class="gallery-image" 
                             alt="{{ $gallery->title }}"
                             loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-actions">
                                <a href="{{ asset('storage/' . $gallery->image) }}" 
                                   class="btn" 
                                   data-bs-toggle="tooltip" 
                                   title="Lihat Ukuran Penuh"
                                   target="_blank">
                                    <i class="fas fa-expand"></i>
                                </a>
                                <a href="{{ route('dashboard.gallery.edit', $gallery) }}" 
                                   class="btn" 
                                   data-bs-toggle="tooltip" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.gallery.destroy', $gallery) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn" 
                                            data-bs-toggle="tooltip" 
                                            title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate mb-2">{{ $gallery->title }}</h5>
                        <div class="d-flex align-items-center text-muted">
                            <i class="far fa-calendar-alt me-2"></i>
                            <small>{{ \Carbon\Carbon::parse($gallery->description)->translatedFormat('d F Y') }}</small>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-image me-1"></i>
                                {{ Str::limit($gallery->title, 30) }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state animate-fade-in" style="--delay: 0.5s">
                    <i class="fas fa-images"></i>
                    <h4 class="text-muted mb-3">Belum Ada Gambar</h4>
                    <p class="text-muted mb-4">Mulai menambahkan gambar ke galeri Anda</p>
                    <a href="{{ route('dashboard.gallery.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Gambar Pertama
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
        <div class="d-flex justify-content-center mt-4 animate-fade-in" style="--delay: 0.6s">
            {{ $galleries->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Add loading animation for images
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.gallery-image');
        images.forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        });
    });
</script>
@endpush
@endsection