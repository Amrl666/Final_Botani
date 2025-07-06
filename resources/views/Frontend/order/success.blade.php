@extends('layouts.frontend')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="mb-8">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check-circle text-6xl text-green-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Pesanan Berhasil!</h1>
                <p class="text-lg text-gray-600 mb-8">
                    Terima kasih telah memesan produk kami. Pesanan Anda telah kami terima.
                </p>
            </div>

            <!-- Success Message -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <div class="space-y-4">
                <div class="flex items-center justify-center space-x-3 text-green-600">
                <span class="text-lg font-semibold">
                    <i class="fas fa-bell text-yellow-500 mr-2"></i>
                    Notifikasi WhatsApp Terkirim
                </span>
                </div>
                <div class="text-gray-600">
                <p class="mb-2">✅ Notifikasi telah dikirim ke admin</p>
                <p class="mb-2">✅ Konfirmasi telah dikirim ke nomor Anda</p>
                <p>⏰ Admin akan segera menghubungi Anda</p>
                </div>
            </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 rounded-2xl p-6 mb-8">
                <h3 class="text-xl font-semibold text-blue-800 mb-4">Langkah Selanjutnya</h3>
                <div class="space-y-3 text-left">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mt-0.5">1</div>
                        <div>
                            <p class="font-medium text-blue-800">Tunggu Konfirmasi</p>
                            <p class="text-sm text-blue-600">Admin akan menghubungi Anda dalam waktu 1-2 jam</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mt-0.5">2</div>
                        <div>
                            <p class="font-medium text-blue-800">Konfirmasi Pembayaran</p>
                            <p class="text-sm text-blue-600">Admin akan memberikan detail pembayaran</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mt-0.5">3</div>
                        <div>
                            <p class="font-medium text-blue-800">Pengiriman/Pengambilan</p>
                            <p class="text-sm text-blue-600">Produk akan disiapkan sesuai jadwal</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('product.index_fr') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-300">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Belanja Lagi
                </a>
                <a href="{{ route('riwayat.produk', session('telepon', '0')) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-300">
                    <i class="fas fa-history me-2"></i>
                    Lihat Riwayat
                </a>
                <a href="/" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-300">
                    <i class="fas fa-home me-2"></i>
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Contact Info -->
            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Butuh bantuan? Hubungi kami:</p>
                <div class="flex items-center justify-center space-x-4">
                    <a href="https://wa.me/6282379044166" 
                       class="flex items-center space-x-2 text-green-600 hover:text-green-700">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-600">0812-3456-7890</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
}

.animate-fade-in-up:nth-child(1) { animation-delay: 0.1s; }
.animate-fade-in-up:nth-child(2) { animation-delay: 0.2s; }
.animate-fade-in-up:nth-child(3) { animation-delay: 0.3s; }
.animate-fade-in-up:nth-child(4) { animation-delay: 0.4s; }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation classes
    const elements = document.querySelectorAll('.animate-fade-in-up');
    elements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
    });
    
    setTimeout(() => {
        elements.forEach(el => {
            el.style.animation = 'fadeInUp 0.6s ease-out forwards';
        });
    }, 100);
});
</script>
@endpush
@endsection 