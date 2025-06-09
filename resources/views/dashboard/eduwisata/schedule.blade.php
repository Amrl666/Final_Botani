@extends('layouts.app')

@section('title', 'Jadwal ' . $eduwisata->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Jadwal: <span class="text-blue-600">{{ $eduwisata->name }}</span></h2>
        <a href="{{ route('dashboard.eduwisata.index') }}" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
            ← Kembali
        </a>
    </div>

    <!-- Eduwisata Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        @if($eduwisata->image)
            <img src="{{ asset('storage/' . $eduwisata->image) }}" class="w-full h-60 object-cover" alt="{{ $eduwisata->name }}">
        @endif
        <div class="p-6">
            <h3 class="text-xl font-bold">{{ $eduwisata->name }}</h3>
            <p class="text-gray-600 mt-2">{{ $eduwisata->description }}</p>
            <p class="text-gray-700 mt-2"><strong>Harga:</strong> Rp{{ number_format($eduwisata->harga, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Form Tambah Jadwal -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h4 class="text-lg font-semibold mb-4">Tambah Jadwal Baru</h4>
        <form method="POST" action="{{ route('dashboard.eduwisata.storeSchedule') }}" class="grid md:grid-cols-3 gap-4">
            @csrf
            <input type="hidden" name="eduwisata_id" value="{{ $eduwisata->id }}">
            <div>
                <label for="date" class="block text-sm font-medium">Tanggal</label>
                <input type="date" name="date" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <div>
                <label for="time" class="block text-sm font-medium">Waktu</label>
                <input type="time" name="time" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <div>
                <label for="max_participants" class="block text-sm font-medium">Maks. Peserta</label>
                <input type="number" name="max_participants" class="mt-1 block w-full border border-gray-300 rounded-md p-2" min="1" required>
            </div>
            <div class="col-span-3 text-right mt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                    Tambah Jadwal
                </button>
            </div>
        </form>
    </div>

    <!-- Jadwal Cards -->
    <div>
        <h4 class="text-xl font-semibold mb-4">Daftar Jadwal</h4>
        @if($schedules->isEmpty())
            <p class="text-gray-500">Belum ada jadwal.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($schedules as $schedule)
                <div class="bg-white p-5 rounded-lg shadow flex flex-col justify-between">
                    <div>
                        <h5 class="text-lg font-semibold text-gray-800 mb-1">
                            {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('d F Y') }}
                        </h5>
                        <p class="text-sm text-gray-600">Waktu: {{ $schedule->time }}</p>
                        <p class="text-sm text-gray-600">Peserta Maks: {{ $schedule->max_participants }}</p>
                    </div>
                    <form action="{{ route('dashboard.eduwisata.schedule.destroy', $schedule->id) }}" method="POST" class="mt-4" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 text-sm">
                            Hapus
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
