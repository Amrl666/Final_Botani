@extends('layouts.frontend')

@section('title', 'Galeri')

@push('styles')
<style>
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-fade-in {
        animation: fadeIn 1s ease-out forwards;
    }
    .animate-slide-down {
        animation: slideDown 0.8s ease-out forwards;
    }
    .animate-slide-up {
        opacity: 0;
        animation: slideUp 0.6s ease-out forwards;
        animation-delay: var(--delay, 0s);
    }

    /* Tab styling */
    .tab-btn {
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
    }
    .tab-btn.active {
        border-bottom-color: #059669;
        color: #059669;
        font-weight: 600;
    }
    .tab-content { display: none; }
    .tab-content.active { 
        display: block;
        animation: fadeIn 0.5s ease-out; /* Fade in content on switch */
    }
    
    /* Card styling */
    .gallery-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Video Grid Styles */
    .aspect-video {
        aspect-ratio: 16 / 10;
        min-height: 250px;
    }

    /* Uniform Grid for Videos - All Landscape */
    .video-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        grid-auto-rows: 1fr;
    }

    .video-grid .video-card {
        break-inside: avoid;
        margin-bottom: 0;
    }

    .video-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        min-height: 400px;
    }

    .video-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transform: translateY(-5px);
    }

    .video-card .p-6 {
        padding: 1.5rem !important;
    }

    .video-card h3 {
        font-size: 1.25rem;
        line-height: 1.4;
    }

    .video-card p {
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .play-button {
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.3s ease;
    }

    .group:hover .play-button {
        opacity: 1;
        transform: scale(1);
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .video-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .video-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="bg-gradient-to-b from-green-50 to-white py-12 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12 animate-slide-down">
            <h1 class="text-4xl font-extrabold text-green-800 tracking-tight sm:text-5xl">Galeri Kami</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                Jelajahi momen dan kegiatan kami melalui koleksi foto dan video.
            </p>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full mt-4"></div>
        </div>

        <!-- Tab Navigation -->
        <div class="flex justify-center border-b border-gray-200 mb-8 animate-fade-in" style="animation-delay: 0.2s;">
            <button id="photo-tab-btn" class="tab-btn py-4 px-6 text-lg" onclick="switchTab('photo')">
                <i class="fas fa-camera mr-2"></i>Foto
            </button>
            <button id="video-tab-btn" class="tab-btn py-4 px-6 text-lg" onclick="switchTab('video')">
                <i class="fas fa-video mr-2"></i>Video
            </button>
        </div>

        <!-- Tab Content -->
        <div class="animate-fade-in" style="animation-delay: 0.4s;">
            <!-- Photo Gallery -->
            <div id="photo-content" class="tab-content">
                @if($galleries->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($galleries as $gallery)
                    <div class="gallery-card bg-white rounded-lg overflow-hidden shadow-md animate-slide-up" style="--delay: {{ $loop->iteration * 0.05 }}s">
                        <a href="{{ Storage::url($gallery->image) }}" data-fancybox="gallery" data-caption="{{ $gallery->title }} - {{ $gallery->description->format('d M Y') }}">
                            <img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->title }}" class="h-64 w-full object-cover">
                        </a>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800">{{ $gallery->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $gallery->description->format('d M Y') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $galleries->appends(['videos_page' => $videos->currentPage()])->links() }}
                </div>
                @else
                <div class="text-center text-gray-500 py-16 animate-fade-in">
                    <i class="fas fa-images text-5xl text-gray-400 mb-4"></i>
                    <p>Belum ada foto yang ditambahkan.</p>
                </div>
                @endif
            </div>

            <!-- Video Gallery -->
            <div id="video-content" class="tab-content">
                @if($videos->count() > 0)
                <div class="video-grid">
                    @foreach($videos as $video)
                    <div class="video-card bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300 animate-slide-up" 
                         style="--delay: {{ $loop->iteration * 0.1 }}s">
                        <div class="relative aspect-video group">
                            <video class="w-full h-full object-cover" 
                                   preload="metadata">
                                <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <button class="play-button bg-white bg-opacity-90 rounded-full p-4 transform hover:scale-110 transition-transform duration-300"
                                        onclick="playVideo(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $video->title }}</h3>
                            @if($video->description)
                                <p class="text-gray-600 line-clamp-2 mb-4">{{ $video->description }}</p>
                            @endif
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="far fa-calendar-alt mr-2"></i>
                                {{ $video->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $videos->appends(['gallery_page' => $galleries->currentPage()])->links() }}
                </div>
                @else
                <div class="text-center text-gray-500 py-16 animate-fade-in">
                    <i class="fas fa-video-slash text-5xl text-gray-400 mb-4"></i>
                    <p>Belum ada video yang ditambahkan.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchTab(tab) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

        document.getElementById(tab + '-content').classList.add('active');
        document.getElementById(tab + '-tab-btn').classList.add('active');
        
        const url = new URL(window.location);
        url.searchParams.set('tab', tab);
        window.history.pushState({}, '', url);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        const tab = params.get('tab') || 'photo';
        switchTab(tab);
    });

    function playVideo(button) {
        const videoContainer = button.closest('.group');
        const video = videoContainer.querySelector('video');
        
        if (video.paused) {
            video.play();
            button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            `;
        } else {
            video.pause();
            button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            `;
        }
    }

    // Pause all videos when scrolling out of view
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    const video = entry.target.querySelector('video');
                    const button = entry.target.querySelector('.play-button');
                    if (video && !video.paused) {
                        video.pause();
                        if (button) {
                            button.innerHTML = `
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            `;
                        }
                    }
                }
            });
        });

        // Observe all video containers
        document.querySelectorAll('.group').forEach(container => {
            observer.observe(container);
        });
    });
</script>
@endpush
@endsection
