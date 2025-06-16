@extends('layouts.frontend')

@section('title', $blog->title)

@section('content')
<div class="w-full px-4 sm:px-8 lg:px-10 py-10 flex justify-center">
    <article class="bg-white p-6 rounded shadow w-full
                    max-w-sm sm:max-w-md md:max-w-3xl lg:max-w-5xl xl:max-w-7xl">
        <h1 class="text-2xl sm:text-3xl font-bold text-green-800 mb-4">{{ $blog->title }}</h1>
        <p class="text-xs sm:text-sm text-gray-500 mb-4">Diposting pada {{ $blog->created_at->translatedFormat('d F Y') }}</p>

        @if($blog->image)
            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full rounded mb-6">
        @endif

        <div class="prose max-w-none text-gray-800">
            {!! $blog->content !!}
        </div>

        <div class="mt-6">
            <a href="{{ route('blog') }}" class="text-green-700 hover:underline">&larr; Kembali ke daftar berita</a>
        </div>
    </article>
</div>
@endsection
