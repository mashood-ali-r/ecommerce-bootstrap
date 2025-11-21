<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('is_visible', true);

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $products->where('category_id', $category->id);
        }

        if ($request->has('search')) {
            $products->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $products->paginate(12);
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function search(Request $request)
    {
        $products = Product::where('is_visible', true)
            ->where('name', 'like', '%' . $request->search . '%')
            ->paginate(12);

        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('products.index', compact('products', 'categories'));
    }
}
