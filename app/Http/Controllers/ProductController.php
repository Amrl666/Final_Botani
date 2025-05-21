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
            'stock' => 'required|integer',
            'image' => 'required|image',
            'featured' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['featured'] = $request->has('featured') ? 1 : 0;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|integer',
            'featured' => 'required|boolean',
        ]);

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
    public function index_fr()
    {
        $products = Product::latest()->paginate(8);
        return view('frontend.product.index', compact('products'));
    }
}
