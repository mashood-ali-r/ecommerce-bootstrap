<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $shipping = 250;
            $tax = $subtotal * 0.05;
            $total = $subtotal + $shipping + $tax;

            // Create Order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => auth()->id(),
                'customer_name' => $request->full_name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'shipping_address' => $request->address . ', ' . $request->city . ' - ' . $request->postal_code,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
            ]);

            // Create Order Items
            foreach ($cart as $id => $item) {
                $product = Product::find($id);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $item['name'],
                    'product_sku' => $product ? $product->sku : 'N/A',
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');
            session(['last_order_id' => $order->id]);

            return redirect()->route('checkout.success')
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order placement failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to place order. Please try again. ' . $e->getMessage());
        }
    }

    /**
     * Show order success page
     */
    public function success()
    {
        $orderId = session()->get('last_order_id');

        if (!$orderId) {
            return redirect()->route('home');
        }

        $order = Order::with('items.product')->findOrFail($orderId);

        return view('checkout-success', compact('order'));
    }
}
