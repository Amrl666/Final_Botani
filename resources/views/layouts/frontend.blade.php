<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BO-TANI')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">

    
    {{-- Navbar --}}
    <nav class="bg-white text-black shadow">
  <div class="container mx-auto px-4 py-4 flex items-center justify-between">

    <!-- Logo kiri -->
    <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
      <span class="text-green-500">BO</span><span class="text-black">TANI</span>
    </a>

<!-- Menu tengah -->
<div class="flex space-x-4 text-sm md:text-base">
  <a href="{{ url('/') }}" class="hover:underline">Beranda</a>
  <a href="{{ route('product.index_fr') }}" class="hover:underline">Produk</a>
  <a href="{{ route('eduwisata') }}" class="hover:underline">Eduwisata</a>
  <a href="{{ route('blog') }}" class="hover:underline">Blog</a>
  <a href="{{ route('gallery') }}" class="hover:underline">Galeri</a>
  <a href="{{ route('videos') }}" class="hover:underline">Video</a>
  <a href="{{ route('perijinan') }}" class="hover:underline">Perijinan</a>
  <a href="{{ route('profile') }}" class="hover:underline">Profil</a>
  <a href="{{ route('contact.index') }}" class="hover:underline">Kontak</a>

  {{-- Tambahan Riwayat --}}
@if(session()->has('telepon'))
  <div class="relative group">
    <button class="flex items-center gap-2 hover:text-green-600">
      <i class="fas fa-user-circle text-xl"></i>
      <span class="text-sm md:text-base">{{ session('telepon') }}</span>
      <i class="fas fa-chevron-down text-xs"></i>
    </button>
    
    <div class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition duration-150 z-50">
      <a href="{{ route('riwayat.produk', ['telepon' => session('telepon')]) }}"
         class="block px-4 py-2 text-sm hover:bg-gray-100">
         Riwayat Produk
      </a>
      <a href="{{ route('riwayat.eduwisata', ['telepon' => session('telepon')]) }}"
         class="block px-4 py-2 text-sm hover:bg-gray-100">
         Riwayat Eduwisata
      </a>
      <a href="{{ route('logout.riwayat') }}"
         class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
         Keluar Riwayat
      </a>
    </div>
  </div>
@else
  <a href="{{ route('login.wa') }}" class="hover:underline text-green-600">
    Lihat Riwayat
  </a>
@endif

</div>

  </div>
</nav>

            </div>
        </div>
    </nav>

    {{-- Halaman Konten --}}
<main class="py-8">
    @if(session('success'))
        <div class="container mx-auto px-4">
            <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded mb-4 shadow">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        </div>
    @endif

    @yield('content')
</main>


    {{-- Footer --}}
    @include('partials.footer')


    @stack('modals')
    @livewireScripts
</body>
</html>
