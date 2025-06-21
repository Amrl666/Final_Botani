@extends('layouts.frontend')
@section('title', 'Login Riwayat')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-login {
        animation: fadeInUp 0.6s ease-out;
    }

    .login-card {
        background: #ffffff;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
</style>

<div class="container mx-auto px-4 max-w-md py-12 animate-login">
    <div class="login-card">
        <h2 class="text-2xl font-semibold mb-6 text-center text-green-600">Login Riwayat Pemesanan</h2>

        <form action="{{ route('login.wa.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                <input type="text" name="telepon" id="telepon" class="mt-1 w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="08xxxxxxxxxx" required>
                @error('telepon')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition duration-300">
                Masuk
            </button>
        </form>
    </div>
</div>
@endsection