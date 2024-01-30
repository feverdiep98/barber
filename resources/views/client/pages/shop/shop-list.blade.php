
@extends('client.layout.master')
@section('content')
<body>
    @if (session('message'))
        <span class="alert-success" style="font-size: 25px">
            {{ session('message') }}
        </span><br>
    @endif
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white text-uppercase mb-3 animated slideInDown">Our Shop</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="home">Home</a></li>
                    <li class="breadcrumb-item text-primary" aria-current="page">Shopping</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container-menu">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message')}}
            </div>
        @endif
        <link rel="stylesheet" href="{{ asset('client/css/shop-list.css') }}">
        <div class="grid">
            <div class="grid__row">
                <div class="grid__column-2">
                    <nav class="category">
                        <h3 class="category__heading">
                            <img src="{{ asset('client/img/menu.png') }}" alt="">
                            Category
                        </h3>
                        @foreach ( $productCategories as $productCategory )
                        <ul class="product-category-list">
                                <li class="product-category-item category-item">
                                    <a href="{{ route('category',['slug' => $productCategory->slug]) }}" class="category-item__link">{{ $productCategory->name }}</a>
                                </li>
                        </ul>
                        @endforeach
                        <h3 class="brand__heading">
                            Brand
                        </h3>
                        @foreach ( $brandProducts as $brandProduct )
                        <ul class="brand-category-list">
                                <li class="brand-category-item brand-item">
                                    <a href="{{ route('brand',['slug' => $brandProduct->slug]) }}" class="brand-item__link">{{ $brandProduct->name }}</a>
                                </li>
                        </ul>
                        @endforeach
                    </nav>
                </div>
                <div class="grid__column-10">
                    <div class="product-bar">
                        <div></div>
                    </div>
                    <div class="filter">
                        <form action="" method="GET">
                            <div class="container-input">
                                <input type="text" placeholder="Search" name="keyword" class="input" value="{{ is_null(request()->keyword) ? "" : request()->keyword}}">
                                <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z"
                                        fill-rule="evenodd">
                                    </path>
                                </svg>
                            </div>
                        </form>
                        <div class="dropdown">
                            <div class="dropdown__select">
                                <span class="dropdown__selected"><i class="fa-solid fa-filter" style="color: #000205;"></i>
                                    Sort By</span>
                                <i class="fa fa-caret-down dropdown__carret"></i>
                            </div>
                            <div class="dropdown__list">
                                <li class="dropdown__item">
                                    <a href="{{ route('shop-list') }}">
                                        <span class="dropdown__text" style="color: #09152a;">All</span>
                                        <i class="fas fa-undo" style="color: #09152a;"></i>
                                    </a>
                                </li>
                                <li class="dropdown__item">
                                    <a href="{{ route('shop-list', array_merge(request()->query(), ['sort' => 'newest'])) }}">
                                        <span class="dropdown__text" style="color: #09152a;">Newest</span>
                                        <i class="fa-solid fa-fire" style="color: #09152a;"></i>
                                    </a>
                                </li>
                                <li class="dropdown__item">
                                    <a href="{{ route('shop-list', ['amount_start' => $minPrice, 'amount_end' => $maxPrice, 'sort_direction_start' => 'asc']) }}">
                                        <span class="dropdown__text" style="color: #09152a;">Price: High-Low</span>
                                        <i class="fa-solid fa-circle-up" style="color: #09152a;"></i>
                                    </a>
                                </li>
                                <li class="dropdown__item">
                                    <a href="{{ route('shop-list', ['amount_start' => $minPrice, 'amount_end' => $maxPrice, 'sort_direction_start' => 'desc']) }}">
                                        <span class="dropdown__text" style="color: #09152a;">Price: Low-High</span>
                                        <i class="fa-solid fa-circle-down" style="color: #09152a;"></i>
                                    </a>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="home-product">
                        <div class="grid__row">
                            @foreach ( $products as $product )
                            <div class="grid__column-product">
                                <div class="home-product-item">
                                    @php
                                        $imageLink = is_null($product->image_url) || !file_exists("images/" .$product->image_url) ? 'default-images.png' : $product->image_url;
                                    @endphp
                                    <div class="home-product-item__img"
                                        style="background-image: url({{ asset('images/'.$imageLink) }})">
                                    </div>
                                    <h4 class="home-product-item__name"><a href="{{ route('product_detail', ['slug'=>$product->slug]) }}">{{ $product->name }}</a></h4>
                                    <div class="home-product-item__price">
                                        <div class="home-product-item__price">
                                            <span class="home-product-item__price-product" >{{ number_format($product->price, 0, '.', '.') }} VND</span>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <button class="cart"><a class="product-add-to-cart" data-url="{{ route('cart.add-to-cart',['productId'=>$product->id])}}" href="">
                                            <span>Add to cart</span>
                                            <i class="fa-solid fa-basket-shopping" aria-hidden="true"></i>
                                        </a></button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
@section('js-custom')
    <script type="text/javascript" >
        $(document).ready(function(){
            $('.product-add-to-cart').on('click',function(event){
                event.preventDefault();
                var url = $(this).data('url');

                $.ajax({
                    method: 'GET', // method of form
                    url: url,
                    success: function(res){
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
                    },
                });
            })
        });
    </script>
@endsection
