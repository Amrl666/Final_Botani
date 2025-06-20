@extends('layouts.frontend')

@section('title', 'Produk Kami')

@section('content')
<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes scaleIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @keyframes floatUpDown {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .animate-fade-in {
        opacity: 0;
        animation: fadeIn 1s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .animate-slide-down {
        animation: slideDown 1s ease-out forwards;
    }

    .animate-slide-up {
        opacity: 0;
        animation: slideUp 1s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .animate-scale-in {
        animation: scaleIn 0.8s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    .animate-float {
        animation: floatUpDown 3s ease-in-out infinite;
    }

    .filter-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        font-weight: 600;
        transition: all 0.3s ease;
        background-color: white;
        color: #1f2937;
        border: 2px solid #e5e7eb;
        position: relative;
        overflow: hidden;
    }

    .filter-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s;
    }

    .filter-btn:hover::before {
        left: 100%;
    }

    .filter-btn:hover {
        border-color: #059669;
        color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(5, 150, 105, 0.2);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        border-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(5, 150, 105, 0.3);
    }

    .product-card {
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
        position: relative;
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }

    .product-card:hover::before {
        opacity: 1;
    }

    .product-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .product-image-container {
        position: relative;
        overflow: hidden;
        height: 200px;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.15);
    }

    .featured-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: #92400e;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        z-index: 2;
        animation: floatUpDown 2s ease-in-out infinite;
    }

    .stock-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }

    .product-content {
        padding: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .product-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .product-description {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: #059669;
        margin-bottom: 0.5rem;
    }

    .product-stock {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    .view-detail-btn {
        width: 100%;
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .view-detail-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .view-detail-btn:hover::before {
        left: 100%;
    }

    .view-detail-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(5, 150, 105, 0.3);
    }

    .empty-state {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 1.5rem;
        padding: 3rem;
        text-align: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .empty-state i {
        font-size: 4rem;
        color: #94a3b8;
        margin-bottom: 1.5rem;
        animation: floatUpDown 3s ease-in-out infinite;
    }

    .stats-section {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-radius: 1.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #059669;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }
</style>

<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="text-center mb-12 animate-slide-down">
            <h1 class="text-5xl font-bold text-green-800 mb-4">Produk Kami</h1>
            <p class="text-gray-600 text-xl mb-6">Temukan produk segar dan berkualitas dari Tani Winongo Asri</p>
            <div class="w-32 h-1 bg-gradient-to-r from-green-500 to-green-600 mx-auto rounded-full"></div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section animate-fade-in" style="--delay: 0.1s">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="stat-item">
                    <div class="stat-number">{{ $products->total() }}</div>
                    <div class="stat-label">Total Produk</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $products->where('featured', true)->count() }}</div>
                    <div class="stat-label">Produk Unggulan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $products->where('stock', '>', 0)->count() }}</div>
                    <div class="stat-label">Tersedia</div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="mb-8 flex flex-wrap gap-4 justify-center animate-fade-in" style="--delay: 0.2s">
            <button class="filter-btn active" data-filter="all">
                <i class="fas fa-th-large me-2"></i>Semua Produk
            </button>
            <button class="filter-btn" data-filter="featured">
                <i class="fas fa-star me-2"></i>Produk Unggulan
            </button>
            <button class="filter-btn" data-filter="new">
                <i class="fas fa-clock me-2"></i>Produk Terbaru
            </button>
            <button class="filter-btn" data-filter="available">
                <i class="fas fa-check-circle me-2"></i>Tersedia
            </button>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products as $product)
            <div class="product-card animate-scale-in" style="--delay: {{ $loop->iteration * 0.1 }}s">
                <div class="product-image-container">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="product-image">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                            <i class="fas fa-seedling text-4xl text-green-500 animate-float"></i>
                        </div>
                    @endif
                    
                    @if($product->featured)
                        <div class="featured-badge">
                            <i class="fas fa-star me-1"></i>Unggulan
                        </div>
                    @endif

                    @if($product->stock <= 0)
                        <div class="stock-badge">
                            <i class="fas fa-times-circle me-1"></i>Stok Habis
                        </div>
                    @endif
                </div>

                <div class="product-content">
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <p class="product-description">{{ $product->description }}</p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="product-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="product-stock">
                            <i class="fas fa-boxes me-1"></i>Stok: {{ $product->stock }}
                        </span>
                    </div>

                    <a href="{{ route('product.show', $product->id) }}" 
                       class="view-detail-btn">
                        <i class="fas fa-eye me-2"></i>Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="empty-state animate-fade-in" style="--delay: 0.3s">
                    <i class="fas fa-box-open"></i>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Produk</h3>
                    <p class="text-gray-600 text-lg">Produk akan segera hadir. Silakan kunjungi kembali nanti.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="mt-12 animate-fade-in" style="--delay: 0.5s">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            button.classList.add('active');
            
            const filter = button.dataset.filter;
            
            // Add animation to product cards
            productCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.remove('animate-scale-in');
                void card.offsetWidth; // Trigger reflow
                card.classList.add('animate-scale-in');
            });
            
            // Here you can add filtering logic
            // Example: You can use AJAX to fetch filtered products
            // or filter the existing products on the page
        });
    });

    // Add intersection observer for lazy loading animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    productCards.forEach(card => {
        observer.observe(card);
    });
});
</script>
@endpush
@endsection