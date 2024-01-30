<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\BrandProduct;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function combinedChart()
    {
    $totalCreatedProducts = Product::count();
    $totalCreatedServices = BookingService::count();
    $totalOrders = Order::count();
    $totalBookings = Booking::count();
    $orders = Order::with('order_items.product.brand')
        ->where('status', 'Completed')
        ->orderBy('created_at', 'desc')
        ->get();

        
    $allBrands = BrandProduct::pluck('name')->toArray();
    $productData['bar'] = array_fill_keys($allBrands, 0);

    foreach ($orders as $order) {
        foreach ($order->order_items as $item) {
            $productBrand = optional($item->product->brand)->name;

            if (!is_null($productBrand)) {
                $quantitySold = $item->qty;

                // Xử lý dữ liệu để tổng hợp số liệu
                $productData['bar'][$productBrand] += $quantitySold;

                // Kiểm tra và tổng hợp dữ liệu cho biểu đồ cột
            }
        }
    }
    $labels_product = array_keys($productData['bar']);
    $values_product = array_values($productData['bar']);
    // Lấy danh sách tất cả các dịch vụ từ bảng "services"
    $allServices = BookingService::pluck('name')->toArray();

    // Khởi tạo mảng $bookingData với giá trị mặc định là 0 cho tất cả các dịch vụ
    $bookingData = array_fill_keys($allServices, 0);

    // Lấy danh sách các đặt lịch có xác nhận từ bảng "booking" và "slot"
    $bookings = Booking::with('slot')
        ->whereHas('slot', function ($query) {
            $query->where('confirmed', 'confirmed');
        })
        ->orderBy('created_at', 'desc')
        ->get();

    // Lặp qua các đặt lịch và cập nhật dữ liệu
    foreach ($bookings as $booking) {
        // Lấy thông tin từ bảng "service"
        $serviceName = $booking->type;

        // Truy cập trực tiếp vào trường confirmed của bảng "slot"
        $quantity = $booking->slot; // Thay bằng trường phù hợp

        // Xử lý dữ liệu để tổng hợp số liệu
        if (isset($bookingData[$serviceName])) {
            $bookingData[$serviceName] += $quantity;
        } else {
            $bookingData[$serviceName] = $quantity;
        }
    }

// Lấy danh sách các dịch vụ và giá trị tương ứng
$labels_booking = array_keys($bookingData);
$values_booking = array_values($bookingData);
        $barLabels = ['Brand Quantity', 'Brand Revenue'];
        $barValues = [
            array_sum($values_product),
            array_sum($productData['bar']),
        ];
        $totalRevenue = 0;

        foreach ($orders as $order) {
            foreach ($order->order_items as $item) {
                $totalRevenue += $item->price * $item->qty;
            }
        }
        // Tổng doanh thu của tất cả các đặt lịch
        $totalBookingRevenue = 0;

        foreach ($bookings as $booking) {
            // Kiểm tra xem có mối quan hệ services hay không và services có giá trị price không
            if ($booking->services && !is_null($booking->services->price)) {
                $totalBookingRevenue += $booking->slot * $booking->services->price;
            }
        }
        $barLabels = ['Product Revenue', 'Booking Revenue'];
        $barValues = [
            $totalRevenue,
            $totalBookingRevenue
        ];
        return view('admin.dashboard.dashboard', compact('labels_product', 'values_product', 'labels_booking', 'values_booking', 'barLabels', 'barValues', 'barLabels', 'barValues','totalCreatedProducts','totalCreatedServices','totalOrders','totalBookings'));
    }
}
