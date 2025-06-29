@extends('layouts.app')

@section('title', 'Detail Pengiriman')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-truck mr-2"></i>
                Detail Pengiriman
            </h1>
            <p class="text-muted">Tracking Number: {{ $delivery->tracking_number }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.delivery.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
            <a href="{{ route('dashboard.orders.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-list mr-1"></i>
                Lihat Pesanan
            </a>
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

    <div class="row">
        <!-- Delivery Information -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle mr-1"></i>
                        Informasi Pengiriman
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Status:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $delivery->status_color }}">
                                        {{ $delivery->status_text }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Kurir:</strong></td>
                                <td>{{ $delivery->courier_name }}</td>
                            </tr>
                            @if($delivery->courier_phone)
                                <tr>
                                    <td><strong>Telepon Kurir:</strong></td>
                                    <td>
                                        <a href="tel:{{ $delivery->courier_phone }}" class="text-primary">
                                            {{ $delivery->courier_phone }}
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>Ongkos Kirim:</strong></td>
                                <td class="font-weight-bold text-success">
                                    Rp {{ number_format($delivery->shipping_cost, 0, ',', '.') }}
                                </td>
                            </tr>
                            @if($delivery->estimated_delivery)
                                <tr>
                                    <td><strong>Estimasi:</strong></td>
                                    <td>{{ $delivery->estimated_delivery->format('d M Y H:i') }}</td>
                                </tr>
                            @endif
                            @if($delivery->delivered_at)
                                <tr>
                                    <td><strong>Diterima:</strong></td>
                                    <td>{{ $delivery->delivered_at->format('d M Y H:i') }}</td>
                                </tr>
                            @endif
                            @if($delivery->notes)
                                <tr>
                                    <td><strong>Catatan:</strong></td>
                                    <td>{{ $delivery->notes }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <!-- Update Status Form -->
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-edit mr-1"></i>
                            Update Status
                        </h6>
                        
                        
                        <form action="{{ route('dashboard.delivery.update-status', $delivery) }}" method="POST" id="updateStatusForm">
                            @csrf
                            @method('PATCH')
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="status" class="form-label">
                                        <strong>Status Baru</strong>
                                    </label>
                                    <select name="status" id="status" required class="form-control">
                                        <option value="pending" {{ $delivery->status === 'pending' ? 'selected' : '' }}>Menunggu Pengiriman</option>
                                        <option value="picked_up" {{ $delivery->status === 'picked_up' ? 'selected' : '' }}>Sudah Diambil</option>
                                        <option value="in_transit" {{ $delivery->status === 'in_transit' ? 'selected' : '' }}>Dalam Perjalanan</option>
                                        <option value="out_for_delivery" {{ $delivery->status === 'out_for_delivery' ? 'selected' : '' }}>Sedang Dikirim</option>
                                        <option value="delivered" {{ $delivery->status === 'delivered' ? 'selected' : '' }}>Terkirim</option>
                                        <option value="failed" {{ $delivery->status === 'failed' ? 'selected' : '' }}>Gagal Dikirim</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">
                                        <strong>Deskripsi</strong>
                                    </label>
                                    <textarea name="description" id="description" rows="3"
                                              class="form-control"
                                              placeholder="Deskripsi status pengiriman..."></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="location" class="form-label">
                                        <strong>Lokasi (Opsional)</strong>
                                    </label>
                                    <input type="text" name="location" id="location"
                                           class="form-control"
                                           placeholder="Lokasi saat ini...">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success w-100" id="updateStatusBtn">
                                        <i class="fas fa-save mr-1"></i>
                                        Update Status
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Information -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        Informasi Pesanan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>ID Pesanan:</strong></td>
                                <td>#{{ $delivery->order->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pemesan:</strong></td>
                                <td>{{ $delivery->order->nama_pemesan }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon:</strong></td>
                                <td>
                                    <a href="tel:{{ $delivery->order->telepon }}" class="text-primary">
                                        {{ $delivery->order->telepon }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status Pesanan:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $delivery->order->status === 'selesai' ? 'success' : ($delivery->order->status === 'menunggu' ? 'warning' : 'info') }}">
                                        {{ ucfirst($delivery->order->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Subtotal:</strong></td>
                                <td>Rp {{ number_format($delivery->order->total_harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ongkir:</strong></td>
                                <td>Rp {{ number_format($delivery->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td class="font-weight-bold text-success">
                                    Rp {{ number_format($delivery->order->total_harga + $delivery->shipping_cost, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Order Items -->
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-box mr-1"></i>
                            Item Pesanan
                        </h6>
                        @if($delivery->order->orderItems->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($delivery->order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                                 alt="{{ $item->product->name }}" 
                                                                 class="w-8 h-8 object-cover rounded mr-2">
                                                        @else
                                                            <div class="w-8 h-8 bg-gray-200 rounded d-flex align-items-center justify-content-center mr-2">
                                                                <i class="fas fa-box text-gray-400"></i>
                                                            </div>
                                                        @endif
                                                        <span>{{ $item->product->name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $item->quantity }} {{ $item->product->unit }}</td>
                                                <td>Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}</td>
                                                <td class="font-weight-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                @if($delivery->order->produk)
                                    <strong>{{ $delivery->order->produk->name }}</strong><br>
                                    Jumlah: {{ $delivery->order->jumlah }} {{ $delivery->order->produk->unit }}<br>
                                    Harga: Rp {{ number_format($delivery->order->produk->price, 0, ',', '.') }}
                                @elseif($delivery->order->eduwisata)
                                    <strong>{{ $delivery->order->eduwisata->name }}</strong><br>
                                    Jumlah: {{ $delivery->order->jumlah_orang }} orang<br>
                                    Harga: Rp {{ number_format($delivery->order->eduwisata->harga, 0, ',', '.') }}
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Shipping Address -->
                    @if($delivery->shippingAddress)
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="font-weight-bold text-primary mb-3">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                Alamat Pengiriman
                            </h6>
                            <div class="alert alert-info">
                                <strong>{{ $delivery->shippingAddress->recipient_name }}</strong><br>
                                {{ $delivery->shippingAddress->full_address }}<br>
                                Telepon: {{ $delivery->shippingAddress->phone }}
                                @if($delivery->shippingAddress->notes)
                                    <br>Catatan: {{ $delivery->shippingAddress->notes }}
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tracking History -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history mr-1"></i>
                        Riwayat Tracking
                    </h6>
                </div>
                <div class="card-body">
                    @if($delivery->trackingLogs->isNotEmpty())
                        <div class="timeline">
                            @foreach($delivery->trackingLogs->sortByDesc('tracked_at') as $log)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $log->status === 'delivered' ? 'success' : ($log->status === 'failed' ? 'danger' : 'primary') }}"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="font-weight-bold">{{ $log->description }}</h6>
                                                @if($log->location)
                                                    <p class="text-muted mb-1">
                                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                                        {{ $log->location }}
                                                    </p>
                                                @endif
                                            </div>
                                            <small class="text-muted">
                                                {{ $log->tracked_at->format('d M Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-history fa-2x mb-2"></i>
                            <p>Belum ada riwayat tracking</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Debug form submission
    $('form[action*="update-status"]').on('submit', function(e) {
        console.log('Form submitted!');
        console.log('Form action:', $(this).attr('action'));
        console.log('Form method:', $(this).attr('method'));
        console.log('Form data:', $(this).serialize());
        
        // Show loading state
        $('#updateStatusBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Updating...');
    });
    
    // Debug button click
    $('#updateStatusBtn').on('click', function(e) {
        console.log('Button clicked!');
    });
});
</script>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e3e6f0;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e3e6f0;
}

.timeline-content {
    background: #f8f9fc;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #4e73df;
}
</style>
@endsection 