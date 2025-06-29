@extends('layouts.app')

@section('title', 'Buat Pengiriman')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-truck mr-2"></i>
                Buat Pengiriman
            </h1>
            <p class="text-muted">Pesanan #{{ $order->id }} - {{ $order->nama_pemesan }}</p>
        </div>
        <a href="{{ route('dashboard.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali ke Pesanan
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-1"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Order Information Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle mr-1"></i>
                Informasi Pesanan
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="font-weight-bold text-primary mb-3">Detail Pemesan</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="120"><strong>Nama:</strong></td>
                            <td>{{ $order->nama_pemesan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Telepon:</strong></td>
                            <td>{{ $order->telepon }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge badge-{{ $order->status === 'disetujui' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td class="font-weight-bold text-success">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="font-weight-bold text-primary mb-3">Item Pesanan</h6>
                    @if($order->orderItems->isNotEmpty())
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
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
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
                            @if($order->produk)
                                <strong>{{ $order->produk->name }}</strong><br>
                                Jumlah: {{ $order->jumlah }} {{ $order->produk->unit }}<br>
                                Harga: Rp {{ number_format($order->produk->price, 0, ',', '.') }}
                            @elseif($order->eduwisata)
                                <strong>{{ $order->eduwisata->name }}</strong><br>
                                Jumlah: {{ $order->jumlah_orang }} orang<br>
                                Harga: Rp {{ number_format($order->eduwisata->harga, 0, ',', '.') }}
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delivery Form Card -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-edit mr-1"></i>
                Form Pengiriman
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.delivery.store', $order) }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="shipping_address_id" class="form-label">
                            <strong>Alamat Pengiriman *</strong>
                        </label>
                        <select name="shipping_address_id" id="shipping_address_id" required
                                class="form-control @error('shipping_address_id') is-invalid @enderror">
                            <option value="">Pilih alamat pengiriman</option>
                            @foreach($shippingAddresses as $address)
                                <option value="{{ $address->id }}" {{ old('shipping_address_id') == $address->id ? 'selected' : '' }}>
                                    {{ $address->recipient_name }} - {{ $address->full_address }}
                                </option>
                            @endforeach
                        </select>
                        @error('shipping_address_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="courier_name" class="form-label">
                            <strong>Nama Kurir *</strong>
                        </label>
                        <input type="text" 
                               name="courier_name" 
                               id="courier_name" 
                               required
                               value="{{ old('courier_name') }}"
                               class="form-control @error('courier_name') is-invalid @enderror"
                               placeholder="Masukkan nama kurir">
                        @error('courier_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="courier_phone" class="form-label">
                            <strong>Telepon Kurir</strong>
                        </label>
                        <input type="tel" 
                               name="courier_phone" 
                               id="courier_phone" 
                               value="{{ old('courier_phone') }}"
                               class="form-control @error('courier_phone') is-invalid @enderror"
                               placeholder="Masukkan nomor telepon kurir">
                        @error('courier_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="shipping_cost" class="form-label">
                            <strong>Ongkos Kirim (Rp) *</strong>
                        </label>
                        <input type="number" 
                               name="shipping_cost" 
                               id="shipping_cost" 
                               required
                               min="0"
                               step="1000"
                               value="{{ old('shipping_cost', 0) }}"
                               class="form-control @error('shipping_cost') is-invalid @enderror"
                               placeholder="Masukkan ongkos kirim">
                        @error('shipping_cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="estimated_delivery" class="form-label">
                            <strong>Estimasi Pengiriman</strong>
                        </label>
                        <input type="datetime-local" 
                               name="estimated_delivery" 
                               id="estimated_delivery" 
                               value="{{ old('estimated_delivery') }}"
                               class="form-control @error('estimated_delivery') is-invalid @enderror">
                        @error('estimated_delivery')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="notes" class="form-label">
                            <strong>Catatan</strong>
                        </label>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="3"
                                  placeholder="Catatan tambahan untuk pengiriman..."
                                  class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dashboard.orders.index') }}" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-times mr-1"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-truck mr-1"></i>
                                Buat Pengiriman
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 