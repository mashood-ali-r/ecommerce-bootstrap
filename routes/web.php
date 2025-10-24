<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Products page
Route::get('/products', function () {
    return view('products.index');
})->name('products.index');

// Product show page
Route::get('/products/{id}', function ($id) {
    return view('products.show', compact('id'));
})->name('products.show');

// Product search
Route::get('/products/search', function () {
    return view('products.index');
})->name('products.search');

// Checkout page
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Account page
Route::get('/account', function () {
    return view('account');
})->name('account');

// Wishlist page
Route::get('/wishlist', function () {
    return view('wishlist');
})->name('wishlist');

// Add to wishlist
Route::post('/wishlist/add', function (Request $request) {
    $wishlist = session('wishlist', []);
    $productId = $request->input('id');
    $productName = $request->input('name');
    $productPrice = $request->input('price');
    
    if (!isset($wishlist[$productId])) {
        $wishlist[$productId] = [
            'id' => $productId,
            'name' => $productName,
            'price' => $productPrice,
            'added_at' => now()
        ];
        session(['wishlist' => $wishlist]);
        return response()->json(['success' => true, 'message' => 'Added to wishlist!']);
    }
    
    return response()->json(['success' => false, 'message' => 'Already in wishlist!']);
})->name('wishlist.add');

// Remove from wishlist
Route::post('/wishlist/remove', function (Request $request) {
    $wishlist = session('wishlist', []);
    $productId = $request->input('id');
    
    if (isset($wishlist[$productId])) {
        unset($wishlist[$productId]);
        session(['wishlist' => $wishlist]);
        return response()->json(['success' => true, 'message' => 'Removed from wishlist!']);
    }
    
    return response()->json(['success' => false, 'message' => 'Item not found in wishlist!']);
})->name('wishlist.remove');

// Categories page
Route::get('/categories', function () {
    return view('categories');
})->name('categories');

// Deals page
Route::get('/deals', function () {
    return view('deals');
})->name('deals');

// Newsletter subscription
Route::post('/newsletter/subscribe', function () {
    return back()->with('success', 'Thank you for subscribing!');
})->name('newsletter.subscribe');


// 🛒 Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'view'])->name('cart.view');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update'); // <-- no extra cart/
});
