@extends('layouts.frontend')

@section('title', 'Jadwal Eduwisata')

@section('content')
<div id="infoUlangiPesan" style="display:none; margin-top:2rem;" class="w-full flex justify-center">
    <div class="w-full bg-yellow-300 border-2 border-yellow-600 text-yellow-900 text-xl font-bold px-6 py-5 rounded-lg shadow text-center">
        Jika sudah chat admin, <u>silakan ulangi kembali proses pemesanan</u>.
    </div>
</div>
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="text-center mb-12 animate-slide-down">
            <h1 class="text-4xl font-bold text-green-800 mb-4">{{ $eduwisata->name }}</h1>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>
        <p class="text-center text-gray-600 text-lg mb-4">Pilih jadwal yang sesuai dengan keinginan Anda</p>

        <!-- Package Details & Schedule Form -->
        <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden mb-12 animate-slide-up">
            <div class="md:flex">
                <!-- Gambar dan Keterangan -->
                <div class="md:w-1/2">
                @if($eduwisata->image)
                    <div class="w-full aspect-[4/3] overflow-hidden">
                    <img src="{{ asset('storage/' . $eduwisata->image) }}" 
                        alt="{{ $eduwisata->name }}" 
                        class="w-full h-full object-cover">
                    </div>

                @else
                    <div class="w-full h-[200px] bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-tree text-6xl text-gray-400"></i>
                    </div>
                @endif

                    <div class="p-6">
                        <div class="uppercase tracking-wide text-sm text-green-600 font-semibold mb-1">Paket Eduwisata</div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $eduwisata->name }}</h2>
                        <p class="text-gray-600 mb-4">{{ $eduwisata->description }}</p>
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 text-green-800 text-lg font-semibold px-4 py-2 rounded-lg">
                                Rp {{ number_format($eduwisata->harga, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-users mr-3 text-green-600"></i>
                                <span>Minimal 5 orang per grup</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-clock mr-3 text-green-600"></i>
                                <span>Durasi 2-3 jam</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-certificate mr-3 text-green-600"></i>
                                <span>Sertifikat keikutsertaan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Jadwal -->
                <div class="md:w-1/2 p-6 bg-gray-50">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Pilih Jadwal Kunjungan</h3>

                    <div id="chat-admin-section">
                        <button id="btnChatAdmin" type="button" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg mb-3" style="display:none;">
                            Chat Admin di WhatsApp
                        </button>
                        <form id="orderForm" action="{{ route('order.store') }}" method="POST" class="space-y-4" style="display:block;">
                            @csrf
                            <input type="hidden" name="eduwisata_id" value="{{ $eduwisata->id ?? '' }}">
                            <div class="flex flex-col space-y-2">
                                <label for="nama_pemesan" class="text-sm font-medium text-gray-700">Nama Pemesan</label>
                                <input type="text" name="nama_pemesan" id="nama_pemesan" required class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label for="telepon" class="text-sm font-medium text-gray-700">Nomor HP</label>
                                <input type="tel" name="telepon" id="telepon" required class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label for="alamat" class="text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3" required class="form-textarea rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200"></textarea>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label for="jumlah_orang" class="text-sm font-medium text-gray-700">Jumlah Orang</label>
                                <input type="number" name="jumlah_orang" id="jumlah_orang" min="1" required class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label for="tanggal_kunjungan" class="text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
                                <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" required class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                            </div>
                            <button id="btnPesan" type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300 transform hover:scale-105">
                                Pesan Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="popupChatAdmin" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4);">
    <div style="background:#fff; max-width:350px; margin:10% auto; padding:2rem; border-radius:1rem; text-align:center; position:relative;">
        <button id="btnClosePopup" style="position:absolute; top:0.5rem; right:0.5rem; background:transparent; border:none; font-size:1.5rem; color:#888; cursor:pointer;">&times;</button>
        <p class="mb-4 text-lg font-semibold">Apakah Anda sudah pernah chat admin?</p>
        <div class="flex justify-center gap-4">
            <button id="btnSudahChat" class="bg-green-600 text-white px-4 py-2 rounded">Sudah</button>
            <button id="btnBelumChat" class="bg-gray-400 text-white px-4 py-2 rounded">Belum</button>
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

input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: transparent;
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
}

select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
</style>

@push('scripts')
<script>
function setBodyScroll(disable) {
    if (disable) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const btnPesan = document.getElementById('btnPesan');
    const orderForm = document.getElementById('orderForm');
    const popup = document.getElementById('popupChatAdmin');
    const btnSudah = document.getElementById('btnSudahChat');
    const btnBelum = document.getElementById('btnBelumChat');
    const btnClose = document.getElementById('btnClosePopup');
    const infoUlangi = document.getElementById('infoUlangiPesan');
    const adminWa = '6282379044166'; // Ganti dengan nomor admin
    if (btnPesan) {
        btnPesan.addEventListener('click', function(e) {
            e.preventDefault();
            popup.style.display = 'block';
            setBodyScroll(true);
        });
    }
    btnSudah && btnSudah.addEventListener('click', function() {
        popup.style.display = 'none';
        setBodyScroll(false);
        orderForm.submit();
    });
    btnBelum && btnBelum.addEventListener('click', function() {
        popup.style.display = 'none';
        setBodyScroll(false);
        window.open('https://wa.me/' + adminWa + '?text=Halo%20Admin%2C%20saya%20ingin%20bertanya%20tentang%20eduwisata', '_blank');
        // Tampilkan info ulangi pesan setelah kembali
        setTimeout(function() {
            infoUlangi.style.display = 'block';
        }, 500);
    });
    btnClose && btnClose.addEventListener('click', function() {
        popup.style.display = 'none';
        setBodyScroll(false);
    });
    popup && popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            popup.style.display = 'none';
            setBodyScroll(false);
        }
    });
});
</script>
@endpush
@endsection
