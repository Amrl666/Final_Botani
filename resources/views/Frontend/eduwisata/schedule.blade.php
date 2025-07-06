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
                                       placeholder="maksimal 15">
                                @error('jumlah_orang')
                                    <div class="text-red-500 text-sm mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Maksimal 15 orang per hari
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

    // Data from backend
    let fullDates = {!! json_encode($fullDates ?? []) !!};
    let quotaData = {!! json_encode($quotaArray ?? []) !!};

    // --- FIX 1: Get today's date in a timezone-agnostic way ---
    // This creates a date string like "2025-07-06" based on local time,
    // which prevents timezone-related "off-by-one-day" errors.
    function getTodayDateString() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    const todayString = getTodayDateString();
    dateInput.min = todayString; // Set the minimum selectable date in the input

    function checkDateAvailability() {
        const selectedDate = dateInput.value;
        const jumlahOrang = parseInt(jumlahInput.value) || 0;

        // Reset all status messages
        dateInfo.classList.add('hidden');
        dateAvailable.classList.add('hidden');
        dateFull.classList.add('hidden');
        datePast.classList.add('hidden');
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');

        if (!selectedDate) {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        // Check if the selected date is in the past
        if (selectedDate < todayString) {
            dateInfo.classList.remove('hidden');
            datePast.classList.remove('hidden');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        const kuotaTersisa = quotaData[selectedDate] !== undefined ? quotaData[selectedDate] : 15;

        // Check if date is full
        if (kuotaTersisa <= 0) {
            dateInfo.classList.remove('hidden');
            dateFull.classList.remove('hidden');
            dateFull.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i><span>Tanggal sudah penuh (15 orang)</span>`;
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        // Check if requested number exceeds available quota
        if (jumlahOrang > kuotaTersisa) {
            dateInfo.classList.remove('hidden');
            dateFull.classList.remove('hidden'); // Re-using element
            dateFull.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i><span>Kuota tidak mencukupi. Tersisa ${kuotaTersisa} slot.</span>`;
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        // If all checks pass, show availability
        if (selectedDate && jumlahOrang >= 1) {
             dateInfo.classList.remove('hidden');
             dateAvailable.classList.remove('hidden');
             dateAvailable.innerHTML = `<i class="fas fa-check-circle me-1"></i><span>Tanggal tersedia. Kuota tersisa: ${kuotaTersisa} slot</span>`;
        }
    }

    dateInput.addEventListener('change', checkDateAvailability);
    jumlahInput.addEventListener('input', checkDateAvailability);

    function renderCalendarPreview() {
        const calendarContainer = document.getElementById('calendarPreview');
        calendarContainer.innerHTML = ''; // Clear existing content

        // --- FIX 2: Use local date parts consistently ---
        const today = new Date();
        const currentMonth = today.getMonth();
        const currentYear = today.getFullYear();

        const daysOfWeek = ['M', 'S', 'S', 'R', 'K', 'J', 'S'];
        daysOfWeek.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'text-center font-medium text-gray-600 p-1';
            dayHeader.textContent = day;
            calendarContainer.appendChild(dayHeader);
        });

        const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        // Adjust for Sunday being 0 in getDay()
        const startOffset = firstDayOfMonth === 0 ? 6 : firstDayOfMonth -1;

        // Add blank days for the start of the month
        for (let i = 0; i < startOffset; i++) {
            const emptyCell = document.createElement('div');
            calendarContainer.appendChild(emptyCell);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center p-1 rounded cursor-pointer transition-colors';
            dayElement.textContent = day;

            const date = new Date(currentYear, currentMonth, day);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const dayStr = String(date.getDate()).padStart(2, '0');
            const dateString = `${year}-${month}-${dayStr}`;

            const kuotaTersisa = quotaData[dateString] !== undefined ? quotaData[dateString] : 15;
            const isFull = kuotaTersisa <= 0;
            const isToday = dateString === todayString;
            // --- FIX 3: Correctly identify past dates ---
            const isPast = dateString < todayString;

            if (!isPast) {
                dayElement.title = `Kuota tersisa: ${kuotaTersisa} slot`;
            }

            if (isToday) {
                dayElement.classList.add('bg-blue-500', 'text-white', 'font-bold');
            } else if (isPast) {
                dayElement.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            } else if (isFull) {
                dayElement.classList.add('bg-red-500', 'text-white', 'cursor-not-allowed');
            } else if (kuotaTersisa <= 5) {
                dayElement.classList.add('bg-yellow-100', 'text-yellow-700', 'hover:bg-yellow-200');
            } else {
                dayElement.classList.add('bg-green-100', 'text-green-700', 'hover:bg-green-200');
            }

            dayElement.addEventListener('click', () => {
                if (!isPast && !isFull) {
                    dateInput.value = dateString;
                    checkDateAvailability();
                }
            });

            calendarContainer.appendChild(dayElement);
        }
    }

    window.refreshCalendar = function() {
        // Show loading indicator
        const refreshButton = this;
        const icon = refreshButton.querySelector('i');
        icon.classList.add('fa-spin');

        fetch('{{ route("eduwisata.quota.data", $eduwisata) }}')
            .then(response => response.json())
            .then(data => {
                quotaData = data.quotaData;
                fullDates = data.fullDates;
                renderCalendarPreview();
            })
            .catch(error => {
                console.error('Error fetching quota data:', error);
                alert('Gagal memuat ulang data kuota.');
            })
            .finally(() => {
                // Remove loading indicator
                icon.classList.remove('fa-spin');
            });
    };

    // Initial render
    renderCalendarPreview();
    checkDateAvailability(); // Check status for any `old()` values on page load

    // Auto-refresh interval
    setInterval(window.refreshCalendar, 30000); // Refresh every 30 seconds
});
</script>
@endpush

@endsection
