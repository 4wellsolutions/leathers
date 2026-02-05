<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$productName = "Double Sided Black Premium Dress Leather Belt For Men";
$product = \App\Models\Product::where('name', $productName)->first();

if (!$product) {
    echo "Product not found.\n";
    exit;
}

echo "Product ID: " . $product->id . "\n";
echo "Global Sale Price: " . $product->sale_price . "\n";

$variants = $product->variants;
echo "Variants Count: " . $variants->count() . "\n";

foreach ($variants as $variant) {
    echo "Variant ID: " . $variant->id . " | Size: " . $variant->size . " | Price: " . $variant->price . " | Sale Price: " . var_export($variant->sale_price, true) . "\n";
}
