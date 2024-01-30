<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckOutRequest;
use App\Models\City;
use App\Models\FeeShip;
use App\Models\Province;
use App\Models\User;
use App\Models\Wards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    public function index(){
        $cart = session()->get('cart') ?? [];
        $cities = City::orderby('matp','ASC')->get();
        return view('client.pages.shop.check-out', compact('cart','cities'));
    }
    public function FormRequest(StoreCheckOutRequest $request){
        $input = $request->validated();
        User::create($input);
        return redirect()->route('cart.checkout');
    }
    public function choose_delivery(Request $request)
    {
        $data = $request->all();
        if (isset($data['action'])) {
            $output = '';
            if ($data['action'] == "city") {
                $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
                    $output .= '<option> Select Province </option>';
                foreach ($select_province as $province) {
                    $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
                }
            } else {
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
                $output .= '<option> Select Wards </option>';
                foreach ($select_wards as $ward) {
                    $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
                }
            }

            return response()->json(['output' => $output]);
        }
    }
    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $feeship = FeeShip::where('fee_matp', $data['matp'])
                ->where('fee_maqh', $data['maqh'])
                ->where('fee_xaid', $data['xaid'])
                ->first();
            if ($feeship) {
                Session::put('fee', $feeship->shipping_fee);
                Session::save();
            }
        }
    }
    public function delete_fee(){
        Session::forget('fee');
        return back();
    }
}
