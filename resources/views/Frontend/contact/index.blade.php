@extends('layouts.frontend')

@section('title', 'Kontak Kami')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold text-green-800 mb-4 text-center">Kontak Kami</h2>
    <p class="text-center text-gray-600 mb-8">Masih Bingung? <span class="text-green-600 font-semibold">Hubungi Kami!</span></p>

    <div class="flex flex-col md:flex-row bg-white rounded-xl shadow p-6 md:gap-6">
        <!-- Info Kontak -->
        <div class="md:w-1/2 bg-green-50 p-6 rounded-xl mb-6 md:mb-0">
            <h4 class="text-xl text-green-700 font-bold mb-2">Kontak Konsultasi</h4>
            <p class="text-gray-700 mb-4">Hubungi Tani Winongo Asri untuk lebih lanjut!!</p>

            <p class="flex items-center text-gray-700 mb-2">
                <i class="fas fa-phone-alt text-green-600 mr-2"></i> 081234567890
            </p>
            <p class="flex items-center text-gray-700 mb-2">
                <i class="fas fa-envelope text-green-600 mr-2"></i> winongoasri@gmail.com
            </p>
            <p class="flex items-start text-gray-700 mb-4">
                <i class="fas fa-map-marker-alt text-green-600 mr-2 mt-1"></i>
                <span>Patangpuluhan, Wirobrajan,<br>Yogyakarta Kota, DIY 55251</span>
            </p>

            <div class="flex space-x-4 mt-2">
                <a href="#" class="text-green-600 hover:text-green-800"><i class="fab fa-instagram fa-lg"></i></a>
                <a href="#" class="text-green-600 hover:text-green-800"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="text-green-600 hover:text-green-800"><i class="fab fa-whatsapp fa-lg"></i></a>
            </div>
        </div>

        <!-- Form Kontak -->
        <div class="md:w-1/2">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Formulir Kontak</h3>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ url('/contact/send') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full border rounded px-4 py-2 @error('name') border-red-500 @enderror">
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full border rounded px-4 py-2 @error('email') border-red-500 @enderror">
                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Subjek</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" required
                        class="w-full border rounded px-4 py-2 @error('subject') border-red-500 @enderror">
                    @error('subject') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
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
    </div>
</div>
@endsection
