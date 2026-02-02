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
        $originalTotal = 0;

        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
            $originalTotal += ($details['original_price'] ?? $details['price']) * $details['quantity'];
        }

        $shipping = \App\Models\ShippingRule::getShippingCost($total);
        [$discount, $newTotal] = $this->calculateDiscount($total);
        $grandTotal = $newTotal + $shipping;

        return view('cart.index', compact('cart', 'total', 'originalTotal', 'shipping', 'discount', 'grandTotal'));
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
        $originalPrice = $product->price; // Default to product regular price
        $image = $product->image;
        $name = $product->name;
        $maxStock = $product->stock;

        if ($variantId) {
            $variant = $product->variants()->with('color')->where('id', $variantId)->first();
            if ($variant) {
                // Prioritize sale_price if available, otherwise use regular price
                if ($variant->sale_price && $variant->sale_price > 0) {
                    $price = $variant->sale_price;
                    $originalPrice = $variant->price; // Set original price to variant regular price
                } elseif ($variant->price) {
                    $price = $variant->price;
                    $originalPrice = $variant->price;
                }
                // If both are null, keep the product's effective_price/price. 
                // Wait, if variant has NO price set, does it inherit product price? 
                // Usually variants have prices. If not, we might be falling back to product logic above.

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
                "original_price" => $originalPrice,
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
            $originalTotal = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
                $originalTotal += ($item['original_price'] ?? $item['price']) * $item['quantity'];
            }

            [$discount, $newTotal] = $this->calculateDiscount($total);
            $shipping = \App\Models\ShippingRule::getShippingCost($total);
            $grandTotal = $newTotal + $shipping;

            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal),
                'total' => number_format($total),
                'original_total' => number_format($originalTotal),
                'discount' => number_format($discount),
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
                "original_price" => null, // Deals usually don't have a single "original" price easily calc here without summing items, can leave null
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
            [$discount, $newTotal] = $this->calculateDiscount($total);

            $grandTotal = $newTotal + $shipping;

            return response()->json([
                'success' => true,
                'total' => number_format($total),
                'shipping_cost' => number_format($shipping),
                'discount' => number_format($discount),
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

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $coupon = \App\Models\Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code.'
            ]);
        }

        // Calculate total to check minimum order amount
        $cart = session()->get('cart', []);
        $total = 0;
        $originalTotal = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $originalTotal += ($item['original_price'] ?? $item['price']) * $item['quantity'];
        }

        if ($coupon->min_order_amount && $total < $coupon->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order amount for this coupon is Rs. ' . number_format($coupon->min_order_amount)
            ]);
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value
        ]);

        [$discount, $newTotal] = $this->calculateDiscount($total);
        $shipping = \App\Models\ShippingRule::getShippingCost($newTotal); // Shipping usually on total, sometimes subtotal? Let's assume subtotal for consistency with earlier logic but newTotal is discounted subtotal
        // Re-read: Shipping rules usually based on subtotal BEFORE discount or AFTER? Usually BEFORE. 
        // Let's stick to base Total for shipping calculation essentially, or stick to current logic.
        // Existing logic: $shipping = \App\Models\ShippingRule::getShippingCost($total);
        // Let's keep shipping based on original total to be generous/consistent, OR check business logic. 
        // Usually shipping is calculated on subtotal.

        $shipping = \App\Models\ShippingRule::getShippingCost($total); // Keep using original total for shipping tier
        $grandTotal = $newTotal + $shipping;

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'subtotal' => number_format($total),
            'total' => number_format($total),
            'original_total' => number_format($originalTotal),
            'discount' => number_format($discount),
            'shipping_cost' => number_format($shipping),
            'grand_total' => number_format($grandTotal)
        ]);
    }

    public function removeCoupon()
    {
        session()->forget('coupon');

        $cart = session()->get('cart', []);
        $total = 0;
        $originalTotal = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $originalTotal += ($item['original_price'] ?? $item['price']) * $item['quantity'];
        }

        $shipping = \App\Models\ShippingRule::getShippingCost($total);

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
            'subtotal' => number_format($total),
            'total' => number_format($total),
            'original_total' => number_format($originalTotal),
            'discount' => number_format(0),
            'shipping_cost' => number_format($shipping),
            'grand_total' => number_format($total + $shipping)
        ]);
    }

    private function calculateDiscount($total)
    {
        $couponData = session()->get('coupon');
        $discount = 0;

        if ($couponData) {
            $coupon = \App\Models\Coupon::where('code', $couponData['code'])->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($total);
            } else {
                session()->forget('coupon'); // Remove invalid coupon from session
            }
        }

        return [$discount, max(0, $total - $discount)];
    }
}
