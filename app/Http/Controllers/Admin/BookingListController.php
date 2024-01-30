<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Slot;
use Illuminate\Http\Request;

class BookingListController extends Controller
{
    public function index(Request $request){
        $booking_lists = Booking::paginate(config('myconfig.item_per_page'));
        return view('admin.booking_list.list', compact('booking_lists'));
    }

    public function create(){
        return view('admin.booking_list.create');
    }

    public function store(Request $request){
        $booking = Booking::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type,
            'number' => $request->number,
            'booking_date' => $request->booking_date,
            'note' => $request->note,
        ]);
        $msg = $booking ? 'Create Customer Success': 'Create Customer Failed';
        return redirect()->route('admin.booking_list.list')->with('message',$msg);
    }

    public function delete($id){
        $check = Booking::where('id',$id)->delete();

        $msg = $check ? 'Delete Customer Success': 'Delete Customer Failed';
        return redirect()->route('admin.booking_list.list')->with('message',$msg);
    }

    public function deleteAll(Request $request){
        $ids = $request->id;
        foreach($ids as $id){
            $check = Booking::where('id', $id)->delete();
        }
        $msg = $check ? 'Delete Customer Success': 'Delete Customer Failed';
        return redirect()->route('admin.booking_list.list')->with('message',$msg);
    }

    public function detail($id){
        $booking = Booking::find($id);
        $service = $booking->services;
        $bookingservice = BookingService::where('status' ,1)->get();
        return view('admin.booking_list.detail',compact('booking','bookingservice','service'));
    }


    public function update($id, Request  $request){
        $check= Booking::where('id',$request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type,
            'number' => $request->number,
            'booking_date' => $request->booking_date,
            'note' => $request->note,
        ]);
        $msg = $check ? 'Update Booking Success': 'Update Booking Failed';
        return redirect()->route('admin.booking_list.list')->with('message',$msg);
    }
}
