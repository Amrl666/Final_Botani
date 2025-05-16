@extends('layouts.frontend')

@section('title', 'BO-TANI - Beranda')

@section('content')
{{-- Hero Section --}}
<section class="bg-green-50 py-10">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-6 md:mb-0">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Menyemai Harapan, <span class="text-green-600">Menuai Sukses!</span></h1>
            <p class="text-gray-700 mb-6">
                BO-TANI adalah platform digital dari Kelompok Tani Winongo Asri untuk promosi produk pertanian, reservasi edu-wisata, dan akses informasi pertanian terkini.
            </p>
            <div class="flex gap-4">
                <a href="{{ route('eduwisata') }}" class="bg-green-700 text-white px-6 py-3 rounded hover:bg-green-800 transition">Lihat Eduwisata</a>
                <a href="{{ route('product.index_fr') }}" class="border border-green-700 text-green-700 px-6 py-3 rounded hover:bg-green-100 transition">Belanja Produk</a>
            </div>
        </div>
        <div class="col-lg-6 order-lg-2 order-1 mb-4 mb-lg-0">
                <div class="hero-image position-relative">
                    <img src="{{ asset('images/content/sawizoom.png') }}" alt="Kelompok Tani" class="img-fluid rounded shadow">
                    <img src="{{ asset('images/icons/tomat.png') }}" alt="Tomat" class="floating-icon icon-tomato">
                    <img src="{{ asset('images/icons/bawang.png') }}" alt="Bawang" class="floating-icon icon-garlic">
                    <img src="{{ asset('images/icons/lombokijo.png') }}" alt="Cabai" class="floating-icon icon-chili">
                </div>
            </div>
    </div>
</section>

{{-- Akses Cepat --}}
<section class="py-12 bg-green-100">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-center mb-8 text-green-800">Akses Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="{{ route('blog') }}" class="bg-white p-4 shadow rounded text-center hover:shadow-lg transition">
                <img src="{{ asset('icons/berita.png') }}" alt="Berita" class="w-12 mx-auto mb-2">
                <h5 class="font-semibold">Berita</h5>
            </a>
            <a href="{{ route('product.index_fr') }}" class="bg-white p-4 shadow rounded text-center hover:shadow-lg transition">
                <img src="{{ asset('icons/store.png') }}" alt="Produk" class="w-12 mx-auto mb-2">
                <h5 class="font-semibold">Produk</h5>
            </a>
            <a href="{{ route('eduwisata') }}" class="bg-white p-4 shadow rounded text-center hover:shadow-lg transition">
                <img src="{{ asset('icons/edu wisata.png') }}" alt="Edu Wisata" class="w-12 mx-auto mb-2">
                <h5 class="font-semibold">Edu Wisata</h5>
            </a>
            <a href="{{ route('contact.index') }}" class="bg-white p-4 shadow rounded text-center hover:shadow-lg transition">
                <img src="{{ asset('icons/help.png') }}" alt="Kontak" class="w-12 mx-auto mb-2">
                <h5 class="font-semibold">Kontak</h5>
            </a>
        </div>
    </div>
</section>

{{-- Produk Unggulan --}}
@if($products->count())
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-green-800 mb-6">Produk Unggulan</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach ($products as $product)
            <div class="border rounded shadow p-4">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover mb-3 rounded">
                <h4 class="font-semibold">{{ $product->name }}</h4>
                <p class="text-sm text-gray-600">{{ Str::limit($product->description, 60) }}</p>
                <p class="text-green-700 font-bold mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Blog Terbaru --}}
@if($latestBlogs->count())
<section class="py-12 bg-green-50">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-green-800 mb-6">Berita Terkini</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($latestBlogs as $blog)
            <div class="bg-white shadow rounded overflow-hidden">
                @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-40 object-cover">
                @endif
                <div class="p-4">
                    <h3 class="font-bold text-lg">{{ $blog->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                    <a href="{{ route('blog.show', $blog->title) }}" class="text-green-600 text-sm mt-2 inline-block hover:underline">Baca selengkapnya</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Galeri --}}
@if($galleries->count())
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-green-800 mb-6">Galeri Kegiatan</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($galleries as $gallery)
            <div class="rounded overflow-hidden shadow">
                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-36 object-cover">
                <div class="p-2 bg-gray-50">
                    <h4 class="text-sm font-semibold">{{ $gallery->title }}</h4>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
