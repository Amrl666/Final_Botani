@extends('layouts.frontend')
@section('title', 'Riwayat Pemesanan Produk')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">Riwayat Pemesanan Produk</h4>
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>{{ $order->produk->name ?? '-' }}</td>
                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada pemesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
