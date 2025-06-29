<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = collect();
        
        // Check if customer is logged in
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $wishlist = Product::whereHas('customers', function($query) use ($customer) {
                $query->where('customers.id', $customer->id);
            })->get();
        } else {
            // Use session-based wishlist for guests
            if (session()->has('wishlist')) {
                $productIds = session('wishlist');
                $wishlist = Product::whereIn('id', $productIds)->get();
            }
        }

        return view('Frontend.wishlist.index', compact('wishlist'));
    }

    public function add(Product $product)
    {
        // Check if customer is logged in
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            
            // Check if already in wishlist
            $existingWishlist = DB::table('wishlists')
                ->where('customer_id', $customer->id)
                ->where('product_id', $product->id)
                ->first();
            
            if (!$existingWishlist) {
                DB::table('wishlists')->insert([
                    'customer_id' => $customer->id,
                    'product_id' => $product->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                return back()->with('success', 'Produk berhasil ditambahkan ke wishlist!');
            }
            
            return back()->with('info', 'Produk sudah ada di wishlist!');
        } else {
            // Session-based wishlist for guests
            $wishlist = session('wishlist', []);
            
            if (!in_array($product->id, $wishlist)) {
                $wishlist[] = $product->id;
                session(['wishlist' => $wishlist]);
                
                return back()->with('success', 'Produk berhasil ditambahkan ke wishlist!');
            }

            return back()->with('info', 'Produk sudah ada di wishlist!');
        }
    }

    public function remove(Product $product)
    {
        // Check if customer is logged in
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            
            DB::table('wishlists')
                ->where('customer_id', $customer->id)
                ->where('product_id', $product->id)
                ->delete();

            return back()->with('success', 'Produk berhasil dihapus dari wishlist!');
        } else {
            // Session-based wishlist for guests
            $wishlist = session('wishlist', []);
            
            $wishlist = array_filter($wishlist, function($id) use ($product) {
                return $id != $product->id;
            });
            
            session(['wishlist' => array_values($wishlist)]);
            
            return back()->with('success', 'Produk berhasil dihapus dari wishlist!');
        }
    }

    public function clear()
    {
        // Check if customer is logged in
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            
            DB::table('wishlists')
                ->where('customer_id', $customer->id)
                ->delete();
        } else {
            // Session-based wishlist for guests
            session()->forget('wishlist');
        }
        
        return back()->with('success', 'Wishlist berhasil dikosongkan!');
    }
}
