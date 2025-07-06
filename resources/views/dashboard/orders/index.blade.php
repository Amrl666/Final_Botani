@extends('layouts.app')
@section('title', 'Manajemen Pesanan')

@section('content')
<style>
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

    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 2rem;
    }

    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #6c757d;
        font-weight: 500;
        padding: 1rem 1.5rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-tabs .nav-link:hover {
        color: var(--bs-primary);
        background: transparent;
        border-color: transparent;
    }

    .nav-tabs .nav-link.active {
        color: var(--bs-primary);
        background: transparent;
        border-color: var(--bs-primary);
        font-weight: 600;
    }

    .filter-section {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .form-control, .form-select {
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .btn {
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .table {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .table thead th {
        background: var(--bs-primary);
        color: white;
        font-weight: 600;
        border: none;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    .badge {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.5rem;
    }

    .status-menunggu { background-color: #ffc107; color: #000; }
    .status-disetujui { background-color: #198754; color: #fff; }
    .status-ditolak { background-color: #dc3545; color: #fff; }
    .status-selesai { background-color: #0d6efd; color: #fff; }

    .order-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .order-actions .form-select {
        font-size: 0.875rem;
        padding: 0.5rem;
    }

    .order-actions .btn {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }

    .stats-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        transition: transform 0.3s ease;
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
    }
</style>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in" style="--delay: 0.1s">
        <div>
            <h1 class="h3 mb-0">Manajemen Pesanan</h1>
            <p class="text-muted">Kelola dan pantau semua pesanan produk dan eduwisata</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('orders.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Export Excel
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card animate-fade-in" style="--delay: 0.2s">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Pesanan</h6>
                        <h3 class="mb-0">{{ $orders->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card animate-fade-in" style="--delay: 0.3s">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Menunggu</h6>
                        <h3 class="mb-0">{{ $orders->where('status', 'menunggu')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card animate-fade-in" style="--delay: 0.4s">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Disetujui</h6>
                        <h3 class="mb-0">{{ $orders->where('status', 'disetujui')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card animate-fade-in" style="--delay: 0.5s">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stats-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Total Pendapatan</h6>
                        <h3 class="mb-0">
                            Rp {{ number_format($orders->whereIn('status', ['disetujui', 'selesai'])->sum('total_harga'), 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4 animate-slide-up" style="--delay: 0.6s">
        <li class="nav-item">
            <a class="nav-link {{ request('jenis') == null ? 'active' : '' }}" href="{{ route('dashboard.orders.index') }}">
                <i class="fas fa-list me-2"></i>Semua
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('jenis') == 'produk' ? 'active' : '' }}" href="{{ route('dashboard.orders.index', ['jenis' => 'produk']) }}">
                <i class="fas fa-box me-2"></i>Produk
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('jenis') == 'eduwisata' ? 'active' : '' }}" href="{{ route('dashboard.orders.index', ['jenis' => 'eduwisata']) }}">
                <i class="fas fa-school me-2"></i>Eduwisata
            </a>
        </li>
    </ul>

    <!-- Filter Section -->
    <div class="filter-section animate-slide-up" style="--delay: 0.7s">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    @foreach(['menunggu','disetujui','ditolak','selesai'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Jenis</label>
                <select name="jenis" class="form-select">
                    <option value="">-- Semua Jenis --</option>
                    <option value="produk" {{ request('jenis') == 'produk' ? 'selected' : '' }}>Produk</option>
                    <option value="eduwisata" {{ request('jenis') == 'eduwisata' ? 'selected' : '' }}>Eduwisata</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

     <!-- Orders Table -->
        <div class="card border-0 shadow-sm animate-scale-in" style="--delay: 0.2s">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Jumlah</th>
                                <th>Pesanan</th>
                                <th>Tanggal Kunjungan</th>
                                <th>Keterangan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->nama_pemesan }}</td>
                                    <td>{{ $order->telepon }}</td>
                                    <td>{{ $order->alamat ?? '-' }}</td>
                                    <td>
                                        {{ $order->jumlah_orang ?? '-' }}
                                    </td>
                                    <td>
                                        @if($order->orderItems->isNotEmpty())
                                            <ul class="list-unstyled mb-0 small">
                                                @foreach($order->orderItems as $item)
                                                    <li>- {{ $item->product->name }} ({{ $item->quantity }} kg)</li>
                                                @endforeach
                                            </ul>
                                        @elseif($order->produk)
                                            <div class="fw-bold">{{ $order->produk->name }}</div>
                                            <div class="small text-muted">{{ $order->jumlah ?? 0 }} kg</div>
                                        @elseif($order->eduwisata)
                                            <div class="fw-bold">{{ $order->eduwisata->name }}</div>
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->tanggal_kunjungan ? date('d M Y', strtotime($order->tanggal_kunjungan)) : '-' }}</td>
                                    <td>{{ $order->keterangan ?? '-' }}</td>
                                    <td>
                                        <div class="fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                                    </td>
                                    <td>
                                        <span class="badge status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('order.update', $order) }}">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm mb-1">
                                                @foreach(['menunggu','disetujui','ditolak','selesai'] as $s)
                                                    <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-sm btn-primary">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">Tidak ada data ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
    @if($orders->hasPages())
        <div class="d-flex justify-content-center mt-5 animate-fade-in" style="--delay: 0.9s">
                    <nav aria-label="Navigasi halaman">
                        <ul class="pagination pagination-lg shadow-sm">
                            {{-- Tombol Sebelumnya --}}
                            @if ($orders->onFirstPage())
                                <li class="page-item disabled" aria-disabled="true">
                                    <span class="page-link">‹</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">‹</a>
                                </li>
                            @endif

                            {{-- Angka Halaman --}}
                            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                <li class="page-item {{ $orders->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            {{-- Tombol Selanjutnya --}}
                            @if ($orders->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">›</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true">
                                    <span class="page-link">›</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </div>


<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
}
</style>
@endsection