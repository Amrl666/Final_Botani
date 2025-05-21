@extends('layouts.frontend')

@section('title', 'BO-TANI - Beranda')

@section('content')
<style>
    .about-image-wrapper {
        width: 100%; /* Gambar mengambil lebar penuh kontainer */
        max-width: 500px; /* Maksimal lebar gambar */
        height: 400px; /* Tinggi tetap untuk gambar */
        margin: 0 auto; /* Memusatkan gambar */
        border-radius: 20px 20px 0 0; /* Sudut melengkung hanya di bagian atas */
        overflow: hidden; /* Menyembunyikan bagian gambar yang keluar dari batas */
        position: relative;
    }

    .about-image-wrapper img {
        object-fit: cover; /* Menjaga proporsi gambar agar tetap bagus, dan gambar tidak terdistorsi */
        width: 100%; /* Memastikan gambar memenuhi lebar kontainer */
        height: 100%; /* Menjaga agar gambar sesuai dengan tinggi yang telah ditentukan */
    }

    .about-image-caption {
        background-color: #38a169; /* Warna hijau */
        color: white;
        padding: 8px; /* Padding lebih kecil agar lebih rapi */
        text-align: center;
        font-weight: bold;
        position: absolute;
        bottom: 0;
        width: 100%;
    }
    .hero-image {
  background: transparent;
}

</style>

{{-- Hero Section --}}
<section class="bg-green-50 py-10">
    <div class="container mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center">
        <!-- Gambar di kiri -->
        <div class="md:w-1/2 mb-6 md:mb-0 relative">
            <div class="hero-image relative w-full max-w-md mx-auto">
                <img src="{{ asset('images/content/sawizoom.png') }}" alt="Kelompok Tani" class="img-fluid rounded shadow">

                <!-- Ikon tersebar, cuma 3 macam -->
                <img src="{{ asset('images/icons/tomat.png') }}" alt="Tomat" class="floating-icon absolute" style="top: 10%; left: 15%; width: 45px; animation: floatUpDown 5s ease-in-out infinite;">
                <img src="{{ asset('images/icons/bawang.png') }}" alt="Bawang" class="floating-icon absolute" style="top: 40%; right: 20%; width: 40px; animation: floatLeftRight 4s ease-in-out infinite;">
                <img src="{{ asset('images/icons/lombokijo.png') }}" alt="Cabai" class="floating-icon absolute" style="bottom: 15%; left: 25%; width: 50px; animation: floatUpDown 6s ease-in-out infinite;">

                <img src="{{ asset('images/icons/tomat.png') }}" alt="Tomat" class="floating-icon absolute" style="top: 25%; right: 10%; width: 35px; animation: floatLeftRight 5s ease-in-out infinite;">
                <img src="{{ asset('images/icons/bawang.png') }}" alt="Bawang" class="floating-icon absolute" style="bottom: 30%; left: 5%; width: 38px; animation: floatUpDown 4.5s ease-in-out infinite;">
                <img src="{{ asset('images/icons/lombokijo.png') }}" alt="Cabai" class="floating-icon absolute" style="top: 60%; right: 30%; width: 42px; animation: floatLeftRight 4.7s ease-in-out infinite;">
            </div>
        </div>

        <!-- Teks di kanan -->
        <div class="md:w-1/2">
            <h1 class="text-4xl font-bold text-green-800 mb-2">
                Menyemai Harapan, <span class="text-green-600">Menuai Sukses!</span>
            </h1>
          <h2 class="text-4xl sm:text-6xl lg:text-8xl uppercase mb-4" 
        style="font-family: 'Anton', sans-serif; text-shadow: 1px 1px 0 #00000030, 2px 2px 0 #00000010;">
         <span class="text-green-600">BO</span>
         <span class="text-gray-800">TANI</span>
        </h2>
            <p class="text-gray-700 mb-6">
                BO-TANI merupakan aplikasi yang memberikan efisiensi kepada khalayak umum untuk mengakses informasi mengenai Kelompok Tani Winongo Asri. Mereka bisa mengakses informasi umum, seperti: denah, struktur organisasi, foto, dan lain-lain. Mereka juga bisa melakukan pemesanan sayur, booking online terhadap paket eduwisata, dan memberikan kritik serta saran di fitur ulasan.
            </p>
            <div class="flex justify-end mt-6">
    <div class="text-right mt-6">
    <a href="#selengkapnya"
       class="inline-block bg-orange-500 text-white px-6 py-3 rounded shadow-md hover:bg-orange-600 transition duration-300 ease-in-out">
        Selengkapnya
    </a>
</div>

        </div>
    </div>
</section>

{{-- Akses Cepat --}}
<section class="py-12 bg-green-100">
    <div class="container mx-auto px-6 lg:px-12">
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
<div class="container mx-auto px-6 lg:px-12 py-16">
    <div class="flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-8 md:mb-0 about-image-wrapper">
            <img src="{{ asset('images/content/kelompok-tani.jpg') }}" alt="Kelompok Tani" class="rounded-lg shadow-lg w-full">
            <div class="about-image-caption">
                Winongo Asri Kelompok Tani
            </div>
        </div>
        <div class="md:w-1/2 md:pl-12">
            <h2 class="text-green-600 font-bold text-2xl mb-2">KELOMPOK TANI</h2>
            <h3 class="text-gray-800 font-bold text-3xl mb-4">WINONGO ASRI PATANGPULUHAN</h3>
            <p class="text-gray-700 mb-6 text-justify">
                Kelompok Tani Winongo Asri awalnya salah satu UKM kecil di daerah Wirobrajan yang bergerak di bidang pertanian, Kemudian Tani ini memiliki kelompokkan yang bermitra dengan masyarakat yang selalu intens untuk berdiskusi mengenai hal-hal yang mengangkat pertanian.
            </p>
            <p class="text-gray-700 mb-6 text-justify">
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


{{-- Unggahan Blog --}}
@if($latestBlogs->count())
<section class="py-12 bg-green-50">
    <div class="container mx-auto px-6 lg:px-12">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-green-800">UNGGAHAN BLOG</h2>
            <div class="w-32 h-1 bg-green-500 mx-auto mt-2 rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($latestBlogs as $blog)
            <div class="bg-white shadow rounded overflow-hidden flex flex-col h-full">
                <div class="w-full h-[120px] overflow-hidden">
                    @if($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-bold text-base mb-2">{{ $blog->title }}</h3>
                    <p class="text-sm text-gray-600 flex-1">{{ Str::limit(strip_tags($blog->content), 80) }}</p>
                    <a href="{{ route('blog.show', $blog->title) }}" class="text-green-600 text-sm hover:underline mt-4">Baca selengkapnya</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
{{-- Produk Unggulan --}}
@if($products->count())
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 lg:px-12">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-green-800">PRODUK TERBAIK</h2>
            <div class="w-32 h-1 bg-green-500 mx-auto mt-2 rounded-full"></div>
        </div>

        <div class="flex flex-wrap justify-center gap-6">
            {{-- Tampilkan produk --}}
            @foreach ($products->take(3) as $product)
            <div class="bg-white shadow rounded overflow-hidden flex flex-col h-full max-w-[40px] h-[20px]">
                <div class="h-[120px] overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <div class="p-3 flex flex-col flex-1 text-center">
                    <h4 class="font-semibold text-base mb-1">{{ $product->name }}</h4>
                    <p class="text-sm text-gray-600 flex-1">{{ Str::limit($product->description, 60) }}</p>
                    <a href="#" class="mt-3 border border-green-600 text-green-600 text-sm px-3 py-1.5 rounded hover:bg-green-50 transition-all duration-200">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
            @endforeach

            {{-- Jika produk lebih dari 3, tampilkan card "Lainnya" --}}
            @if ($products->count() > 3)
            <div class="bg-green-100 shadow rounded overflow-hidden flex flex-col h-full max-w-[240px] w-full">
                <div class="w-full h-[120px] flex items-center justify-center bg-green-200 text-green-800 font-bold text-base">
                    +{{ $products->count() - 3 }} Produk
                </div>
                <div class="p-3 flex flex-col flex-1 text-center">
                    <h4 class="font-bold text-green-800 text-base mb-1">Lainnya</h4>
                    <p class="text-sm text-green-700 flex-1">Buah-Buahan dan Sayuran lainnya</p>
                    <a href="{{ route('frontend.produk') }}" class="mt-3 border border-green-700 text-green-700 text-sm px-3 py-1.5 rounded hover:bg-green-200 transition-all duration-200">
                        Selengkapnya
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Galeri --}}
@if($galleries->count())
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 lg:px-12">
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
