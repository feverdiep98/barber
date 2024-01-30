<?php

namespace App\Http\Controllers\Client;

use App\Events\OrderSuccessEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Repositories\ProductRepository;
use App\Http\Requests\CheckOutRequest;
use App\Http\Requests\StoreCheckOutRequest;
use App\Http\Services\VnpayService;
use App\Models\BrandProduct;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPaymentMethod;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Validator;
class CartController extends Controller
{
    private $vnpayService;
    private $productRespository;
    public function __construct( VnpayService $vnpayService, ProductRepository $productRepository){
        $this->productRespository = $productRepository;
        $this->vnpayService = $vnpayService;
    }
    public function index(){
        $cart = session()->get('cart') ?? [];
        //session()->forget('cart');
        // $product = $this->productRespository->getTopProducts(5);
        return view('client.pages.shop.shopping-cart', compact('cart'));
    }
    public function addProductToCart($productId, $qty = 1){
        $product = Product::find($productId);
        if($product){
            $cart = session()->get('cart') ?? [];
            $imageLink = is_null($product->image_url) || !file_exists("images/" .$product->image_url) ? 'default-images.png' : $product->image_url;

            $cart[$product->id] = [
                'name'=> $product->name,
                'price' => $product->price,
                'image_url'=> asset('images/'.$imageLink),
                'qty'=> ($cart[$productId]['qty'] ?? 0) + $qty
            ];
            //Add cart into session
            session()->put('cart',$cart);
            $totalProduct = count($cart);
            $totalPrice = $this->calculateTotalPrice($cart);

            return response()->json(['message' => 'Add Product Success', 'total_product' => $totalProduct, 'total_price' => $totalPrice]);
        }else{
            return response()->json(['message' => 'Add product Fail!'], Response::HTTP_NOT_FOUND);
        }

    }
    public function calculateTotalPrice(array $cart){
        $totalPrice = 0;
        foreach($cart as $item){
            $totalPrice += ((int)$item['qty'] * (int)$item['price']);
        }
        return number_format($totalPrice);
    }

    public function deleteProductIncart($productId){
        $cart = session()->get('cart') ?? [];
        if(array_key_exists($productId, $cart)){
            unset($cart[$productId]);
            session()->put('cart',$cart);
        }else{
            return response()->json(['message' => 'Add product Fail!'], Response::HTTP_NOT_FOUND);
        }
        $totalProduct = count($cart);
        $totalPrice = $this->calculateTotalPrice($cart);
        return response()->json(['message' => 'Add Product Success', 'total_product' => $totalProduct, 'total_price' => $totalPrice]);
    }

    public function updateProductInCart($productId, $qty){
        $cart = session()->get('cart') ?? [];
        if(array_key_exists($productId, $cart)){
            $cart[$productId]['qty'] = $qty;
            if(!$qty){
                unset($cart[$productId]);
            }
            session()->put('cart',$cart);
        }
        $totalProduct = count($cart);
        $totalPrice = $this->calculateTotalPrice($cart);
        return response()->json(['message' => 'Update Product Success', 'total_product' => $totalProduct, 'total_price' => $totalPrice]);
    }

    public function deleteAllcart(){
        session()->put('cart', []);
        return response()->json(['message' => 'Delete Product Success', 'total_product' => 0, 'total_price' => 0]);
    }
    public function placeOrder(Request $request){
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:15', // Có thể thay đổi tùy theo định dạng số điện thoại
            'address' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'note' => 'nullable|string',
            'gender' => 'required|in:male,female',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try{
            DB::beginTransaction();

            $cart = session()->get('cart',[]);
            $fee = Session::has('fee') ? Session::get('fee') : 0;
            $totalPrice = 0;
            foreach($cart as $item){
                $totalPrice += (int)$item['qty'] * (int)$item['price'];
            }
            $total = $totalPrice + $fee;
            //create record order
            $order = Order::create([
                'customer_name'=>$request->customer_name,
                'email'=> $request->email,
                'customer_phone'=> $request->customer_phone,
                'user_id' => Auth::user()->id,
                'address' => $request->address,
                'town' => $request->town,
                'note' => $request->note,
                'gender' =>$request->gender,
                'payment_method' => $request->payment_method,
                'status' => Order::STATUS_PENDING,
                'delivery_date' => now()->addDays(3)->toDateTimeString(),
                'shipping_fee' => $fee,
                'total' => $total,
            ]);

            //create record order items
            foreach ($cart as $productId => $item){
                $product = Product::find($productId);
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'name' => $item['name'],
                    'category_id' => $product->category->id,
                    'brand_id' => $product->brand->id,
                ]);
            }

            //create record into table orderpaymentmethod
            $orderPaymentMethod = OrderPaymentMethod::create([
                'order_id' => $order->id,
                'payment_provider' => $request->get('payment_method'),
                'total_balance' => $totalPrice,
                'status' => OrderPaymentMethod::STATUS_PENDING,

            ]);
            $user = User::find(Auth::user()->id);
            $user->save();
            session()->put('cart',[]);
            if(in_array($request->payment_method, ['vnpay_atm', 'vnpay_credit'])){
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $vnp_TxnRef = $order->id; //Mã giao dịch thanh toán tham chiếu của merchant
                $vnp_Amount = $order->total; // Số tiền thanh toán
                $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
                $vnp_BankCode = 'VNBANK'; //Mã phương thức thanh toán
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán
                $vnp_Returnurl = route('cart.callback-vnpay');

                $startTime = date("YmdHis");
                $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => "HG4IWDR6",
                    "vnp_Amount" => $vnp_Amount * 100 ,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                    "vnp_OrderType" => "other",
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                    "vnp_ExpireDate" => $expire
                );

                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }
                $vnp_Url = env('VNP_URL'). "?" . $query;
                $vnpSecureHash = hash_hmac('sha512', $hashdata, env('VNP_HASHSECRET'));//
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

                $vnp_Url = $this->vnpayService->getVnpayUrl($order, $request->payment_method);
                DB::commit();
                return Redirect::to($vnp_Url);
                //redirect
            }else{
                DB::commit();
                event(new OrderSuccessEvent($order));
            }
        }catch(\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }
        return redirect()->route('home')->with('message','Order Success');
    }
    public function callBackVnpay(Request $request){

        $order = Order::find($request->vnp_TxnRef);
        if($request->vnp_ResponseCode === '00'){
            //Create event order success
            if($order){
                event(new OrderSuccessEvent($order));
            }
        }else if($request->vnp_ResponseCode === '10'){
            if($order){
                $order->status = 'cancel';
                $orderPaymentMethod = $order->order_payment_methods[0];
                $orderPaymentMethod->status = 'cancel';
                $orderPaymentMethod->note = 'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần';
            }
        }
        return redirect()->route('home')->with('message','Order Success');

    }
}
