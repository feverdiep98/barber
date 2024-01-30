
@extends('client.layout.master')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white text-uppercase mb-3 animated slideInDown">About</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="home">Home</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">About</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
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
@endsection
