@extends('layouts.frontend')

@section('title', 'Eduwisata')

@section('content')

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 40px;
    }

    .row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    /* Card dengan border hitam tipis dan background hijau muda */
    .card {
        background-color: #d7f3d3; /* hijau muda */
        border: 1px solid #000; /* border hitam tipis */
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
        color: inherit;
        overflow: hidden;
        transition: background-color 0.2s ease;
    }

    .card:hover {
        background-color: #c5e7be;
    }

    /* Foto full lebar di atas */
    .card-img-top {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
        display: block;
    }

    /* Header bawah foto: judul kiri, lokasi kanan */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px 8px;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
        color: #333;
    }

    .card-location {
        font-size: 1rem;
        font-weight: 600;
        color: #2f5d27; /* hijau tua */
    }

    /* Deskripsi */
    .card-body {
        padding: 0 15px 15px;
        flex-grow: 1;
    }

    .card-text {
        font-size: 1rem;
        color: #334d1a;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Responsif */
    @media (max-width: 1200px) {
        .row {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 992px) {
        .row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .row {
            grid-template-columns: 1fr;
        }

        h1 {
            font-size: 1.5rem;
        }
    }
</style>

<section class="py-5">
    <div class="container">
        <h1 class="mb-5">Eduwisata Program</h1>
        
        <div class="row">
            @foreach($eduwisatas as $eduwisata)
                <a href="{{ route('eduwisata.schedule') }}" class="card">
                    @if($eduwisata->image)
                        <img src="{{ asset('storage/' . $eduwisata->image) }}" alt="{{ $eduwisata->name }}" class="card-img-top">
                    @endif
                    <div class="card-header">
                        <h2 class="card-title">{{ $eduwisata->name }}</h2>
                        <div class="card-location">{{ $eduwisata->location }}</div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $eduwisata->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
