@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Manajemen Produk</h1>
            <p class="text-muted">Kelola katalog produk dan inventori Anda</p>
        </div>
            <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Produk
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card h-100 stats-card animate-fade-in" style="--delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Total Produk</h6>
                            <h2 class="card-title mb-0 counter">{{ $products->total() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 stats-card animate-fade-in" style="--delay: 0.2s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Tersedia</h6>
                            <h2 class="card-title mb-0 counter">{{ $products->where('stock', '>', 0)->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 stats-card animate-fade-in" style="--delay: 0.3s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Stok Menipis</h6>
                            <h2 class="card-title mb-0 counter">{{ $products->where('stock', '<=', 5)->where('stock', '>', 0)->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 stats-card animate-fade-in" style="--delay: 0.4s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-danger bg-opacity-10 text-danger">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-subtitle text-muted mb-1">Habis</h6>
                            <h2 class="card-title mb-0 counter">{{ $products->where('stock', 0)->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4 animate-fade-in" style="--delay: 0.5s">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" placeholder="Cari produk..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="stockFilter">
                        <option value="">Semua Level Stok</option>
                        <option value="in-stock">Tersedia</option>
                        <option value="low-stock">Stok Menipis</option>
                        <option value="out-of-stock">Habis</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4" id="productsGrid">
        @forelse($products as $product)
            <div class="col-md-6 col-lg-4 col-xl-3 product-item" 
                 data-category="{{ strtolower($product->name) }}" 
                 data-stock="{{ $product->stock > 0 ? ($product->stock <= 5 ? 'low-stock' : 'in-stock') : 'out-of-stock' }}">
                <div class="card h-100 product-card animate-fade-in" style="--delay: {{ 0.6 + ($loop->index * 0.1) }}s">
                    <div class="product-image-container">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             class="card-img-top product-image" 
                             alt="{{ $product->name }}">
                        <div class="product-overlay">
                            <div class="product-actions">
                                <a href="{{ route('dashboard.products.edit', $product) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-light btn-sm" 
                                        data-bs-toggle="tooltip" 
                                        title="Quick View"
                                        onclick="quickView({{ $product->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <form action="{{ route('dashboard.products.destroy', $product) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="product-badge">
                            @if($product->stock > 0)
                                @if($product->stock <= 5)
                                    <span class="badge bg-warning">Stok Menipis</span>
                                @else
                                    <span class="badge bg-success">Tersedia</span>
                                @endif
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                        <p class="card-text text-muted small mb-2">
                            {{ Str::limit($product->description, 60) }}
                        </p>
                        <div class="product-details">
                            <div class="product-price">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                            <div class="product-stock">
                                <i class="fas fa-boxes me-1"></i>
                                {{ $product->stock }} {{ $product->unit ?? 'satuan' }}
                            </div>
                        </div>
                        <div class="product-actions-bottom mt-3">
                            <a href="{{ route('dashboard.products.edit', $product) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Ubah
                            </a>
                            <button type="button" 
                                    class="btn btn-outline-info btn-sm" 
                                    onclick="quickView({{ $product->id }})">
                                <i class="fas fa-eye me-1"></i>Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card empty-state animate-fade-in" style="--delay: 0.6s">
                    <div class="card-body text-center py-5">
                        <div class="empty-icon mb-3">
                            <i class="fas fa-box"></i>
                        </div>
                        <h4 class="text-muted">Belum Ada Produk</h4>
                        <p class="text-muted mb-4">Mulai menambahkan produk ke katalog</p>
                        <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>Tambahkan Produk Pertama
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="quickViewContent">
                <!-- Content will be loaded here -->
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

/* Product Cards */
.product-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.product-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.product-card:hover::before {
    left: 100%;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.product-image-container {
    position: relative;
    overflow: hidden;
    padding-top: 75%; /* 4:3 Aspect Ratio */
}

.product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.1);
}

.product-overlay {
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

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-actions {
    display: flex;
    gap: 0.5rem;
}

.product-actions .btn {
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

.product-actions .btn:hover {
    transform: scale(1.1);
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.product-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.product-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.product-price {
    font-weight: 600;
    color: var(--primary-color);
    font-size: 1.1rem;
}

.product-stock {
    font-size: 0.875rem;
    color: #6c757d;
}

.product-actions-bottom {
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

.bg-success {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
}

.bg-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
    color: #000;
}

.bg-danger {
    background: linear-gradient(135deg, #dc3545, #e83e8c) !important;
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
    
    .product-image-container {
        padding-top: 66.67%; /* 3:2 Aspect Ratio for mobile */
    }
    
    .product-actions .btn {
        width: 35px;
        height: 35px;
    }
    
    .product-actions-bottom {
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
    const productsGrid = document.getElementById('productsGrid');
    const productItems = document.querySelectorAll('.product-item');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        productItems.forEach(item => {
            const title = item.querySelector('.card-title').textContent.toLowerCase();
            const description = item.querySelector('.card-text').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.3s ease-out';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Filter functionality
    const categoryFilter = document.getElementById('categoryFilter');
    const stockFilter = document.getElementById('stockFilter');

    function applyFilters() {
        const category = categoryFilter.value.toLowerCase();
        const stock = stockFilter.value;

        productItems.forEach(item => {
            const itemCategory = item.dataset.category;
            const itemStock = item.dataset.stock;
            
            const categoryMatch = !category || itemCategory.includes(category);
            const stockMatch = !stock || itemStock === stock;
            
            if (categoryMatch && stockMatch) {
                item.style.display = 'block';
                item.style.animation = 'fadeIn 0.3s ease-out';
            } else {
                item.style.display = 'none';
            }
        });
    }

    categoryFilter.addEventListener('change', applyFilters);
    stockFilter.addEventListener('change', applyFilters);

    // Dropdown filter functionality
    const dropdownItems = document.querySelectorAll('.dropdown-item[data-filter]');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const filter = this.dataset.filter;
            
            productItems.forEach(product => {
                if (filter === 'all') {
                    product.style.display = 'block';
                } else if (filter === 'in-stock') {
                    if (product.dataset.stock === 'in-stock') {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                } else if (filter === 'low-stock') {
                    if (product.dataset.stock === 'low-stock') {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                } else if (filter === 'out-of-stock') {
                    if (product.dataset.stock === 'out-of-stock') {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                }
                product.style.animation = 'fadeIn 0.3s ease-out';
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

    // Add hover effects to product cards
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Quick view function
function quickView(productId) {
    // Show loading state
    const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
    const content = document.getElementById('quickViewContent');
    
    content.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Memuat...</span>
            </div>
            <p class="mt-2">Memuat detail produk...</p>
        </div>
    `;
    
    modal.show();
    
    // Simulate loading product data
    setTimeout(() => {
        content.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <img src="/storage/products/product-${productId}.jpg" class="img-fluid rounded" alt="Product Image">
                </div>
                <div class="col-md-6">
                    <h4>Nama Produk</h4>
                    <p class="text-muted">Deskripsi produk akan ditampilkan di sini...</p>
                    <div class="mb-3">
                        <strong>Harga:</strong> Rp 50,000
                    </div>
                    <div class="mb-3">
                        <strong>Stok:</strong> 25 satuan
                    </div>
                    <div class="mb-3">
                        <strong>Kategori:</strong> Sayuran
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/dashboard/product/${productId}/edit" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Produk
                        </a>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        `;
    }, 1000);
}

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

// Export products function
function exportProducts() {
    showAlert('Mengekspor produk...', 'info');
    // Add your export logic here
}

// Bulk actions
function bulkDelete() {
    const selectedItems = document.querySelectorAll('input[name="selected_products"]:checked');
    if (selectedItems.length === 0) {
        showAlert('Silakan pilih produk untuk dihapus', 'warning');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menghapus ${selectedItems.length} produk?`)) {
        showAlert('Menghapus produk yang dipilih...', 'info');
        // Add your bulk delete logic here
    }
}

// Update stock function
function updateStock(productId, newStock) {
    showAlert('Memperbarui stok...', 'info');
    // Add your stock update logic here
}
</script>
@endpush
@endsection