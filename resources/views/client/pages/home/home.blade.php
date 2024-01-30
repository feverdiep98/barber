
@extends('client.layout.master')
@section('content')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @if (session('message'))
                <div class="alert alert-success">
                    <link rel="stylesheet" href="{{ asset('client/css/home.css') }}">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>{{ session('message')}}</strong>
                </div>
                @endif
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('template/img/carousel-1.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex align-items-center justify-content-center text-start">
                        <div class="mx-sm-5 px-5" style="max-width: 900px;">
                            <h1 class="display-2 text-white text-uppercase mb-4 animated slideInDown">We Will Keep You
                                An Awesome Look</h1>
                            <h4 class="text-white text-uppercase mb-4 animated slideInDown"><i
                                    class="fa fa-map-marker-alt text-primary me-3"></i>69 Lê Lợi, Quận 1, TP. Hồ Chí
                                Minh</h4>
                            <h4 class="text-white text-uppercase mb-4 animated slideInDown"><i
                                    class="fa fa-phone-alt text-primary me-3"></i>+012 345 67890</h4>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('template/img/carousel-2.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex align-items-center justify-content-center text-start">
                        <div class="mx-sm-5 px-5" style="max-width: 900px;">
                            <h1 class="display-2 text-white text-uppercase mb-4 animated slideInDown">Luxury Haircut at
                                Affordable Price</h1>
                            <h4 class="text-white text-uppercase mb-4 animated slideInDown"><i
                                    class="fa fa-map-marker-alt text-primary me-3"></i>69 Lê Lợi, Quận 1, TP. Hồ Chí
                                Minh</h4>
                            <h4 class="text-white text-uppercase mb-4 animated slideInDown"><i
                                    class="fa fa-phone-alt text-primary me-3"></i>+012 345 67890</h4>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="d-flex flex-column">
                        <img class="img-fluid w-75 align-self-end"
                            src="{{ asset('template/img/pngtree-hipster-barber-shop-business-card-design-template-barbershop-old-classic-vector-png-image_12453936.png') }}"
                            alt="">
                        <div class="w-50 bg-secondary p-5" style="margin-top: -25%;">
                            <h1 class="text-uppercase text-primary mb-3">8 Years</h1>
                            <h2 class="text-uppercase mb-0">Experience</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <p class="d-inline-block bg-secondary text-primary py-1 px-4">About Us</p>
                    <h1 class="text-uppercase mb-4">More Than Just A Haircut. Learn More About Us!</h1>
                    <p>Lion Hair Cut Shop được thành lập vào năm 2015 với cửa hàng đầu tiên tại số 69 Lê Lợi, Quận 1</p>
                    <p class="mb-4">Sau 8 năm, Lion Hair Cut trở thành địa điểm yêu thích của phái mạnh đến và định hình
                        phong cách. Nơi mà các phái mạnh có thể tự tin với mái tóc của mình</p>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h3 class="text-uppercase mb-3">Since 2015</h3>
                            <p class="mb-0">Chúng tôi Luôn theo kịp xu hướng của ngành nghề tóc và không ngừng phát triển
                                theo mỗi thợi đại khác nhau</p>
                        </div>
                        <div class="col-md-6">
                            <h3 class="text-uppercase mb-3">1000+ clients</h3>
                            <p class="mb-0">Bởi vì sự cầu tiền không ngừng nghĩ và làm hài lòng những khách hàng khó tính
                                nhất</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block bg-secondary text-primary py-1 px-4">Services</p>
                <h1 class="text-uppercase">What We Provide</h1>
            </div>
            <div class="row g-4">
                @foreach ($services as $service )
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                            <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <img class="img-fluid" src="{{ asset('template/img/haircut.png') }}" alt="">
                            </div>
                            <div class="ps-4">
                                <h3 class="text-uppercase mb-3">{{ $service->name }}</h3>
                                <p>{{ $service->short_description }}</p>
                                <span class="text-uppercase text-primary">{{ number_format($service->price, 0, ',', '.') }} VND</span>
                            </div>
                            <a class="btn btn-square" href="booking"><i class="fa fa-plus text-primary"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Price Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="bg-secondary h-100 d-flex flex-column justify-content-center p-5">
                        <p class="d-inline-flex bg-dark text-primary py-1 px-4 me-auto">Price & Plan</p>
                        <h1 class="text-uppercase mb-4">Check Out Our Barber Services And Prices</h1>
                        @foreach ( $services as $service)
                            <div>
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <h6 class="text-uppercase mb-0">{{ $service->name }}</h6>
                                    <span class="text-uppercase text-primary">{{ number_format($service->price, 0, ',', '.') }} VND</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="h-100">
                        <img class="img-fluid h-80"
                            src="{{ asset('template/img/HD-wallpaper-barber-arad-barbacide-romania.jpg') }}"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Price End -->

    <!-- Working Hours Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="h-100">
                        <img class="img-fluid h-70"
                            src="{{ asset('template/img/desktop-wallpaper-stock-of-barber-pole-blue-brick-wall.jpg') }}"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="bg-secondary h-100 d-flex flex-column justify-content-center p-5">
                        <p class="d-inline-flex bg-dark text-primary py-1 px-4 me-auto">Working Hours</p>
                        <h1 class="text-uppercase mb-4">Professional Barbers Are Waiting For You</h1>
                        <div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <h6 class="text-uppercase mb-0">Monday</h6>
                                <span class="text-uppercase">09 AM - 09 PM</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <h6 class="text-uppercase mb-0">Tuesday</h6>
                                <span class="text-uppercase">09 AM - 09 PM</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <h6 class="text-uppercase mb-0">Wednesday</h6>
                                <span class="text-uppercase">09 AM - 09 PM</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <h6 class="text-uppercase mb-0">Thursday</h6>
                                <span class="text-uppercase">09 AM - 09 PM</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <h6 class="text-uppercase mb-0">Friday</h6>
                                <span class="text-uppercase">09 AM - 09 PM</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <h6 class="text-uppercase mb-0">Saturday</h6>
                                <span class="text-uppercase">09 AM - 09 PM</span>
                            </div>
                            <div class="d-flex justify-content-between py-2">
                                <h6 class="text-uppercase mb-0">Sunday</h6>
                                <span class="text-uppercase text-primary">09 AM - 05 PM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Working Hours End -->
    {{-- <section class="featured spad">
        <div class="Title">
            <h1>Feature Products</h1>
        </div>
        <div id="Products">
            @if (!empty($products))
                @foreach ($products as $product)
                    <div class="list">
                        <div class="box">
                            @php
                                $imageLink = is_null($product->image_url) || !file_exists('images/' . $product->image_url) ? 'default-images.png' : $product->image_url;
                            @endphp
                            <div class="image_product">
                                <img src="{{ asset('images/' . $imageLink) }}" alt="" height="150"
                                    width="">
                            </div>
                            <div class="content">
                                <h2 class="info_product"><a
                                        href=" {{ route('shop-list.shopping_detail.slug', ['slug' => $product->slug]) }}">{{ $product->name }}</a>
                                </h2>
                                <p class="price_product">${{ number_format($product->price) }}</p>
                                <a class="shopping-cart-add-to-cart"
                                    data-url="{{ route('cart.add-to-cart', ['productId' => $product->id]) }}"
                                    href="#"><i class="fa fa-shopping-cart"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section> --}}
@endsection
@section('js-custom')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.shopping-cart-add-to-cart').on('click', function(event) {
                event.preventDefault();
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
                    },
                    statusCode: {
                        401: function() {
                            window.location.href = "{{ route('login') }}"
                        }
                    }
                });
            })
        });
    </script>
@endsection
