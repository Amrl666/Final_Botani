@extends('layouts.frontend')

@section('title', 'Jadwal Eduwisata')

@section('content')
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

                    <form action="{{ route('order.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="eduwisata_id" value="{{ $eduwisata->id }}">

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="nama_pemesan" class="block text-sm font-medium text-gray-700">Nama Pemesan</label>
                                <input type="text" id="nama_pemesan" name="nama_pemesan" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            </div>

                            <div>
                                <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="tel" id="telepon" name="telepon" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            </div>

                            <div>
                                <label for="jumlah_orang" class="block text-sm font-medium text-gray-700">Jumlah Peserta</label>
                                <input type="number" id="jumlah_orang" name="jumlah_orang" min="5" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            </div>

                            <div>
                                <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
                                <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" required min="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            </div>

                            <div>
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                                <textarea id="keterangan" name="keterangan" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"></textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-white px-4 py-2 rounded-lg border mt-4">
                            <span class="text-gray-700 font-semibold">Total Pembayaran:</span>
                            <span class="text-green-600 font-bold">Rp {{ number_format($eduwisata->harga, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit"
                            class="w-full mt-4 bg-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-700 transition-colors duration-300">
                            Pesan Sekarang
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
document.addEventListener('DOMContentLoaded', function() {
    const jumlahPesertaInput = document.getElementById('jumlah_orang');
    const tanggalInput = document.getElementById('tanggal_kunjungan');

    const today = new Date().toISOString().split('T')[0];
    tanggalInput.min = today;

    jumlahPesertaInput.addEventListener('change', function() {
        if (this.value < 5) {
            alert('Minimal peserta adalah 5 orang');
            this.value = 5;
        }
    });
});
</script>
@endpush
@endsection
