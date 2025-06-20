@extends('layouts.frontend')

@section('title', $blog->title)

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <article class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
            @if($blog->image)
                <div class="relative h-[400px] animate-scale-in">
                    <img src="{{ asset('storage/' . $blog->image) }}" 
                         alt="{{ $blog->title }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <h1 class="text-4xl font-bold mb-4 animate-slide-up" style="--delay: 0.2s">
                            {{ $blog->title }}
                        </h1>
                        <div class="flex items-center space-x-4 text-sm animate-slide-up" style="--delay: 0.3s">
                            <div class="flex items-center">
                                <i class="far fa-calendar-alt mr-2"></i>
                                {{ $blog->created_at->translatedFormat('d F Y') }}
                            </div>
                            <div class="flex items-center">
                                <i class="far fa-clock mr-2"></i>
                                {{ $blog->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-green-100 p-8 text-center">
                    <h1 class="text-4xl font-bold text-green-800 mb-4 animate-slide-down">
                        {{ $blog->title }}
                    </h1>
                    <div class="flex items-center justify-center space-x-4 text-sm text-green-600">
                        <div class="flex items-center">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ $blog->created_at->translatedFormat('d F Y') }}
                        </div>
                        <div class="flex items-center">
                            <i class="far fa-clock mr-2"></i>
                            {{ $blog->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-8">
                <div class="prose max-w-none text-gray-800 animate-fade-in" style="--delay: 0.4s">
                    {!! $blog->content !!}
                </div>

                <div class="mt-12 pt-6 border-t border-gray-100 animate-slide-up" style="--delay: 0.5s">
                    <a href="{{ route('blog') }}" 
                       class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold transition-colors duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali ke daftar berita
                    </a>
                </div>
            </div>
        </article>
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
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes scaleIn {
    from { transform: scale(1.1); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
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

.animate-scale-in {
    animation: scaleIn 1.5s ease-out forwards;
}

.prose {
    font-size: 1.125rem;
    line-height: 1.75;
}

.prose p {
    margin-bottom: 1.5rem;
}

.prose h2 {
    font-size: 1.875rem;
    font-weight: 700;
    margin-top: 2.5rem;
    margin-bottom: 1.25rem;
    color: #1f2937;
}

.prose h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #374151;
}

.prose ul {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
    list-style-type: disc;
    padding-left: 1.625rem;
}

.prose ol {
    margin-top: 1.25rem;
    margin-bottom: 1.25rem;
    list-style-type: decimal;
    padding-left: 1.625rem;
}

.prose a {
    color: #059669;
    text-decoration: underline;
    font-weight: 500;
}

.prose a:hover {
    color: #047857;
}

.prose blockquote {
    border-left: 4px solid #10b981;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #4b5563;
}

.prose img {
    margin: 2rem auto;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>
@endsection