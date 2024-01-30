<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ViewOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('cart')->name('cart.')->middleware('auth.cart')->group(function(){
    Route::get('view-order', [ViewOrderController::class, 'index'])->name('view-order');
    Route::get('add-to-cart/{productId}/{qty?}',[CartController::class, 'addProductToCart'])->name('add-to-cart');
    Route::get('/', [CartController::class,'index'])->name('index');
    Route::get('delete-product-in-cart/{productId}',[CartController::class,'deleteProductIncart'])->name('delete-product-in-cart');
    Route::get('delete-all-cart',[CartController::class,'deleteAllcart'])->name('delete-all-cart');
    Route::get('update-product-in-cart/{productId}/{qty?}',[CartController::class,'updateProductIncart'])->name('update-product-in-cart');
    Route::get('checkout', [OrderController::class,'index'])->name('checkout');
    Route::get('callback-vnpay', [CartController::class, 'callBackVnpay'])->name('callback-vnpay');
    Route::post('place-order',[CartController::class,'placeOrder'])->name('place-order');
    Route::post('form',[OrderController::class,'FormRequest'])->name('form');
    Route::post('choose-delivery', [OrderController::class,'choose_delivery'])->name('choose-delivery');
    Route::post('get-shipping-fee', [OrderController::class,'shipping_fee'])->name('get-shipping-fee');
    Route::post('calculate-fee', [OrderController::class,'calculate_fee'])->name('calculate-fee');
    Route::get('delete-shippingfee', [OrderController::class,'delete_fee'])->name('delete-shippingfee');
});

