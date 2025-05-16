@extends('layouts.frontend')

@section('title', 'Beranda')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Section: Hero / Welcome --}}
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold mb-4">Selamat Datang di BO-TANI</h1>
        <p class="text-gray-600 text-lg">Platform promosi dan edukasi petani digital dari kelompok tani Winongo Asri</p>
    </div>

    {{-- Section: Produk Unggulan --}}
    <section class="mb-10">
        <h2 class="text-2xl font-semibold mb-4">Produk Unggulan</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @foreach ($products as $product)
                <div class="bg-white shadow p-4 rounded">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover mb-2">
                    <h3 class="font-semibold">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600">{{ Str::limit($product->description, 60) }}</p>
                    <p class="font-bold text-green-600 mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Section: Berita Terkini / Blog --}}
    <section class="mb-10">
        <h2 class="text-2xl font-semibold mb-4">Berita Terkini</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($latestBlogs as $blog)
                <div class="bg-white shadow p-4 rounded">
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-40 object-cover mb-2">
                    @endif
                    <h3 class="font-semibold">{{ $blog->title }}</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                    <a href="{{ route('blog.show', $blog->title) }}" class="text-blue-500 hover:underline">Baca selengkapnya</a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Section: Eduwisata --}}
    @if($eduwisata)
    <section class="mb-10">
        <h2 class="text-2xl font-semibold mb-4">Eduwisata Unggulan</h2>
        <div class="bg-white shadow p-6 rounded flex flex-col md:flex-row gap-4">
            @if($eduwisata->image)
                <img src="{{ asset('storage/' . $eduwisata->image) }}" alt="{{ $eduwisata->name }}" class="w-full md:w-1/3 object-cover">
            @endif
            <div>
                <h3 class="text-xl font-bold">{{ $eduwisata->name }}</h3>
                <p class="text-gray-700">{{ Str::limit($eduwisata->description, 150) }}</p>
                <p class="text-sm text-gray-500 mt-2">Lokasi: {{ $eduwisata->location }}</p>
                <a href="{{ route('eduwisata') }}" class="text-blue-600 hover:underline mt-2 inline-block">Lihat lebih banyak</a>
            </div>
        </div>
    </section>
    @endif

    {{-- Section: Galeri --}}
    <section>
        <h2 class="text-2xl font-semibold mb-4">Galeri Kegiatan</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($galleries as $gallery)
                <div class="overflow-hidden rounded shadow">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-40 object-cover">
                    <div class="p-2">
                        <h4 class="text-sm font-bold">{{ $gallery->title }}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
