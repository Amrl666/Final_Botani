@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-boxes mr-2"></i>
            Manajemen Stok
        </h1>
        <div class="d-flex">
            <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#bulkAdjustModal">
                <i class="fas fa-edit mr-1"></i>
                Penyesuaian Massal
            </button>
            <a href="{{ route('dashboard.stock.export') }}" class="btn btn-success btn-sm mr-2">
                <i class="fas fa-file-excel mr-1"></i>
                Export Excel
            </a>
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#stockStatsModal">
                <i class="fas fa-chart-bar mr-1"></i>
                Statistik
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Produk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stockStats['total_products'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Stok Tersedia
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stockStats['available'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Stok Menipis
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stockStats['low_stock'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Stok Habis
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stockStats['out_of_stock'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    @if($lowStockProducts->count() > 0)
    <div class="card border-left-warning shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Peringatan Stok Menipis
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($lowStockProducts as $product)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card border-warning h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="rounded mr-3" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center mr-3" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-white"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-1">{{ $product->name }}</h6>
                                    <p class="card-text mb-1">
                                        <small class="text-muted">Stok: {{ $product->stock }} {{ $product->unit }}</small>
                                    </p>
                                    <span class="badge badge-warning">Stok Menipis</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Stock List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list mr-1"></i>
                Daftar Stok Produk
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filter Status:</div>
                    <a class="dropdown-item" href="{{ route('dashboard.stock.index', ['status' => 'available']) }}">
                        <i class="fas fa-check text-success mr-1"></i>
                        Stok Tersedia
                    </a>
                    <a class="dropdown-item" href="{{ route('dashboard.stock.index', ['status' => 'low']) }}">
                        <i class="fas fa-exclamation text-warning mr-1"></i>
                        Stok Menipis
                    </a>
                    <a class="dropdown-item" href="{{ route('dashboard.stock.index', ['status' => 'out']) }}">
                        <i class="fas fa-times text-danger mr-1"></i>
                        Stok Habis
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('dashboard.stock.index') }}">
                        <i class="fas fa-list mr-1"></i>
                        Semua Produk
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="stockTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Produk</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Harga</th>
                                <th>Terakhir Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="rounded mr-3" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center mr-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-image text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-weight-bold">{{ $product->name }}</div>
                                            <small class="text-muted">{{ $product->unit }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="font-weight-bold mr-2">{{ $product->stock }}</span>
                                        <span class="text-muted">{{ $product->unit }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($product->stock <= 0)
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times mr-1"></i>
                                            Habis
                                        </span>
                                    @elseif($product->stock <= 10)
                                        <span class="badge badge-warning">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Menipis
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            <i class="fas fa-check mr-1"></i>
                                            Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="font-weight-bold text-success">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-sm">
                                        <div class="font-weight-bold">{{ $product->updated_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $product->updated_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#adjustStockModal{{ $product->id }}"
                                                title="Sesuaikan Stok">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="{{ route('dashboard.stock.history', $product) }}" 
                                           class="btn btn-info btn-sm"
                                           title="Riwayat Stok">
                                            <i class="fas fa-history"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-boxes fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-500">Belum ada data produk</h5>
                    <p class="text-gray-400">Produk akan muncul di sini setelah ditambahkan.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Stock Adjustment Modals -->
@foreach($products as $product)
<div class="modal fade" id="adjustStockModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="adjustStockModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustStockModalLabel{{ $product->id }}">
                    <i class="fas fa-edit mr-2"></i>
                    Sesuaikan Stok - {{ $product->name }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('dashboard.stock.adjust', $product) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type{{ $product->id }}">Jenis Penyesuaian</label>
                                <select class="form-control" id="type{{ $product->id }}" name="type" required>
                                    <option value="in">Stok Masuk (+)</option>
                                    <option value="out">Stok Keluar (-)</option>
                                    <option value="adjustment">Penyesuaian</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity{{ $product->id }}">Jumlah</label>
                                <input type="number" class="form-control" id="quantity{{ $product->id }}" name="quantity" min="1" step="0.01" required>
                                <small class="form-text text-muted">Stok saat ini: {{ $product->stock }} {{ $product->unit }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes{{ $product->id }}">Catatan</label>
                        <textarea class="form-control" id="notes{{ $product->id }}" name="notes" rows="3" placeholder="Alasan penyesuaian stok..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Bulk Adjustment Modal -->
<div class="modal fade" id="bulkAdjustModal" tabindex="-1" role="dialog" aria-labelledby="bulkAdjustModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkAdjustModalLabel">
                    <i class="fas fa-edit mr-2"></i>
                    Penyesuaian Stok Massal
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('dashboard.stock.bulk-adjust') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulk_type">Jenis Penyesuaian</label>
                                <select class="form-control" id="bulk_type" name="type" required>
                                    <option value="in">Stok Masuk (+)</option>
                                    <option value="out">Stok Keluar (-)</option>
                                    <option value="adjustment">Penyesuaian</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bulk_notes">Catatan</label>
                                <input type="text" class="form-control" id="bulk_notes" name="notes" placeholder="Catatan untuk semua produk...">
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Stok Saat Ini</th>
                                    <th>Jumlah Penyesuaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products->take(10) as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->stock }} {{ $product->unit }}</td>
                                    <td>
                                        <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}">
                                        <input type="number" class="form-control form-control-sm" 
                                               name="products[{{ $loop->index }}][quantity]" 
                                               min="0" step="0.01" placeholder="0">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Perubahan Massal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Stock Statistics Modal -->
<div class="modal fade" id="stockStatsModal" tabindex="-1" role="dialog" aria-labelledby="stockStatsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockStatsModalLabel">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Statistik Stok
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-left-primary">
                            <div class="card-body">
                                <h6 class="card-title text-primary">Total Produk</h6>
                                <h3 class="text-gray-800">{{ $stockStats['total_products'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-left-success">
                            <div class="card-body">
                                <h6 class="card-title text-success">Stok Tersedia</h6>
                                <h3 class="text-gray-800">{{ $stockStats['available'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card border-left-warning">
                            <div class="card-body">
                                <h6 class="card-title text-warning">Stok Menipis</h6>
                                <h3 class="text-gray-800">{{ $stockStats['low_stock'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-left-danger">
                            <div class="card-body">
                                <h6 class="card-title text-danger">Stok Habis</h6>
                                <h3 class="text-gray-800">{{ $stockStats['out_of_stock'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#stockTable').DataTable({
        "pageLength": 25,
        "order": [[1, "asc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    // Auto-refresh every 60 seconds
    setInterval(function() {
        location.reload();
    }, 60000);
});
</script>
@endpush

@push('styles')
<style>
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.075);
}

.badge {
    font-size: 0.75rem;
}

.btn-group .btn {
    margin-right: 2px;
}
</style>
@endpush 