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
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Products routes
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('/products/{slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Checkout routes
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Account page
Route::get('/account', function () {
    return view('account');
})->name('account');

// Wishlist routes
Route::prefix('wishlist')->group(function () {
    Route::get('/', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/add', [App\Http\Controllers\WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/remove', [App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/move-to-cart', [App\Http\Controllers\WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
    Route::post('/clear', [App\Http\Controllers\WishlistController::class, 'clear'])->name('wishlist.clear');
});

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

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Products CRUD
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    
    // Categories CRUD
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
});

// 🛒 Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'view'])->name('cart.view');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update'); // <-- no extra cart/
});
