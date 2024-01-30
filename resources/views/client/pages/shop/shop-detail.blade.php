
@extends('client.layout.master')
@section('content')
    <body>
        <div class="main-wrapper">
            <div class="container">
                <div class="product-detail">
                    <link rel="stylesheet" href="{{ asset('client/css/shop-detail.css') }}">

                    <div class="product-detail-left">
                        @php

                            $imageLink = is_null($product->image_url) || !file_exists("images/" .$product->image_url) ? 'default-images.png' : $product->image_url;
                        @endphp
                        <div class="img-list">
                            <img src="{{ asset('images/'.$imageLink) }}" alt="">
                        </div>
                        <div class="hover-img">
                            @if(is_array($product->gallery))
                                @foreach($product->gallery as $galleryImage)
                                    @php
                                        $galleryPath = public_path('images/' . $galleryImage);
                                    @endphp

                                    <div class="image-container">
                                        @if($galleryPath)
                                            <img src="{{ url($galleryImage) }}" alt="{{ $galleryImage }}" >
                                        @else
                                            <p class="error-message">Hình ảnh không tồn tại</p>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="product-detail-right">
                        <h1 class="product-name">{{ $product->name }}</h1>
                        <div class="product-price">
                            <span class="product-price-item">{{ number_format($product->price) }} VND</span>
                        </div>
                        <p class="product-description">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea, sed dolorum, esse atque quo, est
                            nemo accusamus dignissimos id quaerat
                            <br>numquam illum sequi hic accusantium cupiditate unde animi provident facilis.
                        </p>
                        <div class="customer-benefit">
                            <div class="delivery">
                                <h3 class="benefit"><i class="fa-solid fa-truck" style="color: #b28140;"></i> Giao hàng
                                    nhanh</h3>
                                <p>Dịch vụ áp dụng cho các Quận nội <br> thành của Thành Phố Hồ Chí Minh</p>
                            </div>
                            <div class="quality-product">
                                <h3 class="benefit"><i class="fa-solid fa-check" style="color: #b28140;"></i> Kiểm tra Sản
                                    Phẩm</h3>
                                <p>Được kiểm tra sản phẩm khi nhận hàng không <br> đúng hoặc hàng giả sẽ được trả lại</p>
                            </div>
                        </div>
                        <div class="product-qty">
                            <div class="quantity">
                                <button class="btn minus" type="button" onclick="totalClick(-1)">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <span id="qtyInput">1</span>
                                <button class="btn plus" type="button" onclick="totalClick(1)">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                            <div class="product-cart">
                                <button class="add-to-cart" type="submit">
                                    <a class="add-product" data-id="{{ $product->id }}" data-url="{{ route('cart.add-to-cart',['productId'=>$product->id])}}" href="#">
                                        <span>Add to cart</span>
                                    </a>
                                </button>
                            </div>
                        </div>
                        <div class="status">
                            <ul>
                                <li><b>Availability</b> <span> {{ $product->qty }}</span></li>
                                <li><b>Shipping</b><samp> {{ $product->shipping }}</samp></li>
                                <li><b>Weight</b><samp> {{ $product->weight }}</samp></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tabs">
                        <div class="tab-2">
                            <label for="tab2-1">Description</label>
                            <input id="tab2-1" name="tabs-two" type="radio" checked="checked">
                            <div>
                                <h4>Tab One</h4>
                                <p >{!! $product->description !!}</p>
                            </div>
                        </div>

                        <div class="tab-2">
                            <label for="tab2-2">Information</label>
                            <input id="tab2-2" name="tabs-two" type="radio">
                            <div>
                                <h4>Tab Two</h4>
                                <p>Quisque sit amet turpis leo. Maecenas sed dolor mi. Pellentesque varius elit in neque
                                    ornare commodo ac non tellus. Mauris id iaculis quam. Donec eu felis quam. Morbi
                                    tristique lorem eget iaculis consectetur. Class aptent taciti sociosqu ad litora
                                    torquent per conubia nostra, per inceptos himenaeos. Aenean at tellus eget risus
                                    tempus ultrices. Nam condimentum nisi enim, scelerisque faucibus lectus sodales at.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="product-related">Similate Product</h3>
                <div id="formList">
                    <div class="slider">
                        <div class="direction">
                                <button id="prev"><</button>
                                <button id="next">></button>
                        </div>
                        @foreach ( $related as $item )
                        <div class="box">
                            <div class="slide-img">
                                @php
                                    $imageLink = is_null($item->image_url) || !file_exists("images/" .$item->image_url) ? 'default-images.png' : $item->image_url;
                                @endphp
                                <img src="{{ asset('images/'.$imageLink)  }}" alt="1">
                                <div class="overplay">
                                    <a href="javascript:void(0)" onClick="divFunction({{ $item->id }})" class="buy-btn">Preview</a>
                                </div>
                            </div>
                            <div class="detail-box">
                                <div class="type">
                                    <a href="{{ route('product_detail', ['slug'=>$item->slug]) }}">{{ $item->name }}</a>
                                    <span>{{ $item->brand_product_id }}</span>
                                </div>
                                <a href="#" class="price">{{ number_format($item->price) }} VND</a>
                            </div>
                            <div class="product-preview" id="test-{{$item->id}}">
                                <div class="preview" data-target="p-{{$item->id}}">
                                    <i class="fas fa-times" onClick="closeFunction({{ $item->id }})"></i>
                                    @php
                                        $imageLink = is_null($item->image_url) || !file_exists("images/" .$item->image_url) ? 'default-images.png' : $item->image_url;
                                    @endphp
                                    <div class="preview-img">
                                        <img src="{{ asset('images/'.$imageLink)  }}" alt="">
                                    </div>
                                    <div class="img-box">
                                        <h3 class="preview-name">{{ $item->name }}</h3>
                                        <a href="" class="preview-price">{{ number_format($item->price) }} VND</a>
                                        <div class="preview-button">
                                            <button class="cart">
                                                <a class="add-product-preview" data-id="{{ $item->id }}" data-url="{{ route('cart.add-to-cart',['productId'=>$item->id])}}" href="#">
                                                Add to cart
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </body>
@endsection
@section('js-custom')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.add-to-cart .add-product').on('click',function(event){
                event.preventDefault();
                var qty = $(this).closest('.product-qty').find('#qtyInput').text();
                var productId = $(this).data('id');
                var url = $(this).data('url') + '/' + qty;
                console.log(qty, productId, url);
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
            $('.cart .add-product-preview').on('click', function(event) {
                event.preventDefault();
                var productId = $(this).data('id');
                var qty = $(this).closest('.product-preview').find('.quantity-input').val() || 1;
                var url = $(this).data('url') + '/' + qty;
                console.log(productId, url);

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
                    },
                    error: function(err) {
                        console.log('Error:', err);
                        // Xử lý lỗi ở đây nếu cần
                    }
                });
            });
        });
        function divFunction(id) {
            let previewContainer = document.getElementById('test-'+id);
                previewContainer.style.display = 'flex';
        }

        function closeFunction(id){
            let previewContainer = document.getElementById('test-'+id);
            previewContainer.style.display = 'none';
        }


        function totalClick(click) {
            const totalClicks = document.getElementById('qtyInput');
            const sumvalue = parseInt(totalClicks.innerText) + click;
            console.log(sumvalue);
            qtyInput.innerText = sumvalue;

            if (sumvalue < 0) {
                qtyInput.innerText = 0
            }
        }

        const allHoverImages = document.querySelectorAll('.hover-img div img')
        const imgContainer = document.querySelector('.img-list');

        window.addEventListener('DOMContentLoaded', () => {
            allHoverImages[0].parentElement.classList.add('active');
        });

        allHoverImages.forEach((image) => {
            image.addEventListener('mouseover', () => {
                imgContainer.querySelector('img').src = image.src;
                resetActiveImg();
                image.parentElement.classList.add('active');
            });
        });

        function resetActiveImg() {
            allHoverImages.forEach((img) => {
                img.parentElement.classList.remove('active');
            });
        }

        document.getElementById('next').onclick = function() {
            const widthItem = document.querySelector('.box').offsetWidth;
            document.getElementById('formList').scrollLeft += widthItem;
        }
        document.getElementById('prev').onclick = function() {
            const widthItem = document.querySelector('.box').offsetWidth;
            document.getElementById('formList').scrollLeft -= widthItem;
        }
    </script>
@endsection
