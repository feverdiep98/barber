<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BookingService;
use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index(){
        //get 8 latest Product
        $products = Product::latest()->take(4)->get();
        //get 10 product category latest + child >0
        // $productCategories = ProductCategory::latest()->get()->filter(function($productCategory){
        //     return $productCategory->products->count() > 0;
        // })->take(10);
        $services = BookingService::where('status', 1)->get();
        return view('client.pages.home.home', compact('products', 'services'));
    }

    public function home(){
        die('123');
    }
}
