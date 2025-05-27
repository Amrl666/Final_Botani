@extends('layouts.frontend')

@section('title', 'Berita Terkini')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-green-800 mb-6 text-center">Berita Terkini</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($blogs as $blog)
        <div class="bg-white rounded shadow overflow-hidden">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-40 object-cover">
            @endif
            <div class="p-4">
                <h2 class="font-semibold text-lg mb-2">{{ $blog->title }}</h2>
                <p class="text-sm text-gray-600">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                <a href="{{ route('blog.show_fr', $blog->title) }}" class="text-green-700 text-sm mt-2 inline-block hover:underline">
                    Baca selengkapnya →
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
