@extends('layouts.frontend')

@section('title', 'Kontak Kami')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 animate-slide-down">
            <h2 class="text-4xl font-bold text-green-800 mb-4">Kontak Kami</h2>
            <p class="text-gray-600 text-lg">Masih Bingung? <span class="text-green-600 font-semibold animate-pulse">Hubungi Kami!</span></p>
            <div class="w-24 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-xl overflow-hidden animate-slide-up">
                <!-- Info Kontak -->
                <div class="md:w-2/5 bg-gradient-to-br from-green-600 to-green-700 p-8 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="text-2xl font-bold mb-6">Kontak Konsultasi</h4>
                        <p class="mb-8 text-green-100">Hubungi Tani Winongo Asri untuk lebih lanjut!</p>

                        <div class="space-y-6">
                            <div class="flex items-center space-x-4 hover:translate-x-2 transition-transform duration-300">
                                <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-phone-alt text-white"></i>
                                </div>
                                <p>081234567890</p>
                            </div>

                            <div class="flex items-center space-x-4 hover:translate-x-2 transition-transform duration-300">
                                <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <p>winongoasri@gmail.com</p>
                            </div>

                            <div class="flex items-start space-x-4 hover:translate-x-2 transition-transform duration-300">
                                <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <p>Patangpuluhan, Wirobrajan,<br>Yogyakarta Kota, DIY 55251</p>
                            </div>
                        </div>

                        <div class="mt-12">
                            <h5 class="text-lg font-semibold mb-4">Ikuti Kami</h5>
                            <div class="flex space-x-4">
                                <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors duration-300">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors duration-300">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition-colors duration-300">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Decorative circles -->
                    <div class="absolute -bottom-20 -right-20 w-48 h-48 bg-white/5 rounded-full"></div>
                    <div class="absolute -top-20 -left-20 w-48 h-48 bg-white/5 rounded-full"></div>
                </div>

                <!-- Form Kontak -->
                <div class="md:w-3/5 p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h3>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded animate-fade-in">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <form action="{{ url('/contact/send') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="form-group animate-slide-up" style="--delay: 0.1s">
                            <label class="block text-gray-700 font-medium mb-2">Nama</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors duration-300 @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group animate-slide-up" style="--delay: 0.2s">
                            <label class="block text-gray-700 font-medium mb-2">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors duration-300 @error('whatsapp') border-red-500 @enderror">
                            @error('whatsapp') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group animate-slide-up" style="--delay: 0.3s">
                            <label class="block text-gray-700 font-medium mb-2">Subjek</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors duration-300 @error('subject') border-red-500 @enderror">
                            @error('subject') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group animate-slide-up" style="--delay: 0.4s">
                            <label class="block text-gray-700 font-medium mb-2">Pesan</label>
                            <textarea name="message" rows="5" required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-colors duration-300 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 animate-slide-up"
                            style="--delay: 0.5s">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
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
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.animate-fade-in {
    animation: fadeIn 1s ease-out forwards;
}

.animate-slide-down {
    animation: slideDown 1s ease-out forwards;
}

.animate-slide-up {
    animation: slideUp 1s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.form-group {
    opacity: 0;
    animation: slideUp 0.5s ease-out forwards;
    animation-delay: var(--delay, 0s);
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
}
</style>
@endsection