<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking Customer and Order Data:\n";
echo "================================\n";

// Check customers
$customerCount = \App\Models\Customer::count();
echo "Customer count: {$customerCount}\n";

if ($customerCount > 0) {
    $customer = \App\Models\Customer::first();
    echo "Sample customer:\n";
    echo "- ID: {$customer->id}\n";
    echo "- Name: {$customer->name}\n";
    echo "- Email: {$customer->email}\n";
    echo "- Phone: {$customer->phone}\n";
    
    // Check orders for this customer
    $orders = \App\Models\Order::where('telepon', $customer->phone)->get();
    echo "- Orders count: " . $orders->count() . "\n";
    
    if ($orders->count() > 0) {
        echo "- Sample orders:\n";
        foreach ($orders->take(3) as $order) {
            echo "  * Order #{$order->id}: {$order->nama_pemesan} - {$order->telepon} - {$order->status}\n";
        }
    }
}

// Check all orders
$orderCount = \App\Models\Order::count();
echo "\nTotal Order count: {$orderCount}\n";

if ($orderCount > 0) {
    echo "All orders with phone numbers:\n";
    $allOrders = \App\Models\Order::all();
    foreach ($allOrders as $order) {
        echo "- Order #{$order->id}: {$order->nama_pemesan} - '{$order->telepon}' - {$order->status}\n";
    }
}

echo "\n================================\n"; 