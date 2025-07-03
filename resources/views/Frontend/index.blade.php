@extends('layouts.frontend')

@section('title', 'BO-TANI - Beranda')

@section('content')
<style>
    /* Base Animations */
    @keyframes floatUpDown {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes floatLeftRight {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(10px); }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Hero Section Styles */
    .hero-section {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    }

    .hero-content {
        animation: fadeInUp 1s ease-out;
    }

    .hero-image {
        position: relative;
        animation: scaleIn 1.2s ease-out;
    }

    .floating-icon {
        position: absolute;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        z-index: 2;
    }

    /* Quick Access Section */
    .quick-access-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease-out;
        animation-delay: calc(var(--delay) * 0.1s);
    }

    .quick-access-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .quick-access-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 1rem;
        transition: transform 0.3s ease;
    }

    .quick-access-card:hover .quick-access-icon {
        transform: scale(1.1);
    }

    /* About Section */
    .about-section {
        position: relative;
        overflow: hidden;
    }

    .about-image-wrapper {
        position: relative;
        border-radius: 2rem;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        animation: scaleIn 1s ease-out;
    }

    .about-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .about-image-wrapper:hover img {
        transform: scale(1.05);
    }

    .about-content {
        animation: fadeInUp 1s ease-out;
    }

    /* Blog and Product Cards */
    .content-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease-out;
        animation-delay: calc(var(--delay) * 0.1s);
    }

    .content-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .content-image {
        height: 200px;
        overflow: hidden;
    }

    .content-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .content-card:hover .content-image img {
        transform: scale(1.1);
    }
</style>

{{-- Hero Section --}}
<section class="hero-section py-16 lg:py-24">
    <div class="container mx-auto px-6 lg:px-12">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/2 hero-content">
                <h1 class="text-4xl lg:text-5xl font-bold text-green-800 mb-4">
                    Menyemai Harapan, <span class="text-green-600">Menuai Sukses!</span>
                </h1>
                <h2 class="text-4xl sm:text-6xl lg:text-7xl uppercase mb-6 font-anton text-green-700">
                    <span class="text-green-600">BO</span>
                    <span class="text-gray-800">TANI</span>
                </h2>
                <p class="text-gray-700 text-lg mb-8">
                    BO-TANI merupakan aplikasi yang memberikan efisiensi kepada khalayak umum untuk mengakses informasi mengenai Kelompok Tani Winongo Asri. Mereka bisa mengakses informasi umum, seperti: denah, struktur organisasi, foto, dan lain-lain.
                </p>
                <a href="#profil" class="inline-block bg-green-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-300 transform hover:scale-105">
                    Jelajahi Sekarang
                </a>
            </div>
            
            <div class="lg:w-1/2 hero-image">
                <img src="{{ asset('images/content/sawizoom.png') }}" alt="Kelompok Tani" class="w-full rounded-2xl shadow-2xl">
                <img src="{{ asset('images/icons/tomat.png') }}" alt="Tomat" class="floating-icon w-12 top-10 left-10" style="animation: floatUpDown 3s infinite">
                <img src="{{ asset('images/icons/bawang.png') }}" alt="Bawang" class="floating-icon w-12 top-1/3 right-10" style="animation: floatLeftRight 4s infinite">
                <img src="{{ asset('images/icons/lombokijo.png') }}" alt="Cabai" class="floating-icon w-12 bottom-10 left-1/4" style="animation: floatUpDown 5s infinite">
            </div>
        </div>
    </div>
</section>

{{-- Quick Access Section --}}
<section class="py-16 bg-green-600 relative overflow-hidden">
    <img src="{{ asset('images/content/bgsayur.png') }}" alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-10">
    <div class="container mx-auto px-6 lg:px-12 relative z-10">
        <h2 class="text-4xl font-bold text-center text-white mb-12">Akses Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <a href="{{ route('blog') }}" class="quick-access-card" style="--delay: 1">
                <img src="{{ asset('icons/berita.png') }}" alt="Berita" class="quick-access-icon">
                <h3 class="text-xl font-semibold text-center text-gray-800">Berita</h3>
            </a>
            <a href="{{ route('product.index_fr') }}" class="quick-access-card" style="--delay: 2">
                <img src="{{ asset('icons/store.png') }}" alt="Produk" class="quick-access-icon">
                <h3 class="text-xl font-semibold text-center text-gray-800">Produk</h3>
            </a>
            <a href="{{ route('eduwisata') }}" class="quick-access-card" style="--delay: 3">
                <img src="{{ asset('icons/edu wisata.png') }}" alt="Edu Wisata" class="quick-access-icon">
                <h3 class="text-xl font-semibold text-center text-gray-800">Edu Wisata</h3>
            </a>
            <a href="{{ route('contact.index') }}" class="quick-access-card" style="--delay: 4">
                <img src="{{ asset('icons/help.png') }}" alt="Kontak" class="quick-access-icon">
                <h3 class="text-xl font-semibold text-center text-gray-800">Kontak</h3>
            </a>
        </div>
    </div>
</section>

{{-- About Section --}}
<section id="profil" class="py-16 bg-gray-50">
    <div class="container mx-auto px-6 lg:px-12">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/2 about-image-wrapper">
                <img src="{{ asset('images/content/kelompok-tani.jpg') }}" alt="Kelompok Tani" class="w-full">
                <div class="absolute bottom-0 left-0 right-0 bg-green-600 bg-opacity-90 text-white p-4 text-center">
                    Winongo Asri Kelompok Tani
                </div>
            </div>
            <div class="lg:w-1/2 about-content">
                <h2 class="text-green-600 font-bold text-2xl mb-2">KELOMPOK TANI</h2>
                <h3 class="text-gray-800 font-bold text-3xl mb-6">WINONGO ASRI PATANGPULUHAN</h3>
                <div class="prose prose-lg text-gray-700">
                    <p class="mb-6">
                        Kelompok Tani Winongo Asri awalnya salah satu UKM kecil di daerah Wirobrajan yang bergerak di bidang pertanian. Kemudian berkembang menjadi kelompok yang bermitra dengan masyarakat untuk berdiskusi mengenai hal-hal yang mengangkat pertanian.
                    </p>
                    <p class="mb-6">
                        Berawal dari langkah sederhana, kelompok tani ini terus berkembang untuk memenuhi kebutuhan publik di tingkat lokal. Penjualan sayuran dan cabai menjadi produk unggulan mereka. Meski dengan keterbatasan lahan, semangat untuk mengembangkan berbagai jenis tanaman tetap tinggi.
                    </p>
                    <div class="mt-8 italic text-xl text-green-700 font-semibold">
                        "Tanam di Bibit dahulu laut hasil buahnya nanti kali"
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- Blog Section --}}
@if($latestBlogs->count())
<section class="py-16 bg-white">
    <div class="container mx-auto px-6 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-green-800 mb-4">Unggahan Blog Terbaru</h2>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($latestBlogs as $blog)
            <article class="content-card" style="--delay: {{ $loop->iteration }}">
                <div class="content-image">
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
                    @else
                        <div class="w-full h-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-newspaper text-4xl text-green-300"></i>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-3 text-gray-800">{{ $blog->title }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                    <a href="{{ route('blog.show_fr', $blog->title) }}" class="text-green-600 font-semibold hover:text-green-700 transition-colors duration-300">
                        Baca selengkapnya →
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Products --}}
@if($products->count())
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-green-800 mb-4">Produk Unggulan</h2>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products->take(3) as $product)
            <div class="content-card" style="--delay: {{ $loop->iteration }}">
                <div class="content-image">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div class="w-full h-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-box text-4xl text-green-300"></i>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2 text-gray-800">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between mb-4">
                        <span class="product-price text-green-600 font-semibold text-lg">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                            <span class="text-sm text-gray-500">/{{ $product->unit ?? 'satuan' }}</span>
                        </span>
                    </div>

                    <p class="product-description">{{ $product->description }}</p>



                    <div class="flex space-x-2">
                        <a href="{{ route('product.show', $product->id) }}" 
                           class="w-full text-center bg-green-600 text-white px-8 py-2 rounded-lg hover:bg-green-700 transition-colors duration-300">
                            Pesan
                        </a>
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class=" bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-2 rounded-lg transition-colors duration-300">
                                    <i class="fas fa-cart-plus me-1"></i>
                                </button>
                            </form>
                        @else
                            <button disabled 
                                    class="flex-1 bg-gray-400 text-white font-semibold py-2 px-2 rounded-lg cursor-not-allowed">
                                <i class="fas fa-times me-1"></i>Habis
                            </button>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach

            @if($products->count() > 3)
            <div class="content-card bg-green-50" style="--delay: 4">
                <div class="p-6 flex flex-col items-center justify-center h-full">
                    <i class="fas fa-plus-circle text-5xl text-green-600 mb-4"></i>
                    <h3 class="font-bold text-xl mb-2 text-green-800">Lihat Semua Produk</h3>
                    <p class="text-green-600 mb-6 text-center">Temukan lebih banyak produk segar berkualitas</p>
                    <a href="{{ route('product.index_fr') }}" 
                       class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors duration-300">
                        Jelajahi Produk
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Gallery Section --}}
@if($galleries->count())
<section class="py-16 bg-white">
    <div class="container mx-auto px-6 lg:px-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-green-800 mb-4">Galeri Kegiatan</h2>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($galleries as $gallery)
            <div class="relative overflow-hidden rounded-lg shadow-lg group" style="--delay: {{ $loop->iteration }}">
                <img src="{{ asset('storage/' . $gallery->image) }}" 
                     alt="{{ $gallery->title }}" 
                     class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="text-lg font-semibold mb-1">{{ $gallery->title }}</h4>
                        <p class="text-sm">{{ \Carbon\Carbon::parse($gallery->description)->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection