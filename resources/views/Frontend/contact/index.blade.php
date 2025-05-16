@extends('layouts.frontend')

@section('title', 'Kontak Kami')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-green-800 mb-6 text-center">Hubungi Kami</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ url('/contact/send') }}" method="POST" class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full border rounded px-4 py-2 @error('name') border-red-500 @enderror">
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border rounded px-4 py-2 @error('email') border-red-500 @enderror">
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Subjek</label>
            <input type="text" name="subject" value="{{ old('subject') }}" required
                class="w-full border rounded px-4 py-2 @error('subject') border-red-500 @enderror">
            @error('subject') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Pesan</label>
            <textarea name="message" rows="5" required
                class="w-full border rounded px-4 py-2 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
            @error('message') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-semibold px-6 py-2 rounded">
            Kirim Pesan
        </button>
    </form>
</div>
@endsection
