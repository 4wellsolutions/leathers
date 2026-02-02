<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $shipping = \App\Models\ShippingRule::getShippingCost($total);
        $grandTotal = $total + $shipping;

        return view('cart.index', compact('cart', 'total', 'shipping', 'grandTotal'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::with(['variants', 'sale'])->findOrFail($id);
        $variantId = $request->input('variant_id');
        $quantity = $request->input('quantity', 1);
        $action = $request->input('action', 'add');

        $cart = session()->get('cart', []);

        // Determine price and image based on variant
        // Use effective_price (deal/sale) as base, but variant price overrides if set
        $price = $product->effective_price;
        $image = $product->image;
        $name = $product->name;
        $maxStock = $product->stock;

        if ($variantId) {
            $variant = $product->variants()->with('color')->where('id', $variantId)->first();
            if ($variant) {
                // Prioritize sale_price if available, otherwise use regular price
                if ($variant->sale_price && $variant->sale_price > 0) {
                    $price = $variant->sale_price;
                } elseif ($variant->price) {
                    $price = $variant->price;
                }
                // If both are null, keep the product's effective_price

                // Use the color-specific image if available
                $image = ($variant->color && $variant->color->image_url) ? $variant->color->image_url : ($variant->image ?? $image);
                $name = $product->name . ' - ' . $variant->name;
                $maxStock = $variant->stock;

                $colorName = $variant->color ? $variant->color->name : null;
                $sizeName = $variant->size;
            }
        }

        // Generate unique cart item ID (product_id + variant_id)
        $cartItemId = $id . ($variantId ? '-' . $variantId : '');

        if (isset($cart[$cartItemId])) {
            $cart[$cartItemId]['quantity'] += $quantity;
        } else {
            $cart[$cartItemId] = [
                "product_id" => $product->id,
                "variant_id" => $variantId,
                "name" => $name,
                "base_name" => $product->name,
                "quantity" => $quantity,
                "price" => $price,
                "image" => $image,
                "slug" => $product->slug,
                "color" => $colorName ?? null,
                "size" => $sizeName ?? null
            ];
        }

        // Check stock
        if ($cart[$cartItemId]['quantity'] > $maxStock) {
            $cart[$cartItemId]['quantity'] = $maxStock;
            session()->flash('error', 'Sorry, we only have ' . $maxStock . ' items in stock.');
        } else {
            session()->flash('success', 'Product added to cart successfully!');
        }

        session()->put('cart', $cart);

        if ($action === 'buy_now') {
            return redirect()->route('checkout.index');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);

            $subtotal = $cart[$request->id]["quantity"] * $cart[$request->id]["price"];
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $shipping = \App\Models\ShippingRule::getShippingCost($total);
            $grandTotal = $total + $shipping;

            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal),
                'total' => number_format($total),
                'shipping_cost' => number_format($shipping),
                'grand_total' => number_format($grandTotal)
            ]);
        }
    }

    public function addDeal(Request $request, $id)
    {
        $deal = \App\Models\Deal::where('is_active', true)->findOrFail($id);

        if (!$deal->isValid()) {
            return redirect()->back()->with('error', 'This deal is no longer valid.');
        }

        $cart = session()->get('cart', []);
        $cartItemId = 'deal_' . $id;

        if (isset($cart[$cartItemId])) {
            $cart[$cartItemId]['quantity']++;
        } else {
            $cart[$cartItemId] = [
                "deal_id" => $deal->id,
                "name" => $deal->name,
                "quantity" => 1,
                "price" => $deal->price,
                "image" => $deal->products->first()->image ?? null, // Use first product image as fallback
                "slug" => $deal->slug,
                "type" => "deal"
            ];
        }

        session()->put('cart', $cart);
        session()->flash('success', 'Deal added to cart successfully!');

        return redirect()->back();
    }

    public function remove(Request $request)
    {
        \Log::info('Cart remove request received', $request->all());
        $id = $request->input('id');

        if ($id) {
            $cart = session()->get('cart');
            \Log::info('Current cart keys', array_keys($cart ?? []));

            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                \Log::info('Item removed', ['id' => $id]);
            } else {
                \Log::warning('Item not found in cart', ['id' => $id]);
            }

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $shipping = \App\Models\ShippingRule::getShippingCost($total);
            $grandTotal = $total + $shipping;

            return response()->json([
                'success' => true,
                'total' => number_format($total),
                'shipping_cost' => number_format($shipping),
                'grand_total' => number_format($grandTotal),
                'count' => count($cart)
            ]);
        }

        \Log::error('No ID provided for removal');
        return response()->json([
            'success' => false,
            'message' => 'Item ID not provided'
        ], 400);
    }
}
