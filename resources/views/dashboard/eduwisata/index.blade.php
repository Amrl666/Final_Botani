@extends('layouts.app')

@section('title', 'Manajemen Eduwisata')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Manajemen Eduwisata</h1>
            <p class="text-muted">Kelola program eduwisata dan jadwal</p>
        </div>
        <a href="{{ route('dashboard.eduwisata.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Program
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 stats-card animate-fade-in" style="--delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Program</h6>
                            <h2 class="card-title mb-0 counter">{{ $eduwisatas->count() }}</h2>
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
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Jadwal Aktif</h6>
                            <h2 class="card-title mb-0 counter">12</h2>
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
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Peserta</h6>
                            <h2 class="card-title mb-0 counter">156</h2>
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
                <div class="col-md-8">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Cari program..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Programs Grid -->
    <div class="row g-4" id="programsGrid">
        @forelse($eduwisatas as $eduwisata)
            <div class="col-md-6 col-lg-4 program-item" data-category="{{ strtolower($eduwisata->name) }}" data-status="active">
                <div class="card h-100 program-card animate-fade-in" style="--delay: {{ 0.5 + ($loop->index * 0.1) }}s">
                    <div class="program-image-container">
                        @if($eduwisata->image)
                            <img src="{{ asset('storage/' . $eduwisata->image) }}" 
                                 alt="{{ $eduwisata->name }}" 
                                 class="card-img-top program-image">
                        @else
                            <div class="card-img-top program-image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <div class="program-overlay">
                            <div class="program-actions">
                                <a href="{{ route('dashboard.eduwisata.edit', $eduwisata->id) }}" 
                                   class="btn btn-light btn-sm" 
                                   data-bs-toggle="tooltip" 
                                   title="Edit Program">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('dashboard.eduwisata.schedule', $eduwisata) }}" 
                                   class="btn btn-light btn-sm" 
                                   data-bs-toggle="tooltip" 
                                   title="Lihat Jadwal">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                                <form action="{{ route('dashboard.eduwisata.destroy', $eduwisata->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-light btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Hapus Program"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="program-badge">
                            <span class="badge bg-primary">{{ $eduwisata->schedules->count() }} Jadwal</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">{{ $eduwisata->name }}</h5>
                            <h5 class="card-text text-muted mb-3" style="color: green;"> Rp. {{ $eduwisata->harga }} </h5>                        
                        </div> 
                        <div class="program-meta">
                            <div class="meta-item">
                                <i class="fas fa-clock me-1"></i>
                                <span>Durasi: 2-3 jam</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-users me-1"></i>
                                <span>Maks: 20 orang</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('dashboard.eduwisata.schedule', $eduwisata) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-calendar-alt me-2"></i>Lihat Jadwal
                            </a>
                            <div class="btn-group">
                                <a href="{{ route('dashboard.eduwisata.edit', $eduwisata->id) }}" 
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.eduwisata.destroy', $eduwisata->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
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
                <div class="card empty-state animate-fade-in" style="--delay: 0.5s">
                    <div class="card-body text-center py-5">
                        <div class="empty-icon mb-3">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h4 class="text-muted">Belum Ada Program</h4>
                        <p class="text-muted mb-4">Mulai membuat program eduwisata pertama Anda</p>
                        <a href="{{ route('dashboard.eduwisata.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Buat Program Pertama
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

/* Program Cards */
.program-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.program-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.program-image-container {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.program-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.program-card:hover .program-image {
    transform: scale(1.1);
}

.program-image-placeholder {
    height: 200px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 3rem;
}

.program-overlay {
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

.program-card:hover .program-overlay {
    opacity: 1;
}

.program-actions {
    display: flex;
    gap: 0.5rem;
}

.program-actions .btn {
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

.program-actions .btn:hover {
    transform: scale(1.1);
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.program-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.program-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    font-size: 0.875rem;
    color: #6c757d;
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
    
    .program-image-container {
        height: 180px;
    }
    
    .program-actions .btn {
        width: 35px;
        height: 35px;
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
    const programsGrid = document.getElementById('programsGrid');
    const programItems = document.querySelectorAll('.program-item');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        programItems.forEach(item => {
            const title = item.querySelector('.card-title').textContent.toLowerCase();
            const location = item.querySelector('.card-text').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || location.includes(searchTerm)) {
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.3s ease-out';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Filter functionality
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');

    function applyFilters() {
        const category = categoryFilter.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();

        programItems.forEach(item => {
            const itemCategory = item.dataset.category;
            const itemStatus = item.dataset.status;
            
            const categoryMatch = !category || itemCategory.includes(category);
            const statusMatch = !status || itemStatus === status;
            
            if (categoryMatch && statusMatch) {
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.3s ease-out';
            } else {
                item.style.display = 'none';
            }
        });
    }

    categoryFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);

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

    // Add hover effects to program cards
    const programCards = document.querySelectorAll('.program-card');
    programCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
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

// Export programs function
function exportPrograms() {
    showAlert('Mengekspor program...', 'info');
    // Add your export logic here
}

// Bulk actions
function bulkDelete() {
    const selectedItems = document.querySelectorAll('input[name="selected_programs"]:checked');
    if (selectedItems.length === 0) {
        showAlert('Silakan pilih program untuk dihapus', 'warning');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menghapus ${selectedItems.length} program?`)) {
        showAlert('Menghapus program yang dipilih...', 'info');
        // Add your bulk delete logic here
    }
}
</script>
@endpush
@endsection