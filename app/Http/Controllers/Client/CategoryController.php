<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BrandProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;

class CategoryController extends Controller
{

    private function applySortingAndPagination($query)
    {
        // Logic sắp xếp
        if (request()->has('sort')) {
            $sortType = request()->query('sort');

            if ($sortType == 'newest') {
                $query->orderBy('created_at', 'desc');
            }
            // Thêm các loại sắp xếp khác nếu cần
        }

        // Áp dụng filter thông qua Pipeline
        $pinelines = [
            \App\Filters\ByKeyword::class,
            \App\Filters\ByMinMax::class,
        ];
        $pineline = Pipeline::send($query)
            ->through($pinelines)
            ->thenReturn();

        // Lấy giá trị min và max từ truy vấn riêng biệt
        $minPrice = $query->min('price');
        $maxPrice = $query->max('price');

        // Lấy kết quả sau khi áp dụng filter và phân trang
        $products = $pineline->paginate(8);

        return compact('products', 'maxPrice', 'minPrice');
    }
    public function index(){
        // Tạo truy vấn từ model Product
        $query = Product::query();

        // Gọi hàm áp dụng sắp xếp và phân trang
        $data = $this->applySortingAndPagination($query);

        // Trả về view với dữ liệu
        return view('client.pages.shop.shop-list', $data);
    }
    public function product($slug){
        $productCategories = ProductCategory::where('slug',$slug)->first();
        $query = Product::where('product_category_id', $productCategories->id);
        $data = $this->applySortingAndPagination($query);

        return view('client.pages.shop.shop-list', $data);
    }

    public function brand($slug){
        $brandProducts = BrandProduct::where('slug',$slug)->first();
        $query = Product::where('brand_product_id', $brandProducts->id);
        $data = $this->applySortingAndPagination($query);

        return view('client.pages.shop.shop-list', $data);
    }

    public function product_detail($slug){
        $product = Product::where('slug', $slug)->first();
        $preview = Product::where('slug', $slug)->where('slug','=',$product->slug)->first();
        $related = Product::where('product_category_id',$product->product_category_id)->where('id','!=',$product->id)->get();
        return view('client.pages.shop.shop-detail',compact('product','related','preview'));

    }

}
