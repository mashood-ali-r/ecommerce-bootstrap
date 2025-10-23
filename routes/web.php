<?php

use Illuminate\Support\Facades\Route;
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

// Checkout page
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');


// 🛒 Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'view'])->name('cart.view');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update'); // <-- no extra cart/
});
