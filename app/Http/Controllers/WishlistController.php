<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = $this->getWishlistItems();
        
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        $productId = $request->product_id;
        
        if (Auth::check()) {
            // For authenticated users
            Wishlist::firstOrCreate([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
        } else {
            // For guest users
            $sessionId = session()->getId();
            Wishlist::firstOrCreate([
                'session_id' => $sessionId,
                'product_id' => $productId
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'count' => $this->getWishlistCount()
        ]);
    }

    public function remove(Request $request)
    {
        $productId = $request->product_id;
        
        if (Auth::check()) {
            Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $sessionId = session()->getId();
            Wishlist::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'count' => $this->getWishlistCount()
        ]);
    }

    public function toggle(Request $request)
    {
        $productId = $request->product_id;
        $exists = false;

        if (Auth::check()) {
            $exists = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();
                
            if ($exists) {
                Wishlist::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->delete();
            } else {
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId
                ]);
            }
        } else {
            $sessionId = session()->getId();
            $exists = Wishlist::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->exists();
                
            if ($exists) {
                Wishlist::where('session_id', $sessionId)
                    ->where('product_id', $productId)
                    ->delete();
            } else {
                Wishlist::create([
                    'session_id' => $sessionId,
                    'product_id' => $productId
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'inWishlist' => !$exists,
            'count' => $this->getWishlistCount()
        ]);
    }

    private function getWishlistItems()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())
                ->with('product.category')
                ->latest()
                ->get();
        } else {
            $sessionId = session()->getId();
            return Wishlist::where('session_id', $sessionId)
                ->with('product.category')
                ->latest()
                ->get();
        }
    }

    private function getWishlistCount()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->count();
        } else {
            $sessionId = session()->getId();
            return Wishlist::where('session_id', $sessionId)->count();
        }
    }
}
