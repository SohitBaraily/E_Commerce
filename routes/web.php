<?php

use App\Http\Controllers\Frontend\GoogleLoginController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\UserController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return redirect()->route('home');
});
Route::get('/', [PageController::class, 'home'])->name('home');
Route::post('/vendor-request', [PageController::class, 'vendor_request'])->name('vendor_request');
Route::get('/shop/{id}', [PageController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [PageController::class, 'product'])->name('product');
Route::get('/compare', [PageController::class, 'compare'])->name('compare');

Route::middleware(['auth'])->group(function () {
    Route::post('/add-to-cart', [UserController::class, 'add_to_cart'])->name('add_to_cart');
    Route::get('/carts', [UserController::class, 'carts'])->name('carts');
    Route::get('/checkout/{id}', [UserController::class, 'checkout'])->name('checkout');
    Route::post('/order_store/{id}', [UserController::class, 'order_store'])->name('order_store');

    Route::get('/khalti', [UserController::class, 'khalti']);

    Route::get('/success', [UserController::class, 'success'])->name('success');
    Route::get('/failure', [UserController::class, 'failure'])->name('failure');
});
Route::get('/details/{record}', function ($record) {
    $order = Order::findOrFail($record);
    return view('order_details', compact('order'));
})->name('details');

Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');
Route::fallback(function () {
    return view('error.404');
});
