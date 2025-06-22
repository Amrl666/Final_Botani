<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $sessionId = session()->getId();
        $cartItems = CartItem::with('product')
            ->where('session_id', $sessionId)
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('Frontend.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check stock availability
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
        }

        $sessionId = session()->getId();

        // Check if item already exists in cart
        $cartItem = CartItem::where('session_id', $sessionId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            CartItem::create([
                'session_id' => $sessionId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = $cartItem->product;
        
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah produk berhasil diperbarui!');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function clear()
    {
        $sessionId = session()->getId();
        CartItem::where('session_id', $sessionId)->delete();
        
        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }

    public function getCartCount()
    {
        $sessionId = session()->getId();
        $count = CartItem::where('session_id', $sessionId)->sum('quantity');
        
        return response()->json(['count' => $count]);
    }
} 