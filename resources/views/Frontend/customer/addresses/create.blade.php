@extends('layouts.frontend')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Tambah Alamat Pengiriman</h2>
                    <p class="mt-1 text-sm text-gray-500">Tambahkan alamat pengiriman baru untuk pesanan Anda.</p>
                </div>

                <form action="{{ route('customer.addresses.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label for="recipient_name" class="block text-sm font-medium text-gray-700">
                                Nama Penerima *
                            </label>
                            <input type="text" 
                                   name="recipient_name" 
                                   id="recipient_name" 
                                   required
                                   value="{{ old('recipient_name') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('recipient_name') border-red-500 @enderror">
                            @error('recipient_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Nomor Telepon *
                            </label>
                            <input type="tel" 
                                   name="phone" 
                                   id="phone" 
                                   required
                                   value="{{ old('phone') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">
                                Alamat Lengkap *
                            </label>
                            <textarea name="address" 
                                      id="address" 
                                      rows="3" 
                                      required
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">
                                    Kota *
                                </label>
                                <input type="text" 
                                       name="city" 
                                       id="city" 
                                       required
                                       value="{{ old('city') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('city') border-red-500 @enderror">
                                @error('city')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="province" class="block text-sm font-medium text-gray-700">
                                    Provinsi *
                                </label>
                                <input type="text" 
                                       name="province" 
                                       id="province" 
                                       required
                                       value="{{ old('province') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('province') border-red-500 @enderror">
                                @error('province')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">
                                    Kode Pos *
                                </label>
                                <input type="text" 
                                       name="postal_code" 
                                       id="postal_code" 
                                       required
                                       value="{{ old('postal_code') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('postal_code') border-red-500 @enderror">
                                @error('postal_code')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">
                                Catatan (Opsional)
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="2"
                                      placeholder="Contoh: Gedung A Lantai 3, dekat halte bus"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_default" 
                                   id="is_default" 
                                   value="1"
                                   {{ old('is_default') ? 'checked' : '' }}
                                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <label for="is_default" class="ml-2 block text-sm text-gray-900">
                                Jadikan alamat default
                            </label>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('customer.addresses.index') }}" 
                               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                                Simpan Alamat
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 