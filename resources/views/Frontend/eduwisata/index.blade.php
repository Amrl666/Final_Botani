@extends('layouts.frontend')

@section('title', 'Eduwisata')

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

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
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

    .animate-pulse {
        animation: pulse 2s ease-in-out infinite;
    }

    .eduwisata-card {
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
        position: relative;
    }

    .eduwisata-card::before {
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

    .eduwisata-card:hover::before {
        opacity: 1;
    }

    .eduwisata-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .eduwisata-image-container {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .eduwisata-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .eduwisata-card:hover .eduwisata-image {
        transform: scale(1.15);
    }

    .price-badge {
        position: absolute;
        bottom: 1rem;
        left: 1rem;
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        font-size: 0.875rem;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 2;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .eduwisata-card:hover .price-badge {
        opacity: 1;
        transform: translateY(0);
    }

    .eduwisata-content {
        padding: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .eduwisata-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .eduwisata-description {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .eduwisata-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .schedule-link {
        display: inline-flex;
        align-items: center;
        color: #059669;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        background: rgba(5, 150, 105, 0.1);
    }

    .schedule-link:hover {
        color: #047857;
        background: rgba(5, 150, 105, 0.2);
        transform: translateX(5px);
    }

    .rating {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .star {
        color: #fbbf24;
        font-size: 0.875rem;
        transition: transform 0.3s ease;
    }

    .eduwisata-card:hover .star {
        transform: scale(1.2);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .min-h-screen {
            min-height: auto;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .text-4xl {
            font-size: 2rem;
        }

        .text-5xl {
            font-size: 2.5rem;
        }

        .text-lg {
            font-size: 1rem;
        }

        .eduwisata-card {
            border-radius: 1rem;
        }

        .eduwisata-content {
            padding: 1rem;
        }

        .eduwisata-title {
            font-size: 1.125rem;
        }

        .eduwisata-description {
            font-size: 0.8rem;
        }

        .price-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
        }

        .grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1.5rem;
        }

        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    @media (max-width: 480px) {
        .text-4xl {
            font-size: 1.5rem;
        }

        .text-5xl {
            font-size: 2rem;
        }

        .text-lg {
            font-size: 0.9rem;
        }

        .eduwisata-content {
            padding: 0.75rem;
        }

        .eduwisata-title {
            font-size: 1rem;
        }

        .eduwisata-description {
            font-size: 0.75rem;
        }

        .price-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
        }

        .grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 {
            gap: 1rem;
        }
    }

    .features-section {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-radius: 1.5rem;
        padding: 2rem;
        margin: 3rem 0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .feature-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
        transition: left 0.5s;
    }

    .feature-card:hover::before {
        left: 100%;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        width: 4rem;
        height: 4rem;
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .feature-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.75rem;
    }

    .feature-description {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
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
            <h1 class="text-5xl font-bold text-green-800 mb-4">Eduwisata</h1>
            <p class="text-gray-600 text-xl mb-6">Jelajahi pengalaman belajar yang menyenangkan bersama kami</p>
            <div class="w-32 h-1 bg-gradient-to-r from-green-500 to-green-600 mx-auto rounded-full"></div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section animate-fade-in" style="--delay: 0.1s">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="stat-item">
                    <div class="stat-number">{{ $eduwisatas->count() }}</div>
                    <div class="stat-label">Paket Eduwisata</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Peserta</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.8</div>
                    <div class="stat-label">Rating</div>
                </div>
            </div>
        </div>

        <!-- Eduwisata Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($eduwisatas as $eduwisata)
            <div class="eduwisata-card animate-scale-in" style="--delay: {{ $loop->iteration * 0.1 }}s">
                <div class="eduwisata-image-container">
                    @if($eduwisata->image)
                        <img src="{{ asset('storage/' . $eduwisata->image) }}" 
                             alt="{{ $eduwisata->name }}" 
                             class="eduwisata-image">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                            <i class="fas fa-tree text-4xl text-green-500 animate-float"></i>
                        </div>
                    @endif
                    
                    <div class="price-badge">
                        <i class="fas fa-tag me-1"></i>
                        Rp {{ number_format($eduwisata->harga, 0, ',', '.') }}
                    </div>
                </div>

                <div class="eduwisata-content">
                    <h3 class="eduwisata-title">{{ $eduwisata->name }}</h3>
                    <p class="eduwisata-description">{{ $eduwisata->description }}</p>
                    
                    <div class="eduwisata-footer">
                        <a href="{{ route('eduwisata.schedule.detail', $eduwisata->id) }}" 
                           class="schedule-link">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <span>Lihat Jadwal</span>
                            <i class="fas fa-arrow-right ml-2 transition-transform duration-300"></i>
                        </a>
                        <div class="rating">
                            <i class="fas fa-star star"></i>
                            <i class="fas fa-star star"></i>
                            <i class="fas fa-star star"></i>
                            <i class="fas fa-star star"></i>
                            <i class="fas fa-star-half-alt star"></i>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="empty-state animate-fade-in" style="--delay: 0.3s">
                    <i class="fas fa-tree"></i>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Paket Eduwisata</h3>
                    <p class="text-gray-600 text-lg">Paket eduwisata akan segera hadir. Silakan kunjungi kembali nanti.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Features Section -->
        <div class="features-section animate-fade-in" style="--delay: 0.4s">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-green-800 mb-4">Keunggulan Kami</h2>
                <p class="text-gray-600 text-lg">Mengapa memilih eduwisata kami?</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card animate-slide-up" style="--delay: 0.5s">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Pengalaman Interaktif</h3>
                    <p class="feature-description">Belajar langsung dengan metode yang menyenangkan dan interaktif</p>
                </div>

                <div class="feature-card animate-slide-up" style="--delay: 0.6s">
                    <div class="feature-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3 class="feature-title">Pertanian Modern</h3>
                    <p class="feature-description">Pelajari teknik pertanian modern dan ramah lingkungan</p>
                </div>

                <div class="feature-card animate-slide-up" style="--delay: 0.7s">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="feature-title">Sertifikat</h3>
                    <p class="feature-description">Dapatkan sertifikat setelah menyelesaikan program eduwisata</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-12 animate-fade-in" style="--delay: 0.8s">
            <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl p-8 text-white">
                <h3 class="text-2xl font-bold mb-4">Siap untuk Petualangan Belajar?</h3>
                <p class="text-green-100 mb-6">Bergabunglah dengan ribuan peserta yang telah merasakan pengalaman eduwisata kami</p>
                <a href="#contact" class="inline-flex items-center bg-white text-green-600 font-bold py-3 px-6 rounded-lg hover:bg-green-50 transition-colors duration-300">
                    <i class="fas fa-phone me-2"></i>
                    Hubungi Kami
                </a>
            </div>
        </div>

        <!-- Pagination -->
        @if($eduwisatas->hasPages())
            <div class="mt-12 animate-fade-in" style="--delay: 0.9s">
                {{ $eduwisatas->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Add intersection observer for lazy loading animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    // Observe all eduwisata cards
    document.querySelectorAll('.eduwisata-card').forEach(card => {
        observer.observe(card);
    });

    // Add hover effect for schedule links
    document.querySelectorAll('.schedule-link').forEach(link => {
        link.addEventListener('mouseenter', function() {
            const arrow = this.querySelector('.fa-arrow-right');
            if (arrow) {
                arrow.style.transform = 'translateX(5px)';
            }
        });

        link.addEventListener('mouseleave', function() {
            const arrow = this.querySelector('.fa-arrow-right');
            if (arrow) {
                arrow.style.transform = 'translateX(0)';
            }
        });
    });
});
</script>
@endpush
@endsection