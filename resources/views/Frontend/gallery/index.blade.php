@extends('layouts.frontend')

@section('title', 'Gallery')

@section('content')

<style>
    /* Container utama */
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

    /* Card gallery */
    .card {
        background-color: #fff; /* Warna putih */
        border: 1px solid #ddd; /* Border tipis */
        border-radius: 10px; /* Lengkung pada sudut */
        transition: box-shadow 0.3s ease-in-out;
        height: 100%;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Efek saat hover */
    }

    .card-img-top {
        width: 100%;
        height: 220px; /* Gambar lebih besar */
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }

    .card-body {
        padding: 15px;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
    }

    .card-text {
        font-size: 1rem;
        color: #2f5d27; /* Warna hijau */
        margin-bottom: 0;
    }

    /* Grid: 2 kolom di desktop, 1 kolom di mobile */
    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
    }

    .col-md-6 {
        flex: 0 0 calc(50% - 15px); /* 2 kolom dengan gap */
    }

    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%; /* 1 kolom di mobile */
        }

        h1 {
            font-size: 1.5rem;
        }

        .card-img-top {
            height: 180px;
        }
    }

    /* Pagination styling (optional, depends on framework styling) */
    .pagination {
        justify-content: center;
        margin-top: 40px;
    }
</style>

<section class="py-5">
    <div class="container">
        <h1>Our Gallery</h1>

        <div class="row">
            @foreach($galleries as $gallery)
            <div class="col-md-6">
                <div class="card">
                    @if($gallery->image)
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top" alt="{{ $gallery->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $gallery->title }}</h5>
                        @if($gallery->description)
                            <p class="card-text">{{ Str::limit($gallery->description, 50) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $galleries->links() }}
        </div>
    </div>
</section>

@endsection
