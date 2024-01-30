@extends('client.layout.master')
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white text-uppercase mb-3 animated slideInDown">Service</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="home">Home</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Service</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
    
    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block bg-secondary text-primary py-1 px-4">Services</p>
                <h1 class="text-uppercase">What We Provide</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <img class="img-fluid" src="{{ asset('template/img/haircut.png') }}" alt="">
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3">Haircut & Apply Wax, Pomade</h3>
                            <p>Tại Liem Barber Shop, các bạn sẽ được tư vấn tạo kiểu tóc phù hợp với khuôn mặt bởi các
                                barber giàu kinh nghiệm và thân thiện, mang đến trải nghiệm dịch vụ chuyên nghiệp mà vẫn ấm
                                cúng.</p>
                            <span class="text-uppercase text-primary">Price $15</span>
                        </div>
                        <a class="btn btn-square" href="booking"><i class="fa fa-plus text-primary"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <img class="img-fluid" src="{{ asset('template/img/beard-trim.png') }}" alt="">
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3">Beard Trim</h3>
                            <p>Bộ Râu cũng là tạo nên sự lịch lãm cho một quý ông</p>
                            <span class="text-uppercase text-primary">Price $15</span>
                        </div>
                        <a class="btn btn-square" href="booking"><i class="fa fa-plus text-primary"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <img class="img-fluid" src= "{{ asset('template/img/mans-shave.png') }}" alt="">
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3">Mans Shave</h3>
                            <p>Dịch vụ cạo mặt với khăn nóng lạnh tạo nên một cảm giác thoải</p>
                            <span class="text-uppercase text-primary">Price $15</span>
                        </div>
                        <a class="btn btn-square" href="booking"><i class="fa fa-plus text-primary"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <img class="img-fluid" src= "{{ asset('template/img/hair-dyeing.png') }}" alt="">
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3">Hair Dyeing</h3>
                            <p>Một mái đầu đẹp kết hợp với màu tóc nhuộm thời trang sẽ làm sáng khuôn mặt của bạn, đồng thời
                                tạo vẻ cá tính, nổi bật cho phong cách.</p>
                            <span class="text-uppercase text-primary">From $15</span>
                        </div>
                        <a class="btn btn-square" href="booking"><i class="fa fa-plus text-primary"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <img class="img-fluid" src= "{{ asset('template/img/wax.png') }}" alt="">
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3">Relaxing Hair Wax</h3>
                            <p>Không chỉ giới đẹp có thể gội đầu và massage đầu ngay cả những cánh mày râu cũng có thể</p>
                            <span class="text-uppercase text-primary">From $15</span>
                        </div>
                        <a class="btn btn-square" href="booking"><i class="fa fa-plus text-primary"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item position-relative overflow-hidden bg-secondary d-flex h-100 p-5 ps-0">
                        <div class="bg-dark d-flex flex-shrink-0 align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <img class="img-fluid" src="{{ asset('template/img/perming.png') }}" alt="">
                        </div>
                        <div class="ps-4">
                            <h3 class="text-uppercase mb-3">Perming Hair</h3>
                            <p>Uốn, xoăn, rũ theo mọi nhu cầu của khách hàng </p>
                            <span class="text-uppercase text-primary">From $15</span>
                        </div>
                        <a class="btn btn-square" href="booking"><i class="fa fa-plus text-primary"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->
@endsection
