@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Keyframe Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 0.99; }
    }

    @keyframes scaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Animation Classes */
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

    /* Stats Card Styling */
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

    /* Timeline Styling */
    .timeline {
        position: relative;
        padding-left: 3rem; /* Default padding for timeline */
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
        opacity: 0;
        animation: slideUp 0.6s ease-out forwards;
    }

    .timeline-item:nth-child(1) { animation-delay: 0.2s; }
    .timeline-item:nth-child(2) { animation-delay: 0.4s; }
    .timeline-item:nth-child(3) { animation-delay: 0.6s; }
    .timeline-item:nth-child(4) { animation-delay: 0.8s; }
    .timeline-item:nth-child(5) { animation-delay: 1.0s; }
    .timeline-item:nth-child(6) { animation-delay: 1.2s; }


    .timeline-marker {
        position: absolute;
        left: -1.5rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px var(--bs-primary);
        background: white;
        transition: all 0.3s ease;
        top: 0.25rem;
    }

    .timeline-item:hover .timeline-marker {
        transform: scale(1.2);
        box-shadow: 0 0 0 3px var(--bs-primary);
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -1rem;
        top: 1rem;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-content {
        background: white;
        border-radius: 0.5rem;
        padding: 1rem; /* Default padding */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .timeline-item:hover .timeline-content {
        transform: translateX(5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Responsive adjustments for dashboard content */

    /* Medium devices (tablets and small laptops) */
    @media (max-width: 991.98px) { /* Corresponds to Bootstrap's lg breakpoint */
        .stats-card {
            padding: 1.2rem; /* Slightly reduced padding */
        }
        .stats-icon {
            width: 44px;
            height: 44px;
            font-size: 22px;
        }
        .stats-card h2 {
            font-size: 1.75rem; /* Make numbers slightly smaller */
        }
        .timeline {
            padding-left: 2.5rem; /* Slightly less left padding for timeline */
        }
        .timeline-marker {
            left: -1.25rem;
            width: 0.9rem;
            height: 0.9rem;
        }
        .timeline-item:not(:last-child)::before {
            left: -0.8rem;
        }
        .timeline-content {
            padding: 0.9rem;
        }
    }

    /* Small devices (phones) */
    @media (max-width: 767.98px) { /* Corresponds to Bootstrap's md breakpoint */
        .stats-card {
            padding: 1rem; /* Further reduced padding */
        }
        .stats-icon {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }
        .stats-card h2 {
            font-size: 1.5rem; /* Smaller numbers */
        }
        .stats-card h6 {
            font-size: 0.85rem; /* Smaller labels */
        }
        .timeline {
            padding-left: 2rem; /* More reduction for timeline padding */
        }
        .timeline-marker {
            left: -1rem;
            width: 0.8rem;
            height: 0.8rem;
        }
        .timeline-item:not(:last-child)::before {
            left: -0.75rem;
        }
        .timeline-content {
            padding: 0.75rem;
            font-size: 0.9rem; /* Smaller text in timeline content */
        }
        .timeline-content h6 {
            font-size: 1rem; /* Smaller timeline titles */
        }
        .timeline-content p {
            font-size: 0.85rem; /* Smaller timeline descriptions */
        }
        .timeline-content small {
            font-size: 0.75rem; /* Smaller time labels */
        }
    }

    /* Extra small devices (portrait phones) */
    @media (max-width: 575.98px) { /* Corresponds to Bootstrap's sm breakpoint */
        .stats-card {
            padding: 0.75rem; /* Minimal padding for stats cards */
        }
        .stats-icon {
            width: 36px;
            height: 36px;
            font-size: 18px;
        }
        .stats-card h2 {
            font-size: 1.25rem;
        }
        .stats-card h6 {
            font-size: 0.75rem;
        }
        .timeline {
            padding-left: 1.5rem; /* Minimal timeline padding */
        }
        .timeline-marker {
            left: -0.75rem;
            width: 0.7rem;
            height: 0.7rem;
        }
        .timeline-item:not(:last-child)::before {
            left: -0.6rem;
        }
        .timeline-content {
            padding: 0.6rem;
            font-size: 0.8rem;
        }
        .timeline-content h6 {
            font-size: 0.9rem;
        }
        .timeline-content p {
            font-size: 0.75rem;
        }
        .timeline-content small {
            font-size: 0.65rem;
        }
    }
</style>

<div class="row g-4">
    <div class="col-12">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="stats-card animate-fade-in" style="--delay: 0.1s">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Products</h6>
                            <h2 class="mb-0">{{ \App\Models\Product::count() }}</h2>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-primary" style="width: 75%"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stats-card animate-fade-in" style="--delay: 0.2s">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h2 class="mb-0">{{ \App\Models\Order::count() }}</h2>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-success" style="width: 85%"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stats-card animate-fade-in" style="--delay: 0.3s">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-school"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Active Eduwisata</h6>
                            <h2 class="mb-0">{{ \App\Models\Eduwisata::count() }}</h2>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-info" style="width: 60%"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stats-card animate-fade-in" style="--delay: 0.4s">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">New Messages</h6>
                            <h2 class="mb-0">{{ \App\Models\Contact::count() }}</h2>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-warning" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm animate-scale-in" style="--delay: 0.5s">
            <div class="card-header bg-white border-bottom-0 py-4">
                <h5 class="card-title mb-0">Recent Activities</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    {{-- Display the last added Product --}}
                    @if($lastProduct = \App\Models\Product::latest()->first())
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Produk Baru</h6>
                            <p class="text-muted mb-0">Produk <strong>{{ $lastProduct->name }}</strong> ditambahkan</p>
                            <small class="text-muted">{{ $lastProduct->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endif

                    {{-- Display the last created Order --}}
                    @if($lastOrder = \App\Models\Order::latest()->first())
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Pemesanan Baru</h6>
                            <p class="text-muted mb-0">{{ $lastOrder->nama_pemesan }} melakukan pemesanan</p>
                            <small class="text-muted">{{ $lastOrder->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endif

                    {{-- Display the last added Eduwisata program --}}
                    @if($lastEduwisata = \App\Models\Eduwisata::latest()->first())
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Program Eduwisata</h6>
                            <p class="text-muted mb-0">Program <strong>{{ $lastEduwisata->name }}</strong> ditambahkan</p>
                            <small class="text-muted">{{ $lastEduwisata->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endif

                    {{-- Display the last received Contact message --}}
                    @if($lastMsg = \App\Models\Contact::latest()->first())
                    <div class="timeline-item">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Pesan Baru</h6>
                            <p class="text-muted mb-0">Pesan dari <strong>{{ $lastMsg->name }}</strong></p>
                            <small class="text-muted">{{ $lastMsg->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection