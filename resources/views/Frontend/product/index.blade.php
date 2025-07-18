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
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-color: #10b981;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        min-height: 500px; /* Minimum height untuk konsistensi */
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .product-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .featured-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 10;
    }

    .stock-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 10;
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
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .empty-state i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .stats-section {
        margin-bottom: 3rem;
    }

    .stat-item {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #10b981;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1rem;
        color: #6b7280;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .product-card {
            min-height: 450px;
        }
        
        .product-image-container {
            height: 180px;
        }
        
        .stat-number {
            font-size: 2rem;
        }
    }

    @media (max-width: 640px) {
        .product-card {
            min-height: 400px;
        }
        
        .product-image-container {
            height: 160px;
        }
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
            <a href="{{ route('product.index_fr') }}" 
               class="filter-btn {{ !request('filter') ? 'active' : '' }}">
                <i class="fas fa-th-large me-2"></i>Semua Produk
            </a>
            <a href="{{ route('product.index_fr', ['filter' => 'featured']) }}" 
               class="filter-btn {{ request('filter') == 'featured' ? 'active' : '' }}">
                <i class="fas fa-star me-2"></i>Produk Unggulan
            </a>
            <a href="{{ route('product.index_fr', ['filter' => 'new']) }}"
               class="filter-btn {{ request('filter') == 'new' ? 'active' : '' }}">
                <i class="fas fa-clock me-2"></i>Produk Terbaru
            </a>
            <a href="{{ route('product.index_fr', ['filter' => 'available']) }}"
               class="filter-btn {{ request('filter') == 'available' ? 'active' : '' }}">
                <i class="fas fa-check-circle me-2"></i>Tersedia
            </a>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products as $product)
            <div class="product-card flex flex-col h-full animate-scale-in" style="--delay: {{ $loop->iteration * 0.1 }}s">
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

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="font-bold text-xl mb-2 text-gray-800">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between mb-4">
                        <span class="product-price text-green-600 font-semibold text-lg">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                            <span class="text-sm text-gray-500">/{{ $product->unit ?? 'satuan' }}</span>
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-boxes me-1"></i>{{ $product->stock }} {{ $product->unit ?? 'satuan' }}
                        </span>
                    </div>

                    <p class="product-description text-gray-600 text-sm mb-4 flex-grow">{{ Str::limit($product->description, 120) }}</p>

                    <div class="flex space-x-2 mt-auto">
                        <a href="{{ route('product.show', $product->id) }}" 
                        class="flex flex-1 items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-300 text-center text-sm">
                            <i class="fas fa-eye me-2"></i>Detail
                        </a>
                        
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-300 text-sm">
                                    <i class="fas fa-cart-plus me-1"></i>Keranjang
                                </button>
                            </form>
                        @else
                            <button disabled 
                                    class="flex-1 bg-gray-400 text-white font-semibold py-2 px-4 rounded-lg cursor-not-allowed text-sm">
                                <i class="fas fa-times me-1"></i>Habis
                            </button>
                        @endif
                    </div>
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
            <div class="mt-12 flex justify-center animate-fade-in" style="--delay: 0.5s">
                <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <span class="px-4 py-2 border border-gray-300 bg-gray-100 text-gray-400 rounded-l-md cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="px-4 py-2 border border-gray-300 bg-white text-green-600 hover:bg-green-50 rounded-l-md transition">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            <span class="px-4 py-2 border-t border-b border-gray-300 bg-green-600 text-white font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-green-600 hover:bg-green-50 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="px-4 py-2 border border-gray-300 bg-white text-green-600 hover:bg-green-50 rounded-r-md transition">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-4 py-2 border border-gray-300 bg-gray-100 text-gray-400 rounded-r-md cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const productCards = document.querySelectorAll('.product-card');

    // Add intersection observer for lazy loading animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-scale-in');
                observer.unobserve(entry.target);
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