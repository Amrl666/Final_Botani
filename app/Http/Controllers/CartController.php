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

        $total = 0;
        foreach ($cartItems as $item) {
            $product = $item->product;
            $quantity = $item->quantity;
            
            $total += $product->calculateTotalPrice($quantity);
        }

        return view('Frontend.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.01'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check stock availability
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
        }

        // Check if quantity is valid based on min_increment
        if ($product->min_increment > 0) {
            $remainder = fmod($request->quantity, $product->min_increment);
            // Use a small epsilon for float comparison to avoid precision issues
            if (abs($remainder) > 0.00001) {
                return back()->with('error', "Jumlah harus kelipatan {$product->min_increment} {$product->unit}.");
            }
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
            'quantity' => 'required|numeric|min:0.01'
        ]);

        $product = $cartItem->product;
        
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
        }

        // Check if quantity is valid based on min_increment
        if ($product->min_increment > 0) {
            $remainder = fmod($request->quantity, $product->min_increment);
            // Use a small epsilon for float comparison to avoid precision issues
            if (abs($remainder) > 0.00001) {
                return back()->with('error', "Jumlah harus kelipatan {$product->min_increment} {$product->unit}.");
            }
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
        $count = CartItem::where('session_id', $sessionId)->count();
        
        return response()->json(['count' => $count]);
    }
} 