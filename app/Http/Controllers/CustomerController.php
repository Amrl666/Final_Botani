<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function showRegistrationForm()
    {
        return view('Frontend.auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|max:20|unique:customers',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->intended('/')->with('success', 'Akun berhasil dibuat!');
    }

    public function showLoginForm()
    {
        return view('Frontend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout!');
    }

    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('Frontend.customer.profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'address' => 'nullable|string',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Update basic info
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Update password if provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $customer->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah.'])->withInput();
            }
            $customer->update(['password' => Hash::make($request->new_password)]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function orders()
    {
        $customer = Auth::guard('customer')->user();
        $orders = $customer->orders()->with(['produk', 'eduwisata', 'orderItems.product', 'payment'])
            ->latest()
            ->paginate(10);

        return view('Frontend.customer.orders', compact('orders'));
    }

    public function riwayatProduk()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::with(['orderItems.product', 'produk'])
            ->where('telepon', $customer->phone)
            ->where(function ($query) {
                $query->whereHas('orderItems')
                      ->orWhereNotNull('produk_id');
            })
            ->latest()
            ->get();

        return view('Frontend.orders.riwayat_produk', compact('orders', 'customer'));
    }

    public function riwayatEduwisata()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::with(['eduwisata' => function($query) {
                $query->select('id', 'name', 'harga');
            }])
            ->where('telepon', $customer->phone)
            ->whereNotNull('eduwisata_id')
            ->latest()
            ->get();
        return view('Frontend.orders.riwayat_eduwisata', compact('orders', 'customer'));
    }

    public function wishlist()
    {
        $customer = Auth::guard('customer')->user();
        
        // Ambil produk di wishlist customer menggunakan query langsung
        $wishlist = Product::whereHas('customers', function($query) use ($customer) {
            $query->where('customers.id', $customer->id);
        })->paginate(12);

        return view('Frontend.customer.wishlist', compact('wishlist'));
    }

    public function addToWishlist(Product $product)
    {
        $customer = Auth::guard('customer')->user();
        
        // Debug: cek apakah sudah ada di wishlist
        $existingWishlist = DB::table('wishlists')
            ->where('customer_id', $customer->id)
            ->where('product_id', $product->id)
            ->first();
        
        if (!$existingWishlist) {
            // Tambah ke wishlist
            DB::table('wishlists')->insert([
                'customer_id' => $customer->id,
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            return back()->with('success', 'Produk berhasil ditambahkan ke wishlist!');
        }

        return back()->with('info', 'Produk sudah ada di wishlist!');
    }

    public function removeFromWishlist(Product $product)
    {
        $customer = Auth::guard('customer')->user();
        
        // Hapus dari wishlist menggunakan DB::table
        DB::table('wishlists')
            ->where('customer_id', $customer->id)
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Produk berhasil dihapus dari wishlist!');
    }

    // Customer deliveries
    public function deliveries()
    {
        $customer = Auth::guard('customer')->user();
        $deliveries = $customer->deliveries()->with(['order', 'trackingLogs'])
            ->latest()
            ->paginate(10);

        return view('Frontend.customer.deliveries', compact('deliveries'));
    }

    // Customer shipping addresses
    public function addresses()
    {
        $customer = Auth::guard('customer')->user();
        $addresses = $customer->shippingAddresses()->orderBy('is_default', 'desc')->get();
        
        return view('Frontend.customer.addresses.index', compact('addresses'));
    }
}
