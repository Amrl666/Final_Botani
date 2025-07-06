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
                                <input type="text" 
                                       name="nama_pemesan" 
                                       id="nama_pemesan" 
                                       value="{{ old('nama_pemesan') }}"
                                       required 
                                       class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 @error('nama_pemesan') border-red-500 @enderror">
                                @error('nama_pemesan')
                                    <div class="text-red-500 text-sm mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label for="telepon" class="text-sm font-medium text-gray-700">Nomor HP</label>
                                <input type="tel" 
                                       name="telepon" 
                                       id="telepon" 
                                       value="{{ old('telepon') }}"
                                       required 
                                       class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 @error('telepon') border-red-500 @enderror">
                                @error('telepon')
                                    <div class="text-red-500 text-sm mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label for="alamat" class="text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="alamat" 
                                          id="alamat" 
                                          rows="3" 
                                          required 
                                          class="form-textarea rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="text-red-500 text-sm mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label for="jumlah_orang" class="text-sm font-medium text-gray-700">Jumlah Orang</label>
                                <input type="number" 
                                       name="jumlah_orang" 
                                       id="jumlah_orang" 
                                       min="1" 
                                       max="15"
                                       required 
                                       value="{{ old('jumlah_orang') }}"
                                       class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 @error('jumlah_orang') border-red-500 @enderror"
                                       placeholder="Minimal 1, maksimal 15">
                                @error('jumlah_orang')
                                    <div class="text-red-500 text-sm mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Maksimal 15 orang per hari. Minimal 5 orang per grup.
                                </div>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label for="tanggal_kunjungan" class="text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
                                <input type="date" 
                                       name="tanggal_kunjungan" 
                                       id="tanggal_kunjungan" 
                                       min="{{ now()->toDateString() }}"
                                       value="{{ old('tanggal_kunjungan') }}"
                                       required 
                                       class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 @error('tanggal_kunjungan') border-red-500 @enderror">
                                @error('tanggal_kunjungan')
                                    <div class="text-red-500 text-sm mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                
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
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-sm font-medium text-gray-700">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            Status Kuota Bulan Ini
                                        </h4>
                                        <button type="button" onclick="refreshCalendar()" class="text-xs bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                            <i class="fas fa-sync-alt me-1"></i>Refresh
                                        </button>
                                    </div>
                                    <div class="text-xs text-gray-600 mb-3">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Klik tanggal untuk memilih.
                                    </div>
                                    <div id="calendarPreview" class="grid grid-cols-7 gap-1 text-xs">
                                        <!-- Akan diisi oleh JavaScript -->
                                    </div>
                                    

                                    

                                    <div class="mt-2 text-xs text-gray-500">
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-green-100 border border-green-300 rounded mr-1"></div>
                                                <span>Tersedia (&gt;5 slot)</span>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-yellow-100 border border-yellow-300 rounded mr-1"></div>
                                                <span>Hampir Penuh (&lt;=5 slot)</span>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-red-500 rounded mr-1"></div>
                                                <span>Penuh (0 slot)</span>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-gray-300 rounded mr-1"></div>
                                                <span>Tanggal Lewat</span>
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
    const jumlahInput = document.getElementById('jumlah_orang');
    const dateInfo = document.getElementById('dateInfo');
    const dateAvailable = document.getElementById('dateAvailable');
    const dateFull = document.getElementById('dateFull');
    const datePast = document.getElementById('datePast');
    const submitButton = document.querySelector('button[type="submit"]');
    
    // Data tanggal yang sudah penuh dari backend
    const fullDates = {!! json_encode($fullDates ?? []) !!};
    const quotaData = {!! json_encode($quotaArray ?? []) !!};
    

    
    function checkDateAvailability() {
        const selectedDate = dateInput.value;
        const jumlahOrang = parseInt(jumlahInput.value) || 0;
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
        
        // Cek kuota tersisa
        const kuotaTersisa = quotaData[selectedDate] !== undefined ? quotaData[selectedDate] : 15;
        
        // Cek apakah tanggal sudah penuh
        if (kuotaTersisa <= 0) {
            dateInfo.classList.remove('hidden');
            dateFull.classList.remove('hidden');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }
        
        // Cek apakah jumlah orang melebihi kuota tersisa
        if (jumlahOrang > kuotaTersisa) {
            dateInfo.classList.remove('hidden');
            dateFull.classList.remove('hidden');
            dateFull.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i><span>Kuota tidak mencukupi. Tersisa ${kuotaTersisa} slot untuk tanggal ini.</span>`;
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }
        
        // Cek minimal 5 orang per grup
        if (jumlahOrang < 5) {
            dateInfo.classList.remove('hidden');
            dateFull.classList.remove('hidden');
            dateFull.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i><span>Minimal 5 orang per grup untuk pemesanan eduwisata.</span>`;
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }
        
        // Tanggal tersedia
        dateInfo.classList.remove('hidden');
        dateAvailable.classList.remove('hidden');
        dateAvailable.innerHTML = `<i class="fas fa-check-circle me-1"></i><span>Tanggal tersedia. Kuota tersisa: ${kuotaTersisa} slot</span>`;
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
    }
    
    // Event listener untuk perubahan tanggal dan jumlah orang
    dateInput.addEventListener('change', checkDateAvailability);
    dateInput.addEventListener('input', checkDateAvailability);
    jumlahInput.addEventListener('change', checkDateAvailability);
    jumlahInput.addEventListener('input', checkDateAvailability);
    
    // Set tanggal minimum ke hari ini
    dateInput.min = new Date().toISOString().split('T')[0];
    
    // Tambahkan tooltip untuk tanggal yang sudah penuh
    const calendarIcon = document.createElement('div');
    calendarIcon.className = 'absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400';
    
    
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
        calendarContainer.innerHTML = ''; // Clear existing content
        
        const today = new Date();
        // Gunakan UTC untuk konsistensi
        const currentMonth = today.getUTCMonth();
        const currentYear = today.getUTCFullYear();
        
        // Header hari
        const daysOfWeek = ['M', 'S', 'S', 'R', 'K', 'J', 'S'];
        daysOfWeek.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'text-center font-medium text-gray-600 p-1';
            dayHeader.textContent = day;
            calendarContainer.appendChild(dayHeader);
        });
        
        // Hari-hari dalam bulan
        const firstDay = new Date(Date.UTC(currentYear, currentMonth, 1));
        const lastDay = new Date(Date.UTC(currentYear, currentMonth + 1, 0));
        const startDate = new Date(firstDay);
        startDate.setUTCDate(startDate.getUTCDate() - firstDay.getUTCDay() + 1);
        
        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setUTCDate(startDate.getUTCDate() + i);
            
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center p-1 rounded cursor-pointer transition-colors';
            
            if (date.getUTCMonth() === currentMonth) {
                const dateString = date.toISOString().split('T')[0];
                const isToday = dateString === today.toISOString().split('T')[0];
                const isPast = date < today;
                const kuotaTersisa = quotaData[dateString] !== undefined ? quotaData[dateString] : 15;
                const isFull = kuotaTersisa <= 0;
                

                
                dayElement.textContent = date.getUTCDate();
                
                // Tambahkan tooltip dengan info kuota
                if (!isPast) {
                    dayElement.title = `Kuota tersisa: ${kuotaTersisa} slot`;
                }
                
                if (isToday) {
                    dayElement.className += ' bg-blue-500 text-white font-bold';
                } else if (isPast) {
                    dayElement.className += ' bg-gray-300 text-gray-500';
                } else if (isFull) {
                    dayElement.className += ' bg-red-500 text-white';
                } else if (kuotaTersisa <= 5) {
                    dayElement.className += ' bg-yellow-100 text-yellow-700 hover:bg-yellow-200';
                } else {
                    dayElement.className += ' bg-green-100 text-green-700 hover:bg-green-200';
                }
                
                // Click event untuk memilih tanggal
                dayElement.addEventListener('click', function() {
                    if (!isPast && !isFull) {
                        // Pastikan format tanggal yang benar (YYYY-MM-DD)
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getUTCDate()).padStart(2, '0');
                        const formattedDate = `${year}-${month}-${day}`;
                        
                        dateInput.value = formattedDate;
                        checkDateAvailability();
                        updateQuotaInfo();
                    }
                });
            } else {
                dayElement.className += ' text-gray-300';
                dayElement.textContent = date.getUTCDate();
            }
            
            calendarContainer.appendChild(dayElement);
        }
        

    }
    
    // Render kalender saat halaman dimuat
    renderCalendarPreview();
    
    // Fungsi untuk refresh kalender manual
    window.refreshCalendar = function() {
        fetch('{{ route("eduwisata.quota.data", $eduwisata) }}')
            .then(response => response.json())
            .then(data => {
                // Update data global
                Object.assign(quotaData, data.quotaData);
                fullDates.length = 0;
                fullDates.push(...data.fullDates);
                // Re-render kalender
                renderCalendarPreview();
            })
            .catch(error => {
                console.error('Error fetching quota data:', error);
            });
    };
    

    
    // Refresh kalender setiap 30 detik untuk update real-time
    setInterval(function() {
        // Fetch data terbaru dari API
        fetch('{{ route("eduwisata.quota.data", $eduwisata) }}')
            .then(response => response.json())
            .then(data => {
                // Update data global
                Object.assign(quotaData, data.quotaData);
                fullDates.length = 0;
                fullDates.push(...data.fullDates);
                // Re-render kalender
                renderCalendarPreview();
            })
            .catch(error => {
                console.error('Error fetching quota data:', error);
            });
    }, 30000); // Refresh setiap 30 detik
    

});
</script>
@endpush

@endsection
