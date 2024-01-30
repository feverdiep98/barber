<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\FeeShip;
use App\Models\Province;
use App\Models\Wards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ShipController extends Controller
{
    public function index(){
        $cities = City::orderby('matp','ASC')->get();
        $feeship = FeeShip::orderby('fee_id','DESC')->get();
        return view('admin.shipping.index')->with(compact('cities','feeship'));
    }
    public function select_delivery(Request $request)
    {
        $data = $request->all();
        if (isset($data['action'])) {
            $output = '';
            if ($data['action'] == "city") {
                $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
                    $output .= '<option>---Select Province---</option>';
                foreach ($select_province as $province) {
                    $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
                }
            } else {
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
                $output .= '<option>---Select Wards---</option>';
                foreach ($select_wards as $ward) {
                    $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
                }
            }

            return response()->json(['output' => $output]);
        }
    }

    public function insert_delivery(Request $request)
    {
        try {
            $data = $request->all();
            $feeship = new FeeShip();
            $feeship->fee_matp = $data['city'];
            $feeship->fee_maqh = $data['province'];
            $feeship->fee_xaid = $data['wards'];
            $feeship->shipping_fee = $data['fee_ship'];
            $feeship->save();

            // Lưu thông báo thành công vào session
            Session::flash('success', 'Shipping Fee created successfully');
        } catch (\Exception $e) {
            Log::error('Error in insert_delivery: ' . $e->getMessage());

            // Lưu thông báo lỗi vào session nếu có lỗi
            Session::flash('error', 'Internal Server Error');
        }

        // Chuyển hướng về trang index
        return redirect()->route('admin.shipping.index');
    }

    public function update_delivery(Request $request)
    {
        // Lấy giá trị shipping_fee từ request
        $shippingFees = $request->input('shipping_fee');
        $feeIds = $request->input('fee_id');

        // Kiểm tra xem mảng fee_id có tồn tại không
        if (is_array($feeIds)) {
            // Lặp qua mỗi giá trị và cập nhật dữ liệu
            foreach ($feeIds as $index => $fee_id) {
                // Kiểm tra xem chỉ mục có tồn tại trong mảng không
                if (isset($shippingFees[$index])) {
                    $fee_value = rtrim($shippingFees[$index], '.');

                    // Thực hiện cập nhật dữ liệu trong CSDL
                    FeeShip::where('fee_id', $fee_id)->update([
                        'shipping_fee' => $fee_value,
                    ]);
                }
            }
        }

        // Redirect hoặc trả về response thành công
        return redirect()->route('admin.shipping.index')->with('message', 'Cập nhật giá vận chuyển thành công');
    }
}
