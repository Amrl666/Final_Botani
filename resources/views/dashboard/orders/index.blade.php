@extends('layouts.app')
@section('title', 'Manajemen Pesanan')

@section('content')
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link {{ request('jenis') == null ? 'active' : '' }}" href="{{ route('dashboard.orders.index') }}">Semua</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('jenis') == 'produk' ? 'active' : '' }}" href="{{ route('dashboard.orders.index', ['jenis' => 'produk']) }}">Produk</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('jenis') == 'eduwisata' ? 'active' : '' }}" href="{{ route('dashboard.orders.index', ['jenis' => 'eduwisata']) }}">Eduwisata</a>
    </li>
</ul>

<form method="GET" class="mb-3 d-flex gap-3 flex-wrap">
    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control" style="max-width: 200px">
    <select name="status" class="form-select" style="max-width: 200px">
        <option value="">-- Semua Status --</option>
        @foreach(['menunggu','disetujui','ditolak','selesai'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <select name="jenis" class="form-select" style="max-width: 200px">
        <option value="">-- Semua Jenis --</option>
        <option value="produk" {{ request('jenis') == 'produk' ? 'selected' : '' }}>Produk</option>
        <option value="eduwisata" {{ request('jenis') == 'eduwisata' ? 'selected' : '' }}>Eduwisata</option>
    </select>
    <button class="btn btn-primary">Filter</button>
    <a href="{{ route('orders.export') }}" class="btn btn-success">Export Excel</a>
</form>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Nama</th>
                    <th>No. WA</th>
                    <th>Jumlah</th>
                    <th>Produk</th>
                    <th>Eduwisata</th>
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
                        <td>{{ $order->jumlah_orang ?? '-' }}</td>
                        <td>{{ $order->produk->name ?? '-' }}</td>
                        <td>{{ $order->eduwisata->name ?? '-' }}</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></td>
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
                        <td colspan="8" class="text-center text-muted">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
