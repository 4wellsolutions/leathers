<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$order = App\Models\Order::latest()->first();

if (!$order) {
    echo "No orders found.\n";
    exit;
}

echo "Order ID: " . $order->id . "\n";
foreach ($order->items as $item) {
    $product = $item->product;
    echo "--------------------------------------------------\n";
    echo "Item: " . $item->product_name . "\n";
    if ($product) {
        echo "Product ID: " . $product->id . "\n";
        echo "Slug: " . $product->slug . "\n";
        echo "Is Active: " . ($product->is_active ? 'Yes' : 'No') . "\n";
        try {
            echo "Generated URL: " . route('products.show', $product->slug) . "\n";
        } catch (\Exception $e) {
            echo "URL Generation Failed: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Product Relation: NULL (Soft Deleted or Missing)\n";
    }
}
