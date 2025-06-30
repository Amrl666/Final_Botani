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
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    @foreach($videos as $video)
                    <div class="gallery-card bg-white rounded-lg overflow-hidden shadow-md p-4 animate-slide-up" style="--delay: {{ $loop->iteration * 0.05 }}s">
                        <video controls class="w-full rounded-md">
                            <source src="{{ Storage::url($video->video) }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                        </video>
                        <div class="mt-4">
                            <h3 class="font-bold text-lg text-gray-800">{{ $video->title }}</h3>
                            <p class="text-gray-600 text-sm mt-1">{{ $video->description }}</p>
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
</script>
@endpush
@endsection
