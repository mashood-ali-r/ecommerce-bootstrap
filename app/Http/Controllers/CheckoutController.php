<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Redirect to cart if empty
        if (empty($cart)) {
            return redirect()->route('cart.view')
                ->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping = 250; // Flat shipping rate
        $tax = $subtotal * 0.05; // 5% tax
        $total = $subtotal + $shipping + $tax;

        return view('checkout', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
    }

    /**
     * Process the order
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,bank_transfer,credit_card'
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')
                ->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping = 250;
        $tax = $subtotal * 0.05;
        $total = $subtotal + $shipping + $tax;

        // Store order data in session (will be saved to database later)
        $orderData = [
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $request->full_name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'shipping_address' => $request->address . ', ' . $request->city . ' - ' . $request->postal_code,
            'payment_method' => $request->payment_method,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'items' => $cart,
            'status' => 'pending',
            'created_at' => now()->toDateTimeString()
        ];

        session(['last_order' => $orderData]);
        session()->forget('cart'); // Clear cart

        return redirect()->route('checkout.success')
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Show order success page
     */
    public function success()
    {
        $order = session()->get('last_order');

        if (!$order) {
            return redirect()->route('home')
                ->with('error', 'No order found!');
        }

        return view('checkout-success', compact('order'));
    }
}
