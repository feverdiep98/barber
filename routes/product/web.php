<?php

use App\Http\Controllers\Client\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/category/{slug}',[CategoryController::class,'product'])->name('category');
Route::get('/brand/{slug}',[CategoryController::class,'brand'])->name('brand');
Route::get('shop-list', [CategoryController::class, 'index'])->name('shop-list');
Route::get('shop-detail/{slug}',[CategoryController::class,'product_detail'])->name('product_detail');
