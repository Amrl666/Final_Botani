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
                <button onclick="openLightbox('{{ asset('storage/' . $gallery->image) }}', '{{ $gallery->title }}')"
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
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden animate-fade-in">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors">
            <i class="fas fa-times text-2xl"></i>
        </button>
        
        <div class="max-w-4xl w-full">
            <img id="lightbox-image" src="" alt="" class="w-full h-auto rounded-lg shadow-2xl">
            <div class="text-white text-center mt-4">
                <h3 id="lightbox-title" class="text-xl font-semibold"></h3>
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
</style>

@push('scripts')
<script>
function openLightbox(imageSrc, title) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const lightboxTitle = document.getElementById('lightbox-title');
    
    lightboxImage.src = imageSrc;
    lightboxTitle.textContent = title;
    lightbox.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close lightbox when clicking outside the image
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});

// Close lightbox with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});
</script>
@endpush
@endsection