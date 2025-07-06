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
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-calendar-check mr-3 text-green-600"></i>
                                <span>Maksimal 15 orang per hari</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Jadwal -->
                <div class="md:w-1/2 p-6 bg-gray-50">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Pilih Jadwal Kunjungan</h3>

                    <form id="orderForm" action="{{ route('order.store') }}" method="POST" class="space-y-4">
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
                                <input type="date" 
                                       name="tanggal_kunjungan" 
                                       id="tanggal_kunjungan" 
                                       min="{{ now()->toDateString() }}"
                                       required 
                                       class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                                
                                <!-- Info Tanggal Full -->
                                <div id="dateInfo" class="text-sm mt-2 hidden">
                                    <div id="dateAvailable" class="text-green-600 hidden">
                                        <i class="fas fa-check-circle me-1"></i>
                                        <span>Tanggal tersedia</span>
                                    </div>
                                    <div id="dateFull" class="text-red-600 hidden">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <span>Tanggal sudah penuh (15 orang)</span>
                                    </div>
                                    <div id="datePast" class="text-orange-600 hidden">
                                        <i class="fas fa-calendar-times me-1"></i>
                                        <span>Tanggal sudah lewat</span>
                                    </div>
                                </div>
                                
                                <!-- Kalender Mini untuk Preview -->
                                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Status Kuota Bulan Ini
                                    </h4>
                                    <div id="calendarPreview" class="grid grid-cols-7 gap-1 text-xs">
                                        <!-- Akan diisi oleh JavaScript -->
                                    </div>
                                    <div class="mt-2 text-xs text-gray-500">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-green-500 rounded mr-1"></div>
                                                <span>Tersedia</span>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-red-500 rounded mr-1"></div>
                                                <span>Penuh</span>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-gray-300 rounded mr-1"></div>
                                                <span>Lewat</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300 transform hover:scale-105">
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
    const dateInput = document.getElementById('tanggal_kunjungan');
    const dateInfo = document.getElementById('dateInfo');
    const dateAvailable = document.getElementById('dateAvailable');
    const dateFull = document.getElementById('dateFull');
    const datePast = document.getElementById('datePast');
    const submitButton = document.querySelector('button[type="submit"]');
    
    // Data tanggal yang sudah penuh dari backend
    const fullDates = @json($fullDates ?? []);
    
    function checkDateAvailability() {
        const selectedDate = dateInput.value;
        const today = new Date().toISOString().split('T')[0];
        
        // Reset semua status
        dateInfo.classList.add('hidden');
        dateAvailable.classList.add('hidden');
        dateFull.classList.add('hidden');
        datePast.classList.add('hidden');
        
        if (!selectedDate) {
            return;
        }
        
        // Cek apakah tanggal sudah lewat
        if (selectedDate < today) {
            dateInfo.classList.remove('hidden');
            datePast.classList.remove('hidden');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }
        
        // Cek apakah tanggal sudah penuh
        if (fullDates.includes(selectedDate)) {
            dateInfo.classList.remove('hidden');
            dateFull.classList.remove('hidden');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }
        
        // Tanggal tersedia
        dateInfo.classList.remove('hidden');
        dateAvailable.classList.remove('hidden');
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
    }
    
    // Event listener untuk perubahan tanggal
    dateInput.addEventListener('change', checkDateAvailability);
    dateInput.addEventListener('input', checkDateAvailability);
    
    // Set tanggal minimum ke hari ini
    dateInput.min = new Date().toISOString().split('T')[0];
    
    // Tambahkan tooltip untuk tanggal yang sudah penuh
    const calendarIcon = document.createElement('div');
    calendarIcon.className = 'absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400';
    calendarIcon.innerHTML = '<i class="fas fa-calendar-alt"></i>';
    
    const dateContainer = dateInput.parentElement;
    dateContainer.style.position = 'relative';
    dateContainer.appendChild(calendarIcon);
    
    // Tambahkan info kuota tersisa
    function updateQuotaInfo() {
        const selectedDate = dateInput.value;
        if (selectedDate && !fullDates.includes(selectedDate) && selectedDate >= new Date().toISOString().split('T')[0]) {
            // Hitung kuota tersisa (implementasi bisa ditambahkan nanti)
            const quotaInfo = document.createElement('div');
            quotaInfo.className = 'text-xs text-blue-600 mt-1';
            quotaInfo.innerHTML = '<i class="fas fa-users me-1"></i>Kuota tersisa: Tersedia';
            
            // Hapus info sebelumnya jika ada
            const existingQuota = dateContainer.querySelector('.quota-info');
            if (existingQuota) {
                existingQuota.remove();
            }
            
            quotaInfo.classList.add('quota-info');
            dateContainer.appendChild(quotaInfo);
        }
    }
    
    dateInput.addEventListener('change', updateQuotaInfo);
    
    // Render kalender preview
    function renderCalendarPreview() {
        const calendarContainer = document.getElementById('calendarPreview');
        const today = new Date();
        const currentMonth = today.getMonth();
        const currentYear = today.getFullYear();
        
        // Header hari
        const daysOfWeek = ['M', 'S', 'S', 'R', 'K', 'J', 'S'];
        daysOfWeek.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'text-center font-medium text-gray-600 p-1';
            dayHeader.textContent = day;
            calendarContainer.appendChild(dayHeader);
        });
        
        // Hari-hari dalam bulan
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay() + 1);
        
        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + i);
            
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center p-1 rounded cursor-pointer transition-colors';
            
            if (date.getMonth() === currentMonth) {
                const dateString = date.toISOString().split('T')[0];
                const isToday = dateString === today.toISOString().split('T')[0];
                const isPast = date < today;
                const isFull = fullDates.includes(dateString);
                
                dayElement.textContent = date.getDate();
                
                if (isToday) {
                    dayElement.className += ' bg-blue-500 text-white font-bold';
                } else if (isPast) {
                    dayElement.className += ' bg-gray-300 text-gray-500';
                } else if (isFull) {
                    dayElement.className += ' bg-red-500 text-white';
                } else {
                    dayElement.className += ' bg-green-100 text-green-700 hover:bg-green-200';
                }
                
                // Click event untuk memilih tanggal
                dayElement.addEventListener('click', function() {
                    if (!isPast && !isFull) {
                        dateInput.value = dateString;
                        checkDateAvailability();
                        updateQuotaInfo();
                    }
                });
            } else {
                dayElement.className += ' text-gray-300';
                dayElement.textContent = date.getDate();
            }
            
            calendarContainer.appendChild(dayElement);
        }
    }
    
    // Render kalender saat halaman dimuat
    renderCalendarPreview();
});
</script>
@endpush

@endsection
