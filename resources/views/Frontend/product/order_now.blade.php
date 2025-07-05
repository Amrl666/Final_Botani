@extends('layouts.frontend')

@section('title', $product->name)

@section('content')
<div id="infoUlangiPesan" style="display:none; margin-top:2rem;" class="w-full flex justify-center">
    <div class="w-full bg-yellow-300 border-2 border-yellow-600 text-yellow-900 text-xl font-bold px-6 py-5 rounded-lg shadow text-center">
        Jika sudah chat admin, <u>silakan ulangi kembali proses pemesanan</u>.
    </div>
</div>
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12 animate-fade-in">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-8 animate-slide-down">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li>
                    <a href="{{ route('product.index_fr') }}" class="hover:text-green-600 transition-colors duration-200">
                        Produk
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li class="text-gray-800 font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Product Image -->
                <div class="animate-slide-right">
                    <div class="relative aspect-square rounded-xl overflow-hidden group">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-seedling text-6xl text-gray-400"></i>
                            </div>
                        @endif
                        
                        @if($product->featured)
                            <div class="absolute top-4 left-4">
                                <span class="bg-yellow-400 text-yellow-900 text-sm font-bold px-4 py-2 rounded-full">
                                    Produk Unggulan
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="animate-slide-left">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-center space-x-4 mb-6">
                        <span class="text-3xl font-bold text-green-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            Stok: {{ $product->stock }} {{ $product->unit ?? 'satuan' }}
                        </span>
                    </div>

                    <div class="prose prose-green max-w-none mb-8">
                        <p class="text-gray-600">{{ $product->description }}</p>
                    </div>

                    @if($product->stock > 0)
                      
                        <!-- Direct Order Section -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pesan Langsung</h3>
                            <div id="chat-admin-section">
                                <button id="btnChatAdmin" type="button" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg mb-3" style="display:none;">
                                    Chat Admin di WhatsApp
                                </button>
                                <form id="orderForm" action="{{ route('order.store') }}" method="POST" class="space-y-4" style="display:block;">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $product->id }}">
                                    
                                    <div class="flex flex-col space-y-2">
                                        <label for="nama_pemesan" class="text-sm font-medium text-gray-700">Nama Pemesan</label>
                                        <input type="text" 
                                               name="nama_pemesan" 
                                               id="nama_pemesan" 
                                               required
                                               class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <label for="telepon" class="text-sm font-medium text-gray-700">Nomor HP</label>
                                        <input type="tel" 
                                               name="telepon" 
                                               id="telepon" 
                                               required
                                               class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <label for="alamat" class="text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                                        <textarea name="alamat" 
                                                  id="alamat" 
                                                  rows="3" 
                                                  required
                                                  class="form-textarea rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200"></textarea>
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <label for="jumlah" class="text-sm font-medium text-gray-700">Jumlah ({{ $product->unit ?? 'satuan' }})</label>
                                        <input type="number" 
                                        name="jumlah" 
                                        id="jumlah" 
                                        min="{{ $product->min_increment ?? 1 }}" 
                                        max="{{ $product->stock }}"
                                        value="{{ old('jumlah', $jumlah ?? ($product->min_increment ?? 1)) }}"
                                        step="{{ $product->min_increment ?? 1 }}"
                                        required
                                        class="form-input rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                                    </div>

                                    <div class="flex flex-col space-y-2">
                                        <label class="text-sm font-medium text-gray-700">Total Harga</label>
                                        <div id="totalHarga" class="font-bold text-green-700 text-lg">
                                            Rp {{ number_format(($jumlah ?? 1) * $product->price, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <button id="btnPesan" type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300 transform hover:scale-105">
                                        Pesan Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                            <p class="text-red-800 font-medium">Maaf, stok produk ini sedang habis</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="popupChatAdmin" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4);">
    <div style="background:#fff; max-width:350px; margin:10% auto; padding:2rem; border-radius:1rem; text-align:center; position:relative;">
        <button id="btnClosePopup" style="position:absolute; top:0.5rem; right:0.5rem; background:transparent; border:none; font-size:1.5rem; color:#888; cursor:pointer;">&times;</button>
        <p class="mb-4 text-lg font-semibold">Apakah Anda sudah pernah chat admin?</p>
        <div class="flex justify-center gap-4">
            <button id="btnSudahChat" class="bg-green-600 text-white px-4 py-2 rounded">Sudah</button>
            <button id="btnBelumChat" class="bg-gray-400 text-white px-4 py-2 rounded">Belum</button>
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

@keyframes slideRight {
    from { transform: translateX(-20px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideLeft {
    from { transform: translateX(20px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.animate-fade-in {
    animation: fadeIn 1s ease-out forwards;
}

.animate-slide-down {
    animation: slideDown 1s ease-out forwards;
}

.animate-slide-right {
    animation: slideRight 1s ease-out forwards;
}

.animate-slide-left {
    animation: slideLeft 1s ease-out forwards;
}

.form-input, .form-textarea {
    transition: all 0.3s ease;
}

.form-input:focus, .form-textarea:focus {
    transform: translateY(-2px);
}

button[type="submit"] {
    transition: all 0.3s ease;
}

button[type="submit"]:active {
    transform: scale(0.95);
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const jumlahInput = document.getElementById('jumlah');
    const cartQuantityInput = document.getElementById('cart_quantity');
    const maxStock = {{ $product->stock }};
    
    if (jumlahInput) {
        jumlahInput.addEventListener('input', () => {
            if (parseInt(jumlahInput.value) > maxStock) {
                jumlahInput.value = maxStock;
            }
        });
    }

    if (cartQuantityInput) {
        cartQuantityInput.addEventListener('input', () => {
            if (parseInt(cartQuantityInput.value) > maxStock) {
                cartQuantityInput.value = maxStock;
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const jumlahInput = document.getElementById('jumlah');
    const totalHargaDiv = document.getElementById('totalHarga');
    const hargaProduk = {{ $product->price }};
    if(jumlahInput && totalHargaDiv) {
        function updateTotal() {
            var qty = parseInt(jumlahInput.value) || 1;
            var total = hargaProduk * qty;
            totalHargaDiv.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        jumlahInput.addEventListener('input', updateTotal);
        updateTotal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const btnChatAdmin = document.getElementById('btnChatAdmin');
    const orderForm = document.getElementById('orderForm');
    const adminWa = '6282379044166'; // Ganti dengan nomor admin
    // Cek localStorage
    if (localStorage.getItem('sudahChatAdmin') === '1') {
        orderForm.style.display = 'block';
    } else {
        btnChatAdmin.style.display = 'block';
    }
    btnChatAdmin && btnChatAdmin.addEventListener('click', function() {
        window.open('https://wa.me/' + adminWa + '?text=Halo%20Admin%2C%20saya%20ingin%20bertanya', '_blank');
        localStorage.setItem('sudahChatAdmin', '1');
        btnChatAdmin.style.display = 'none';
        orderForm.style.display = 'block';
    });
});

function setBodyScroll(disable) {
    if (disable) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const btnPesan = document.getElementById('btnPesan');
    const orderForm = document.getElementById('orderForm');
    const popup = document.getElementById('popupChatAdmin');
    const btnSudah = document.getElementById('btnSudahChat');
    const btnBelum = document.getElementById('btnBelumChat');
    const btnClose = document.getElementById('btnClosePopup');
    const infoUlangi = document.getElementById('infoUlangiPesan');
    const adminWa = '6282379044166'; // Ganti dengan nomor admin
    if (btnPesan) {
        btnPesan.addEventListener('click', function(e) {
            e.preventDefault();
            popup.style.display = 'block';
            setBodyScroll(true);
        });
    }
    btnSudah && btnSudah.addEventListener('click', function() {
        popup.style.display = 'none';
        setBodyScroll(false);
        orderForm.submit();
    });
    btnBelum && btnBelum.addEventListener('click', function() {
        popup.style.display = 'none';
        setBodyScroll(false);
        window.open('https://wa.me/' + adminWa + '?text=Halo%20Admin%2C%20saya%20ingin%20bertanya', '_blank');
        // Tampilkan info ulangi pesan setelah kembali
        setTimeout(function() {
            infoUlangi.style.display = 'block';
        }, 500);
    });
    btnClose && btnClose.addEventListener('click', function() {
        popup.style.display = 'none';
        setBodyScroll(false);
    });
    popup && popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            popup.style.display = 'none';
            setBodyScroll(false);
        }
    });
});
</script>
@endpush
@endsection