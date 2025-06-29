@extends('layouts.frontend')

@section('title', 'Kontak Kami')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                <i class="fas fa-headset text-green-600 mr-3"></i>
                Kontak Kami
            </h1>
            <p class="text-gray-600 text-xl">Masih bingung? <span class="text-green-600 font-semibold">Hubungi kami!</span></p>
            <div class="w-24 h-1 bg-green-500 mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Contact Information -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-8">
                    <h2 class="text-white font-bold text-2xl mb-2 flex items-center">
                        <i class="fas fa-info-circle mr-3"></i>
                        Informasi Kontak
                    </h2>
                    <p class="text-green-100">Hubungi Tani Winongo Asri untuk konsultasi lebih lanjut!</p>
                </div>
                
                <div class="p-8">
                    <div class="space-y-6">
                        <!-- Phone -->
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-phone text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Telepon</p>
                                <p class="font-semibold text-gray-900">0855-3020-204</p>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">WhatsApp</p>
                                <p class="font-semibold text-gray-900">0855-3020-204</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-envelope text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-semibold text-gray-900">winongoasri@gmail.com</p>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mt-1">
                                <i class="fas fa-map-marker-alt text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Alamat</p>
                                <p class="font-semibold text-gray-900">Patangpuluhan, Wirobrajan,<br>Yogyakarta Kota, DIY 55251</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-share-alt mr-2"></i>
                            Ikuti Kami
                        </h3>
                        <div class="flex space-x-4">
                            <a href="#" class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center hover:bg-pink-200 transition-colors">
                                <i class="fab fa-instagram text-pink-600 text-xl"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center hover:bg-blue-200 transition-colors">
                                <i class="fab fa-facebook text-blue-600 text-xl"></i>
                            </a>
                            <a href="https://wa.me/628553020204" target="_blank" class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center hover:bg-green-200 transition-colors">
                                <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-8">
                    <h2 class="text-white font-bold text-2xl mb-2 flex items-center">
                        <i class="fas fa-paper-plane mr-3"></i>
                        Kirim Pesan
                    </h2>
                    <p class="text-blue-100">Kirim pesan dan kami akan segera menghubungi Anda</p>
                </div>
                
                <div class="p-8">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3 text-lg"></i>
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ url('/contact/send') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-1"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('name') border-red-500 @enderror"
                                   placeholder="Masukkan nama lengkap Anda">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- WhatsApp -->
                        <div>
                            <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-whatsapp mr-1"></i>
                                Nomor WhatsApp
                            </label>
                            <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('whatsapp') border-red-500 @enderror"
                                   placeholder="Contoh: 0855-3020-204">
                            @error('whatsapp')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag mr-1"></i>
                                Subjek
                            </label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('subject') border-red-500 @enderror"
                                   placeholder="Contoh: Konsultasi Produk">
                            @error('subject')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-comment mr-1"></i>
                                Pesan
                            </label>
                            <textarea name="message" id="message" rows="5" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('message') border-red-500 @enderror"
                                      placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Quick Contact -->
        <div class="mt-12 bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Butuh Bantuan Cepat?</h3>
                <p class="text-gray-600">Hubungi kami langsung melalui WhatsApp</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="https://wa.me/628553020204?text=Halo, saya ingin bertanya tentang produk Tani Winongo Asri" 
                   target="_blank"
                   class="inline-flex items-center px-8 py-4 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors">
                    <i class="fab fa-whatsapp mr-3 text-xl"></i>
                    Chat WhatsApp
                </a>
                
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-phone mr-2"></i>
                    <span class="font-semibold">0855-3020-204</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection