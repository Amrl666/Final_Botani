<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | BO-TANI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- Tailwind CSS --}}
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- Navbar --}}
    <header class="bg-green-700 text-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold">BO-TANI</a>
            <nav class="space-x-4 text-sm md:text-base">
                <a href="{{ url('/') }}" class="hover:underline">Beranda</a>
                <a href="{{ route('product.index_fr') }}" class="hover:underline">Produk</a>
                <a href="{{ route('gallery') }}" class="hover:underline">Galeri</a>
                <a href="{{ route('videos') }}" class="hover:underline">Video</a>
                <a href="{{ route('blog') }}" class="hover:underline">Blog</a>
                <a href="{{ route('profile') }}" class="hover:underline">Profil</a>
                <a href="{{ route('eduwisata') }}" class="hover:underline">Eduwisata</a>
                <a href="{{ route('contact.index') }}" class="hover:underline">Kontak</a>
            </nav>
        </div>
    </header>

    {{-- Konten halaman --}}
    <main class="min-h-screen py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-green-700 text-white py-6 mt-10">
        <div class="container mx-auto text-center text-sm">
            &copy; {{ date('Y') }} BO-TANI. Seluruh hak cipta dilindungi.
        </div>
    </footer>

</body>
</html>
