<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function view()
    {
        $cart = $this->getCart();
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->input('id'));
        $cart = $this->getCart(true);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function remove(Request $request)
    {
        $cart = $this->getCart();
        $cart->items()->where('id', $request->input('id'))->delete();

        return redirect()->route('cart.view')->with('success', 'Product removed successfully!');
    }

    public function update(Request $request)
    {
        $cart = $this->getCart();
        $cart->items()->where('id', $request->input('id'))->update([
            'quantity' => max(1, (int)$request->input('quantity', 1)),
        ]);

        return redirect()->route('cart.view')->with('success', 'Quantity updated!');
    }

    private function getCart($create = false)
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $sessionId = Session::getId();
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }

        return $cart;
    }
}
