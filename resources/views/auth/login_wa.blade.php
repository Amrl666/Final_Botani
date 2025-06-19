@extends('layouts.frontend')
@section('title', 'Login Riwayat')

@section('content')
<div class="container mx-auto px-4 max-w-md py-10">
    <div class="bg-white shadow p-6 rounded-lg">
        <h2 class="text-2xl font-semibold mb-4 text-center text-green-600">Login Riwayat Pemesanan</h2>

        <form action="{{ route('login.wa.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="telepon" class="block text-sm font-medium">Nomor WhatsApp</label>
                <input type="text" name="telepon" id="telepon" class="mt-1 w-full border rounded p-2" placeholder="08xxxxxxxxxx" required>
                @error('telepon')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                Masuk
            </button>
        </form>
    </div>
</div>
@endsection
