@extends('layouts.app')

@section('title', 'Manajemen Blog')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Manajemen Blog</h1>
            <p class="text-muted">Kelola artikel dan konten blog</p>
        </div>
        <a href="{{ route('dashboard.blog.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Artikel
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="stats-card animate-fade-in" style="--delay: 0.1s">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total Posts</h6>
                                <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $blogs->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-4 animate-slide-in">
        <div class="card-header bg-transparent">
            <h5 class="card-title mb-0">
                <i class="fas fa-search me-2 text-primary"></i>
                Search & Filters
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari artikel...">
                        <label for="searchInput">
                            <i class="fas fa-search me-2"></i>Cari Artikel
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Archived</option>
                        </select>
                        <label for="statusFilter">
                            <i class="fas fa-toggle-on me-2"></i>Status
                        </label>
                    </div>
                </div>
            </a>
        </div>
            </div>
        </div>
    </div>

    <!-- Blog Posts List -->
    <div class="card animate-fade-in">
        <div class="card-header bg-transparent">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2 text-primary"></i>
                Blog Posts
            </h5>
        </div>
        <div class="card-body">
            @if($blogs->count() > 0)
                <div class="row g-4">
                    @foreach($blogs as $blog)
                        <div class="col-lg-6 col-xl-4 blog-post-card" data-category="{{ $blog->category ?? 'other' }}" data-status="{{ $blog->status }}">
                            <div class="card h-100 blog-card animate-scale-in">
                                <div class="card-img-top position-relative">
                                    @if($blog->image)
                                        <img src="{{ asset('storage/' . $blog->image) }}" 
                                             alt="{{ $blog->title }}" 
                                             class="blog-image">
                                    @else
                                        <div class="blog-placeholder">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="card-img-overlay d-flex justify-content-between align-items-start">
                                        @if($blog->is_featured)
                                            <span class="badge bg-warning">
                                                <i class="fas fa-star me-1"></i>Featured
                                            </span>
                                        @endif
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('dashboard.blog.show', $blog) }}">
                                                    <i class="fas fa-eye me-2"></i>View
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('dashboard.blog.edit', $blog) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><form action="{{ route('dashboard.blog.destroy', $blog) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus blog ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" title="Delete">
                                                        <i class="fas fa-trash me-2"></i>Delete
                                                    </button>
                                                </form></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="blog-meta mb-2">
                                        <span class="badge bg-primary">{{ $blog->category ?? 'General' }}</span>
                                        <span class="badge bg-{{ $blog->status == 'published' ? 'success' : ($blog->status == 'draft' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($blog->status) }}
                                        </span>
                                    </div>
                                    <h5 class="card-title blog-title">{{ $blog->title }}</h5>
                                    <p class="card-text blog-excerpt">
                                        {{ Str::limit($blog->content, 120) }}
                                    </p>
                                    <div class="blog-info mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="far fa-calendar me-1"></i>
                                                {{ $blog->created_at->format('M j, Y') }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                {{ $blog->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dashboard.blog.show', $blog) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>View
                                            </a>
                                            <a href="{{ route('dashboard.blog.edit', $blog) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </a>
                                        </div>
                                        <div class="blog-actions">
                                            @if($blog->status == 'draft')
                                                <button class="btn btn-sm btn-success" onclick="publishBlog({{ $blog->id }})" title="Publish">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            <form action="{{ route('dashboard.blog.destroy', $blog) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus blog ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Blog Posts Found</h5>
                        <p class="text-muted">Start by creating your first blog post.</p>
                        <a href="{{ route('dashboard.blog.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create First Post
                        </a>
                    </div>
                </div>
            @endif
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
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out forwards;
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
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1.5rem;
}

.card-body {
    padding: 2rem;
}



/* Stats Cards */
.stats-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem; /* Default padding */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
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

/* Blog Card Styles */
.blog-card {
    transition: all 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.blog-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card:hover .blog-image {
    transform: scale(1.05);
}

.blog-placeholder {
    width: 100%;
    height: 200px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.5rem 0.5rem 0 0;
}

.blog-title {
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 0.75rem;
    color: #2d3748;
}

.blog-excerpt {
    color: #718096;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.blog-meta {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.blog-info {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
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

.bg-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
    color: #000;
}

.bg-secondary {
    background: linear-gradient(135deg, #6c757d, #495057) !important;
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
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.btn-group .btn {
    border-radius: 0.5rem;
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

/* Form Styles */
.form-floating {
    position: relative;
}

.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 0.75rem;
    padding: 1rem 0.75rem;
    font-size: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #fff;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
    outline: none;
}

.form-floating > label {
    padding: 1rem 0.75rem;
    color: #6c757d;
    font-weight: 500;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label,
.form-floating > .form-select ~ label {
    color: var(--primary-color);
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

/* Dropdown Styles */
.dropdown-menu {
    border: none;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-radius: 0.75rem;
    padding: 0.5rem;
}

.dropdown-item {
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background-color: rgba(5, 150, 105, 0.1);
    color: var(--primary-color);
}

/* Empty State */
.empty-state {
    padding: 3rem 1rem;
}

.empty-state i {
    opacity: 0.5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
    
    .blog-title {
        font-size: 1rem;
    }
    
    .btn-group {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .btn-group .btn {
        margin-right: 0;
        margin-bottom: 0.25rem;
    }
}

/* Focus styles for accessibility */
.btn:focus,
.form-control:focus,
.form-select:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
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
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    const blogCards = document.querySelectorAll('.blog-post-card');

    function filterBlogs() {
        const searchValue = searchInput.value.toLowerCase();
        const categoryValue = categoryFilter.value;
        const statusValue = statusFilter.value;

        blogCards.forEach(card => {
            const category = card.dataset.category;
            const status = card.dataset.status;
            const text = card.textContent.toLowerCase();

            const categoryMatch = !categoryValue || category === categoryValue;
            const statusMatch = !statusValue || status === statusValue;
            const searchMatch = !searchValue || text.includes(searchValue);

            if (categoryMatch && statusMatch && searchMatch) {
                card.style.display = '';
                card.classList.add('animate-scale-in');
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterBlogs);
    categoryFilter.addEventListener('change', filterBlogs);
    statusFilter.addEventListener('input', filterBlogs);

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});

// Blog action functions
function filterPosts(filter) {
    const blogCards = document.querySelectorAll('.blog-post-card');
    
    blogCards.forEach(card => {
        const status = card.dataset.status;
        const isFeatured = card.querySelector('.badge.bg-warning') !== null;
        
        let show = false;
        
        switch(filter) {
            case 'all':
                show = true;
                break;
            case 'published':
                show = status === 'published';
                break;
            case 'draft':
                show = status === 'draft';
                break;
            case 'featured':
                show = isFeatured;
                break;
        }
        
        if (show) {
            card.style.display = '';
            card.classList.add('animate-scale-in');
        } else {
            card.style.display = 'none';
        }
    });
}

function publishBlog(id) {
    if (confirm('Apakah Anda yakin ingin mempublikasikan artikel blog ini?')) {
        // Add your publish logic here
        showAlert(`Artikel blog ${id} berhasil dipublikasikan!`, 'success');
    }
}

function deleteBlog(id) {
    if (confirm('Apakah Anda yakin ingin menghapus artikel blog ini? Tindakan ini tidak dapat dibatalkan.')) {
        // Add your delete logic here
        showAlert(`Artikel blog ${id} berhasil dihapus!`, 'success');
    }
}

function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show animate-bounce-in`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert at the top of the container
    const container = document.querySelector('.container-fluid');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}
</script>
@endpush
@endsection