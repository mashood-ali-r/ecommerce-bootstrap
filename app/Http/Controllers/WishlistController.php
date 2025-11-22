<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display the wishlist page
     */
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        return view('wishlist', compact('wishlist'));
    }

    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $wishlist = session()->get('wishlist', []);
        $productId = $request->input('id');

        // Check if product already in wishlist
        if (isset($wishlist[$productId])) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist!'
            ]);
        }

        // Add to wishlist
        $wishlist[$productId] = [
            'id' => $productId,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'added_at' => now()->toDateTimeString()
        ];

        session(['wishlist' => $wishlist]);

        return response()->json([
            'success' => true,
            'message' => 'Added to wishlist!',
            'count' => count($wishlist)
        ]);
    }

    /**
     * Remove product from wishlist
     */
    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $wishlist = session()->get('wishlist', []);
        $productId = $request->input('id');

        if (isset($wishlist[$productId])) {
            unset($wishlist[$productId]);
            session(['wishlist' => $wishlist]);

            return response()->json([
                'success' => true,
                'message' => 'Removed from wishlist!',
                'count' => count($wishlist)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in wishlist!'
        ]);
    }

    /**
     * Move item from wishlist to cart
     */
    public function moveToCart(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $wishlist = session()->get('wishlist', []);
        $cart = session()->get('cart', []);
        $productId = $request->input('id');

        if (isset($wishlist[$productId])) {
            $item = $wishlist[$productId];
            
            // Add to cart
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => 1
                ];
            }

            // Remove from wishlist
            unset($wishlist[$productId]);

            session(['wishlist' => $wishlist, 'cart' => $cart]);

            return response()->json([
                'success' => true,
                'message' => 'Moved to cart!',
                'wishlist_count' => count($wishlist),
                'cart_count' => count($cart)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in wishlist!'
        ]);
    }

    /**
     * Clear entire wishlist
     */
    public function clear()
    {
        session()->forget('wishlist');

        return redirect()->route('wishlist.index')
            ->with('success', 'Wishlist cleared successfully!');
    }
}
