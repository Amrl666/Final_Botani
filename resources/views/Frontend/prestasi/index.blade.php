    @extends('layouts.frontend')

    @section('title', 'Profil Kelompok Tani') {{-- Judul halaman tetap Profil Kelompok Tani --}}

    @section('content')

    {{-- Bagian Style CSS untuk Profil dan Perizinan --}}
    <style>
        .profil-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
            background-color: white;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            font-size: 26px;
            margin: 60px 0 30px;
            position: relative;
            display: inline-block;
            border-bottom: 5px solid #07AA07;
            padding-bottom: 10px;
        }

        .section-subtitle {
            font-size: 22px;
            font-weight: bold;
            margin: 30px 0 10px;
        }

        .section-text {
            font-size: 16px;
            line-height: 1.9;
            text-align: justify;
        }

        .section-image {
            display: flex;
            justify-content: center;
        }

        .section-image img {
            max-width: 100%;
            height: auto;
            border: 3px solid #ccc;
            border-radius: 8px;
        }

        /* === Prestasi Cards Horizontal === */
        .prestasi-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-top: 30px;
        }

        .prestasi-card {
            display: flex;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s;
        }

        .prestasi-card:hover {
            transform: translateY(-4px);
        }

        .prestasi-image {
            flex: 1;
            min-width: 200px;
            max-width: 250px;
        }

        .prestasi-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .prestasi-content {
            flex: 2;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .prestasi-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .prestasi-text {
            font-size: 15px;
            color: #2f5d27;
            text-align: right;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .prestasi-card {
                flex-direction: column;
            }

            .prestasi-image,
            .prestasi-content {
                max-width: 100%;
            }

            .prestasi-text {
                text-align: justify;
            }
        }

        /* CSS Tambahan dari Perizinan */
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

    <div class="container-fluid px-20">

        <div class="text-center">
            <div class="section-title">VISI & MISI</div>
        </div>

        <div class="section-subtitle">Visi</div>
        <p class="section-text">
            "Menjadi kelompok tani yang maju, mandiri, dan sejahtera melalui penerapan teknologi pertanian modern, pengelolaan sumber daya alam yang berkelanjutan, dan peningkatan kualitas hidup anggota."
        </p>

        <div class="section-subtitle">Misi</div>
        <ol class="section-text list-decimal pl-5 space-y-3 text-gray-700">
            <li><strong>Meningkatkan Produktivitas dan Kualitas Hasil Pertanian:</strong> melalui teknologi pertanian modern dan pengelolaan sumber daya alam yang berkelanjutan.</li>
            <li><strong>Meningkatkan Kesejahteraan Anggota:</strong> melalui peningkatan pendapatan, pelatihan, dan pengembangan usaha.</li>
            <li><strong>Mengembangkan Usaha Pertanian yang Berkelanjutan:</strong> dan ramah lingkungan.</li>
            <li><strong>Meningkatkan Kerjasama dan Solidaritas:</strong> antar anggota dan masyarakat sekitar.</li>
            <li><strong>Meningkatkan Kapasitas dan Kemampuan Anggota:</strong> melalui pelatihan dan pendidikan.</li>
        </ol>

        <div class="text-center">
            <div class="section-title">TUJUAN</div>
        </div>

        <div class="section-subtitle">Tujuan</div>
        <ol class="section-text list-decimal pl-5 space-y-3 text-gray-700">
            <li><strong>Meningkatkan Pendapatan Anggota:</strong> melalui produktivitas dan kualitas hasil pertanian.</li>
            <li><strong>Meningkatkan Kualitas Hidup Anggota:</strong> melalui pendidikan, kesehatan, dan kesejahteraan.</li>
            <li><strong>Mengembangkan Usaha Pertanian yang Berkelanjutan:</strong> untuk anggota dan masyarakat sekitar.</li>
        </ol>

         {{-- E. Konten Perizinan (dipindahkan ke sini) --}}
        <div class="text-center">
            <div class="section-title">PERIZINAN</div>
        </div>
        <div class="container mx-auto px-4 py-12 animate-fade-in">
                <div class="bg-white rounded-lg shadow-lg p-8 animate-slide-up">
                    <div class="grid md:grid-cols-2 gap-8">
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

        <div id="pdf-modal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl h-5/6 relative">
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
                    
                    <div class="p-4 h-full">
                        <iframe id="pdf-iframe" src="{{ route('perizinan.pdf') }}" class="w-full h-full border-0 rounded"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <div class="section-title">STRUKTUR ORGANISASI</div>
        </div>
        <div class="section-image">
            <img src="{{ asset('images/struktur-organisasi.jpg') }}" alt="Struktur Organisasi">
        </div>

        <div class="text-center">
            <div class="section-title">PRESTASI</div>
        </div>

        <section class="py-4">
            <div class="container">
            @if($prestasi && $prestasi->count())
            <div class="prestasi-grid">
                @foreach($prestasi as $item)
                <div class="prestasi-card">
                    <div class="prestasi-image">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                    </div>
                    <div class="prestasi-content">
                        <div class="prestasi-title">{{ $item->title }}</div>
                            <div class="prestasi-text">{!! Str::limit(strip_tags($item->content), 250) !!}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info text-center mt-4">
                Tidak ada informasi prestasi yang tersedia saat ini.
            </div>
            @endif
            </div>
        </section>

       

    </div>

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