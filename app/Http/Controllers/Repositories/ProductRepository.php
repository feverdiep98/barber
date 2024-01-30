<?php

namespace App\Http\Controllers\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository extends Controller
{
    public function getTopProducts($number = 5){
        return Product::latest()->take($number)->get();
    }
}
