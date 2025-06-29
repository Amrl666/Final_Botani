@extends('layouts.frontend')

@section('title', 'Alamat Pengiriman')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-map-marker-alt text-green-600 mr-3"></i>
                Alamat Pengiriman
            </h1>
            <p class="text-gray-600 text-lg">Kelola alamat pengiriman untuk pesanan Anda</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3 text-lg"></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if($addresses->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-map-marker-alt text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada alamat</h3>
                <p class="text-gray-600 mb-6">Mulai dengan menambahkan alamat pengiriman pertama Anda.</p>
                <a href="{{ route('customer.addresses.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Alamat
                </a>
            </div>
        @else
            <!-- Addresses Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($addresses as $address)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <!-- Address Header -->
                        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold text-lg">{{ $address->recipient_name }}</h3>
                                        <p class="text-green-100 text-sm">
                                            <i class="fas fa-phone mr-1"></i>
                                            {{ $address->phone }}
                                        </p>
                                    </div>
                                </div>
                                @if($address->is_default)
                                    <span class="px-3 py-1 bg-white bg-opacity-20 text-white text-sm font-semibold rounded-full">
                                        <i class="fas fa-star mr-1"></i>
                                        Default
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Address Content -->
                        <div class="p-6">
                            <!-- Address Details -->
                            <div class="mb-6">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                                        Alamat Lengkap
                                    </h4>
                                    <div class="space-y-2">
                                        <p class="text-gray-700">{{ $address->address }}</p>
                                        <p class="text-gray-700 font-medium">
                                            {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                                        </p>
                                        @if($address->notes)
                                            <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                                <p class="text-sm text-blue-800">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    <strong>Catatan:</strong> {{ $address->notes }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                @if(!$address->is_default)
                                    <form action="{{ route('customer.addresses.set-default', $address) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-star mr-2"></i>
                                            Set Default
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('customer.addresses.edit', $address) }}" 
                                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit
                                </a>
                                
                                <form action="{{ route('customer.addresses.destroy', $address) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors"
                                            onclick="return confirm('Yakin ingin menghapus alamat ini?')">
                                        <i class="fas fa-trash mr-2"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Add New Address Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('customer.addresses.create') }}" 
                   class="inline-flex items-center px-8 py-4 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-colors shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus mr-3 text-lg"></i>
                    Tambah Alamat Baru
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 