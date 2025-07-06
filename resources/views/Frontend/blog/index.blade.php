@extends('layouts.frontend')

@section('title', 'Berita Terkini')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 animate-slide-down">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Berita Terkini</h1>
            <p class="text-gray-600 text-lg mb-4">Temukan informasi terbaru seputar Tani Winongo Asri</p>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($blogs as $blog)
            <article class="group bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 animate-slide-up" style="--delay: {{ $loop->iteration * 0.1 }}s">
                <div class="relative">
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                             class="w-full h-48 object-cover transform transition-transform duration-700 ease-in-out group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    @else
                        <div class="w-full h-48 bg-green-100 flex items-center justify-center">
                            <i class="fas fa-newspaper text-4xl text-green-500"></i>
                        </div>
                    @endif
                    <div class="absolute bottom-4 left-4 text-white">
                        <div class="flex items-center text-sm">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ $blog->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <h2 class="font-bold text-xl mb-3 text-gray-800 hover:text-green-600 transition-colors duration-300">
                        {{ $blog->title }}
                    </h2>
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($blog->content), 150) }}
                    </p>
                    <a href="{{ route('blog.show_fr', $blog->title) }}"
                       class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold transition-colors duration-300">
                        Baca selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($blogs->hasPages())
            <div class="mt-12 flex justify-center animate-fade-in" style="--delay: 0.5s">
                <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($blogs->onFirstPage())
                        <span class="px-4 py-2 border border-gray-300 bg-gray-100 text-gray-400 rounded-l-md cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $blogs->previousPageUrl() }}" class="px-4 py-2 border border-gray-300 bg-white text-green-600 hover:bg-green-50 rounded-l-md transition">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                        @if ($page == $blogs->currentPage())
                            <span class="px-4 py-2 border-t border-b border-gray-300 bg-green-600 text-white font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-green-600 hover:bg-green-50 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($blogs->hasMorePages())
                        <a href="{{ $blogs->nextPageUrl() }}" class="px-4 py-2 border border-gray-300 bg-white text-green-600 hover:bg-green-50 rounded-r-md transition">
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
</div>

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
    from {
        transform: translateY(30px) scale(0.95);
        opacity: 0;
    }
    to {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
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
    animation: slideUp 0.8s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive Design */
@media (max-width: 768px) {
    .min-h-screen {
        min-height: auto;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .text-4xl {
        font-size: 2rem;
    }

    .text-lg {
        font-size: 1rem;
    }

    .grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1.5rem;
    }

    .p-6 {
        padding: 1rem;
    }

    .text-xl {
        font-size: 1.125rem;
    }

    .h-48 {
        height: 12rem;
    }

    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

@media (max-width: 480px) {
    .text-4xl {
        font-size: 1.5rem;
    }

    .text-lg {
        font-size: 0.9rem;
    }

    .p-6 {
        padding: 0.75rem;
    }

    .text-xl {
        font-size: 1rem;
    }

    .h-48 {
        height: 10rem;
    }

    .grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 {
        gap: 1rem;
    }
}
</style>
@endsection
