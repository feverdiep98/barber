@extends('client.layout.master')
@section('content')
    <div class="px-4 px-lg-0">
        <!-- For demo purpose -->
        <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container text-center py-5">
                <h1 class="display-3 text-white text-uppercase mb-3 animated slideInDown">Cart</h1>
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb justify-content-center text-uppercase mb-0">
                        <li class="breadcrumb-item"><a class="text-white" href="home">Home</a></li>
                        <li class="breadcrumb-item text-primary" aria-current="page">Shopping-cart</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End -->
        <div class="pb-5">
            <link rel="stylesheet" href="{{ asset('client/css/shop-cart.css') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

                        <!-- Shopping cart table -->
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="color: #e21b5a;">
                                        <th scope="col" class="border-0 bg-dark">
                                            <div class="p-2 px-3 text-uppercase">Product</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-dark">
                                            <div class="py-2 text-uppercase">Price</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-dark">
                                            <div class="py-2 text-uppercase">Quantity</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-dark">
                                            <div class="py-2 text-uppercase">Total</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-dark">
                                            <div class="py-2 text-uppercase">Remove</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="table-product">

                                    @php
                                        $totalPrice = 0;
                                    @endphp
                                    @foreach ($cart as $productId => $item)
                                        @php
                                        $product = \App\Models\Product::with('brand')->find($productId);
                                        @endphp
                                        <tr id="product{{ $productId }}">
                                            <th scope="row">
                                                <div class="p-2">
                                                    <img src="{{ $item['image_url'] }}" alt="" width="70"
                                                        class="img-fluid rounded shadow-sm">
                                                    <div class="ml-3 d-inline-block align-middle">
                                                        <h5 class="mb-0"> <a href="#"
                                                                class="text-dark d-inline-block">{{ $item['name'] }}</a>
                                                        </h5><span
                                                            class="text-muted font-weight-normal font-italic">
                                                            {{ $product->brand->name }}</span>
                                                    </div>
                                                </div>
                                            <td class="align-middle">
                                                <strong>{{ number_format((float) $item['price'], 0, '.', '.') }}
                                                    VND</strong>
                                            </td>
                                            <td class="align-middle">
                                                <div class="quantity">
                                                    <button class="btn minus" type="button"
                                                        onclick="totalClick(-1, {{ $productId }})">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                    <span data-id="{{ $productId }}" id="qtyInput-{{ $productId }}"
                                                        data-url="{{ route('cart.update-product-in-cart', ['productId' => $productId]) }}"
                                                        data-value="{{ $item['qty'] }}"
                                                        oninput="updateQuantity({{ $productId }})">{{ $item['qty'] }}</span>
                                                    <button class="btn plus" type="button"
                                                        onclick="totalClick(1, {{ $productId }})">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <strong>{{ number_format(str_replace(',', '.', $item['price']) * $item['qty'], 0, ',', '.') }}
                                                    VND</strong>
                                            </td>
                                            <td class="align-middle">
                                                <a href="#" class="text-dark">
                                                    <button class="delete-button"
                                                        data-url = "{{ route('cart.delete-product-in-cart', ['productId' => $productId]) }}"
                                                        data-id="{{ $productId }}">
                                                        <svg class="delete-svgIcon" viewBox="0 0 448 512">
                                                            <path
                                                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </a>
                                            </td>
                                            </th>
                                        </tr>
                                        @php
                                            $totalPrice += (int) str_replace(',', '', $item['price']) * $item['qty'];
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End -->
                        <div class="shoping__cart__btns">
                            <a href="{{ route('shop-list') }}" class="cart-btn"> CONTINUE SHOPPING</a>
                            <a href="#" data-url="{{ route('cart.delete-all-cart') }}" class="delete-cart-btn">
                                <button class="button">
                                    <svg viewBox="0 0 448 512" class="svgIcon">
                                        <path
                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                        </path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row py-5 p-4 bg-white rounded shadow-sm">
                    <div class="col-lg-6">
                        <div class="bg-dark rounded-pill px-4 py-3 text-uppercase font-weight-bold" style="color: #e21b5a;">
                            Coupon code</div>
                        <div class="p-4">
                            <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>
                            <div class="input-group mb-4 border rounded-pill p-2">
                                <input type="text" placeholder="Apply coupon" aria-describedby="button-addon3"
                                    class="form-control border-0">
                                <div class="input-group-append border-0">
                                    <button id="button-addon3" type="button" class="btn btn-dark px-4 rounded-pill"
                                        style="color: #e21b5a;"><i class="fa fa-gift mr-2" style="color: #e21b5a;"></i>
                                        Apply coupon</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-dark rounded-pill px-4 py-3 text-uppercase font-weight-bold"
                            style="color: #e21b5a;">
                            Order summary </div>
                        <div class="p-4">
                            <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you
                                have entered.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong
                                        class="text-muted total">Total:  <span>{{ number_format(intval($totalPrice), 0, '.', '.') }}VND</strong>
                                </li>
                            </ul><a href="{{ route('cart.checkout') }}" class="btn btn-dark rounded-pill py-2 btn-block"
                                style="color: #e21b5a;">Procceed to checkout</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js-custom')
    <script type="text/javascript">
        $(document).ready(function() {

            $('.delete-button').on('click', function() {
                var productId = $(this).data('id');
                var url = $(this).data('url');
                $.ajax({
                    method: 'GET', // method of form
                    url: url,
                    success: function(res) {
                        var total_price = res.total_price;
                        var total_product = res.total_product
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Add Success',
                            timer: 1500
                        });

                        $('#total_product').html(total_product);
                        $('#total_price').html('$' + total_price);
                        $('#product' + productId).empty();
                    }
                });
            });

        });

        function totalClick(change, productId) {
            let previewContainer = document.getElementById('qtyInput-' + productId);
            const totalClicks = previewContainer;
            const sumvalue = parseInt(totalClicks.innerText) + change;
            previewContainer.innerText = sumvalue;

            if (sumvalue < 0) {
                previewContainer.innerText = 0;
            }

            var test = "{{ route('cart.update-product-in-cart', '') }}/" + productId;
            var url = test + '/' + sumvalue;

            $.ajax({
                method: 'GET',
                url: url,
                success: function(res) {
                    var total_price = res.total_price;
                    var total_product = res.total_product;
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Add Success',
                        timer: 1500
                    });
                    $('#total_product').html(total_product);
                    $('#total_price').html('$' + total_price);

                    var urlCart = "{{ route('cart.index') }}";
                    var selector = "#product" + productId + " .align-middle strong";
                    var urlUpdate = urlCart + " " + selector;

                    var selectorSubtotal = '.list-unstyled .subtotal';
                    var selectorTotal = '.list-unstyled .total';
                    var urlUpdateSubtotal = urlCart + " " + selectorSubtotal;
                    var urlUpdateTotal = urlCart + " " + selectorTotal;
                    $(selectorSubtotal).load(urlUpdateSubtotal);
                    $(selectorTotal).load(urlUpdateTotal);

                    if (!total_product) {
                        $('#product' + id).empty();
                    } else {
                        location.reload(true); // Reload the page
                    }
                }
            });
        }
        // $('.quantity-input .inc-qty').on('click', function() {
        //     var button = $(this);
        //     var id = button.find('input').data('id');
        //     var oldValue = button.find('input').val();

        //     if (button.hasClass('inc')) {
        //         oldValue = parseFloat(oldValue) + 1;
        //     } else {
        //         oldValue = parseFloat(oldValue) - 1;
        //         oldValue = oldValue >= 0 ? oldValue : 0;
        //     }

        //     var url = 'cart.update-product-in-cart/' + id + '/' + oldValue;
        //     console.log(url)
        //     $.ajax({
        //         method: 'GET',
        //         url: url,
        //         success: function(res) {
        //             var total_price = res.total_price;
        //             var total_product = res.total_product;
        //             Swal.fire({
        //                 position: 'top',
        //                 icon: 'success',
        //                 title: 'Add Success',
        //                 timer: 1500
        //             });
        //             $('#total_product').html(total_product);
        //             $('#total_price').html('$' + total_price);

        //             var urlCart = "{{ route('cart.index') }}";
        //             var selector = "#product" + id + " .align-middle strong";
        //             var urlUpdate = urlCart + " " + selector;

        //             var selectorTotal = ' .list-unstyled .total';
        //             $(selector).load(urlUpdate);

        //             var urlUpdateTotal = urlCart + " " + selectorTotal;
        //             $(selectorTotal).load(urlUpdateTotal);

        //             if (!total_product) {
        //                 $('#product' + id).empty();
        //             }
        //         }
        //     });
        // });

        $('.delete-cart-btn').on('click', function() {
            var url = $(this).data('url');

            $.ajax({
                method: 'GET', // method of form
                url: url,
                success: function(res) {
                    var total_price = res.total_price;
                    var total_product = res.total_product
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Add Success',
                        timer: 1500
                    });
                    $('#total_product').html(total_product);
                    $('#total_price').html('$' + total_price);


                    var urlCart = "{{ route('cart.index') }}";

                    var selectorSubtotal = ' .list-unstyled .subtotal';
                    var selectorTotal = ' .list-unstyled .total';

                    var urlUpdateSubtotal = urlCart + " " + selectorSubtotal;
                    var urlUpdateTotal = urlCart + " " + selectorTotal;
                    $(selectorSubtotal).load(urlUpdateSubtotal);
                    $(selectorTotal).load(urlUpdateTotal);

                    $('#table-product').empty();
                }
            });
        })
    </script>
@endsection
