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
        
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }
  
    public function add(Request $request, $id)
    {
        $product = Product::with(['variants', 'deal'])->findOrFail($id);
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
            $variant = $product->variants->where('id', $variantId)->first();
            if ($variant) {
                // Prioritize sale_price if available, otherwise use regular price
                if ($variant->sale_price && $variant->sale_price > 0) {
                    $price = $variant->sale_price;
                } elseif ($variant->price) {
                    $price = $variant->price;
                }
                // If both are null, keep the product's effective_price
                
                $image = $variant->image ?? $image;
                $name = $product->name . ' - ' . $variant->name;
                $maxStock = $variant->stock;
            }
        }
        
        // Generate unique cart item ID (product_id + variant_id)
        $cartItemId = $id . ($variantId ? '-' . $variantId : '');
        
        if(isset($cart[$cartItemId])) {
            $cart[$cartItemId]['quantity'] += $quantity;
        } else {
            $cart[$cartItemId] = [
                "product_id" => $product->id,
                "variant_id" => $variantId,
                "name" => $name,
                "quantity" => $quantity,
                "price" => $price,
                "image" => $image,
                "slug" => $product->slug
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
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            
            $subtotal = $cart[$request->id]["quantity"] * $cart[$request->id]["price"];
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            return response()->json([
                'success' => true, 
                'subtotal' => number_format($subtotal),
                'total' => number_format($total)
            ]);
        }
    }
  
    public function addCombo(Request $request, $id)
    {
        $combo = \App\Models\Combo::where('is_active', true)->findOrFail($id);
        
        if (!$combo->isValid()) {
            return redirect()->back()->with('error', 'This combo is no longer valid.');
        }

        $cart = session()->get('cart', []);
        $cartItemId = 'combo_' . $id;

        if(isset($cart[$cartItemId])) {
            $cart[$cartItemId]['quantity']++;
        } else {
            $cart[$cartItemId] = [
                "combo_id" => $combo->id,
                "name" => $combo->name,
                "quantity" => 1,
                "price" => $combo->price,
                "image" => $combo->products->first()->image ?? null, // Use first product image as fallback
                "slug" => $combo->slug,
                "type" => "combo"
            ];
        }

        session()->put('cart', $cart);
        session()->flash('success', 'Combo added to cart successfully!');
        
        return redirect()->back();
    }

    public function remove(Request $request)
    {
        \Log::info('Cart remove request received', $request->all());
        $id = $request->input('id');
        
        if($id) {
            $cart = session()->get('cart');
            \Log::info('Current cart keys', array_keys($cart ?? []));
            
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                \Log::info('Item removed', ['id' => $id]);
            } else {
                \Log::warning('Item not found in cart', ['id' => $id]);
            }
            
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            return response()->json([
                'success' => true,
                'total' => number_format($total),
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
