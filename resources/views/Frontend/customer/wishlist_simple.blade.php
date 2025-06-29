<!DOCTYPE html>
<html>
<head>
    <title>Wishlist Test</title>
</head>
<body>
    <h1>Wishlist Test</h1>
    
    @if(session('success'))
        <div style="background: green; color: white; padding: 10px; margin: 10px 0;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div style="background: blue; color: white; padding: 10px; margin: 10px 0;">
            {{ session('info') }}
        </div>
    @endif

    <div style="background: yellow; padding: 10px; margin: 10px 0;">
        <strong>Debug Info:</strong><br>
        Total produk di wishlist: {{ $wishlist->count() }}<br>
        @if($wishlist->count() > 0)
            Produk: {{ $wishlist->pluck('name')->implode(', ') }}
        @else
            Tidak ada produk di wishlist
        @endif
    </div>

    @if($wishlist->count() > 0)
        <h2>Produk di Wishlist:</h2>
        <ul>
            @foreach($wishlist as $product)
                <li>
                    <strong>{{ $product->name }}</strong> - 
                    Rp {{ number_format($product->price, 0, ',', '.') }} per {{ $product->unit }}
                    <form action="{{ route('customer.wishlist.remove', $product) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus dari wishlist?')">Hapus</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>Wishlist kosong</p>
    @endif

    <p><a href="{{ route('product.index_fr') }}">Kembali ke Produk</a></p>
</body>
</html> 