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

    // Add product to cart
    public function add(Request $request)
    {
        $productId = $request->input('id');
        $productName = $request->input('name');
        $productPrice = $request->input('price');

        $cart = session()->get('cart', []);

        if(isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "name" => $productName,
                "quantity" => 1,
                "price" => $productPrice
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.view')->with('success', 'Product added to cart!');
    }

    // Remove product from cart
    public function remove(Request $request)
    {
        $id = $request->input('id'); // must match hidden input 'id' in Blade
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
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
        $quantity = max(1, (int)$request->input('quantity', 1)); // minimum quantity = 1
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity; // update the quantity
            session(['cart' => $cart]);
            return redirect()->route('cart.view')->with('success', 'Quantity updated!');
        }

        return redirect()->route('cart.view')->with('error', 'Product not found in cart.');
    }
}
