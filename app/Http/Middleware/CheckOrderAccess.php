<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOrderAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $orderId = $request->route('id');

        // Lấy đơn hàng từ database
        $order = Order::find($orderId);

        // Kiểm tra xem người dùng có quyền xem đơn hàng không
        if ($order && Auth::check() && $order->user_id == Auth::id()) {
            return $next($request);
        }

        // Nếu không có quyền, bạn có thể chuyển hướng hoặc xử lý theo ý của bạn
        return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập đơn hàng này.');
    }
}
