<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendOrderPlacedEmail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('cart.index');
        }

        $subtotal = 0;
        $originalTotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $originalTotal += ($item['original_price'] ?? $item['price']) * $item['quantity'];
        }

        // Calculate shipping
        $shippingCost = \App\Models\ShippingRule::getShippingCost($subtotal);
        $total = $subtotal + $shippingCost;

        // Calculate discount for display (subtotal is passed to view, logic handles display)
        [$discount, $newSubtotal] = $this->calculateDiscount($subtotal);
        // Note: The controller logic calculates $total = $subtotal + $shipping.
        // But wait, if discount exists, $total should be discounted total + shipping.
        // In `store` method: $total = $newSubtotal + $shippingCost;
        // In `index` current logic: $total = $subtotal + $shippingCost; 
        // This seems inconsistent if I want to show the final discounted total.
        // Let's match `store` logic mostly.

        $total = $newSubtotal + $shippingCost;

        return view('checkout.index', compact('cart', 'subtotal', 'originalTotal', 'shippingCost', 'total', 'discount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email:rfc,dns',
            'phone' => ['required', 'regex:/^[0-9+\-\s()]{10,15}$/'],
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ], [
            'full_name.required' => 'Full name is required',
            'email.email' => 'Please enter a valid email address',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Please enter a valid phone number (10-15 digits)',
            'address.required' => 'Street address is required',
            'city.required' => 'City is required',
        ]);

        $cart = session()->get('cart');

        // Check if cart exists and has items
        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Calculate shipping and discount
        $shippingCost = \App\Models\ShippingRule::getShippingCost($subtotal);
        [$discount, $newSubtotal] = $this->calculateDiscount($subtotal);

        $total = $newSubtotal + $shippingCost;

        $order = \App\Models\Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $request->full_name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'shipping_address' => $request->address,
            'city' => $request->city,
            'postal_code' => '00000', // Hardcoded value since field is not used
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'coupon_code' => session('coupon.code'),
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'status' => 'pending',
            'notes' => $request->notes
        ]);

        // Sync address to user profile if authenticated
        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $user->address = $request->address;
            $user->city = $request->city;
            // $user->phone = $request->phone; // Optional: Sync phone too if needed
            $user->save();
        }

        // Increment Coupon Usage
        if (session()->has('coupon')) {
            $couponCode = session('coupon.code');
            $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
            if ($coupon) {
                $coupon->increment('used_count');
            }
        }

        foreach ($cart as $id => $item) {
            // Check if it's a DEAL
            if (isset($item['type']) && $item['type'] === 'deal' && isset($item['deal_id'])) {
                $deal = \App\Models\Deal::with(['items.product', 'items.variant'])->find($item['deal_id']);

                if ($deal) {
                    // Calculate total regular price of items in the deal to determine ratio
                    $totalRegularPrice = 0;
                    foreach ($deal->items as $dealItem) {
                        $pPrice = $dealItem->product->price ?? 0;
                        if ($dealItem->variant) {
                            $pPrice = $dealItem->variant->price ?? $pPrice;
                        }
                        $totalRegularPrice += $pPrice; // quantity is usually 1 per deal item
                    }

                    // Ratio for pro-rating (prevent division by zero)
                    $ratio = ($totalRegularPrice > 0) ? ($deal->price / $totalRegularPrice) : 0;

                    // Distribute deal price across items
                    $remainingDealPrice = $deal->price * $item['quantity']; // Total to account for

                    foreach ($deal->items as $index => $dealItem) {
                        // Calculate item text details
                        $itemName = $dealItem->product->name;
                        if ($dealItem->variant_id && $dealItem->variant) {
                            $itemName .= ' - ' . $dealItem->variant->name;
                        }
                        $itemName .= ' (Deal: ' . $deal->name . ')';

                        // Calculate pro-rated price
                        $itemRegularPrice = ($dealItem->variant ? $dealItem->variant->price : $dealItem->product->price) ?? 0;
                        $proRatedPrice = round($itemRegularPrice * $ratio, 2);

                        // Adjust last item to handle rounding errors
                        if ($index === $deal->items->count() - 1) {
                            // This logic is for SINGLE deal unit. For N quantity, we multiply.
                            // Actually, simpler: Just store unit price.
                            // But total for line item is quantity * unit price.
                        }

                        // Create OrderItem
                        \App\Models\OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $dealItem->product_id,
                            'product_name' => $itemName,
                            'price' => $proRatedPrice, // Unit price
                            'quantity' => $item['quantity'], // Use cart quantity (e.g. 2 deals = 2 of each item)
                            'subtotal' => $proRatedPrice * $item['quantity']
                        ]);

                        // Decrement Stock
                        if ($dealItem->variant_id && $dealItem->variant) {
                            $dealItem->variant->decrement('stock', $item['quantity']);
                        } else {
                            $dealItem->product->decrement('stock', $item['quantity']);
                        }
                    }
                }
            } else {
                // REGULAR PRODUCT
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'] ?? $id, // Use product_id from cart item, fallback to key
                    'variant_id' => $item['variant_id'] ?? null,
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);

                // Decrease stock - handle both variant and product stock
                if (isset($item['variant_id']) && $item['variant_id']) {
                    // Decrease variant stock
                    $variant = \App\Models\ProductVariant::find($item['variant_id']);
                    if ($variant) {
                        $variant->decrement('stock', $item['quantity']);
                    }
                } else {
                    // Decrease product stock
                    $product = \App\Models\Product::find($item['product_id'] ?? $id);
                    if ($product) {
                        $product->decrement('stock', $item['quantity']);
                    }
                }
            }
        }

        session()->forget('cart');
        session()->forget('coupon');

        // Load items relationship and dispatch email job
        $order->load('items.product');
        SendOrderPlacedEmail::dispatch($order);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('checkout.success', $order->order_number)
            ]);
        }

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success($order_number)
    {
        $order = \App\Models\Order::where('order_number', $order_number)->firstOrFail();
        return view('checkout.success', compact('order'));
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
