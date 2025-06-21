@extends('layouts.frontend')
@section('title', 'Riwayat Pemesanan Eduwisata')

@section('content')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade {
        animation: fadeIn 0.6s ease-out forwards;
        animation-delay: var(--delay, 0s);
        opacity: 0;
    }

    .table-container {
        background: #ffffff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
</style>

<div class="container py-5 animate-fade" style="--delay: 0.2s">
    <h2 class="mb-4 text-center font-bold text-xl text-gray-800">Riwayat Pemesanan Eduwisata</h2>
    <div class="table-container">
        <table class="table table-bordered table-hover">
            <thead class="table-secondary">
                <tr>
                    <th>Tanggal Pesan</th>
                    <th>Program</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Jumlah Orang</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>{{ $order->eduwisata->name ?? '-' }}</td>
                        <td>{{ $order->tanggal_kunjungan ? \Carbon\Carbon::parse($order->tanggal_kunjungan)->format('d M Y') : '-' }}</td>
                        <td>{{ $order->jumlah_orang ?? '-' }}</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada pemesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
