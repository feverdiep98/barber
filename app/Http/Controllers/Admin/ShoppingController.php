<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\BrandProduct;
use App\Models\Models\ImgProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Http\UploadedFile;
class ShoppingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pinelines = [
            \App\Filters\ByKeyword::class,
            \App\Filters\ByStatus::class,
            \App\Filters\ByMinMax::class,
        ];
        $pineline = Pipeline::send(Product::query()->withTrashed())
        ->through($pinelines)
        ->thenReturn()->orderBy('id', 'DESC');
        $products = $pineline->paginate(config('myconfig.item_per_page'));
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');
        return view('admin.shopping_details.list',['products' => $products , 'maxPrice' => $maxPrice , 'minPrice' => $minPrice]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $productCategories = ProductCategory::where('status',1)->get();
        $brandproducts = BrandProduct::where('status',1)->get();
        return view('admin.shopping_details.create')->with('productCategories',$productCategories)->with('brandproducts',$brandproducts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $originName = $image->getClientOriginalName();
                $galleryName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $galleryName = $galleryName . '_' . time() . '.' . $extension;
                $image->move(public_path('images'), $galleryName);
                $gallery[] = 'images/' . $galleryName;
            }
        }

        $fileName= null;
        if($request->hasFile('image_url')){
            $originName = $request->file('image_url')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('image_url')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('image_url')->move(public_path('images'),$fileName);
        }
        $galleryJson = json_encode($gallery);
        //Eloquent ORM
        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'information' => $request->information,
            'qty' => $request->qty,
            'shipping' => $request->shipping,
            'weight' => $request->weight,
            'status' => $request->status,
            'image_url' => $fileName,
            'gallery' => $galleryJson,
            'brand_product_id' =>$request->brand_product_id,
            'product_category_id' =>$request->product_category_id,
        ]);
        $msg = $product ? 'Create Product Success': 'Create Product Failed';
        return redirect()->route('admin.shopping_details.index')->with('message',$msg);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $product = Product::find($id);
        $listCategory = ProductCategory::where('status',1)->get();
        $productCategories = $product->category;
        $brandproducts = $product->brand;
        $listBrand = BrandProduct::where('status' ,1)->get();
        return view('admin.shopping_details.detail',['product'=>$product,'productCategories'=>$productCategories,'listCategory' => $listCategory, 'brandproducts'=>$brandproducts,'listBrand' => $listBrand]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        die('123');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if(isset($request->image_url)){
            $fileName= $product->image_url;
            if($request->hasFile('image_url')){
                $originName = $request->file('image_url')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('image_url')->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;
                $request->file('image_url')->move(public_path('images'),$fileName);

                //Remove old images
                if (!is_null($product->image_url) && file_exists("images/" . $product->image_url)){
                    unlink("images/" . $product->image_url);
                }
            }
            $check= $product->where('id',$request->id)->update([
                'image_url' => $fileName,
            ]);
        }

        // Xử lý trường gallery
        if ($request->hasFile('gallery') && isset($request->gallery)) {
            $gallery = $product->gallery ?? [];

            foreach ($request->file('gallery') as $image) {
                $originName = $image->getClientOriginalName();
                $galleryName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $galleryName = $galleryName . '_' . time() . '.' . $extension;
                $image->move(public_path('images'), $galleryName);
                $gallery[] = 'images/' . $galleryName;
            }

            $check = $product->where('id', $request->input('id'))->update([
                'gallery' => $gallery,
                // Các trường khác mà bạn muốn cập nhật cùng với gallery
            ]);
        }

        $check= $product->where('id',$request->id)->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'information' => $request->information,
            'qty' => $request->qty,
            'shipping' => $request->shipping,
            'weight' => $request->weight,
            'status' => $request->status,
            'product_category_id' =>$request->product_category_id,
            'brand_product_id' =>$request->brand_product_id,
        ]);
        $msg = $check ? 'Update Product Success': 'Update Product Failed';
        return redirect()->route('admin.shopping_details.index')->with('message',$msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $check = $product->delete();

        $msg = $check ? 'Delete Product Success': 'Delete Product Failed';
        return redirect()->route('admin.shopping_details.list')->with('message',$msg);

    }
    public function deleteAll(Request $request){
        $ids = $request->input('id',[]);
        foreach($ids as $id){
            $check = Product::where('id', $id)->delete();
        }
        $msg = $check ? 'Delete Customer Success': 'Delete Customer Failed';
        return redirect()->route('admin.shopping_details.index')->with('message',$msg);
        // $ids = $request->id;
        // $check= Product::whereIn('id',explode(",",$ids))->delete();
        // $msg = $check ? 'Delete Customer Success': 'Delete Customer Failed';
        // return redirect()->route('admin.shopping_details.index')->with('message',$msg);
    }
    public function getslug(Request $request){
        $slug = Str::slug($request->name);
        return response()->json(['slug' => $slug]);
   }
   public function restore( $product){
        //find all
        $product = Product::withTrashed()->find($product);
        $product->restore();
        return redirect()->route('admin.shopping_details.index')->with('message','Restore success');
   }

   public function uploadImage(Request $request){
        if($request->hasFile('image_url')){
            $originName = $request->file('image_url')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('image_url')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('image_url')->move(public_path('images'),$fileName);

            $url = asset('images/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }
}
