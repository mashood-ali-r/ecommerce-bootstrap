<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Show cart page
    public function view()
    {
        $cart = session()->get('cart', []); // session key 'cart'
        return view('cart', compact('cart'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $productId = $request->input('id');
        $productName = $request->input('name');
        $productPrice = $request->input('price');
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                "name" => $productName,
                "quantity" => $quantity,
                "price" => $productPrice
            ];
        }

        session(['cart' => $cart]);

        // Return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => count($cart)
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    // Remove product from cart
    public function remove(Request $request)
    {
        $id = $request->input('id'); // must match hidden input 'id' in Blade
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
            return redirect()->route('cart.view')->with('success', 'Product removed successfully!');
        }

        return redirect()->route('cart.view')->with('error', 'Product not found in cart.');
    }

    // Update quantity in cart
    public function update(Request $request)
    {
        $id = $request->input('id'); // must match hidden input 'id' in Blade
        $quantity = max(1, (int) $request->input('quantity', 1)); // minimum quantity = 1
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session(['cart' => $cart]);

            if ($request->expectsJson()) {
                $itemSubtotal = $cart[$id]['price'] * $quantity;
                $total = 0;
                $count = 0;
                foreach ($cart as $c) {
                    $total += $c['price'] * $c['quantity'];
                    $count += $c['quantity'];
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Quantity updated',
                    'item_subtotal' => number_format($itemSubtotal),
                    'cart_total' => number_format($total),
                    'cart_count' => $count
                ]);
            }

            return redirect()->route('cart.view')->with('success', 'Quantity updated!');
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        return redirect()->route('cart.view')->with('error', 'Product not found in cart.');
    }
}
