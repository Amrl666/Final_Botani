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
        <div class="mt-12 animate-fade-in" style="--delay: 0.5s">
            {{ $blogs->links() }}
        </div>
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
</style>
@endsection
