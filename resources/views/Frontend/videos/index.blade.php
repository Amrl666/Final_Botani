@extends('layouts.frontend')

@section('title', 'Videos')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 animate-slide-down">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Galeri Video</h1>
            <p class="text-gray-600 text-lg mb-4">Jelajahi koleksi video inspiratif kami</p>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($videos as $video)
                <div class="video-card bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300 animate-slide-up" 
                     style="--delay: {{ $loop->iteration * 0.1 }}s">
                    <div class="relative aspect-video group">
                        <video class="w-full h-full object-cover" preload="metadata" poster="{{ asset('images/video-placeholder.jpg') }}">
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
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-lg p-8 text-center animate-fade-in">
                        <div class="mb-4">
                            <i class="fas fa-video text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Video</h3>
                        <p class="text-gray-600">Video akan segera hadir. Silakan kunjungi kembali nanti.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($videos->hasPages())
            <div class="mt-12 flex justify-center animate-fade-in" style="--delay: 0.5s">
                <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($videos->onFirstPage())
                        <span class="px-4 py-2 border border-gray-300 bg-gray-100 text-gray-400 rounded-l-md cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $videos->previousPageUrl() }}" class="px-4 py-2 border border-gray-300 bg-white text-green-600 hover:bg-green-50 rounded-l-md transition">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($videos->getUrlRange(1, $videos->lastPage()) as $page => $url)
                        @if ($page == $videos->currentPage())
                            <span class="px-4 py-2 border-t border-b border-gray-300 bg-green-600 text-white font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-green-600 hover:bg-green-50 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($videos->hasMorePages())
                        <a href="{{ $videos->nextPageUrl() }}" class="px-4 py-2 border border-gray-300 bg-white text-green-600 hover:bg-green-50 rounded-r-md transition">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-4 py-2 border border-gray-300 bg-gray-100 text-gray-400 rounded-r-md cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
</section>

@push('styles')
<style>
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
    opacity: 0;
    animation: fadeIn 1s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.animate-slide-down {
    animation: slideDown 1s ease-out forwards;
}

.animate-slide-up {
    opacity: 0;
    animation: slideUp 1s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.aspect-video {
    aspect-ratio: 16 / 9;
}

.video-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.video-card:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
</style>
@endpush

@push('scripts')
<script>
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
    }, { threshold: 0.5 });

    document.querySelectorAll('.video-card .group').forEach(video => {
        observer.observe(video);
    });
});
</script>
@endpush
@endsection