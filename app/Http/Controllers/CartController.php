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
        $cartItems = collect();
        
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $sessionId = session()->getId();
            
            // Get cart items by user_id OR session_id for the current customer
            $cartItems = CartItem::with('product')
                ->where(function($query) use ($customer, $sessionId) {
                    $query->where('user_id', $customer->id)
                          ->orWhere('session_id', $sessionId);
                })
                ->get();
        } else {
            $sessionId = session()->getId();
            $cartItems = CartItem::with('product')
                ->where('session_id', $sessionId)
                ->get();
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

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

        // Check if quantity is valid based on min_increment (only if min_increment > 0)
        if ($product->min_increment > 0) {
            // Use a more robust method to avoid floating-point precision issues
            $remainder = fmod($request->quantity, $product->min_increment);
            if (abs($remainder) > 0.001) { // Allow for small floating-point errors
                return back()->with('error', "Jumlah harus kelipatan {$product->min_increment} {$product->unit}.");
            }
        }

        $cartData = [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'session_id' => session()->getId() // Always include session_id
        ];

        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $cartData['user_id'] = $customer->id;
            
            // Check if item already exists in cart
            $cartItem = CartItem::where('user_id', $customer->id)
                ->where('product_id', $request->product_id)
                ->first();
        } else {
            // Check if item already exists in cart
            $cartItem = CartItem::where('session_id', $cartData['session_id'])
                ->where('product_id', $request->product_id)
                ->first();
        }

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            CartItem::create($cartData);
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

        // Check if quantity is valid based on min_increment (only if min_increment > 0)
        if ($product->min_increment > 0) {
            // Use a more robust method to avoid floating-point precision issues
            $remainder = fmod($request->quantity, $product->min_increment);
            if (abs($remainder) > 0.001) { // Allow for small floating-point errors
                return back()->with('error', "Jumlah harus kelipatan {$product->min_increment} {$product->unit}.");
            }
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah produk berhasil diperbarui!');
    }

    public function remove(CartItem $cartItem)
    {
        // Check if cart item belongs to current user
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            if ($cartItem->user_id !== $customer->id) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            $sessionId = session()->getId();
            if ($cartItem->session_id !== $sessionId) {
                abort(403, 'Unauthorized action.');
            }
        }

        $cartItem->delete();
        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function clear()
    {
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            CartItem::where('user_id', $customer->id)->delete();
        } else {
            $sessionId = session()->getId();
            CartItem::where('session_id', $sessionId)->delete();
        }
        
        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }

    public function getCartCount()
    {
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $sessionId = session()->getId();
            $count = CartItem::where(function($query) use ($customer, $sessionId) {
                $query->where('user_id', $customer->id)
                      ->orWhere('session_id', $sessionId);
            })->sum('quantity');
        } else {
            $sessionId = session()->getId();
            $count = CartItem::where('session_id', $sessionId)->sum('quantity');
        }
        return response()->json(['count' => $count]);
    }
} 