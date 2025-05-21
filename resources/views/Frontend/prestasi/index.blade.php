@extends('layouts.frontend')

@section('title', 'Profil Kelompok Tani')

@section('content')

<style>
    .profil-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
        background-color: white;
    }

    .section-title {
        text-align: center;
        font-weight: bold;
        font-size: 26px;
        margin: 60px 0 30px;
        position: relative;
        display: inline-block;
        border-bottom: 5px solid #07AA07;
        padding-bottom: 10px;
    }

    .section-subtitle {
        font-size: 22px;
        font-weight: bold;
        margin: 30px 0 10px;
    }

    .section-text {
        font-size: 16px;
        line-height: 1.9;
        text-align: justify;
    }

    .section-image {
        display: flex;
        justify-content: center;
    }

    .section-image img {
        max-width: 100%;
        height: auto;
        border: 3px solid #ccc;
        border-radius: 8px;
    }

    /* === Prestasi Cards Horizontal === */
    .prestasi-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin-top: 30px;
    }



    .prestasi-card {
        display: flex;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s;
    }

    .prestasi-card:hover {
        transform: translateY(-4px);
    }

    .prestasi-image {
        flex: 1;
        min-width: 200px;
        max-width: 250px;
    }

    .prestasi-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .prestasi-content {
        flex: 2;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .prestasi-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .prestasi-text {
        font-size: 15px;
        color: #2f5d27;
        text-align: right;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .prestasi-card {
            flex-direction: column;
        }

        .prestasi-image,
        .prestasi-content {
            max-width: 100%;
        }

        .prestasi-text {
            text-align: justify;
        }
    }
</style>

<div class="container-fluid px-20">

    <!-- A. Visi & Misi -->
    <div class="text-center">
        <div class="section-title">VISI & MISI</div>
    </div>

    <div class="section-subtitle">Visi</div>
    <p class="section-text">
        "Menjadi kelompok tani yang maju, mandiri, dan sejahtera melalui penerapan teknologi pertanian modern, pengelolaan sumber daya alam yang berkelanjutan, dan peningkatan kualitas hidup anggota."
    </p>

    <div class="section-subtitle">Misi</div>
    <ol class="section-text list-decimal pl-5 space-y-3 text-gray-700">
        <li><strong>Meningkatkan Produktivitas dan Kualitas Hasil Pertanian:</strong> melalui teknologi pertanian modern dan pengelolaan sumber daya alam yang berkelanjutan.</li>
        <li><strong>Meningkatkan Kesejahteraan Anggota:</strong> melalui peningkatan pendapatan, pelatihan, dan pengembangan usaha.</li>
        <li><strong>Mengembangkan Usaha Pertanian yang Berkelanjutan:</strong> dan ramah lingkungan.</li>
        <li><strong>Meningkatkan Kerjasama dan Solidaritas:</strong> antar anggota dan masyarakat sekitar.</li>
        <li><strong>Meningkatkan Kapasitas dan Kemampuan Anggota:</strong> melalui pelatihan dan pendidikan.</li>
    </ol>

    <!-- B. Tujuan -->
    <div class="text-center">
        <div class="section-title">TUJUAN</div>
    </div>

    <div class="section-subtitle">Tujuan</div>
    <ol class="section-text list-decimal pl-5 space-y-3 text-gray-700">
        <li><strong>Meningkatkan Pendapatan Anggota:</strong> melalui produktivitas dan kualitas hasil pertanian.</li>
        <li><strong>Meningkatkan Kualitas Hidup Anggota:</strong> melalui pendidikan, kesehatan, dan kesejahteraan.</li>
        <li><strong>Mengembangkan Usaha Pertanian yang Berkelanjutan:</strong> untuk anggota dan masyarakat sekitar.</li>
    </ol>

    <!-- C. Struktur Organisasi -->
    <div class="text-center">
        <div class="section-title">STRUKTUR ORGANISASI</div>
    </div>
    <div class="section-image">
        <img src="{{ asset('images/struktur-organisasi.jpg') }}" alt="Struktur Organisasi">
    </div>

    <!-- D. Prestasi -->
    <div class="text-center">
        <div class="section-title">PRESTASI</div>
    </div>

    <section class="py-4">
        <div class="container">
        @if($prestasi && $prestasi->count())
        <div class="prestasi-grid">
            @foreach($prestasi as $item)
            <div class="prestasi-card">
                <div class="prestasi-image">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                </div>
                <div class="prestasi-content">
                    <div class="prestasi-title">{{ $item->title }}</div>
                        <div class="prestasi-text">{!! Str::limit(strip_tags($item->content), 250) !!}</div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-info text-center mt-4">
            Tidak ada informasi prestasi yang tersedia saat ini.
        </div>
        @endif
    </div>
</section>
</div>

@endsection
