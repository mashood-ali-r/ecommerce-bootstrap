<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_visible', true)->latest()->take(8)->get();
        $categories = Category::whereNull('parent_id')->with('children')->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}
