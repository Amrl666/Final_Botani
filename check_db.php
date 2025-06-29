<?php

// File untuk mengecek database
// Jalankan dengan: php check_db.php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== DATABASE CHECK ===\n\n";

try {
    // Test koneksi database
    DB::connection()->getPdo();
    echo "✅ Koneksi database berhasil\n\n";
    
    // Cek tabel wishlists
    if (Schema::hasTable('wishlists')) {
        echo "✅ Tabel wishlists ada\n";
        
        $columns = Schema::getColumnListing('wishlists');
        echo "Kolom: " . implode(', ', $columns) . "\n";
        
        $count = DB::table('wishlists')->count();
        echo "Total data: $count\n\n";
        
        if ($count > 0) {
            $data = DB::table('wishlists')->get();
            foreach ($data as $row) {
                echo "- Customer ID: {$row->customer_id}, Product ID: {$row->product_id}\n";
            }
        }
    } else {
        echo "❌ Tabel wishlists tidak ada\n";
    }
    
    // Cek tabel customers
    if (Schema::hasTable('customers')) {
        echo "\n✅ Tabel customers ada\n";
        $count = DB::table('customers')->count();
        echo "Total customers: $count\n";
    }
    
    // Cek tabel products
    if (Schema::hasTable('products')) {
        echo "\n✅ Tabel products ada\n";
        $count = DB::table('products')->count();
        echo "Total products: $count\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== END CHECK ===\n"; 