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
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-color);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
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
        @media (max-width: 768px) {
            .nav-menu {
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
            }

            .nav-menu.active {
                display: flex;
            }

            .mobile-menu-button {
                display: block;
            }

            .nav-link {
                width: 100%;
                text-align: center;
                padding: 0.75rem 1rem;
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
<body class="font-sans antialiased bg-gray-100 text-gray-800">

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
    <nav class="navbar">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="logo flex items-center space-x-2">
                    <img src="{{ asset('images/logo/logobotani.png') }}" 
                        alt="BO TANI Logo" 
                        class="w-10 h-10 object-contain drop-shadow-lg">
                    <span class="text-green-500">BO</span><span class="text-black">TANI</span>
                </a>

                <!-- Desktop Menu -->
                <div class="nav-menu">
                    <a href="{{ url('/') }}" class="nav-link">Beranda</a>
                    <a href="{{ route('product.index_fr') }}" class="nav-link">Produk</a>
                    <a href="{{ route('eduwisata') }}" class="nav-link">Eduwisata</a>
                    <a href="{{ route('blog') }}" class="nav-link">Blog</a>
                    <a href="{{ route('gallery') }}" class="nav-link">Galeri</a>
                    <a href="{{ route('videos') }}" class="nav-link">Video</a>
                    <a href="{{ route('perijinan') }}" class="nav-link">Perijinan</a>
                    <a href="{{ route('profile') }}" class="nav-link">Profil</a>
                    <a href="{{ route('contact.index') }}" class="nav-link">Kontak</a>

                    {{-- User Session Dropdown --}}
                    @if(session()->has('telepon'))
                        <div class="user-dropdown">
                            <button class="user-button">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span class="text-sm md:text-base">{{ session('telepon') }}</span>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                            </button>
                            
                            <div class="dropdown-menu">
                                <a href="{{ route('riwayat.produk', ['telepon' => session('telepon')]) }}"
                                   class="dropdown-item">
                                   <i class="fas fa-shopping-bag mr-2"></i>
                                   Riwayat Produk
                                </a>
                                <a href="{{ route('riwayat.eduwisata', ['telepon' => session('telepon')]) }}"
                                   class="dropdown-item">
                                   <i class="fas fa-graduation-cap mr-2"></i>
                                   Riwayat Eduwisata
                                </a>
                                <a href="{{ route('logout.riwayat') }}"
                                   class="dropdown-item logout">
                                   <i class="fas fa-sign-out-alt mr-2"></i>
                                   Keluar Riwayat
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

                {{-- <!-- Mobile Menu Button -->
                <button class="mobile-menu-button" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="nav-menu md:hidden" id="mobileMenu">
                <a href="{{ url('/') }}" class="nav-link">Beranda</a>
                <a href="{{ route('product.index_fr') }}" class="nav-link">Produk</a>
                <a href="{{ route('eduwisata') }}" class="nav-link">Eduwisata</a>
                <a href="{{ route('blog') }}" class="nav-link">Blog</a>
                <a href="{{ route('gallery') }}" class="nav-link">Galeri</a>
                <a href="{{ route('videos') }}" class="nav-link">Video</a>
                <a href="{{ route('perijinan') }}" class="nav-link">Perijinan</a>
                <a href="{{ route('profile') }}" class="nav-link">Profil</a>
                <a href="{{ route('contact.index') }}" class="nav-link">Kontak</a>

                {{-- Mobile User Session --}}
                {{-- @if(session()->has('telepon'))
                    <div class="user-dropdown">
                        <button class="user-button w-full justify-center">
                            <i class="fas fa-user-circle text-xl"></i>
                            <span>{{ session('telepon') }}</span>
                        </button>
                        
                        <div class="dropdown-menu">
                            <a href="{{ route('riwayat.produk', ['telepon' => session('telepon')]) }}"
                               class="dropdown-item">
                               <i class="fas fa-shopping-bag mr-2"></i>
                               Riwayat Produk
                            </a>
                            <a href="{{ route('riwayat.eduwisata', ['telepon' => session('telepon')]) }}"
                               class="dropdown-item">
                               <i class="fas fa-graduation-cap mr-2"></i>
                               Riwayat Eduwisata
                            </a>
                            <a href="{{ route('logout.riwayat') }}"
                               class="dropdown-item logout">
                               <i class="fas fa-sign-out-alt mr-2"></i>
                               Keluar Riwayat
                            </a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login.wa') }}" class="nav-link text-green-600 hover:bg-green-50">
                        <i class="fas fa-history mr-2"></i>
                        Lihat Riwayat
                    </a>
                @endif
            </div> --}} 
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

        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const button = document.querySelector('.mobile-menu-button i');
            
            mobileMenu.classList.toggle('active');
            
            if (mobileMenu.classList.contains('active')) {
                button.classList.remove('fa-bars');
                button.classList.add('fa-times');
            } else {
                button.classList.remove('fa-times');
                button.classList.add('fa-bars');
            }
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileButton = document.querySelector('.mobile-menu-button');
            
            if (!mobileMenu.contains(event.target) && !mobileButton.contains(event.target)) {
                mobileMenu.classList.remove('active');
                const button = mobileButton.querySelector('i');
                button.classList.remove('fa-times');
                button.classList.add('fa-bars');
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
    </script>
</body>
</html>