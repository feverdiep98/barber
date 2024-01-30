<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandProduct;
use App\Models\BrandProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Pipeline;
class BrandProductController extends Controller
{
    public function store(Request $request)
    {
        //query Builder
        $check = DB::table('brand_product')->insert([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ]);
        $msg = $check ? 'Create Brand Product Success' : 'Create Brand Product Failed';
        return redirect()->route('admin.brand.list')->with('message', $msg);
    }
    public function getslug(Request $request)
    {
        $slug = Str::slug($request->name);
        return response()->json(['slug' => $slug]);
    }

    public function index(Request $request)
    {
        $pinelines = [
            \App\Filters\ByKeyword::class,
        ];
        $pineline = Pipeline::send(BrandProduct::query())
        ->through($pinelines)
        ->thenReturn();
        $brandproducts = $pineline->paginate(config('myconfig.item_per_page'));
        return view('admin.brand.list', compact('brandproducts'));
    }
    public function create()
    {
        return view('admin.brand.create');
    }
    public function detail($id)
    {
        $brandproduct = DB::select('select * from brand_product where id = ?', [$id]);
        return view('admin.brand.detail', ['brandproduct' => $brandproduct]);
    }

    public function update(Request  $request)
    {
        $check = BrandProduct::where('id', $request->id)->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        $msg = $check ? 'Update Brand Product Success' : 'Update Brand Product Failed';
        return redirect()->route('admin.brand.list')->with('message', $msg);
    }

    public function destroy($id)
    {
        // $check = DB::table('product_category')
        // ->where('id',$id)
        // ->delete();
        //Eloquent
        $BrandProduct = BrandProduct::find($id);
        $check = $BrandProduct->delete();

        $msg = $check ? 'Delete Brand Product Success' : 'Delete Brand Product Failed';

        return redirect()->route('admin.brand.list')->with('message', $msg);
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->id;
        foreach ($ids as $id) {
            $check = BrandProduct::where('id', $id)->delete();
        }
        $msg = $check ? 'Delete Brand Product Success' : 'Delete Brand Product Failed';
        return redirect()->route('admin.brand.list')->with('message', $msg);
    }
}
