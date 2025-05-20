@extends('layouts.app')

@section('title', 'Galeri Kegiatan')

@section('content')
<div class="container py-4">
    <!-- Judul Galeri -->
    <div class="mb-4">
        <h2 class="border-start border-5 border-success ps-3 fw-bold">Galeri Kegiatan</h2>
    </div>

    <!-- Galeri Grid -->
    <div class="row g-4">
        @foreach($galleries as $gallery)
            <div class="col-md-6 col-lg-6">
                <div class="card shadow-sm rounded-4 h-100 border-0">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" class="card-img-top rounded-top-4" alt="{{ $gallery->title }}" style="height: 250px; object-fit: cover;">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div class="fw-bold">{{ $gallery->title }}</div>
                        <div class="text-success small">{{ \Carbon\Carbon::parse($gallery->created_at)->format('d F Y') }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
