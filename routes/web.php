<?php

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PaymentLinkController;

Route::get('/', function () {
    return view('home', [
        'products' => Product::latest()->with('prices')->paginate(20),
        'cart' => count(Cart::get())
    ]);
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::post('/create-product', [ProductController::class, 'store'])->name('product.create');


Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies');
Route::post('/create-currency', [CurrencyController::class, 'store'])->name('currency.create');

Route::get('/price', [PriceController::class, 'index'])->name('price');
Route::post('/create-price', [PriceController::class, 'store'])->name('price.create');

Route::get('/paymentlink', [PaymentLinkController::class, 'index'])->name('paymentlink');
Route::post('/create-paymentlink', [PaymentLinkController::class, 'store'])->name('paymentlink.create');

Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice');
Route::post('/create-invoice', [InvoiceController::class, 'store'])->name('invoice.create');
Route::post('/resend-invoice/{invoice}', [InvoiceController::class, 'resend'])->name('invoice.resend');


Route::get('/coupon', [CouponController::class, 'index'])->name('coupon');
Route::post('/create-coupon', [CouponController::class, 'store'])->name('coupon.create');


Route::post('/add-to-cart/{price}', [CartController::class, 'store'])->name('add.cart');
Route::post('/destroy-cart', [CartController::class, 'destroy'])->name('destroy.cart');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

Route::view('/success', 'success');
Route::view('/cancel', 'cancel');