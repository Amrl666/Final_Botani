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
                    
                    <!-- PDF Action Buttons -->
                    <div class="mt-8 space-y-3">
                        <button onclick="openPdfViewer()" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300 flex items-center justify-center space-x-2">
                            <i class="fas fa-file-pdf text-xl"></i>
                            <span>Lihat Dokumen Perizinan</span>
                        </button>
                        <a href="{{ route('perizinan.pdf') }}" target="_blank" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300 text-center flex items-center justify-center space-x-2">
                            <i class="fas fa-download text-xl"></i>
                            <span>Download PDF</span>
                        </a>
                        
                    </div>
                </div>

                <!-- Right Column - PDF Preview -->
                <div class="relative overflow-hidden rounded-lg shadow-lg animate-fade-in bg-gray-100">
                    <div id="pdf-container" class="w-full h-96 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-file-pdf text-6xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 font-medium">Dokumen Perizinan</p>
                            <p class="text-sm text-gray-500 mt-2">Klik tombol di sebelah kiri untuk melihat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PDF Viewer Modal -->
<div id="pdf-modal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl h-5/6 relative">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Dokumen Perizinan</h3>
                <div class="flex items-center space-x-2">
                    <button onclick="toggleFullscreen()" class="text-gray-500 hover:text-gray-700 p-2 rounded hover:bg-gray-100" title="Fullscreen">
                        <i class="fas fa-expand text-lg"></i>
                    </button>
                    <button onclick="closePdfViewer()" class="text-gray-500 hover:text-gray-700 p-2 rounded hover:bg-gray-100">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- PDF Content -->
            <div class="p-4 h-full">
                <iframe id="pdf-iframe" src="{{ route('perizinan.pdf') }}" class="w-full h-full border-0 rounded"></iframe>
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

/* Modal animations */
#pdf-modal {
    transition: opacity 0.3s ease-in-out;
}

#pdf-modal.show {
    display: flex !important;
}

/* Responsive modal */
@media (max-width: 768px) {
    #pdf-modal .bg-white {
        width: 95vw !important;
        height: 90vh !important;
        max-width: none !important;
    }
    
    #pdf-modal .p-4 {
        padding: 0.5rem !important;
    }
    
    #pdf-modal .h-5\/6 {
        height: calc(90vh - 4rem) !important;
    }
}

/* Fullscreen styles */
#pdf-modal .bg-white:fullscreen {
    border-radius: 0 !important;
    max-width: none !important;
    height: 100vh !important;
}

#pdf-modal .bg-white:-webkit-full-screen {
    border-radius: 0 !important;
    max-width: none !important;
    height: 100vh !important;
}
</style>

<script>
function openPdfViewer() {
    const modal = document.getElementById('pdf-modal');
    const iframe = document.getElementById('pdf-iframe');
    
    // Tambahkan loading state
    iframe.onload = function() {
        // PDF berhasil dimuat
    };
    
    iframe.onerror = function() {
        alert('Gagal memuat dokumen. Pastikan file PDF tersedia di server.');
        closePdfViewer();
    };
    
    modal.classList.remove('hidden');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closePdfViewer() {
    const modal = document.getElementById('pdf-modal');
    modal.classList.add('hidden');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

function toggleFullscreen() {
    const modal = document.getElementById('pdf-modal');
    const modalContent = modal.querySelector('.bg-white');
    
    if (!document.fullscreenElement) {
        // Enter fullscreen
        if (modalContent.requestFullscreen) {
            modalContent.requestFullscreen();
        } else if (modalContent.webkitRequestFullscreen) {
            modalContent.webkitRequestFullscreen();
        } else if (modalContent.msRequestFullscreen) {
            modalContent.msRequestFullscreen();
        }
    } else {
        // Exit fullscreen
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

// Close modal when clicking outside
document.getElementById('pdf-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePdfViewer();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePdfViewer();
    }
});

// Handle fullscreen change
document.addEventListener('fullscreenchange', function() {
    const fullscreenBtn = document.querySelector('[onclick="toggleFullscreen()"] i');
    if (document.fullscreenElement) {
        fullscreenBtn.className = 'fas fa-compress text-lg';
    } else {
        fullscreenBtn.className = 'fas fa-expand text-lg';
    }
});
</script>
@endsection