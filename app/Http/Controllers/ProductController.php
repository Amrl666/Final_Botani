<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan daftar produk (Admin)
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('dashboard.product.index', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        return view('dashboard.product.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'unit' => 'required|string|in:kg,gram,buah,ikat,pack,box,pcs',
            'min_increment' => 'required|numeric|min:0.01',
            'stock' => 'required|integer',
            'image' => 'required|image',
            'featured' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['featured'] = $request->input('featured', 0);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            $data['image'] = $imagePath;
        }

        Product::create($data);
        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Menampilkan form edit produk
    public function edit(Product $product)
    {
        return view('dashboard.product.edit', compact('product'));
    }

    // Mengupdate produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'unit' => 'required|string|in:kg,gram,buah,ikat,pack,box,pcs',
            'min_increment' => 'required|numeric|min:0.01',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|integer',
            'featured' => 'nullable|boolean',
        ]);

        // Handle featured checkbox
        $validated['featured'] = $request->input('featured', 0);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        }

        $product->update($validated);

        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil diperbarui.');
    }


    // Menghapus produk
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil dihapus.');
    }

    // Menampilkan produk di frontend
    public function index_fr(Request $request)
    {
        $query = Product::query();

        if ($request->filter == 'featured') {
            $query->where('featured', true);
        } elseif ($request->filter == 'new') {
            $query->latest();
        } elseif ($request->filter == 'available') {
            $query->where('stock', '>', 0);
        } else {
            $query->latest(); // Default sorting
        }

        $products = $query->paginate(8)->appends($request->query());
        return view('Frontend.product.index', compact('products'));
    }
    public function show(Product $product)
    {
        return view('Frontend.product.product', compact('product'));
    }

}
