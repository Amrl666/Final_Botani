@extends('layouts.frontend')

@section('title', 'Eduwisata')

@section('content')

<style>
    /* Bagian umum container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Heading utama */
    h1 {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 40px;
    }

    /* Grid untuk 4 kartu per baris */
    .row {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 4 kolom */
        gap: 20px; /* Jarak antar kartu */
    }

    /* Kartu Eduwisata */
    .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        height: 180px;
        object-fit: cover;
        width: 100%;
        border-bottom: 1px solid #ddd;
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
    }

    .card-text {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 15px;
    }

    .card-text strong {
        font-weight: bold;
        color: #333;
    }

    /* Jadwal Eduwisata */
    .list-group-item {
        font-size: 0.9rem;
        color: #444;
        border: none;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .h5 {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
    }

    /* Tombol "View All Schedules" */
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        font-size: 0.9rem;
        padding: 8px 15px;
        border-radius: 25px;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Mengatur agar tombol berada di tengah */
    .card-footer {
        display: flex;
        justify-content: center; /* Memusatkan tombol secara horizontal */
        padding: 15px;
    }

    /* Responsif untuk tampilan mobile */
    @media (max-width: 1200px) {
        .row {
            grid-template-columns: repeat(3, 1fr); /* 3 kolom untuk layar lebih kecil */
        }
    }

    @media (max-width: 992px) {
        .row {
            grid-template-columns: repeat(2, 1fr); /* 2 kolom untuk layar lebih kecil */
        }
    }

    @media (max-width: 768px) {
        .row {
            grid-template-columns: 1fr; /* 1 kolom untuk layar sangat kecil */
        }

        h1 {
            font-size: 1.5rem;
        }

        .btn-success {
            font-size: 0.85rem;
        }
    }
</style>

<section class="py-5">
    <div class="container">
        <h1 class="mb-5">Eduwisata Program</h1>
        
        <div class="row">
            @foreach($eduwisatas as $eduwisata)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    @if($eduwisata->image)
                        <img src="{{ asset('storage/' . $eduwisata->image) }}" class="card-img-top" alt="{{ $eduwisata->name }}">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ $eduwisata->name }}</h2>
                        <p class="card-text"><strong>Location:</strong> {{ $eduwisata->location }}</p>
                        <p class="card-text">{{ $eduwisata->description }}</p>
                        
                        @if($eduwisata->schedules->count() > 0)
                            <h3 class="h5 mt-4">Available Schedules</h3>
                            <ul class="list-group list-group-flush mb-3">
                                @foreach($eduwisata->schedules->take(3) as $schedule)
                                <li class="list-group-item">
                                    {{ $schedule->date->format('F j, Y') }} at {{ $schedule->time }} (Max: {{ $schedule->max_participants }})
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('eduwisata.schedule') }}" class="btn btn-success">View All Schedules</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection