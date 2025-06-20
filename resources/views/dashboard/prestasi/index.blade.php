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
                    <li><a class="dropdown-item" href="#" data-filter="all">All Achievements</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="recent">Recent Awards</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="featured">Featured</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" data-filter="category">By Category</a></li>
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
            <div class="card h-100 stats-card animate-fade-in" style="--delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-trophy"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Achievements</h6>
                            <h2 class="card-title mb-0 counter">{{ $prestasis->total() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 stats-card animate-fade-in" style="--delay: 0.2s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-medal"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">This Year</h6>
                            <h2 class="card-title mb-0 counter">{{ $prestasis->where('year', date('Y'))->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 stats-card animate-fade-in" style="--delay: 0.3s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Featured</h6>
                            <h2 class="card-title mb-0 counter">{{ $prestasis->where('is_featured', true)->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4 animate-fade-in" style="--delay: 0.4s">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Search achievements..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="yearFilter">
                        <option value="">All Years</option>
                        @for($year = date('Y'); $year >= date('Y') - 10; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="competition">Competition</option>
                        <option value="award">Award</option>
                        <option value="recognition">Recognition</option>
                        <option value="certification">Certification</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements Grid -->
    <div class="row g-4" id="achievementsGrid">
        @forelse($prestasis as $prestasi)
            <div class="col-md-6 col-lg-4 achievement-item" 
                 data-year="{{ $prestasi->year }}" 
                 data-category="{{ strtolower($prestasi->category) }}"
                 data-featured="{{ $prestasi->is_featured ? 'true' : 'false' }}">
                <div class="card h-100 achievement-card animate-fade-in" style="--delay: {{ 0.5 + ($loop->index * 0.1) }}s">
                    <div class="achievement-header">
                        <div class="achievement-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        @if($prestasi->is_featured)
                            <div class="featured-badge">
                                <i class="fas fa-star"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="achievement-meta mb-3">
                            <h5 class="card-title mb-1">{{ $prestasi->title }}</h5>
                            <p class="text-muted small mb-0">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ $prestasi->year }}
                            </p>
                        </div>
                        <p class="card-text achievement-description">{{ Str::limit($prestasi->description, 120) }}</p>
                        <div class="achievement-tags mb-3">
                            <span class="badge bg-primary">{{ $prestasi->category }}</span>
                            @if($prestasi->is_featured)
                                <span class="badge bg-warning">Featured</span>
                            @endif
                        </div>
                        <div class="achievement-actions">
                            <a href="{{ route('dashboard.prestasi.edit', $prestasi) }}" 
                               class="btn btn-outline-primary btn-sm" 
                               data-bs-toggle="tooltip" 
                               title="Edit Achievement">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <form action="{{ route('dashboard.prestasi.destroy', $prestasi) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-outline-danger btn-sm" 
                                        data-bs-toggle="tooltip" 
                                        title="Delete Achievement"
                                        onclick="return confirm('Are you sure you want to delete this achievement?')">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card empty-state animate-fade-in" style="--delay: 0.5s">
                    <div class="card-body text-center py-5">
                        <div class="empty-icon mb-3">
                            <i class="fas fa-trophy"></i>
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

@keyframes shine {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
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

/* Stats Cards */
.stats-card {
    background: linear-gradient(135deg, #fff, #f8f9fa);
    border-left: 4px solid var(--primary-color);
}

.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.stats-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 1rem;
    font-size: 28px;
    transition: all 0.3s ease;
}

.stats-card:hover .stats-icon {
    transform: scale(1.1) rotate(5deg);
}

.counter {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    transition: all 0.3s ease;
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

/* Achievement Cards */
.achievement-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.achievement-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.achievement-card:hover::before {
    left: 100%;
}

.achievement-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.achievement-header {
    position: relative;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    padding: 2rem 1.5rem 1rem;
    text-align: center;
}

.achievement-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 50%;
    font-size: 32px;
    margin: 0 auto 1rem;
    transition: all 0.3s ease;
}

.achievement-card:hover .achievement-icon {
    transform: scale(1.1) rotate(10deg);
}

.featured-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    background: #ffc107;
    color: #000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    animation: pulse 2s infinite;
}

.achievement-meta {
    text-align: center;
}

.achievement-description {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.achievement-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

.achievement-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

/* Empty State */
.empty-state {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
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

.bg-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
    color: #000;
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

/* Dropdown Styles */
.dropdown-menu {
    border: none;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    border-radius: 0.75rem;
    padding: 0.5rem;
}

.dropdown-item {
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background: var(--primary-color);
    color: white;
    transform: translateX(5px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-icon {
        width: 50px;
        height: 50px;
        font-size: 24px;
    }
    
    .counter {
        font-size: 2rem;
    }
    
    .achievement-icon {
        width: 60px;
        height: 60px;
        font-size: 24px;
    }
    
    .achievement-actions {
        flex-direction: column;
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
    const achievementsGrid = document.getElementById('achievementsGrid');
    const achievementItems = document.querySelectorAll('.achievement-item');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        achievementItems.forEach(item => {
            const title = item.querySelector('.card-title').textContent.toLowerCase();
            const description = item.querySelector('.achievement-description').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.3s ease-out';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Filter functionality
    const yearFilter = document.getElementById('yearFilter');
    const categoryFilter = document.getElementById('categoryFilter');

    function applyFilters() {
        const year = yearFilter.value;
        const category = categoryFilter.value.toLowerCase();

        achievementItems.forEach(item => {
            const itemYear = item.dataset.year;
            const itemCategory = item.dataset.category;
            
            const yearMatch = !year || itemYear === year;
            const categoryMatch = !category || itemCategory.includes(category);
            
            if (yearMatch && categoryMatch) {
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.3s ease-out';
            } else {
                item.style.display = 'none';
            }
        });
    }

    yearFilter.addEventListener('change', applyFilters);
    categoryFilter.addEventListener('change', applyFilters);

    // Dropdown filter functionality
    const dropdownItems = document.querySelectorAll('.dropdown-item[data-filter]');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const filter = this.dataset.filter;
            
            achievementItems.forEach(achievement => {
                if (filter === 'all') {
                    achievement.style.display = 'block';
                } else if (filter === 'featured') {
                    if (achievement.dataset.featured === 'true') {
                        achievement.style.display = 'block';
                    } else {
                        achievement.style.display = 'none';
                    }
                } else if (filter === 'recent') {
                    const year = parseInt(achievement.dataset.year);
                    if (year >= new Date().getFullYear() - 2) {
                        achievement.style.display = 'block';
                    } else {
                        achievement.style.display = 'none';
                    }
                }
                achievement.style.animation = 'fadeIn 0.3s ease-out';
            });
        });
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

    // Animate counters
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.textContent);
        let current = 0;
        const increment = target / 50;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        updateCounter();
    });

    // Add hover effects to achievement cards
    const achievementCards = document.querySelectorAll('.achievement-card');
    achievementCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add shine effect on featured achievements
    const featuredAchievements = document.querySelectorAll('[data-featured="true"]');
    featuredAchievements.forEach(achievement => {
        achievement.addEventListener('mouseenter', function() {
            this.style.animation = 'shine 1s ease-in-out';
        });
        
        achievement.addEventListener('mouseleave', function() {
            this.style.animation = '';
        });
    });
});

// Show alert function
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show animate-bounce-in`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container-fluid');
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}

// Export achievements function
function exportAchievements() {
    showAlert('Exporting achievements...', 'info');
    // Add your export logic here
}

// Bulk actions
function bulkDelete() {
    const selectedItems = document.querySelectorAll('input[name="selected_achievements"]:checked');
    if (selectedItems.length === 0) {
        showAlert('Please select achievements to delete', 'warning');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${selectedItems.length} achievements?`)) {
        showAlert('Deleting selected achievements...', 'info');
        // Add your bulk delete logic here
    }
}

// Toggle featured status
function toggleFeatured(achievementId) {
    showAlert('Updating featured status...', 'info');
    // Add your toggle featured logic here
}
</script>
@endpush
@endsection