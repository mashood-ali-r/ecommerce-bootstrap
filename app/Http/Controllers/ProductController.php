<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhere('sku', 'like', "%{$searchTerm}%");
            });
        }

        // Price range filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->withCount('products')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment views
        $product->incrementViews();

        // Get related products from same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Search products (AJAX)
     */
    public function search(Request $request)
    {
        $searchTerm = $request->get('q', '');

        // For AJAX requests, return JSON
        if ($request->has('ajax') || $request->ajax()) {
            if (strlen($searchTerm) < 2) {
                return response()->json([]);
            }

            $query = Product::with('category')->where('is_active', true)
                ->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('sku', 'like', "%{$searchTerm}%")
                        ->orWhere('description', 'like', "%{$searchTerm}%");
                });

            // Filter by category slug if provided
            if ($request->has('category') && $request->category != '') {
                $category = Category::where('slug', $request->category)->first();
                if ($category) {
                    // Include children categories
                    $categoryIds = [$category->id];
                    $childIds = Category::where('parent_id', $category->id)->pluck('id')->toArray();
                    $categoryIds = array_merge($categoryIds, $childIds);
                    $query->whereIn('category_id', $categoryIds);
                }
            }

            $products = $query->limit(10)->get();

            // Format response with image and category
            $results = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'image' => $product->image ? asset('storage/' . $product->image) : null,
                    'category_name' => $product->category ? $product->category->name : null,
                ];
            });

            return response()->json($results);
        }

        // For regular form submission, redirect to products index with search
        return redirect()->route('products.index', [
            'search' => $searchTerm,
            'category' => $request->get('category', '')
        ]);
    }
}
