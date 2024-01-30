@extends('admin.layout.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manager Order</li>
                        <li class="breadcrumb-item active">Order</li>
                        <li class="breadcrumb-item active">Order Detail</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <form role="form" action="{{ route('admin.manage_order.update',['id'=> $manages->id]) }}" method="post">
                        @csrf
                        <h6 class="mb-4" style="font-size:30px; ">Information Order
                            <div class="float-end">
                                <button type="submit" class="btn btn-primary">Update Order</button>
                            </div>
                        </h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">City</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $manages->id }}</th>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm" id="customer_name" value="{{ $manages->customer_name }}" name="customer_name">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm" id="phone" value="{{ $manages->phone }}" name="phone">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-sm" id="email" value="{{ $manages->email }}" name="email">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm" id="address" value="{{ $manages->address }}" name="address">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm" id="town" value="{{ $manages->town }}" name="town">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <h6 style="font-size:30px;">Information Product</h6>
                        <form method="POST" action="{{ route('admin.manage_order.add_product',['order_id' => $manages->id ]) }}" class="d-flex align-items-end">
                            @csrf
                            <div class="me-3">
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="product_id"  id="product_id">
                                    <option value=""> ---Select ---</option>
                                    @foreach ( $products as $product )
                                        <option value="{{ $product->id }}" data-category-id="{{ $product->product_category_id }}" data-brand-id="{{ $product->brand_product_id }}">{{ $product->name }} - {{ number_format($product->price, 0, ',', '.') }} VND -- {{ $product->product_category_id }} -- {{ $product->brand_product_id }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="category_id" id="category_id" value="">
                                <input type="hidden" name="brand_id" id="brand_id" value="">
                            </div>
                            <div class="me-3">
                                <input type="text" class="form-control form-control-sm" id="qty" value="1" name="qty">
                            </div>
                            <button type="submit" class="btn btn-primary">Add to Order</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">brand</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($manages->order_items as $order_item)
                                    @php
                                        $total = $order_item->price * $order_item->qty;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $order_item->product_id}}</th>
                                        <td>{{ $order_item->name}}</td>
                                        <td>{{ $order_item->category->name }}</td>
                                        <td>{{ $order_item->brand->name }}</td>
                                        <td>{{ $order_item->qty}}</td>
                                        <td>{{ number_format($order_item->price, 0, ',', '.')}} VND</td>
                                        <td>{{ number_format($total, 0, ',', '.') }} VND</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4" style="font-size:30px; ">Payment</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Shipping Fee</th>
                                <th scope="col">Total (shipping + product)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalBalance = $manages->total;
                                $shippingFee = $manages->shipping_fee;


                                $total = $totalBalance + $shippingFee;
                            @endphp
                                <tr>
                                    <td>{{ $manages->payment_method }}</td>
                                    <td>{{ number_format($manages->shipping_fee, 0, ',', '.') }} VND</td>
                                    <td>{{ number_format($total, 0, ',', '.') }} VND</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="row mb-4">
                        <div class="col-6">
                            <h6 class="mb-4" style="font-size:30px;">Status</h6>
                        </div>
                        <div class="col-6 text-end">
                            @if (strtolower($manages->status) === 'pending')
                                <form method="POST" action="{{ route('admin.manage_order.confirm', ['id' => $manages->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Confirm Order</button>
                                </form>
                            @endif
                            @if ($manages->status === 'Shipping')
                                <div class="" style=" display:flex; width:350px;">
                                    <div class="" style="margin-right: 5px;">
                                        <form method="POST" action="{{ route('admin.manage_order.complete', ['id' => $manages->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Complete Order</button>
                                        </form>
                                    </div>
                                    <div class="">
                                        <form >
                                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">
                                @php
                                    $orderStatus = $manages->status;
                                @endphp

                                @if ($orderStatus === 'Completed' || $orderStatus === 'Cancelled')
                                    @if ($orderStatus === 'Completed')
                                        Completed Date
                                    @elseif ($orderStatus === 'Cancelled')
                                        Cancelled Date
                                    @endif
                                @else
                                    Delivery Date
                                @endif</th>
                                <th scope="col">Status Order</th>
                                <th scope="col">Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @if ($manages->status === 'Completed')
                                        {{ $manages->completed_at }}
                                    @elseif ($manages->status === 'Cancelled')
                                        {{ $manages->cancelled_at }}
                                    @else
                                        {{ $manages->delivery_date }}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $orderStatus = $manages->status;
                                        $statusClass = ($orderStatus === 'Pending') ? 'danger' : (($orderStatus === 'Completed') ? 'Success' : 'Warning');
                                    @endphp

                                    <a class="btn btn-{{ $statusClass }}">
                                        {{ ucfirst($orderStatus) }}
                                    </a>
                                </td>
                                <td>{{ $manages->note }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-custom')
    <script>
            document.getElementById('product_id').addEventListener('change', function () {
            var selectedProduct = this.options[this.selectedIndex];
            document.getElementById('category_id').value = selectedProduct.getAttribute('data-category-id');
            document.getElementById('brand_id').value = selectedProduct.getAttribute('data-brand-id');
        });
    </script>
@endsection
