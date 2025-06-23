@extends('layouts.frontend')

@section('title', 'Galeri')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="text-center mb-12 animate-slide-down">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Galeri Kegiatan</h1>
            <p class="text-gray-600 text-lg mb-4">Dokumentasi kegiatan dan momen berharga kami</p>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($galleries as $gallery)
            <div class="group relative overflow-hidden rounded-xl shadow-lg animate-slide-up"
                 style="--delay: {{ $loop->iteration * 0.1 }}s">
                <!-- Image -->
                <div class="relative aspect-[4/3] overflow-hidden">
                    @if($gallery->image)
                        <img src="{{ asset('storage/' . $gallery->image) }}" 
                             alt="{{ $gallery->title }}" 
                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-image text-4xl text-gray-400"></i>
                        </div>
                    @endif
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <h3 class="text-lg font-semibold mb-1 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                {{ $gallery->title }}
                            </h3>
                            <div class="flex items-center text-sm transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 delay-75">
                                <i class="far fa-calendar-alt mr-2"></i>
                                {{ \Carbon\Carbon::parse($gallery->description)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Button -->
                <button onclick="openLightbox('{{ asset('storage/' . $gallery->image) }}', '{{ $gallery->title }}', {{ $loop->index }})"
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white bg-opacity-90 rounded-full p-3 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110">
                    <i class="fas fa-search-plus text-green-600 text-xl"></i>
                </button>
            </div>
            @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-lg p-8 text-center animate-fade-in">
                    <div class="mb-4">
                        <i class="fas fa-images text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Foto</h3>
                    <p class="text-gray-600">Galeri foto akan segera hadir. Silakan kunjungi kembali nanti.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12 animate-fade-in" style="--delay: 0.5s">
            {{ $galleries->links() }}
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-95 z-50 hidden">
    <!-- Close Button -->
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors bg-black bg-opacity-50 rounded-full p-3">
        <i class="fas fa-times text-2xl"></i>
    </button>
    
    <!-- Navigation Arrows -->
    <button onclick="previousImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 transition-colors bg-black bg-opacity-50 rounded-full p-3">
        <i class="fas fa-chevron-left text-2xl"></i>
    </button>
    
    <button onclick="nextImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 transition-colors bg-black bg-opacity-50 rounded-full p-3">
        <i class="fas fa-chevron-right text-2xl"></i>
    </button>
    
    <!-- Image Counter -->
    <div class="absolute top-4 left-1/2 transform -translate-x-1/2 text-white bg-black bg-opacity-50 rounded-full px-4 py-2">
        <span id="image-counter">1 / 1</span>
    </div>
    
    <!-- Scrollable Container -->
    <div class="absolute inset-0 overflow-y-scroll p-4" onclick="handleLightboxClick(event)"> {{-- ✅ PERBAIKAN --}}
        <div class="min-h-full flex items-center justify-center py-8">
            <div class="max-w-5xl w-full">
                <!-- Image Container -->
                <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
                    <img id="lightbox-image" src="" alt="" class="w-full h-auto max-h-[80vh] object-contain">
                </div>
                
                <!-- Image Info -->
                <div class="text-white text-center mt-6">
                    <h3 id="lightbox-title" class="text-2xl font-semibold mb-2"></h3>
                    <p id="lightbox-date" class="text-lg opacity-75"></p>
                </div>
                
                <!-- Close Button at Bottom -->
                <div class="text-center mt-8">
                    <button onclick="closeLightbox()" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-6 py-3 rounded-lg transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>Tutup Preview
                    </button>
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

/* Lightbox Styles */
#lightbox {
    backdrop-filter: blur(5px);
}

#lightbox-image {
    max-height: 80vh;
    object-fit: contain;
}

#lightbox::-webkit-scrollbar {
    width: 8px;
}
#lightbox::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}
#lightbox::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 4px;
}
#lightbox::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* ✅ PERBAIKAN tombol di atas elemen lain */
#lightbox button {
    z-index: 60;
}
</style>

@push('scripts')
<script>
let currentImageIndex = 0;
let galleryImages = [];

document.addEventListener('DOMContentLoaded', function() {
    const imageElements = document.querySelectorAll('.group img[src*="storage"]');
    galleryImages = Array.from(imageElements).map((img, index) => ({
        src: img.src,
        title: img.alt,
        date: img.closest('.group').querySelector('.text-sm')?.textContent?.trim() || ''
    }));
});

function openLightbox(imageSrc, title, index = 0) {
    currentImageIndex = index;

    document.getElementById('lightbox-image').src = imageSrc;
    document.getElementById('lightbox-title').textContent = title;
    document.getElementById('lightbox-date').textContent = galleryImages[index]?.date || '';
    document.getElementById('image-counter').textContent = `${index + 1} / ${galleryImages.length}`;
    document.getElementById('lightbox').classList.remove('hidden');

    document.body.classList.add('overflow-hidden'); // ✅ PERBAIKAN
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.body.classList.remove('overflow-hidden'); // ✅ PERBAIKAN
}

function previousImage() {
    if (currentImageIndex > 0) {
        currentImageIndex--;
        loadImage(currentImageIndex);
    }
}

function nextImage() {
    if (currentImageIndex < galleryImages.length - 1) {
        currentImageIndex++;
        loadImage(currentImageIndex);
    }
}

function loadImage(index) {
    const image = galleryImages[index];
    if (!image) return;

    document.getElementById('lightbox-image').src = image.src;
    document.getElementById('lightbox-title').textContent = image.title;
    document.getElementById('lightbox-date').textContent = image.date;
    document.getElementById('image-counter').textContent = `${index + 1} / ${galleryImages.length}`;
}

// ✅ PERBAIKAN klik luar gambar untuk menutup
function handleLightboxClick(event) {
    const content = document.getElementById('lightbox-image');
    if (!content.contains(event.target)) {
        closeLightbox();
    }
}

// Keyboard support
document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightbox').classList.contains('hidden')) return;
    switch (e.key) {
        case 'Escape':
            closeLightbox();
            break;
        case 'ArrowLeft':
            previousImage();
            break;
        case 'ArrowRight':
            nextImage();
            break;
    }
});
</script>
@endpush
@endsection
