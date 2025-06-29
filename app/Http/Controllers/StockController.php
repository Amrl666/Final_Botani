<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::with('stockHistories')
            ->orderBy('stock', 'asc')
            ->paginate(15);

        $lowStockProducts = Product::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->get();

        $stockStats = [
            'total_products' => Product::count(),
            'low_stock' => Product::where('stock', '<=', 10)->count(),
            'out_of_stock' => Product::where('stock', '<=', 0)->count(),
            'available' => Product::where('stock', '>', 10)->count(),
        ];

        return view('dashboard.stock.index', compact('products', 'lowStockProducts', 'stockStats'));
    }

    public function history(Product $product)
    {
        $histories = $product->stockHistories()
            ->latest()
            ->paginate(20);

        return view('dashboard.stock.history', compact('product', 'histories'));
    }

    public function adjust(Request $request, Product $product)
    {
        $request->validate([
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $quantity = $request->type === 'out' ? -$request->quantity : $request->quantity;
        
        $product->updateStock(
            $quantity,
            $request->type,
            $request->notes,
            'manual_adjustment'
        );

        return back()->with('success', 'Stok berhasil diperbarui!');
    }

    public function bulkAdjust(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'required|exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer',
            'type' => 'required|in:in,out,adjustment',
            'notes' => 'nullable|string|max:255',
        ]);

        $productIds = $request->product_ids;
        $quantities = $request->quantities;

        foreach ($productIds as $index => $productId) {
            if (isset($quantities[$index])) {
                $product = Product::find($productId);
                $quantity = $request->type === 'out' ? -$quantities[$index] : $quantities[$index];
                
                $product->updateStock(
                    $quantity,
                    $request->type,
                    $request->notes,
                    'bulk_adjustment'
                );
            }
        }

        return back()->with('success', 'Stok berhasil diperbarui untuk semua produk!');
    }

    public function export()
    {
        $products = Product::with('stockHistories')
            ->orderBy('stock', 'asc')
            ->get();

        $filename = 'stock_report_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'ID', 'Nama Produk', 'Stok Saat Ini', 'Unit', 'Status', 
                'Harga', 'Terakhir Diupdate'
            ]);

            // Data
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->stock,
                    $product->unit,
                    $product->stock_status,
                    $product->price,
                    $product->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
