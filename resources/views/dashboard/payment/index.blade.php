@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-credit-card mr-2"></i>
            Manajemen Pembayaran
        </h1>
        
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pembayaran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
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
                                Sudah Dibayar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['paid'] }}
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
                                Menunggu Verifikasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['pending'] }}
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
                                Gagal/Expired
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['failed'] }}
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

    <!-- Payment List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list mr-1"></i>
                Daftar Pembayaran
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filter Status:</div>
                    <a class="dropdown-item" href="{{ route('dashboard.payments.index', ['status' => 'pending']) }}">
                        <i class="fas fa-clock text-warning mr-1"></i>
                        Menunggu Verifikasi
                    </a>
                    <a class="dropdown-item" href="{{ route('dashboard.payments.index', ['status' => 'paid']) }}">
                        <i class="fas fa-check text-success mr-1"></i>
                        Sudah Dibayar
                    </a>
                    <a class="dropdown-item" href="{{ route('dashboard.payments.index', ['status' => 'failed']) }}">
                        <i class="fas fa-times text-danger mr-1"></i>
                        Gagal
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('dashboard.payments.index') }}">
                        <i class="fas fa-list mr-1"></i>
                        Semua Pembayaran
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="paymentTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Pemesan</th>
                                <th>Metode</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>
                                    <span class="badge badge-secondary">#{{ $payment->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $payment->order->nama_pemesan }}</div>
                                            <small class="text-muted">{{ $payment->order->telepon }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        <i class="fas fa-{{ $payment->payment_method === 'transfer' ? 'university' : ($payment->payment_method === 'cod' ? 'money-bill' : 'mobile-alt') }} mr-1"></i>
                                        {{ ucfirst($payment->payment_method) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="font-weight-bold text-success">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @if($payment->status === 'paid')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check mr-1"></i>
                                            Sudah Dibayar
                                        </span>
                                    @elseif($payment->status === 'pending')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock mr-1"></i>
                                            Menunggu
                                        </span>
                                    @elseif($payment->status === 'failed')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times mr-1"></i>
                                            Gagal
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-question mr-1"></i>
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-sm">
                                        <div class="font-weight-bold">{{ $payment->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $payment->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dashboard.payments.show', $payment) }}" 
                                           class="btn btn-info btn-sm" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($payment->status === 'pending')
                                            <form action="{{ route('dashboard.payments.verify', $payment) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" 
                                                        title="Verifikasi Pembayaran"
                                                        onclick="return confirm('Verifikasi pembayaran ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('dashboard.payments.reject', $payment) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        title="Tolak Pembayaran"
                                                        onclick="return confirm('Tolak pembayaran ini?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $payments->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-credit-card fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-500">Belum ada data pembayaran</h5>
                    <p class="text-gray-400">Pembayaran akan muncul di sini setelah customer melakukan pembayaran.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Payment Statistics Modal -->
<div class="modal fade" id="paymentStatsModal" tabindex="-1" role="dialog" aria-labelledby="paymentStatsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentStatsModalLabel">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Statistik Pembayaran
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
                                <h6 class="card-title text-primary">Total Pembayaran</h6>
                                <h3 class="text-gray-800">{{ $stats['total'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-left-success">
                            <div class="card-body">
                                <h6 class="card-title text-success">Total Terverifikasi</h6>
                                <h3 class="text-gray-800">{{ $stats['paid'] }}</h3>
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
    $('#paymentTable').DataTable({
        "pageLength": 25,
        "order": [[5, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    // Auto-refresh every 30 seconds for pending payments
    @if($payments->where('status', 'pending')->count() > 0)
    setInterval(function() {
        location.reload();
    }, 30000);
    @endif
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