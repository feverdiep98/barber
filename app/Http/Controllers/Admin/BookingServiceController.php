<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
class BookingServiceController extends Controller
{
    public function index(){
        $pinelines = [
            \App\Filters\ByKeyword::class,
        ];
        $pineline = Pipeline::send(BookingService::query())
        ->through($pinelines)
        ->thenReturn();
        $booking_services= $pineline->paginate(config('myconfig.item_per_page'));
        return view('admin.booking_service.list', compact('booking_services'));
    }

    public function create(){
        return view('admin.booking_service.create');
    }

    public function store(Request $request){
        $booking = BookingService::create([
            'name' => $request->name,
            'price' => $request->price,
            'short_description' => $request->short_description,
            'status' => $request->status,
        ]);
        $msg = $booking ? 'Create Product Success': 'Create Product Failed';
        return redirect()->route('admin.booking_service.index')->with('message',$msg);
    }

    public function delete($id){
        $check = BookingService::where('id',$id)->delete();

        $msg = $check ? 'Delete Product Success': 'Delete Product Failed';
        return redirect()->route('admin.booking_service.index')->with('message',$msg);
    }
    public function deleteAll(Request $request){
        $ids = $request->input('id',[]);;
        foreach($ids as $id){
            $check = BookingService::where('id', $id)->delete();
        }
        $msg = $check ? 'Delete Customer Success': 'Delete Customer Failed';
        return redirect()->route('admin.booking_service.index')->with('message',$msg);
    }
    public function detail($id){
        $booking = BookingService::find($id);
        return view('admin.booking_service.detail',compact('booking'));
    }


    public function update($id, Request  $request){
        $check= BookingService::where('id',$request->id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'short_description' => $request->short_description,
            'status' => $request->status,
        ]);
        $msg = $check ? 'Update Product Success': 'Update Product Failed';
        return redirect()->route('admin.booking_service.index')->with('message',$msg);
    }
}
