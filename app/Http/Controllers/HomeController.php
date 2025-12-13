<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * HomeController
 * 
 * This is the CONTROLLER in the MVC (Model-View-Controller) architecture.
 * 
 * Key Responsibilities:
 * - Handle HTTP requests for the homepage
 * - Fetch data from Models (Product, Category)
 * - Pass data to Views (home.blade.php)
 * - Act as the "middleman" between Model and View
 * 
 * MVC Flow for Homepage:
 * 1. User visits homepage (/)
 * 2. Route (web.php) directs request to HomeController@index
 * 3. Controller fetches data from database via Models
 * 4. Controller passes data to View
 * 5. View renders HTML and sends to user's browser
 */
class HomeController extends Controller
{
    /**
     * Display the home page
     * 
     * This method handles GET requests to the homepage (/).
     * It fetches various product collections and passes them to the view.
     * 
     * Route Definition (in routes/web.php):
     *   Route::get('/', [HomeController::class, 'index'])->name('home');
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /**
         * QUERY 1: Get Featured Products
         * 
         * Eloquent Query Builder Chain:
         * - with(['category', 'primaryImage']): EAGER LOADING - prevents N+1 query problem
         * - where('is_active', true): Only show active products
         * - where('is_featured', true): Only featured products
         * - inRandomOrder(): Randomize the results for variety
         * - limit(8): Get maximum 8 products
         * - get(): Execute query and return Collection
         * 
         * SQL Generated (approximately):
         * SELECT * FROM products 
         * WHERE is_active = 1 AND is_featured = 1 
         * ORDER BY RAND() 
         * LIMIT 8
         * 
         * Eager Loading Benefit:
         * Without eager loading: 1 query for products + 8 queries for categories + 8 for images = 17 queries
         * With eager loading: 1 query for products + 1 for categories + 1 for images = 3 queries
         */
        $featuredProducts = Product::with(['category', 'primaryImage'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        /**
         * QUERY 2: Get New Arrivals
         * 
         * Similar to featured products but:
         * - Filters by is_new flag instead of is_featured
         * - Orders by created_at DESC (newest first) instead of random
         * 
         * This shows the 8 most recently added products marked as "new"
         */
        $newProducts = Product::with(['category', 'primaryImage'])
            ->where('is_active', true)
            ->where('is_new', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        /**
         * QUERY 3: Get Flash Deals
         * 
         * Complex WHERE clause using closure:
         * - Get products marked as flash_deal OR featured
         * - The closure creates: WHERE (is_flash_deal = 1 OR is_featured = 1)
         * - This allows showing featured products if no flash deals exist
         * 
         * SQL Generated:
         * SELECT * FROM products 
         * WHERE is_active = 1 
         * AND (is_flash_deal = 1 OR is_featured = 1)
         * ORDER BY created_at DESC 
         * LIMIT 6
         */
        $flashDeals = Product::with(['category', 'primaryImage'])
            ->where('is_active', true)
            ->where(function ($q) {
                // Closure allows grouping OR conditions
                $q->where('is_flash_deal', true)
                    ->orWhere('is_featured', true);
            })
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        /**
         * FALLBACK LOGIC: Ensure Flash Deals Section Has Content
         * 
         * If no products match the flash deal criteria:
         * - Get any 6 random active products
         * - Prevents empty section on homepage
         * 
         * Collection Methods:
         * - isEmpty(): Returns true if collection has no items
         */
        if ($flashDeals->isEmpty()) {
            $flashDeals = Product::with(['category', 'primaryImage'])
                ->where('is_active', true)
                ->inRandomOrder()
                ->limit(6)
                ->get();
        }

        /**
         * QUERY 4: Get Categories with Product Count
         * 
         * withCount('products'): Adds a products_count attribute to each category
         * - Performs a COUNT subquery
         * - Accessible in view as: $category->products_count
         * 
         * orderBy('sort_order'): Manual sorting (admin can set order)
         * 
         * SQL Generated:
         * SELECT *, 
         *   (SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count
         * FROM categories 
         * WHERE is_active = 1 
         * ORDER BY sort_order 
         * LIMIT 8
         */
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        /**
         * RETURN VIEW WITH DATA
         * 
         * compact() function creates an associative array:
         * compact('featuredProducts', 'newProducts', 'flashDeals', 'categories')
         * 
         * Equivalent to:
         * [
         *     'featuredProducts' => $featuredProducts,
         *     'newProducts' => $newProducts,
         *     'flashDeals' => $flashDeals,
         *     'categories' => $categories
         * ]
         * 
         * These variables are now available in the view (resources/views/home.blade.php):
         * - {{ $featuredProducts }}
         * - @foreach($newProducts as $product)
         * - etc.
         * 
         * View Rendering Process:
         * 1. Laravel finds resources/views/home.blade.php
         * 2. Blade template engine processes the file
         * 3. Variables are injected into the template
         * 4. HTML is generated and returned to browser
         */
        return view('home', compact('featuredProducts', 'newProducts', 'flashDeals', 'categories'));
    }
}
