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

echo "Fixing variants for: " . $product->name . "\n";

$variants = $product->variants;
$count = 0;
foreach ($variants as $variant) {
    // Explicitly set to NULL
    $variant->sale_price = null;
    $variant->save();
    echo "Cleared sale price for variant ID: " . $variant->id . "\n";
    $count++;
}

echo "Fixed $count variants.\n";
