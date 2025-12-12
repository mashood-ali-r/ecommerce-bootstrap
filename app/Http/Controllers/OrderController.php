<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display the user's orders.
     */
    public function index()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your orders.');
        }

        // Fetch orders for the logged-in user with their items
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Display a specific order.
     */
    public function show($orderNumber)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your order.');
        }

        // Fetch the order for the logged-in user
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with(['items.product'])
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}
