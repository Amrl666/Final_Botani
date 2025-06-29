@extends('layouts.app')

@section('title', 'Manajemen Pengiriman')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-truck mr-2"></i>
            Manajemen Pengiriman
        </h1>
        <div class="d-flex">
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#deliveryStatsModal">
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
                                Total Pengiriman
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $deliveries->total() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
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
                                Terkirim
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $deliveries->where('status', 'delivered')->count() }}
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
                                Dalam Proses
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $deliveries->whereIn('status', ['pending', 'picked_up', 'in_transit', 'out_for_delivery'])->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                Gagal
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $deliveries->where('status', 'failed')->count() }}
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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Delivery List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list mr-1"></i>
                Daftar Pengiriman
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filter Status:</div>
                    <a class="dropdown-item" href="{{ route('dashboard.delivery.index', ['status' => 'pending']) }}">
                        <i class="fas fa-clock text-warning mr-1"></i>
                        Menunggu Pengiriman
                    </a>
                    <a class="dropdown-item" href="{{ route('dashboard.delivery.index', ['status' => 'in_transit']) }}">
                        <i class="fas fa-truck text-info mr-1"></i>
                        Dalam Perjalanan
                    </a>
                    <a class="dropdown-item" href="{{ route('dashboard.delivery.index', ['status' => 'delivered']) }}">
                        <i class="fas fa-check text-success mr-1"></i>
                        Terkirim
                    </a>
                    <a class="dropdown-item" href="{{ route('dashboard.delivery.index', ['status' => 'failed']) }}">
                        <i class="fas fa-times text-danger mr-1"></i>
                        Gagal
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('dashboard.delivery.index') }}">
                        <i class="fas fa-list mr-1"></i>
                        Semua Pengiriman
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($deliveries->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="deliveryTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Tracking Number</th>
                                <th>Pesanan</th>
                                <th>Kurir</th>
                                <th>Status</th>
                                <th>Estimasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deliveries as $delivery)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2">
                                            <i class="fas fa-truck text-white"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $delivery->tracking_number }}</div>
                                            <small class="text-muted">{{ $delivery->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="font-weight-bold">#{{ $delivery->order->id }}</div>
                                        <small class="text-muted">{{ $delivery->order->nama_pemesan }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="font-weight-bold">{{ $delivery->courier_name }}</div>
                                        @if($delivery->courier_phone)
                                            <small class="text-muted">{{ $delivery->courier_phone }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($delivery->status === 'delivered')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check mr-1"></i>
                                            Terkirim
                                        </span>
                                    @elseif($delivery->status === 'failed')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times mr-1"></i>
                                            Gagal
                                        </span>
                                    @elseif($delivery->status === 'in_transit')
                                        <span class="badge badge-info">
                                            <i class="fas fa-truck mr-1"></i>
                                            Dalam Perjalanan
                                        </span>
                                    @elseif($delivery->status === 'out_for_delivery')
                                        <span class="badge badge-primary">
                                            <i class="fas fa-shipping-fast mr-1"></i>
                                            Sedang Dikirim
                                        </span>
                                    @elseif($delivery->status === 'picked_up')
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-hand-holding mr-1"></i>
                                            Sudah Diambil
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock mr-1"></i>
                                            Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($delivery->estimated_delivery)
                                        <div class="text-sm">
                                            <div class="font-weight-bold">{{ $delivery->estimated_delivery->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $delivery->estimated_delivery->format('H:i') }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dashboard.delivery.show', $delivery) }}" 
                                           class="btn btn-info btn-sm"
                                           title="Detail Pengiriman">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-primary btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#updateStatusModal{{ $delivery->id }}"
                                                title="Update Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $deliveries->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-truck fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-500">Belum ada pengiriman</h5>
                    <p class="text-gray-400">Pengiriman akan muncul di sini setelah dibuat.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Update Modals -->
@foreach($deliveries as $delivery)
<div class="modal fade" id="updateStatusModal{{ $delivery->id }}" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel{{ $delivery->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel{{ $delivery->id }}">
                    <i class="fas fa-edit mr-2"></i>
                    Update Status Pengiriman - {{ $delivery->tracking_number }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('dashboard.delivery.update-status', $delivery) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status{{ $delivery->id }}">Status Baru</label>
                        <select class="form-control" id="status{{ $delivery->id }}" name="status" required>
                            <option value="pending" {{ $delivery->status === 'pending' ? 'selected' : '' }}>Menunggu Pengiriman</option>
                            <option value="picked_up" {{ $delivery->status === 'picked_up' ? 'selected' : '' }}>Sudah Diambil</option>
                            <option value="in_transit" {{ $delivery->status === 'in_transit' ? 'selected' : '' }}>Dalam Perjalanan</option>
                            <option value="out_for_delivery" {{ $delivery->status === 'out_for_delivery' ? 'selected' : '' }}>Sedang Dikirim</option>
                            <option value="delivered" {{ $delivery->status === 'delivered' ? 'selected' : '' }}>Terkirim</option>
                            <option value="failed" {{ $delivery->status === 'failed' ? 'selected' : '' }}>Gagal Dikirim</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description{{ $delivery->id }}">Deskripsi</label>
                        <textarea class="form-control" id="description{{ $delivery->id }}" name="description" rows="3" placeholder="Deskripsi status pengiriman..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="location{{ $delivery->id }}">Lokasi (Opsional)</label>
                        <input type="text" class="form-control" id="location{{ $delivery->id }}" name="location" placeholder="Lokasi saat ini...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Delivery Statistics Modal -->
<div class="modal fade" id="deliveryStatsModal" tabindex="-1" role="dialog" aria-labelledby="deliveryStatsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliveryStatsModalLabel">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Statistik Pengiriman
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
                                <h6 class="card-title text-primary">Total Pengiriman</h6>
                                <h3 class="text-gray-800">{{ $deliveries->total() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-left-success">
                            <div class="card-body">
                                <h6 class="card-title text-success">Terkirim</h6>
                                <h3 class="text-gray-800">{{ $deliveries->where('status', 'delivered')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card border-left-warning">
                            <div class="card-body">
                                <h6 class="card-title text-warning">Dalam Proses</h6>
                                <h3 class="text-gray-800">{{ $deliveries->whereIn('status', ['pending', 'picked_up', 'in_transit', 'out_for_delivery'])->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-left-danger">
                            <div class="card-body">
                                <h6 class="card-title text-danger">Gagal</h6>
                                <h3 class="text-gray-800">{{ $deliveries->where('status', 'failed')->count() }}</h3>
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
    $('#deliveryTable').DataTable({
        "pageLength": 25,
        "order": [[0, "desc"]],
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
.avatar-sm {
    width: 32px;
    height: 32px;
}

.badge {
    font-size: 0.75rem;
}

.btn-group .btn {
    margin-right: 2px;
}

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
</style>
@endpush 