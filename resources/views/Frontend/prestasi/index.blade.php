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
    <ol class="section-text list-decimal pl-5 space-y-3 text-justify text-gray-700">
        <li>
            <strong>Meningkatkan Produktivitas dan Kualitas Hasil Pertanian:</strong>
            Meningkatkan produktivitas dan kualitas hasil pertanian melalui penerapan teknologi pertanian modern dan pengelolaan sumber daya alam yang berkelanjutan.
        </li>
        <li>
            <strong>Meningkatkan Kesejahteraan Anggota:</strong>
            Meningkatkan kesejahteraan anggota melalui peningkatan pendapatan, dan pelatihan.
        </li>
        <li>
            <strong>Mengembangkan Usaha Pertanian yang Berkelanjutan:</strong>
            Mengembangkan usaha pertanian yang berkelanjutan dan ramah lingkungan untuk meningkatkan kualitas hidup anggota dan masyarakat sekitar.
        </li>
        <li>
            <strong>Meningkatkan Kerjasama dan Solidaritas:</strong>
            Meningkatkan kerjasama dan solidaritas antara anggota dan masyarakat sekitar untuk mencapai tujuan bersama.
        </li>
        <li>
            <strong>Meningkatkan Kapasitas dan Kemampuan Anggota:</strong>
            Meningkatkan kapasitas dan kemampuan anggota melalui pendidikan, pelatihan, dan pengembangan sumber daya manusia.
        </li>
    </ol>



    <!-- B. Tujuan -->
    <div class="text-center">
        <div class="section-title">TUJUAN</div>
    </div>

    <div class="section-subtitle">Tujuan</div>
    <ol class="section-text list-decimal pl-5 space-y-3 text-justify text-gray-700">
        <li>
            <strong>Meningkatkan Pendapatan Anggota:</strong>
            Meningkatkan pendapatan anggota melalui peningkatan produktivitas dan kualitas hasil pertanian.
        </li>
        <li>
            <strong>Meningkatkan Kualitas Hidup Anggota:</strong>
            Meningkatkan kualitas hidup anggota melalui peningkatan pendidikan, kesehatan, dan kesejahteraan.
        </li>
        <li>
            <strong>Mengembangkan Usaha Pertanian yang Berkelanjutan:</strong>
            Mengembangkan usaha pertanian yang berkelanjutan dan ramah lingkungan untuk meningkatkan kualitas hidup anggota dan masyarakat sekitar.
        </li>
    </ol>


    <!-- C. Struktur Organisasi -->
    <div class="text-center">
        <div class="section-title">STRUKTUR ORGANISASI</div>
    </div>
    <div class="section-image">
        <img src="{{ asset('images/struktur-organisasi.jpg') }}" alt="Struktur Organisasi">
    </div>

    <!-- Bagian D - Prestasi -->
    <div class="text-center">
        <div class="section-title">PRESTASI</div>
    </div>x
    <section class="py-5">
        <div class="container">
            @if($prestasi)
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="mb-4">{{ $prestasi->title }}</h1>
                    <div class="content">
                        {!! $prestasi->content !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    @if($prestasi->image)
                        <img src="{{ asset('storage/' . $prestasi->image) }}" alt="{{ $prestasi->title }}" class="img-fluid rounded">
                    @endif
                </div>
            </div>
            @else
            <div class="alert alert-info">
                No profile information available yet.
            </div>
            @endif
        </div>
    </section>
    @endsection

    </div>


</div>
