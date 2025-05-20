@extends('layouts.app')

@section('title', 'BO-TANI - Beranda')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-1 order-2">
                <div class="hero-content">
                    <h1 class="display-5 fw-bold mb-3">Menyemai Harapan, <span class="text-success">Menuai Sukses!</span></h1>
                    <p class="lead mb-4">
                        BO-TANI merupakan platform digital Kelompok Tani Winongo Asri yang menyediakan akses informasi, 
                        pemesanan produk pertanian, booking edu-wisata, dan layanan konsultasi pertanian.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('services') }}" class="btn btn-success btn-lg px-4">
                            <i class="fas fa-leaf me-2"></i> Layanan Kami
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-success btn-lg px-4">
                            <i class="fas fa-shopping-basket me-2"></i> Belanja
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2 order-1 mb-4 mb-lg-0">
                <div class="hero-image position-relative">
                    <img src="{{ asset('images/content/sawizoom.png') }}" alt="Kelompok Tani" class="img-fluid rounded shadow">
                    <img src="{{ asset('images/icons/tomat.png') }}" alt="Tomat" class="floating-icon icon-tomato">
                    <img src="{{ asset('images/icons/bawang.png') }}" alt="Bawang" class="floating-icon icon-garlic">
                    <img src="{{ asset('images/icons/lombokijo.png') }}" alt="Cabai" class="floating-icon icon-chili">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Akses Cepat -->
<section class="features-section py-5 bg-green-custom">
    <div class="container">
        <h2 class="text-center mb-5">Akses Cepat</h2>
        <div class="row flex-nowrap overflow-auto g-4">
        <div class="col-md-3 col-6" style="min-width: 200px;">
            <a href="{{ route('news.index') }}" class="feature-card text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-effect card-click-anim">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <img src="{{ asset('icons/berita.png') }}" alt="Berita" width="40">
                        <h5 class="fw-bold mb-0">Berita</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-6" style="min-width: 200px;">
            <a href="{{ route('products.index') }}" class="feature-card text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-effect card-click-anim">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <img src="{{ asset('icons/store.png') }}" alt="Produk" width="40">
                        <h5 class="fw-bold mb-0">Produk</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-6" style="min-width: 200px;">
            <a href="{{ route('edu-wisata.index') }}" class="feature-card text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-effect card-click-anim">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <img src="{{ asset('icons/edu wisata.png') }}" alt="Edu Wisata" width="40">
                        <h5 class="fw-bold mb-0">Edu Wisata</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-6" style="min-width: 200px;">
            <a href="{{ route('konsultasi.index') }}" class="feature-card text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-effect card-click-anim">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <img src="{{ asset('icons/help.png') }}" alt="Konsultasi" width="40">
                        <h5 class="fw-bold mb-0">Konsultasi</h5>
                    </div>
                </div>
            </a>
        </div>
        </div>

    </div>
</section>
@endsection

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9f5e9 100%);
    }
    .floating-icon {
        position: absolute;
        animation: float 6s ease-in-out infinite;
    }
    .icon-tomato { top: 10%; left: 5%; width: 50px; }
    .icon-garlic { bottom: 15%; right: 8%; width: 45px; animation-delay: 1s; }
    .icon-chili { top: 20%; right: 5%; width: 40px; animation-delay: 2s; }

    .hover-effect:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }

    .card-click-anim {
        transition: transform 0.1s ease;
    }

    .card-click-anim:active {
        transform: scale(0.95);
    }

    .bg-green-custom {
    background-color: #8BBF59;
    
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
</style>
@endpush