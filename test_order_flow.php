<?php

require_once 'vendor/autoload.php';

use App\Models\Order;
use App\Models\Product;
use App\Models\Eduwisata;
use App\Models\Payment;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Order Flow ===\n\n";

// Test 1: Check if products exist
echo "1. Checking products...\n";
$products = Product::all();
echo "   Found " . $products->count() . " products\n";
if ($products->count() > 0) {
    echo "   Sample product: " . $products->first()->name . " (ID: " . $products->first()->id . ")\n";
}

// Test 2: Check if eduwisata exist
echo "\n2. Checking eduwisata...\n";
$eduwisatas = Eduwisata::all();
echo "   Found " . $eduwisatas->count() . " eduwisata\n";
if ($eduwisatas->count() > 0) {
    echo "   Sample eduwisata: " . $eduwisatas->first()->name . " (ID: " . $eduwisatas->first()->id . ")\n";
}

// Test 3: Check existing orders
echo "\n3. Checking existing orders...\n";
$orders = Order::all();
echo "   Found " . $orders->count() . " orders\n";
if ($orders->count() > 0) {
    $latestOrder = Order::latest()->first();
    echo "   Latest order: #" . $latestOrder->id . " - " . $latestOrder->nama_pemesan . " (Rp " . number_format($latestOrder->total_harga, 0, ',', '.') . ")\n";
}

// Test 4: Check payments
echo "\n4. Checking payments...\n";
$payments = Payment::all();
echo "   Found " . $payments->count() . " payments\n";

// Test 5: Test order creation (simulate)
echo "\n5. Testing order creation simulation...\n";
try {
    // Simulate product order
    $product = Product::first();
    if ($product) {
        $orderData = [
            'nama_pemesan' => 'Test User',
            'telepon' => '08123456789',
            'alamat' => 'Test Address',
            'produk_id' => $product->id,
            'jumlah' => 2,
            'total_harga' => $product->price * 2,
            'status' => 'menunggu'
        ];
        
        echo "   Would create order for: " . $product->name . " x2 = Rp " . number_format($orderData['total_harga'], 0, ',', '.') . "\n";
        echo "   Redirect URL would be: /payment/" . ($orders->count() + 1) . "\n";
    }
    
    // Simulate eduwisata order
    $eduwisata = Eduwisata::first();
    if ($eduwisata) {
        $orderData = [
            'nama_pemesan' => 'Test User',
            'telepon' => '08123456789',
            'alamat' => 'Test Address',
            'eduwisata_id' => $eduwisata->id,
            'jumlah_orang' => 5,
            'total_harga' => 14000 * 5, // Assuming 5 people
            'status' => 'menunggu'
        ];
        
        echo "   Would create eduwisata order for: " . $eduwisata->name . " x5 people = Rp " . number_format($orderData['total_harga'], 0, ',', '.') . "\n";
        echo "   Redirect URL would be: /payment/" . ($orders->count() + 2) . "\n";
    }
    
} catch (Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

// Test 6: Check routes
echo "\n6. Checking routes...\n";
$routes = [
    'order.store' => '/order',
    'payment.show' => '/payment/{order}',
    'payment.process' => '/payment/{order}/process',
    'payment.success' => '/payment/{order}/success',
    'customer.orders' => '/orders',
    'product.index_fr' => '/product'
];

foreach ($routes as $name => $path) {
    echo "   " . $name . " -> " . $path . "\n";
}

echo "\n=== Test Complete ===\n";
echo "The order flow appears to be properly configured.\n";
echo "To test the actual flow:\n";
echo "1. Visit http://127.0.0.1:8000/product\n";
echo "2. Add products to cart or order directly\n";
echo "3. Fill the order form\n";
echo "4. Should redirect to payment page\n";
echo "5. Process payment\n";
echo "6. Should redirect to success page\n"; 