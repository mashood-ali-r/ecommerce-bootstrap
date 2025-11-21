<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as ShopProductController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products page
Route::get('/products', [ShopProductController::class, 'index'])->name('products.index');

// Product show page
Route::get('/products/{product}', [ShopProductController::class, 'show'])->name('products.show');

// Product search
Route::get('/products/search', [ShopProductController::class, 'search'])->name('products.search');

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
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');

// Add to wishlist
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');

// Remove from wishlist
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');

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
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::delete('products/images/{image}', [ProductController::class, 'destroyImage'])->name('products.images.destroy');
});
