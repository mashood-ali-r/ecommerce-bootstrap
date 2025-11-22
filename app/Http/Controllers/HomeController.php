<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Get featured products
        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        // Get new arrivals
        $newProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_new', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Get flash deals
        $flashDeals = Product::with('category')
            ->where('is_active', true)
            ->where('is_flash_deal', true)
            ->whereNotNull('old_price')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get active categories with product count
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        return view('home', compact('featuredProducts', 'newProducts', 'flashDeals', 'categories'));
    }
}
