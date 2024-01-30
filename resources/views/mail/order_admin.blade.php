<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">

    <div style="max-width: 600px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 8px;">

        <div style="background-color: #333; height: 300px; max-width: 600px; margin: 0 auto; text-align: center; border-radius: 8px;">
            <i class="fa-solid fa-circle-check" style="color: #e23d75; font-size: 100px; margin-top: 50px;"></i>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <h1>Cảm ơn bạn đã mua hàng!</h1>
            <p>Xin chào {{ $order->customer_name }}, Chúng tôi đã nhận được đặt hàng của bạn và đã sẵn sàng để vận chuyển. Chúng tôi sẽ thông báo cho bạn khi đơn hàng được gửi đi.</p>

            <a href="#" style="text-decoration: none;">
                <button style="background-color: #e23d75; color: #fff; font-size: 25px; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer; margin-right: 10px;">View Order</button>
            </a>

            <span style="font-size: 16px;">Or</span>

            <a href="{{ route('home') }}" style="color: #005bc5; text-decoration: none; font-size: 16px;">Our Shop</a>
        </div>

        <div style="margin-top: 20px;">
            @php $totalPrice = 0 @endphp
            <h2 style="text-align: center; padding-top: 20px;">Thông tin đơn hàng</h2>

            @foreach ($order->order_items as $item)
                @php
                    $orderPrice = str_replace(',', '', $item['price']);
                    $totalProductPrice = $orderPrice * $item['qty'];
                    $totalPrice += $totalProductPrice;
                @endphp
                <div style="display: flex; align-items: center;">
                    @if ($item->product)
                        <img src="{{ $item->product->image_url }}" alt="" height="130px" width="120px" style="margin-right: 20px;">
                    @endif
                    <div>
                        <h4 style="font-weight: bold; margin: 0;">Order Number: {{ $item->order_id }}</h4>
                        <p style="font-weight: bold; margin: 0;">{{ $item->name }} X {{ $item->qty }}</p>
                        <p>{{ $item->brand->name }}</p>
                        <p><strong>{{ number_format($totalProductPrice, 0, ',', '.') }} VND</strong></p>
                    </div>
                </div>
            @endforeach

            <div style="text-align: center; margin-top: 20px;">
                <p style="font-weight: bold; margin: 0;">Tổng giá trị sản phẩm: {{ number_format($totalProductPrice, 0, ',', '.') }} VND</p>
                <p style="font-weight: bold; margin: 0;">Phí vận chuyển: {{ number_format($order->shipping_fee, 0, ',', '.') }} VND</p>
                <div style="height: 1px; width: 40%; margin: 10px auto; background: #ddd;"></div>
                <p style="font-weight: bold; margin: 0;">Tổng cộng: <span style="font-size: 30px;">{{ number_format($totalPrice + $order->shipping_fee, 0, ',', '.') }} VND</span></p>
            </div>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <h2>Thông tin khách hàng</h2>
            <div style="display: flex; justify-content: center;">
                <div style="margin-right: 20px;">
                    <p style="margin: 0;"><strong>Địa chỉ giao hàng:</strong> {{ $order->customer_name }}, {{ $order->town }}, {{ $order->town }}</p>
                    <p style="margin: 0;"><strong>Địa chỉ thanh toán:</strong> {{ $order->customer_name }}, {{ $order->town }}, {{ $order->town }}</p>
                </div>
                <div>
                    <p style="margin: 0;"><strong>Phương thức vận chuyển:</strong> Nội Thành Hồ Chí Minh</p>
                    <p style="margin: 0;"><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
                </div>
            </div>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <p>Nếu bạn có bất kỳ câu hỏi nào, đừng ngần ngại liên lạc với chúng tôi tại <br>
                <a href="mailto:rulermen.com@gmail.com" style="color: #005bc5; text-decoration: none;">HairCut@gmail.com</a> hoặc hotline 123456789</p>
        </div>

    </div>

</body>

</html>
