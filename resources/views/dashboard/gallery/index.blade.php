    @extends('layouts.app')

    @section('title', 'Manajemen Galeri')

    @section('content')
    <style>
        /* --- Animasi --- */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes scaleIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            animation-delay: var(--delay, 0s);
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
            animation-delay: var(--delay, 0s);
        }

        .animate-scale-in {
            animation: scaleIn 0.6s ease-out forwards;
            animation-delay: var(--delay, 0s);
        }

        .animate-zoom-in {
            animation: zoomIn 0.6s ease-out forwards;
            animation-delay: var(--delay, 0s);
        }

        /* --- Kartu Statistik --- */
        .stats-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        /* --- Kartu Galeri (Disamakan dengan Video Card) --- */
        .gallery-card {
            background: white; /* Tambahkan ini */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-radius: 1rem;
            overflow: hidden;
            position: relative;
        }


        .gallery-card:hover {
            transform: translateY(-8px); /* Sama seperti video-card */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); /* Sama seperti video-card */
        }

        /* Efek Shimmer saat Hover */
        .gallery-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%; /* Mulai dari luar kiri */
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
            transition: left 0.5s ease;
            z-index: 1; /* Pastikan di bawah gambar dan overlay */
        }

        .gallery-card:hover::before {
            left: 100%; /* Bergerak ke luar kanan saat hover */
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
            transition: transform 0.5s ease;
            z-index: 2; /* Di atas ::before */
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
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 3; /* Di atas gambar */
        }

        .gallery-card:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-actions {
            display: flex;
            gap: 0.75rem;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .gallery-card:hover .gallery-actions {
            transform: translateY(0);
        }

        .gallery-actions .btn {
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            border: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .gallery-actions .btn:hover {
            transform: scale(1.15);
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .gallery-actions .btn:first-child:hover {
            background: #28a745; /* Green for view */
            color: white;
        }

        .gallery-actions .btn:nth-child(2):hover {
            background: #007bff; /* Blue for edit */
            color: white;
        }

        .gallery-actions .btn:last-child:hover {
            background: #dc3545; /* Red for delete */
            color: white;
        }

        /* --- Gaya Tombol (Disamakan dengan Video Page) --- */
        .btn {
            border-radius: 0.5rem;
            padding: 0.625rem 1.25rem; /* Menyesuaikan padding agar seragam */
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); /* Animasi lebih halus */
            border: none;
            display: inline-flex; /* Untuk ikon + teks yang rapi */
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
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

        /* --- Dropdown Menu (Penting: z-index lebih tinggi) --- */
        .dropdown-menu {
            z-index: 1050; /* Pastikan dropdown muncul di atas elemen lain */
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        /* --- Kartu Umum (Sesuai dengan video page) --- */
        .card {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); /* Menyamakan dengan video card */
            border-radius: 1rem;
            overflow: hidden; /* Penting untuk gambar di dalam card */
        }

        .card-body {
            padding: 1.5rem;
        }

        /* --- Empty State (Disamakan dengan Video Page) --- */
        .empty-state {
            background: white; /* Mengubah latar belakang agar seperti card */
            border-radius: 1rem;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); /* Tambahkan shadow */
            border: none; /* Pastikan tidak ada border */
        }

        .empty-state i {
            font-size: 4rem;
            color: #adb5bd;
            margin-bottom: 1.5rem;
        }

        /* --- Responsive Design --- */
        @media (max-width: 768px) {
            .gallery-actions .btn {
                width: 35px;
                height: 35px;
            }
        }

        /* --- Loading States --- */
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
        .gallery-actions .btn:focus,
        .btn:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
    </style>

    <div class="container-fluid">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Manajemen Galeri</h1>
                <p class="text-muted">Kelola foto dan gambar galeri</p>
            </div>
            <a href="{{ route('dashboard.gallery.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Foto
            </a>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stats-card h-100 animate-fade-in" style="--delay: 0.2s">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-images"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Gambar</h6>
                            <h2 class="mb-0">{{ $galleries->total() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card animate-fade-in" style="--delay: 0.4s">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Bulan Ini</h6>
                            <h2 class="mb-0">{{ $galleries->where('created_at', '>=', now()->startOfMonth())->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse($galleries as $gallery)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="gallery-card animate-zoom-in" style="--delay: {{ $loop->iteration * 0.1 }}s">
                        <div class="gallery-image-container">
                            <img src="{{ asset('storage/' . $gallery->image) }}"
                                class="gallery-image"
                                alt="{{ $gallery->title }}"
                                loading="lazy">
                            <div class="gallery-overlay">
                                <div class="gallery-actions">
                                    <a href="{{ asset('storage/' . $gallery->image) }}"
                                    class="btn"
                                    data-bs-toggle="tooltip"
                                    title="Lihat Ukuran Penuh"
                                    target="_blank">
                                        <i class="fas fa-expand"></i>
                                    </a>
                                    <a href="{{ route('dashboard.gallery.edit', $gallery) }}"
                                    class="btn"
                                    data-bs-toggle="tooltip"
                                    title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.gallery.destroy', $gallery) }}"
                                        method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn"
                                                data-bs-toggle="tooltip"
                                                title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-truncate mb-2">{{ $gallery->title }}</h5>
                            <div class="d-flex align-items-center text-muted">
                                <i class="far fa-calendar-alt me-2"></i>
                                <small>{{ \Carbon\Carbon::parse($gallery->description)->translatedFormat('d F Y') }}</small>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-image me-1"></i>
                                    {{ Str::limit($gallery->title, 30) }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state animate-fade-in" style="--delay: 0.5s">
                        <i class="fas fa-images"></i>
                        <h4 class="text-muted mb-3">Belum Ada Gambar</h4>
                        <p class="text-muted mb-4">Mulai menambahkan gambar ke galeri Anda</p>
                        <a href="{{ route('dashboard.gallery.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Gambar Pertama
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if($galleries->hasPages())
            <div class="d-flex justify-content-center mt-4 animate-fade-in" style="--delay: 0.6s">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.gallery-image');
            images.forEach(img => {
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
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

            // Add hover effects to gallery cards
            const galleryCards = document.querySelectorAll('.gallery-card');
            galleryCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all animated elements
            document.querySelectorAll('.animate-fade-in, .animate-slide-up, .animate-zoom-in').forEach(el => {
                el.style.opacity = '0'; // Ensure initial state for animation
                observer.observe(el);
            });
        });
    </script>
    @endpush
    @endsection