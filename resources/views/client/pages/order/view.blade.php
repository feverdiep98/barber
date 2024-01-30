@extends('client.layout.master')
@section('content')
    <style>
        .order-container {
            display: grid;
            grid-template-columns: 7fr 3fr;
            /* Cột thứ nhất chiếm 60%, cột thứ hai chiếm 40% */
            margin-left: 50px;
            margin-right: 50px;
            margin-top: 30px;
            background: #fff;
            box-sizing: content-box;
            border-radius: 4px;
        }

        .order-details h2 {
            color: #000;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .payment-details h2 {
            color: #000;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .table-info {
        width: 80%; /* Độ rộng của bảng, có thể điều chỉnh theo ý muốn */
        margin: 30px; /* Khoảng cách từ nội dung xung quanh bảng */
        border-collapse: collapse; /* Gộp đường viền của các ô để tạo ra đường viền mảnh */
    }

    /* Định dạng cho các ô trong bảng */
    .table-info th, .table-info td {
        border: 1px solid #ddd; /* Định dạng đường viền của các ô */
        padding: 8px; /* Khoảng cách từ nội dung đến đường viền trong ô */
        text-align: left; /* Canh lề văn bản trong ô */
    }

    /* Định dạng màu nền và màu chữ cho các dòng chẵn và lẻ */
    .table-info tbody tr:nth-child(even) {
        background-color: #f2f2f2; /* Màu nền cho các dòng chẵn */
    }

    .table-info tbody tr:nth-child(odd) {
        background-color: #fff; /* Màu nền cho các dòng lẻ */
    }
    </style>
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white text-uppercase mb-3 animated slideInDown">Your Account</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="home">Home</a></li>
                    <li class="breadcrumb-item text-primary" aria-current="page">View Order</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="order-container">
        <div class="order-details">
            <!-- Nội dung cho phần đơn hàng -->
            <h2>Thông tin đơn hàng</h2>
            <div class="pb-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 p-5  mb-5">
                            <!-- Shopping cart table -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="color: #e21b5a;">
                                            <th scope="col" class="border-0 bg-dark text-center">
                                                <div class="py-2 text-uppercase">ID</div>
                                            </th>
                                            <th scope="col" class="border-0 bg-dark text-center">
                                                <div class="p-2  text-uppercase">Product</div>
                                            </th>
                                            <th scope="col" class="border-0 bg-dark text-center">
                                                <div class="py-2 text-uppercase">Price</div>
                                            </th>
                                            <th scope="col" class="border-0 bg-dark text-center">
                                                <div class="py-2 text-uppercase">Quantity</div>
                                            </th>
                                            <th scope="col" class="border-0 bg-dark text-center">
                                                <div class="py-2 text-uppercase">Total</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                            $shippingFee = 0;

                                            foreach ($customerorders as $order) {
                                                $shippingFee = $order->shipping_fee;
                                            }
                                        @endphp
                                        @foreach ($customerorders as $order)
                                            @foreach ($order->order_items as $item)
                                                @php
                                                    $total += $item->price * $item->qty;
                                                @endphp
                                                <tr>
                                                    <td class="align-middle text-center">
                                                        <strong>{{ $item->product_id }}</strong>
                                                    </td>
                                                    <th scope="row">
                                                        <div class="p-2">
                                                            @php
                                                                $imageLink = is_null($item->product->image_url) || !file_exists('images/' . $item->product->image_url) ? 'default-images.png' : $item->product->image_url;
                                                            @endphp
                                                            <img src="{{ asset('images/' . $imageLink) }}"
                                                                alt="{{ $item->product->image_url }}" width="80"
                                                                height="80" class="img-fluid rounded shadow-sm">
                                                            <div class="ml-3 d-inline-block align-middle">
                                                                <h5 class="mb-0"> <a href="#"
                                                                        class="text-dark d-inline-block">{{ $item->name }}</a>
                                                                </h5><span
                                                                    class="text-muted font-weight-normal font-italic">{{ $item->brand->name }}</span>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <td class="align-middle">
                                                        <strong>{{ number_format($item->price, 0, ',', '.') }} VND</strong>
                                                    </td>
                                                    <td class="align-middle"><strong
                                                            class="align-middle text-center">{{ $item->qty }}</strong>
                                                    </td>
                                                    <td class="align-middle"><strong
                                                            class="align-middle text-center">{{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                                            VND</strong></td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                    <tr>
                                        <td class="align-middle text-center" style="font-size:15px;"><strong
                                                class="py-2 text-uppercase">Estimate Price</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong
                                                class="align-middle text-center">{{ number_format($total, 0, ',', '.') }}
                                                VND</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center" style="font-size:15px;"><strong
                                                class="py-2 text-uppercase">Shipping fee</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong
                                                class="align-middle text-center">{{ number_format($shippingFee, 0, ',', '.') }}
                                                VND</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-center" style="font-size:15px;"><strong
                                                class="py-2 text-uppercase">Total</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong
                                                class="align-middle text-center">{{ number_format($total + $shippingFee, 0, ',', '.') }}
                                                VND</strong></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- End -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Các thông tin đơn hàng -->
        <div class="payment-details">
            <!-- Nội dung cho phần thanh toán -->
            <h2>Thông tin thanh toán</h2>
            <table class="table-info">
                <thead>
                    <tr>
                        <th class="text-middle"></th>
                        <th class="text-middle">Thông tin</th>
                    </tr>
                </thead>
                <tbody class="table-hover">
                    @foreach ($customerorders as $order)
                            <tr>
                                <td class="text-middle">Tình trạng thanh toán</td>
                                <td class="text-middle">
                                    @if ($order->payment_method === 'vnpay_atm')
                                        <strong>Paid</strong>
                                    @elseif($order->payment_method === 'COD')
                                        <strong>Unpaid (COD)</strong>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-middle">Status</td>
                                <td class="text-middle">
                                    @php
                                        $orderStatus = $order->status;
                                        $statusClass = ($orderStatus === 'pending') ? 'danger' : (($orderStatus === 'completed') ? 'success' : 'warning');
                                    @endphp

                                    <a class="btn btn-{{ $statusClass }}" style="border-radius:8px;">
                                        {{ ucfirst($orderStatus) }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-middle">tên</td>
                                <td class="text-middle">{{ $order->customer_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Address</td>
                                <td class="text-left">{{ $order->address }}</td>
                            </tr>
                            <tr>
                                <td class="text-middle">thành phố</td>
                                <td class="text-middle">{{ $order->town }}</td>
                            </tr>
                            <tr>
                                <td class="text-middle">Phone Number</td>
                                <td class="text-middle">{{ $order->phone }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Các thông tin thanh toán -->
        </div>
    </div>
@endsection
