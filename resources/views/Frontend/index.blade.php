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


<!-- About Section -->
<div class="container mx-auto px-4 py-16">
    <div class="flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-8 md:mb-0">
            <img src="{{ asset('images/kelompok-tani.jpg') }}" alt="Kelompok Tani" class="rounded-lg shadow-lg w-full">
            <div class="bg-green-600 text-white p-3 rounded-b-lg -mt-1 text-center">
                Winongo Asri Kelompok Tani
            </div>
        </div>
        <div class="md:w-1/2 md:pl-12">
            <h2 class="text-green-600 font-bold text-2xl mb-2">KELOMPOK TANI</h2>
            <h3 class="text-gray-800 font-bold text-3xl mb-4">WINONGO ASRI PATANGPULUHAN</h3>
            <p class="text-gray-700 mb-6">
                Kelompok Tani Winongo Asri awalnya salah satu UKM kecil di daerah Wirobrajan yang bergerak di bidang pertanian, Kemudian Tani ini memiliki kelompokkan yang bermitra dengan masyarakat yang selalu intens untuk berdiskusi mengenai hal-hal yang mengangkat pertanian.
            </p>
            <p class="text-gray-700 mb-6">
                Kelompok Tani ini diawalinya dengan masih yang sangat sederhana. Tidak hanya mengkhususkan perkembangannya kemajuan bagi kelompok tani ini menunda permintaan yang dibutuhkan publik hingga untuk ditingkat lokal, penjualan sayuran dan cabai adalah yang produk unggulan mereka, tapi tetapi begitu keterbatasan lahan ini membuat tanaman cabai dan tomat, masih ada dorongan kelompok tani ini mampu bertambah sayuran yang lainnya mulai dan tuna dan begitupun dengan labu, dll demoplot tersebut sudah mulai ada dan menyediakan paket edu-wisata yang bisa disinilah cukup menarik karena mereka menurunkan pengalaman kepada orang-orang mengenai pertanian Hidroponik dan juga berbagi hal yang bisa dikembangkan.
            </p>
            <a href="#" class="text-green-600 font-semibold hover:underline flex items-center">
                Baca selengkapnya <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            <div class="mt-8 italic text-gray-600">
                "Tanam di Bibit dahulu laut hasil buahnya nanti kali"
            </div>
        </div>
    </div>
</div>

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
