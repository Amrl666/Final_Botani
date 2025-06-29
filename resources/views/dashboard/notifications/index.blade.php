@extends('layouts.app')

@section('title', 'Manajemen Notifikasi')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-bell mr-2"></i>
            Manajemen Notifikasi
        </h1>
        <div class="d-flex">
            <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#sendNotificationModal">
                <i class="fas fa-paper-plane mr-1"></i>
                Kirim Notifikasi
            </button>
            <button type="button" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#sendPromoModal">
                <i class="fas fa-gift mr-1"></i>
                Kirim Promo
            </button>
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#notificationStatsModal">
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
                                Total Notifikasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bell fa-2x text-gray-300"></i>
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
                                Belum Dibaca
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['unread'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
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
                                Sudah Dibaca
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['read'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Customer Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Customer::where('is_active', true)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-info shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-bolt mr-1"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <form action="{{ route('dashboard.notifications.mark-all-read') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm btn-block">
                                    <i class="fas fa-check-double mr-1"></i>
                                    Tandai Semua Dibaca
                                </button>
                            </form>
                        </div>
                        <div class="col-md-3 mb-2">
                            <form action="{{ route('dashboard.notifications.clear-all') }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Hapus semua notifikasi?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm btn-block">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus Semua
                                </button>
                            </form>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#sendNotificationModal">
                                <i class="fas fa-paper-plane mr-1"></i>
                                Kirim Notifikasi
                            </button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button type="button" class="btn btn-success btn-sm btn-block" data-toggle="modal" data-target="#sendPromoModal">
                                <i class="fas fa-gift mr-1"></i>
                                Kirim Promo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list mr-1"></i>
                Daftar Notifikasi
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filter Status:</div>
                    <a class="dropdown-item" href="{{ route('dashboard.notifications.index', ['status' => 'unread']) }}">
                        <i class="fas fa-envelope text-warning mr-1"></i>
                        Belum Dibaca
                    </a>
                    <a class="dropdown-item" href="{{ route('dashboard.notifications.index', ['status' => 'read']) }}">
                        <i class="fas fa-envelope-open text-success mr-1"></i>
                        Sudah Dibaca
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('dashboard.notifications.index') }}">
                        <i class="fas fa-list mr-1"></i>
                        Semua Notifikasi
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($notifications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="notificationTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Customer</th>
                                <th>Tipe</th>
                                <th>Judul</th>
                                <th>Pesan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifications as $notification)
                            <tr class="{{ $notification->isRead() ? '' : 'table-warning' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $notification->customer->name }}</div>
                                            <small class="text-muted">{{ $notification->customer->phone }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $typeIcons = [
                                            'order_status' => 'shopping-cart',
                                            'payment' => 'credit-card',
                                            'stock_alert' => 'exclamation-triangle',
                                            'promo' => 'gift',
                                            'system' => 'cog'
                                        ];
                                        $typeColors = [
                                            'order_status' => 'info',
                                            'payment' => 'success',
                                            'stock_alert' => 'warning',
                                            'promo' => 'primary',
                                            'system' => 'secondary'
                                        ];
                                    @endphp
                                    <span class="badge badge-{{ $typeColors[$notification->type] ?? 'secondary' }}">
                                        <i class="fas fa-{{ $typeIcons[$notification->type] ?? 'bell' }} mr-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $notification->title }}</div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $notification->message }}">
                                        {{ Str::limit($notification->message, 50) }}
                                    </div>
                                </td>
                                <td>
                                    @if($notification->isRead())
                                        <span class="badge badge-success">
                                            <i class="fas fa-check mr-1"></i>
                                            Dibaca
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-envelope mr-1"></i>
                                            Belum Dibaca
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-sm">
                                        <div class="font-weight-bold">{{ $notification->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $notification->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if(!$notification->isRead())
                                            <form action="{{ route('dashboard.notifications.mark-read', $notification) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" title="Tandai Dibaca">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('dashboard.notifications.destroy', $notification) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    title="Hapus Notifikasi"
                                                    onclick="return confirm('Hapus notifikasi ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bell fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-500">Belum ada notifikasi</h5>
                    <p class="text-gray-400">Notifikasi akan muncul di sini setelah dikirim.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Send Notification Modal -->
<div class="modal fade" id="sendNotificationModal" tabindex="-1" role="dialog" aria-labelledby="sendNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendNotificationModalLabel">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Notifikasi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('dashboard.notifications.send') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Tipe Notifikasi</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="order_status">Status Pesanan</option>
                                    <option value="payment">Pembayaran</option>
                                    <option value="stock_alert">Peringatan Stok</option>
                                    <option value="promo">Promo</option>
                                    <option value="system">Sistem</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_ids">Target Customer</label>
                                <select class="form-control" id="customer_ids" name="customer_ids[]" multiple>
                                    <option value="">Semua Customer</option>
                                    @foreach(\App\Models\Customer::where('is_active', true)->get() as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Kosongkan untuk mengirim ke semua customer</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title">Judul Notifikasi</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="send_whatsapp" name="send_whatsapp">
                            <label class="custom-control-label" for="send_whatsapp">
                                <i class="fab fa-whatsapp text-success mr-1"></i>
                                Kirim juga via WhatsApp
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane mr-1"></i>
                        Kirim Notifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send Promo Modal -->
<div class="modal fade" id="sendPromoModal" tabindex="-1" role="dialog" aria-labelledby="sendPromoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendPromoModalLabel">
                    <i class="fas fa-gift mr-2"></i>
                    Kirim Promo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('dashboard.notifications.send-promo') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="promo_title">Judul Promo</label>
                        <input type="text" class="form-control" id="promo_title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="promo_message">Pesan Promo</label>
                        <textarea class="form-control" id="promo_message" name="message" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="promo_whatsapp" name="send_whatsapp">
                            <label class="custom-control-label" for="promo_whatsapp">
                                <i class="fab fa-whatsapp text-success mr-1"></i>
                                Kirim juga via WhatsApp
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-gift mr-1"></i>
                        Kirim Promo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification Statistics Modal -->
<div class="modal fade" id="notificationStatsModal" tabindex="-1" role="dialog" aria-labelledby="notificationStatsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationStatsModalLabel">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Statistik Notifikasi
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
                                <h6 class="card-title text-primary">Total Notifikasi</h6>
                                <h3 class="text-gray-800">{{ $stats['total'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-left-warning">
                            <div class="card-body">
                                <h6 class="card-title text-warning">Belum Dibaca</h6>
                                <h3 class="text-gray-800">{{ $stats['unread'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card border-left-success">
                            <div class="card-body">
                                <h6 class="card-title text-success">Sudah Dibaca</h6>
                                <h3 class="text-gray-800">{{ $stats['read'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-left-info">
                            <div class="card-body">
                                <h6 class="card-title text-info">Customer Aktif</h6>
                                <h3 class="text-gray-800">{{ \App\Models\Customer::where('is_active', true)->count() }}</h3>
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
    $('#notificationTable').DataTable({
        "pageLength": 25,
        "order": [[5, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    // Auto-refresh every 30 seconds for unread notifications
    @if($stats['unread'] > 0)
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

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.075);
}

.table-warning {
    background-color: #fff3cd !important;
}
</style>
@endpush 