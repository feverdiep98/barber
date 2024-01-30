<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Pipeline;
class ProductCategoryController extends Controller
{
   public function store(StoreProductCategoryRequest $request){
        //query Builder
        $check = DB::table('product_category')->insert([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ]);
        $msg = $check ? 'Create Product Category Success': 'Create Product Category Failed';
        return redirect()->route('admin.shopping_category.list')->with('message',$msg);
   }
   public function getslug(Request $request){
        $slug = Str::slug($request->name);
        return response()->json(['slug' => $slug]);
   }

   public function index(Request $request){
        $pinelines = [
            \App\Filters\ByKeyword::class,
        ];
        $pineline = Pipeline::send(ProductCategory::query())
        ->through($pinelines)
        ->thenReturn();
        $product_Categories = $pineline->where('status',1)->paginate(config('myconfig.item_per_page'));
        return view('admin.shopping_category.list', compact('product_Categories'));
   }

   public function detail($id){
    $productCategory = DB::select('select * from product_category where id = ?', [$id]);
    return view('admin.shopping_category.detail',['productCategory' => $productCategory]);

   }

   public function update(UpdateProductCategoryRequest $request, string $id){
        $check = DB::table('product_category')
        ->where('id',$id)
        ->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
        ]);
        $message = $check ? 'success' : 'failed';

        return redirect()->route('admin.shopping_category.list')->with('message',$message);
   }

   public function destroy($id){
        // $check = DB::table('product_category')
        // ->where('id',$id)
        // ->delete();
        //Eloquent
        $productCategory = ProductCategory::find($id);
        $check = $productCategory->delete();

        $msg = $check ? 'Delete Product Category Success': 'Delete Product Category Failed';

        return redirect()->route('admin.shopping_category.list')->with('message',$msg);
   }
    public function deleteAll(Request $request){
        $ids = $request->id;
        foreach($ids as $id){
            $check = ProductCategory::where('id', $id)->delete();
        }
        $msg = $check ? 'Delete Customer Success': 'Delete Customer Failed';
        return redirect()->route('admin.shopping_category.list')->with('message',$msg);
    }
}
