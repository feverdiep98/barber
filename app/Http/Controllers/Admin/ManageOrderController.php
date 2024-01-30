<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderCancelled;
use App\Events\OrderCompleted;
use App\Events\OrderConfirmed;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPaymentMethod;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManageOrderController extends Controller
{
    public function index(){
        $manages = Order::paginate(config('myconfig.item_per_page'));
        $totalQuantity = 0;

        foreach ($manages as $order){
            $totalQuantity += $order->calculateTotalQuantity();
        }
        return view('admin.manage_order.index', compact('manages','totalQuantity',));
    }

    public function detail($id){
        $products = Product::all();
        $manages = Order::with('order_items', 'order_payment_methods', 'order_items.category', 'order_items.brand')->find($id);

        if ($manages->order_items) {
            $total = $manages->order_items->sum(function ($item) {
                return $item->qty * $item->price;
            });

            // Thêm biến total vào thông tin đơn hàng
            $manages->total = $total;
        }

        return view('admin.manage_order.detail', compact('manages', 'total','products'));
    }
    public function destroy($id){
        $manages = Order::find($id);
        $check = $manages->delete();

        $msg = $check ? 'Delete Order Success': 'Delete Order Failed';

        return redirect()->route('admin.manage_order.index')->with('message',$msg);
    }

    public function deleteAll(Request $request){
        $ids = $request->input('id',[]);
        foreach($ids as $id){
            $check = Order::where('id', $id)->delete();
        }
        $msg = $check ? 'Delete Order Success': 'Delete Order Failed';
        return redirect()->route('admin.manage_order.index')->with('message',$msg);
    }
    public function complete($id){
        try{
            DB::beginTransaction();
            $order = Order::find($id);
            if($order->status === 'Shipping'){
                $order->status = 'Completed';
                $order->completed_at = now();
                $order->save();
                DB::commit();
                event(new OrderCompleted ($order));
                return redirect()->route('admin.manage_order.index')->with('success', 'Order is completed');
            }else {
                return redirect()->route('admin.manage_order.index')->with('error', 'Order cannot be completed. Current status is invalid.');
            }
        }catch (Exception $e) {
            // Xử lý exception nếu có
            DB::rollback();
            return redirect()->route('admin.manage_order.index')->with('error', 'Có lỗi xảy ra khi hoàn thành đơn hàng. Vui lòng thử lại.');
        }
    }

    public function cancel($id)
    {
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);

            if ($order->status === 'Pending') {
                $order->status = 'Cancelled';
                $order->cancelled_at = now();
                $order->save();
                DB::commit();
                event(new OrderCancelled ($order));
                return redirect()->route('admin.manage_order.index')->with('success', 'Order is cancelled');
            } else {
                return redirect()->route('admin.manage_order.index')->with('error', 'Orders cannot be canceled. Current status is invalid.');
            }
        } catch (Exception $e) {
            DB::rollback();
            // Xử lý exception nếu có
            return redirect()->route('admin.manage_order.index')->with('error', 'Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại.');
        }
    }

    public function delivery($id){
        $order = Order::find($id);
        if (!$order) {
            return view('admin.manage_order.index',['newDeliveryDate' => null]);
        }
        if(is_int($order->delivery_date)){
            $currentDeliveryDate = now()->addDays($order->delivery_date);
            if(!$order->delivery_date || now()->addDays($order->delivery_date)->isPast()){
                $order->delivery_date = now()->addDays(3);
                $order->save();
            }else{
                $order->delivery_date = now()->addDays(3);
                $order->save(); // Lưu thay đổi
            }
            $newDeliveryDate = now()->addDays($order->delivery_date);
            return view('admin.manage_order.index', ['newDeliveryDate' => $newDeliveryDate]);
        }
    }

    public function update(Request $request, $id){
        $order = Order::findOrFail($id);
        $order->update([
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'town' => $request->town,
        ]);

        $msg = $order ? 'Update Order Success':'Update Order Fail';
        return redirect()->route('admin.manage_order.index',['id' => $id])->with('message',$msg);
    }

    public function add_product( Request $request, $order_id){
        $product_id = $request->input('product_id');
        if (empty($product_id)) {
            return redirect()->route('admin.manage_order.detail', ['id' => $order_id])->with('error', 'Vui lòng chọn sản phẩm trước khi thêm vào đơn hàng.');
        }


        $category_id = $request->input('category_id'); // Thêm dòng này
        $brand_id = $request->input('brand_id');
        $qty = $request->input('qty', 1);

        $order = Order::findOrFail($order_id);
        $existingOrderItem = $order->order_items()->where('product_id', $product_id)->first();

        if($existingOrderItem){
            $existingOrderItem->qty += 1;
            $existingOrderItem->save();
        }else{
            $product = Product::with('category', 'brand')->find($product_id);
            $orderItem = new OrderItem([
                'order_id' => $order_id,
                'product_id' => $product_id,
                'name' => $product->name,
                'category_id' => $category_id,
                'brand_id' => $brand_id,
                'qty' => $qty,
                'price' => $product->price,
            ]);

            $orderItem->save();
        }
            // Kiểm tra trạng thái thanh toán
        if ($order->payment_method !== 'COD') {
            return redirect()->route('admin.manage_order.detail', ['id' => $order_id])->with('error', 'The customer has paid. Unable to add product.');
        }elseif($order->status === 'Completed' || $order->status === 'Cancelled'){
            return redirect()->route('admin.manage_order.detail', ['id' => $order_id])->with('error', 'This Order is completed or cancelled. Can not update it.');
        }

        // Tính tổng số tiền từ sản phẩm trong đơn hàng
        $orderTotalFromItems = $order->order_items->sum(function ($item) {
            return $item->qty * $item->price;
        });

        // Tính tổng số tiền cuối cùng bao gồm cả phí vận chuyển
        $totalWithShipping = $orderTotalFromItems + $order->shipping_fee;

        $order->total = $totalWithShipping;
        $order->save();

        $orderPaymentMethod = OrderPaymentMethod::where('order_id', $order_id)->first();
        $orderPaymentMethod->total_balance = $orderTotalFromItems;
        $orderPaymentMethod->save();

        return redirect()->route('admin.manage_order.index', ['id' => $order_id])->with('success', 'Add Product Success.');
    }

    public function confirm_order($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($id);

            if ($order->status === 'Pending') {
                $order->status = 'Shipping';
                $order->save();
                DB::commit();
                event(new OrderConfirmed($order));
                return redirect()->route('admin.manage_order.index')->with('success', 'Đơn hàng đã được xác nhận và chuyển sang trạng thái shipping.');
            } else {
                return redirect()->route('admin.manage_order.index')->with('error', 'Đơn hàng đã được xác nhận trước đó.');
            }

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error confirming order: ' . $e->getMessage());
            return redirect()->route('admin.manage_order.index')->with('error', 'Có lỗi xảy ra khi xác nhận đơn hàng. Vui lòng thử lại.');
        }
    }
}
