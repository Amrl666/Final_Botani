@extends('layouts.frontend')

@section('title', 'Jadwal Eduwisata')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="text-center mb-12 animate-slide-down">
            <h1 class="text-4xl font-bold text-green-800 mb-4">{{ $eduwisata->name }}</h1>
            <p class="text-gray-600 text-lg mb-4">Pilih jadwal yang sesuai dengan keinginan Anda</p>
            <div class="w-24 h-1 bg-green-500 mx-auto rounded-full"></div>
        </div>

        <!-- Package Details -->
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden mb-12 animate-slide-up">
            <div class="md:flex">
                <div class="md:w-1/2">
                    @if($eduwisata->image)
                        <img src="{{ asset('storage/' . $eduwisata->image) }}" 
                             alt="{{ $eduwisata->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full min-h-[300px] bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-tree text-6xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
                <div class="p-8 md:w-1/2">
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
        </div>

        <!-- Schedule Form -->
        <div class="max-w-2xl mx-auto animate-fade-in" style="--delay: 0.3s">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Pilih Jadwal Kunjungan</h3>
                
                @if(!$customer)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                            <div>
                                <p class="text-blue-800 font-medium">Info</p>
                                <p class="text-blue-700 text-sm">Silakan <a href="{{ route('customer.login') }}" class="underline font-medium">login</a> terlebih dahulu agar data Anda dapat diisi otomatis.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            <div>
                                <p class="text-green-800 font-medium">Data Terisi Otomatis</p>
                                <p class="text-green-700 text-sm">Data Anda telah diisi otomatis berdasarkan profil yang tersimpan.</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('order.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="eduwisata_id" value="{{ $eduwisata->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="nama_pemesan" class="block text-sm font-medium text-gray-700">Nama Pemesan</label>
                            <input type="text" id="nama_pemesan" name="nama_pemesan" required
                                value="{{ $customer->name ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <div class="space-y-2">
                            <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="tel" id="telepon" name="telepon" required
                                value="{{ $customer->phone ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <div class="space-y-2">
                            <label for="jumlah_orang" class="block text-sm font-medium text-gray-700">Jumlah Peserta</label>
                            <input type="number" id="jumlah_orang" name="jumlah_orang" min="5" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <div class="space-y-2">
                            <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
                            <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" required min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                        <textarea id="keterangan" name="keterangan" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center justify-between text-lg font-semibold">
                            <span>Total Pembayaran:</span>
                            <span class="text-green-600">Rp {{ number_format($eduwisata->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-700 transition-colors duration-300">
                        Pesan Sekarang
                    </button>
                </form>
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

/* Form focus styles */
input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: transparent;
    box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
}

/* Custom select arrow */
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
document.addEventListener('DOMContentLoaded', function() {
    const jumlahPesertaInput = document.getElementById('jumlah_orang');
    const tanggalInput = document.getElementById('tanggal_kunjungan');
    const namaPemesanInput = document.getElementById('nama_pemesan');
    const teleponInput = document.getElementById('telepon');
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    tanggalInput.min = today;
    
    // Validate minimum participants
    jumlahPesertaInput.addEventListener('change', function() {
        if (this.value < 5) {
            alert('Minimal peserta adalah 5 orang');
            this.value = 5;
        }
    });
    
    // Validate phone number format
    teleponInput.addEventListener('input', function() {
        // Remove non-numeric characters except + and -
        this.value = this.value.replace(/[^\d+\-]/g, '');
    });
    
    // Form validation before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const nama = namaPemesanInput.value.trim();
        const telepon = teleponInput.value.trim();
        const jumlah = jumlahPesertaInput.value;
        const tanggal = tanggalInput.value;
        
        if (!nama) {
            e.preventDefault();
            alert('Nama pemesan harus diisi');
            namaPemesanInput.focus();
            return false;
        }
        
        if (!telepon) {
            e.preventDefault();
            alert('Nomor telepon harus diisi');
            teleponInput.focus();
            return false;
        }
        
        if (jumlah < 5) {
            e.preventDefault();
            alert('Minimal peserta adalah 5 orang');
            jumlahPesertaInput.focus();
            return false;
        }
        
        if (!tanggal) {
            e.preventDefault();
            alert('Tanggal kunjungan harus dipilih');
            tanggalInput.focus();
            return false;
        }
        
        // Show loading state
        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    });
});
</script>
@endpush
@endsection