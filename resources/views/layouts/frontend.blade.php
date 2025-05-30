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
    </div>

    <!-- Icon search kanan -->
    <a href="#" class="text-xl hover:text-green-500 ml-4">
      <i class="fas fa-search"></i>
    </a>

  </div>
</nav>

            </div>
        </div>
    </nav>

    {{-- Halaman Konten --}}
    <main class="py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')


    @stack('modals')
    @livewireScripts
</body>
</html>
