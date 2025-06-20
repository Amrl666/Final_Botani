@extends('layouts.app')

@section('title', 'Galeri Kegiatan')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="gallery-header mb-5 animate-fade-in">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="fas fa-images me-3"></i>
                    Galeri Kegiatan
                </h1>
                <p class="lead text-muted">
                    Dokumentasi berbagai kegiatan dan acara yang telah kami selenggarakan
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="gallery-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $galleries->count() }}</span>
                        <span class="stat-label">Foto</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="gallery-filters mb-4 animate-fade-in" style="--delay: 0.2s">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control search-input" placeholder="Cari kegiatan..." id="searchInput">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="yearFilter">
                    <option value="">Semua Tahun</option>
                    @php
                        $years = $galleries->pluck('created_at')->map(function($date) {
                            return $date->format('Y');
                        })->unique()->sort()->reverse();
                    @endphp
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="sortFilter">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="az">A-Z</option>
                    <option value="za">Z-A</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="row g-4" id="galleryGrid">
        @forelse($galleries as $gallery)
            <div class="col-md-6 col-lg-4 gallery-item" 
                 data-title="{{ strtolower($gallery->title) }}" 
                 data-year="{{ $gallery->created_at->format('Y') }}"
                 data-date="{{ $gallery->created_at->format('Y-m-d') }}">
                <div class="gallery-card animate-fade-in" style="--delay: {{ 0.3 + ($loop->index * 0.1) }}s">
                    <div class="gallery-image-container">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                             class="gallery-image" 
                             alt="{{ $gallery->title }}"
                             loading="lazy">
                        <div class="gallery-overlay">
                            <div class="gallery-actions">
                                <button type="button" 
                                        class="btn btn-light btn-sm" 
                                        data-bs-toggle="tooltip" 
                                        title="Lihat Detail"
                                        onclick="viewImage('{{ asset('storage/' . $gallery->image_path) }}', '{{ $gallery->title }}', '{{ $gallery->created_at->format('d F Y') }}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-light btn-sm" 
                                        data-bs-toggle="tooltip" 
                                        title="Download"
                                        onclick="downloadImage('{{ asset('storage/' . $gallery->image_path) }}', '{{ $gallery->title }}')">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-light btn-sm" 
                                        data-bs-toggle="tooltip" 
                                        title="Bagikan"
                                        onclick="shareImage('{{ $gallery->title }}', '{{ asset('storage/' . $gallery->image_path) }}')">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gallery-badge">
                            <span class="badge bg-primary">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $gallery->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="gallery-content">
                        <h5 class="gallery-title">{{ $gallery->title }}</h5>
                        <div class="gallery-meta">
                            <span class="meta-item">
                                <i class="fas fa-clock me-1"></i>
                                {{ $gallery->created_at->format('d F Y') }}
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-image me-1"></i>
                                Foto Kegiatan
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-gallery animate-fade-in" style="--delay: 0.4s">
                    <div class="text-center py-5">
                        <div class="empty-icon mb-3">
                            <i class="fas fa-images"></i>
                        </div>
                        <h4 class="text-muted">Belum Ada Foto</h4>
                        <p class="text-muted">Galeri kegiatan akan ditampilkan di sini</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Load More Button -->
    @if($galleries->hasPages())
        <div class="text-center mt-5 animate-fade-in" style="--delay: 0.5s">
            <button class="btn btn-outline-primary btn-lg" id="loadMoreBtn">
                <i class="fas fa-plus me-2"></i>Muat Lebih Banyak
            </button>
        </div>
    @endif
</div>

<!-- Image Viewer Modal -->
<div class="modal fade" id="imageViewerModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalTitle">Judul Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img src="" id="modalImage" class="img-fluid" alt="Gallery Image">
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="image-info">
                        <small class="text-muted" id="imageModalDate">Tanggal</small>
                    </div>
                    <div class="image-actions">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="downloadModalBtn">
                            <i class="fas fa-download me-1"></i>Download
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="shareModalBtn">
                            <i class="fas fa-share me-1"></i>Bagikan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes bounceIn {
    0% { opacity: 0; transform: scale(0.3); }
    50% { opacity: 1; transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { opacity: 1; transform: scale(1); }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes shimmer {
    0% { background-position: -200px 0; }
    100% { background-position: calc(200px + 100%) 0; }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.animate-bounce-in {
    animation: bounceIn 0.6s ease-out forwards;
}

/* Gallery Header */
.gallery-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 2rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
}

.gallery-stats {
    display: flex;
    justify-content: center;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Search Box */
.search-box {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 10;
}

.search-input {
    padding-left: 3rem;
    border-radius: 0.75rem;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
}

/* Gallery Cards */
.gallery-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.gallery-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.gallery-card:hover::before {
    left: 100%;
}

.gallery-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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
    transition: transform 0.3s ease;
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
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.gallery-actions {
    display: flex;
    gap: 0.5rem;
}

.gallery-actions .btn {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    transition: all 0.3s ease;
    border: none;
}

.gallery-actions .btn:hover {
    transform: scale(1.1);
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.gallery-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.gallery-content {
    padding: 1.5rem;
}

.gallery-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
    line-height: 1.4;
}

.gallery-meta {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.meta-item {
    font-size: 0.875rem;
    color: #6c757d;
    display: flex;
    align-items: center;
}

/* Empty State */
.empty-gallery {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 1rem;
}

.empty-icon {
    font-size: 4rem;
    color: #adb5bd;
    animation: pulse 2s infinite;
}

/* Button Styles */
.btn {
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
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

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    background: transparent;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-2px);
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.1rem;
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

/* Form Controls */
.form-control, .form-select {
    border-radius: 0.75rem;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.modal-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border-bottom: none;
    border-radius: 1rem 1rem 0 0;
}

.modal-header .btn-close {
    filter: invert(1);
}

.modal-body {
    padding: 0;
}

.modal-footer {
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    border-radius: 0 0 1rem 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .gallery-header {
        padding: 1.5rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .gallery-image-container {
        padding-top: 66.67%; /* 3:2 Aspect Ratio for mobile */
    }
    
    .gallery-actions .btn {
        width: 35px;
        height: 35px;
    }
    
    .gallery-content {
        padding: 1rem;
    }
    
    .gallery-title {
        font-size: 1rem;
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
.btn:focus, .form-control:focus, .form-select:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}

/* Success/Error Messages */
.alert {
    border: none;
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    margin-bottom: 1rem;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    color: #721c24;
}

/* Image loading animation */
.gallery-image {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200px 100%;
    animation: shimmer 1.5s infinite;
}

.gallery-image[src] {
    animation: none;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const galleryGrid = document.getElementById('galleryGrid');
    const galleryItems = document.querySelectorAll('.gallery-item');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        galleryItems.forEach(item => {
            const title = item.querySelector('.gallery-title').textContent.toLowerCase();
            
            if (title.includes(searchTerm)) {
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.3s ease-out';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Filter functionality
    const yearFilter = document.getElementById('yearFilter');
    const sortFilter = document.getElementById('sortFilter');

    function applyFilters() {
        const year = yearFilter.value;
        const sort = sortFilter.value;

        const items = Array.from(galleryItems);
        
        // Filter by year
        if (year) {
            items.forEach(item => {
                const itemYear = item.dataset.year;
                if (itemYear === year) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        } else {
            items.forEach(item => {
                item.style.display = 'block';
            });
        }

        // Sort items
        const visibleItems = items.filter(item => item.style.display !== 'none');
        
        visibleItems.sort((a, b) => {
            if (sort === 'newest') {
                return new Date(b.dataset.date) - new Date(a.dataset.date);
            } else if (sort === 'oldest') {
                return new Date(a.dataset.date) - new Date(b.dataset.date);
            } else if (sort === 'az') {
                return a.querySelector('.gallery-title').textContent.localeCompare(b.querySelector('.gallery-title').textContent);
            } else if (sort === 'za') {
                return b.querySelector('.gallery-title').textContent.localeCompare(a.querySelector('.gallery-title').textContent);
            }
        });

        // Reorder in DOM
        const container = document.getElementById('galleryGrid');
        visibleItems.forEach(item => {
            container.appendChild(item);
        });

        // Add animation
        visibleItems.forEach((item, index) => {
            item.style.animation = 'fadeIn 0.3s ease-out';
            item.style.animationDelay = `${index * 0.1}s`;
        });
    }

    yearFilter.addEventListener('change', applyFilters);
    sortFilter.addEventListener('change', applyFilters);

    // Add hover effects to gallery cards
    const galleryCards = document.querySelectorAll('.gallery-card');
    galleryCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Lazy loading for images
    const images = document.querySelectorAll('.gallery-image');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src || img.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => {
        imageObserver.observe(img);
    });
});

// View image function
function viewImage(imageSrc, title, date) {
    const modal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('imageModalTitle');
    const modalDate = document.getElementById('imageModalDate');
    
    modalImage.src = imageSrc;
    modalTitle.textContent = title;
    modalDate.textContent = date;
    
    // Set download and share buttons
    document.getElementById('downloadModalBtn').onclick = () => downloadImage(imageSrc, title);
    document.getElementById('shareModalBtn').onclick = () => shareImage(title, imageSrc);
    
    modal.show();
}

// Download image function
function downloadImage(imageSrc, title) {
    const link = document.createElement('a');
    link.href = imageSrc;
    link.download = `${title}.jpg`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showAlert('Gambar berhasil diunduh!', 'success');
}

// Share image function
function shareImage(title, imageSrc) {
    if (navigator.share) {
        navigator.share({
            title: title,
            text: `Lihat foto kegiatan: ${title}`,
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(`${title} - ${window.location.href}`).then(() => {
            showAlert('Link berhasil disalin ke clipboard!', 'success');
        });
    }
}

// Show alert function
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show animate-bounce-in position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}

// Load more functionality
function loadMore() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        loadMoreBtn.classList.add('loading');
        loadMoreBtn.disabled = true;
        
        // Simulate loading more content
        setTimeout(() => {
            loadMoreBtn.classList.remove('loading');
            loadMoreBtn.disabled = false;
            showAlert('Fitur load more akan segera tersedia!', 'info');
        }, 2000);
    }
}

// Initialize load more button
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', loadMore);
    }
});
</script>
@endpush
@endsection