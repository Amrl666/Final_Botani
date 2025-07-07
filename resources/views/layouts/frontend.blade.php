<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BO-TANI')</title>
    <link rel="icon" href="{{ asset('logo/logobotani.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @stack('styles')

    <style>
        :root {
            --primary-color: #059669;
            --primary-dark: #047857;
            --secondary-color: #10b981;
            --accent-color: #34d399;
            --text-color: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #f9fafb;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Page Loading Animation */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
        }

        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-logo {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 2rem;
            animation: logoFloat 2s ease-in-out infinite;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .loader-logo .text-green {
            color: var(--primary-color);
        }

        .loader-logo .text-black {
            color: var(--text-color);
        }

        .loader-text {
            font-size: 1.1rem;
            color: var(--text-color);
            font-weight: 500;
            text-align: center;
            animation: textPulse 2s ease-in-out infinite;
            margin-bottom: 1.5rem;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .loader-dots {
            display: flex;
            gap: 0.5rem;
        }

        .loader-dot {
            width: 8px;
            height: 8px;
            background: var(--primary-color);
            border-radius: 50%;
            animation: dotBounce 1.4s ease-in-out infinite;
            box-shadow: 0 2px 4px rgba(5, 150, 105, 0.3);
        }

        .loader-dot:nth-child(1) { animation-delay: 0s; }
        .loader-dot:nth-child(2) { animation-delay: 0.2s; }
        .loader-dot:nth-child(3) { animation-delay: 0.4s; }

        /* Loading Animations */
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes textPulse {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }

        @keyframes dotBounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        /* Page Transition Effects */
        .page-transition {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .page-transition.loaded {
            opacity: 1;
            transform: translateY(0);
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar .container {
            position: relative;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        /* Desktop menu visibility */
        .nav-menu.hidden.md\\:flex {
            display: none;
        }

        .mobile-menu {
            /* Mengubah menu mobile menjadi layout flex-column */
            display: flex;
            flex-direction: column;
            width: 100%; /* Memastikan menu memenuhi lebar kontainer */
            padding-top: 1rem; /* Memberi jarak dari navbar atas */
            border-top: 1px solid #e5e7eb; /* Garis pemisah opsional */
            margin-top: 1rem;
        }

        .mobile-menu .nav-link {
            padding: 0.75rem 0; /* Memberi padding vertikal pada setiap link */
            width: 100%;
        }
        

        @media (min-width: 768px) {
            .nav-menu.hidden.md\\:flex {
                display: flex !important;
            }
        }

        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background: rgba(5, 150, 105, 0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--primary-color);
            background: rgba(5, 150, 105, 0.1);
            font-weight: 600;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
            animation: activePulse 2s ease-in-out infinite;
        }

        .nav-link.active:hover {
            background: rgba(5, 150, 105, 0.15);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(5, 150, 105, 0.3);
            animation: none;
        }

        @keyframes activePulse {
            0%, 100% { 
                box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
            }
            50% { 
                box-shadow: 0 4px 20px rgba(5, 150, 105, 0.4);
            }
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .nav-link.active::after {
            background: var(--primary-color);
            width: 80%;
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .user-button:hover {
            background: rgba(5, 150, 105, 0.1);
            color: var(--primary-color);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .user-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--border-color);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: var(--bg-light);
            color: var(--primary-color);
            padding-left: 1.5rem;
        }

        .dropdown-item.logout {
            color: #dc2626;
        }

        .dropdown-item.logout:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        /* Mobile Menu */
        .mobile-menu-button {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-color);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            z-index: 9999;
            position: relative;
            min-width: 44px;
            min-height: 44px;
            display: none;
            align-items: center;
            justify-content: center;
            pointer-events: auto;
        }
        
        .mobile-menu-button:hover {
            background: rgba(5, 150, 105, 0.1);
            color: var(--primary-color);
        }

        .mobile-menu-button:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Mobile menu container */
        #mobileMenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            flex-direction: column;
            padding: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-top: 1px solid var(--border-color);
            z-index: 1000;
            max-height: 80vh;
            overflow-y: auto;
            transition: all 0.3s ease;
            transform: translateY(-10px);
            opacity: 0;
        }
        
        #mobileMenu.active {
            display: flex;
            transform: translateY(0);
            opacity: 1;
        }

        /* Show mobile menu button only on mobile */
        @media (max-width: 767px) {
            .mobile-menu-button {
                display: flex !important;
                position: relative;
                z-index: 9999;
                visibility: visible !important;
                opacity: 1 !important;
                pointer-events: auto !important;
                background: rgba(255, 255, 255, 0.9) !important;
                border: 1px solid #e5e7eb !important;
                width: 44px !important;
                height: 44px !important;
                margin: 0 !important;
                padding: 8px !important;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
            }
            
            /* Ensure mobile menu button is clickable */
            .mobile-menu-button i {
                pointer-events: none;
            }
        }

        .mobile-menu-button:hover {
            background: rgba(5, 150, 105, 0.1);
            color: var(--primary-color);
        }

        /* Alert Styles */
        .alert {
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideDown 0.5s ease-out;
        }

        .alert-success {
            background: #d1fae5;
            border-color: #a7f3d0;
            color: #065f46;
        }

        .alert-error {
            background: #fee2e2;
            border-color: #fecaca;
            color: #991b1b;
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
        }

        /* Responsive Design */
        @media (max-width: 767px) {
            /* Desktop menu hidden on mobile */
            .nav-menu.hidden.md\\:flex {
                display: none !important;
            }
            
            /* Ensure mobile menu button is visible */
            .mobile-menu-button {
                display: flex !important;
            }

            /* Mobile menu styles */
            #mobileMenu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                border-top: 1px solid var(--border-color);
                z-index: 1000;
                max-height: 80vh;
                overflow-y: auto;
            }

            #mobileMenu.active {
                display: flex;
            }

            .mobile-menu-button {
                display: flex !important;
                position: relative;
                z-index: 1001;
            }

            /* Ensure mobile menu button is visible and clickable */
            .mobile-menu-button i {
                font-size: 1.5rem;
                color: var(--text-color);
            }

            .mobile-menu-button:hover {
                background: rgba(5, 150, 105, 0.1);
                color: var(--primary-color);
            }

            .nav-link {
                width: 100%;
                text-align: center;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                margin-bottom: 0.25rem;
            }

            .user-dropdown {
                width: 100%;
            }

            .dropdown-menu {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                margin-top: 0.5rem;
                box-shadow: none;
                border: 1px solid var(--border-color);
                border-radius: 0.5rem;
            }

            .logo {
                font-size: 1.25rem;
            }

            .logo img {
                width: 2rem;
                height: 2rem;
            }
        }

        /* Desktop Menu Styles */
        @media (min-width: 768px) {
            /* Ensure desktop menu is visible */
            .nav-menu.hidden.md\\:flex {
                display: flex !important;
            }
            
            /* Hide mobile menu on desktop */
            #mobileMenu {
                display: none !important;
            }
            
            .nav-menu {
                display: flex !important;
                position: static;
                background: transparent;
                box-shadow: none;
                border: none;
                padding: 0;
                max-height: none;
                overflow: visible;
                flex-direction: row;
                align-items: center;
                gap: 1.5rem;
            }

            .nav-link {
                width: auto;
                text-align: left;
                padding: 0.5rem 1rem;
                margin-bottom: 0;
            }

            .user-dropdown {
                width: auto;
            }

            .dropdown-menu {
                position: absolute;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                margin-top: 0.5rem;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
                border: 1px solid var(--border-color);
            }

            /* Hide mobile menu on desktop */
            #mobileMenu {
                display: none !important;
            }

            /* Hide mobile menu button on desktop */
            .mobile-menu-button {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .nav-menu {
                padding: 0.75rem;
            }

            .nav-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.9rem;
            }

            .logo {
                font-size: 1.1rem;
            }

            .logo img {
                width: 1.75rem;
                height: 1.75rem;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Focus styles for accessibility */
        .nav-link:focus,
        .user-button:focus,
        .mobile-menu-button:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-800 lansia-friendly">

    {{-- Page Loading Screen --}}
    <div class="page-loader" id="pageLoader">
        <div class="loader-logo">
            <span class="text-green">BO</span><span class="text-black">TANI</span>
        </div>
        <div class="loader-text">Memuat halaman...</div>
        <div class="loader-dots">
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
        </div>
    </div>

    {{-- Navbar --}}
  <nav class="navbar bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            
            <a href="{{ url('/') }}" class="logo flex items-center space-x-2">
                <img src="{{ asset('images/logo/logobotani.png') }}" 
                     alt="BO TANI Logo" 
                     class="w-10 h-10 object-contain drop-shadow-lg">
                <span class="text-lg font-bold"><span class="text-green-500">BO</span><span class="text-black">TANI</span></span>
            </a>

            <div class="flex items-center space-x-4">
                
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('product.index_fr') }}" class="nav-link {{ request()->routeIs('product.index_fr') ? 'active' : '' }}">Produk</a>
                    <a href="{{ route('eduwisata') }}" class="nav-link {{ request()->routeIs('eduwisata') ? 'active' : '' }}">Eduwisata</a>
                    <a href="{{ route('blog') }}" class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a>
                    <a href="{{ route('gallery') }}" class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}">Galeri</a>
                    <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">Profil</a>
                    <a href="{{ route('contact.index') }}" class="nav-link {{ request()->routeIs('contact.index') ? 'active' : '' }}">Kontak</a>

                
                    <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-green-600 p-2">
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">
                            0
                        </span>
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </a>
                    
                     @if(session()->has('telepon'))
                        <div class="user-dropdown">
                            <button class="user-button">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span class="text-sm md:text-base">{{ session('telepon') }}</span>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                            </button>
                            
                            <div class="dropdown-menu">
                                <a href="{{ route('riwayat.produk', ['telepon' => session('telepon')]) }}" class="dropdown-item">
                                    <i class="fas fa-shopping-bag mr-2"></i> Riwayat Produk
                                </a>
                                <a href="{{ route('riwayat.eduwisata', ['telepon' => session('telepon')]) }}" class="dropdown-item">
                                    <i class="fas fa-graduation-cap mr-2"></i> Riwayat Eduwisata
                                </a>
                                <a href="{{ route('logout.riwayat') }}" class="dropdown-item logout">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar Riwayat
                                </a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login.wa') }}" class="nav-link text-green-600 hover:bg-green-50">
                            <i class="fas fa-history mr-2"></i> Lihat Riwayat
                        </a>
                    @endif
                </div>

                <div class="nav-menu hidden md:flex" id="desktopMenu">
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobileMenuButton" class="mobile-menu-button text-gray-800 focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200" style="display: none;">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

            </div>
        </div>

        <div id="mobileMenu" class="hidden md:hidden pb-4">
            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('product.index_fr') }}" class="nav-link {{ request()->routeIs('product.index_fr') ? 'active' : '' }}">Produk</a>
            <a href="{{ route('eduwisata') }}" class="nav-link {{ request()->routeIs('eduwisata') ? 'active' : '' }}">Eduwisata</a>
            <a href="{{ route('blog') }}" class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a>
            <a href="{{ route('gallery') }}" class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}">Galeri</a>
            <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">Profil</a>
            <a href="{{ route('contact.index') }}" class="nav-link {{ request()->routeIs('contact.index') ? 'active' : '' }}">Kontak</a>

            <a href="{{ route('cart.index') }}" class="nav-link relative">
                <i class="fas fa-shopping-cart mr-2"></i>
                Keranjang
                <span id="cart-count-mobile" class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">
                    0
                </span>
            </a>

            @if(session()->has('telepon'))
                <div class="user-dropdown">
                    <button class="user-button w-full justify-center">
                        <i class="fas fa-user-circle text-xl"></i>
                        <span>{{ session('telepon') }}</span>
                    </button>
                    
                    <div class="dropdown-menu">
                        <a href="{{ route('riwayat.produk', ['telepon' => session('telepon')]) }}" class="dropdown-item">
                            <i class="fas fa-shopping-bag mr-2"></i> Riwayat Produk
                        </a>
                        <a href="{{ route('riwayat.eduwisata', ['telepon' => session('telepon')]) }}" class="dropdown-item">
                            <i class="fas fa-graduation-cap mr-2"></i> Riwayat Eduwisata
                        </a>
                        <a href="{{ route('logout.riwayat') }}" class="dropdown-item logout">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar Riwayat
                        </a>
                    </div>
                </div>
            @else
                <a href="{{ route('login.wa') }}" class="nav-link text-green-600 hover:bg-green-50">
                    <i class="fas fa-history mr-2"></i>
                    Lihat Riwayat
                </a>
            @endif
        </div>
    </div>
</nav>


    {{-- Main Content --}}
    <main class="animate-fade-in page-transition" id="mainContent">
        @if(session('success'))
            <div class="container mx-auto px-4 mt-4">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mx-auto px-4 mt-4">
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')
    @stack('scripts')
    @stack('modals')
    @livewireScripts

    <script>
        // Page Loading Management
        let isLoading = false;
        const pageLoader = document.getElementById('pageLoader');
        const mainContent = document.getElementById('mainContent');

        // Show loading screen
        function showLoading() {
            if (isLoading) return;
            isLoading = true;
            pageLoader.classList.remove('hidden');
            mainContent.classList.remove('loaded');
        }

        // Hide loading screen
        function hideLoading() {
            isLoading = false;
            pageLoader.classList.add('hidden');
            mainContent.classList.add('loaded');
        }

        // Initial page load
        document.addEventListener('DOMContentLoaded', function() {
            // Simulate loading time for better UX
            setTimeout(() => {
                hideLoading();
            }, 1500);
        });

        // Handle page transitions
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && !link.href.includes('#') && !link.href.includes('javascript:') && !link.target) {
                // Don't show loading for external links or special links
                if (link.href.startsWith(window.location.origin) && !link.href.includes('logout')) {
                    e.preventDefault();
                    showLoading();
                    
                    // Navigate to the page
                    setTimeout(() => {
                        window.location.href = link.href;
                    }, 300);
                }
            }
        });

        // Handle form submissions
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.method === 'post' || form.method === 'POST') {
                showLoading();
            }
        });

        // Handle browser back/forward
        window.addEventListener('beforeunload', function() {
            showLoading();
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Window resize handler for debugging
        window.addEventListener('resize', function() {
            console.log('Window resized to:', window.innerWidth); // Debug log
            const mobileMenu = document.getElementById('mobileMenu');
            const desktopMenu = document.getElementById('desktopMenu');
            const mobileButton = document.querySelector('.mobile-menu-button');
            
            console.log('Mobile menu display:', mobileMenu ? getComputedStyle(mobileMenu).display : 'not found');
            console.log('Desktop menu display:', desktopMenu ? getComputedStyle(desktopMenu).display : 'not found');
            console.log('Mobile button display:', mobileButton ? getComputedStyle(mobileButton).display : 'not found');
        });



        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileButton = document.getElementById('mobileMenuButton');
            
            if (mobileMenu && mobileButton && !mobileMenu.contains(event.target) && !mobileButton.contains(event.target)) {
                mobileMenu.classList.remove('active');
                const buttonIcon = mobileButton.querySelector('i');
                if (buttonIcon) {
                    buttonIcon.classList.remove('fa-times');
                    buttonIcon.classList.add('fa-bars');
                }
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading animation for dynamic content
        function addLoadingToElement(element) {
            element.style.opacity = '0.6';
            element.style.pointerEvents = 'none';
        }

        function removeLoadingFromElement(element) {
            element.style.opacity = '1';
            element.style.pointerEvents = 'auto';
        }

        // Handle AJAX requests (if any)
        if (typeof $ !== 'undefined') {
            $(document).ajaxStart(function() {
                showLoading();
            });
            
            $(document).ajaxStop(function() {
                hideLoading();
            });
        }

        // Page loading and transition scripts
        document.addEventListener('DOMContentLoaded', function() {
            const pageLoader = document.getElementById('pageLoader');
            const pageTransition = document.getElementById('pageTransition');
            
            // Hide loader after a minimum duration
            setTimeout(() => {
                pageLoader.classList.add('hidden');
            }, 500); // Minimum 0.5s loading screen

            // Show content with transition
            if(pageTransition) {
                pageTransition.classList.add('loaded');
            }

            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 20) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                });
            }

            // Debug: Check all elements
            console.log('=== DEBUG INFO ===');
            console.log('Window width:', window.innerWidth);
            console.log('Is mobile:', window.innerWidth <= 767);
            
            // Direct mobile menu button event listener
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            console.log('Mobile menu button found:', mobileMenuButton);
            console.log('Mobile menu button display:', mobileMenuButton ? getComputedStyle(mobileMenuButton).display : 'not found');
            console.log('Mobile menu button visibility:', mobileMenuButton ? getComputedStyle(mobileMenuButton).visibility : 'not found');
            
            // Set mobile menu button visibility based on screen size
            function updateMobileMenuButton() {
                if (mobileMenuButton) {
                    if (window.innerWidth <= 767) {
                        mobileMenuButton.style.display = 'flex';
                        console.log('Mobile menu button shown');
                    } else {
                        mobileMenuButton.style.display = 'none';
                        console.log('Mobile menu button hidden');
                    }
                }
            }
            
            // Initial call
            updateMobileMenuButton();
            
            // Update on window resize
            window.addEventListener('resize', updateMobileMenuButton);
            
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Mobile menu button clicked directly');
                    
                    const mobileMenu = document.getElementById('mobileMenu');
                    const buttonIcon = mobileMenuButton.querySelector('i');
                    
                    if (mobileMenu && buttonIcon) {
                        mobileMenu.classList.toggle('active');
                        
                        if (mobileMenu.classList.contains('active')) {
                            buttonIcon.classList.remove('fa-bars');
                            buttonIcon.classList.add('fa-times');
                            console.log('Mobile menu opened');
                        } else {
                            buttonIcon.classList.remove('fa-times');
                            buttonIcon.classList.add('fa-bars');
                            console.log('Mobile menu closed');
                        }
                    }
                });
            }

            // Close mobile menu when clicking on menu items
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu) {
                const mobileMenuLinks = mobileMenu.querySelectorAll('a');
                mobileMenuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.remove('active');
                        const mobileMenuButton = document.getElementById('mobileMenuButton');
                        const buttonIcon = mobileMenuButton ? mobileMenuButton.querySelector('i') : null;
                        if (buttonIcon) {
                            buttonIcon.classList.remove('fa-times');
                            buttonIcon.classList.add('fa-bars');
                        }
                    });
                });
            }

            // Update cart count
            updateCartCount();
        });

        // Function to update cart count
        function updateCartCount() {
            const cartCountElement = document.getElementById('cart-count');
            const cartCountMobileElement = document.getElementById('cart-count-mobile');
            
            fetch('{{ route('cart.count') }}')
                .then(response => response.json())
                .then(data => {
                    // Update desktop cart count
                    if (cartCountElement) {
                        if (data.count > 0) {
                            cartCountElement.textContent = data.count;
                            cartCountElement.classList.remove('hidden');
                        } else {
                            cartCountElement.classList.add('hidden');
                        }
                    }
                    
                    // Update mobile cart count
                    if (cartCountMobileElement) {
                        if (data.count > 0) {
                            cartCountMobileElement.textContent = data.count;
                            cartCountMobileElement.classList.remove('hidden');
                        } else {
                            cartCountMobileElement.classList.add('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error fetching cart count:', error));
        }

    </script>
</body>
</html>