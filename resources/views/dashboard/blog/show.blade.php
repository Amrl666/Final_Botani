@extends('layouts.app')

@section('title', $blog->title)

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Detail Artikel Blog</h1>
            <p class="text-muted">Lihat dan kelola informasi artikel blog</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.blog.edit', $blog) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Ubah Artikel
            </a>
            <a href="{{ route('dashboard.blog.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Artikel
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card animate-fade-in">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h2 class="card-title mb-2">{{ $blog->title }}</h2>
                            <div class="blog-meta">
                                <span class="badge bg-primary me-2">{{ $blog->category ?? 'Tanpa Kategori' }}</span>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    Diposting pada {{ $blog->created_at->format('d M Y \p\u\k\u\l H:i') }}
                                </small>
                            </div>
                        </div>
                        <div class="blog-status">
                            <span class="badge bg-success">Dipublikasikan</span>
                        </div>
                    </div>
                </div>
                
                @if($blog->image)
                    <div class="blog-image-container">
                        <img src="{{ asset('storage/' . $blog->image) }}" 
                             alt="{{ $blog->title }}" 
                             class="blog-image">
                        <div class="image-overlay">
                            <button class="btn btn-light btn-sm" onclick="openImageModal('{{ asset('storage/' . $blog->image) }}', '{{ $blog->title }}')">
                                <i class="fas fa-expand-alt me-1"></i>Lihat Ukuran Penuh
                            </button>
                        </div>
                    </div>
                @endif
                
                <div class="card-body">
                    <div class="blog-content">
                        {!! nl2br(e($blog->content)) !!}
                    </div>
                </div>
                
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="blog-actions">
                            <!-- Hapus tombol bagikan (share) di blog-actions -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Post Information -->
            <div class="card mb-4 animate-slide-in" style="--delay: 0.2s">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informasi Artikel
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">ID Artikel</span>
                            <span class="text-dark">#{{ $blog->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Kategori</span>
                            <span class="badge bg-primary">{{ $blog->category ?? 'Tanpa Kategori' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Status</span>
                            <span class="badge bg-success">Dipublikasikan</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Dibuat</span>
                            <span class="text-dark">{{ $blog->created_at->format('d M Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Diperbarui</span>
                            <span class="text-dark">{{ $blog->updated_at->format('d M Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalTitle">Pratinjau Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid">
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

@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.animate-scale-in {
    animation: scaleIn 0.6s ease-out forwards;
}

/* Card Styles */
.card {
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border-radius: 1rem;
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

.card-body {
    padding: 2rem;
}

.card-footer {
    background: #f8f9fa;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

/* Blog Content */
.blog-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.blog-content p {
    margin-bottom: 1.5rem;
}

.blog-content h1, .blog-content h2, .blog-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

/* Blog Image */
.blog-image-container {
    position: relative;
    overflow: hidden;
    max-height: 400px;
}

.blog-image {
    width: 100%;
    height: auto;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-image-container:hover .blog-image {
    transform: scale(1.05);
}

.image-overlay {
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
    transition: opacity 0.3s ease;
}

.blog-image-container:hover .image-overlay {
    opacity: 1;
}

/* Blog Meta */
.blog-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.blog-stats {
    display: flex;
    gap: 1.5rem;
}

.stat-item {
    display: flex;
    align-items: center;
    color: #6c757d;
    font-size: 0.875rem;
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

.bg-success {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
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

.btn-outline-success {
    border: 2px solid #28a745;
    color: #28a745;
    background: transparent;
}

.btn-outline-success:hover {
    background: #28a745;
    color: white;
    transform: translateY(-2px);
}

.btn-outline-info {
    border: 2px solid #17a2b8;
    color: #17a2b8;
    background: transparent;
}

.btn-outline-info:hover {
    background: #17a2b8;
    color: white;
    transform: translateY(-2px);
}

.btn-outline-danger {
    border: 2px solid #dc3545;
    color: #dc3545;
    background: transparent;
}

.btn-outline-danger:hover {
    background: #dc3545;
    color: white;
    transform: translateY(-2px);
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* List Group */
.list-group-item {
    border: none;
    padding: 1rem 0;
    background: transparent;
}

.list-group-item:not(:last-child) {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: 1rem;
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    
    .blog-stats {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .blog-meta {
        flex-direction: column;
        align-items: flex-start;
    }
}

/* Focus styles for accessibility */
.btn:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
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

    // Add loading states to forms
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
});

// Image modal functions
function openImageModal(imageSrc, imageTitle) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalImage').alt = imageTitle;
    document.getElementById('imageModalTitle').textContent = imageTitle;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

// Share post function
function sharePost() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $blog->title }}',
            text: '{{ Str::limit($blog->content, 100) }}',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link berhasil disalin ke clipboard!');
        });
    }
}

// Duplicate post function
function duplicatePost() {
    if (confirm('Apakah Anda ingin membuat salinan artikel ini?')) {
        // Anda dapat mengimplementasikan logika duplikasi di sini
        alert('Fitur duplikasi artikel akan segera tersedia!');
    }
}

// Preview post function
function previewPost() {
    // Buka di tab baru untuk pratinjau
    window.open('{{ route("dashboard.blog.show", $blog) }}', '_blank');
}

// Loading state styles
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
</script>
@endpush
@endsection