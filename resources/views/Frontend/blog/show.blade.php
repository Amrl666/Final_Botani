@extends('layouts.frontend')

@section('title', $blog->title)

@section('content')
<div class="container mx-auto px-4 py-10 max-w-4xl">
    <article class="bg-white p-6 rounded shadow">
        <h1 class="text-3xl font-bold text-green-800 mb-4">{{ $blog->title }}</h1>
        <p class="text-sm text-gray-500 mb-4">Diposting pada {{ $blog->created_at->translatedFormat('d F Y') }}</p>

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
