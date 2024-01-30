<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewOrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $customerorders = Order::where('user_id', $user->id)->with('order_items.product')->get();
        return view('client.pages.order.view', compact('customerorders'));
    }
}
