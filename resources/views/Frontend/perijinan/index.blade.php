@extends('layouts.frontend')

@section('title', 'Perijinan')

@section('content')
<div class="container mx-auto px-4 py-12 animate-fade-in">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12 animate-slide-down">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Perizinan</h1>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-lg p-8 animate-slide-up">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Left Column - Information -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-semibold text-green-700 mb-4">Informasi Perizinan</h2>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Izin Usaha</h3>
                                <p class="text-gray-600">Kami memiliki izin usaha resmi dari pemerintah setempat</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-certificate text-green-500 text-xl mt-1"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Sertifikasi</h3>
                                <p class="text-gray-600">Produk kami telah tersertifikasi halal dan aman dikonsumsi</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-award text-green-500 text-xl mt-1"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Penghargaan</h3>
                                <p class="text-gray-600">Berbagai penghargaan dari instansi terkait</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Image -->
                <div class="relative overflow-hidden rounded-lg shadow-lg animate-fade-in">
                    <img src="{{ asset('images/perizinan.jpg') }}" alt="Perizinan" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
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
}

/* Hover effects */
.hover\:scale-105:hover {
    transform: scale(1.05);
}
</style>
@endsection