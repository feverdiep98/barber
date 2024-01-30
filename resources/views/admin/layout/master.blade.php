<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DarkPan - Bootstrap 5 Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('admin/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('admin/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-home"></i> Hair Cut</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        @if(Auth::user()->image_url)
                            <img class="rounded-circle me-lg-2" src="{{ asset('images/' . Auth::user()->image_url) }}" alt=""
                                style="width: 60px; height: 60px;">
                        @else
                            <img class="rounded-circle me-lg-2" src="{{ asset('img/default-user.jpg') }}" alt=""
                                style="width: 60px; height: 60px;">
                        @endif

                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{Auth::user()->name}}</h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="/admin/chart" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-list me-2"></i>Category</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="/admin/shopping_category/list" class="dropdown-item">Shopping category</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fab fa-product-hunt me-2"></i>Product</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="/admin/shopping_details/list" class="dropdown-item">Shopping details</a>
                        </div>
                    </div>
                    <a href="/admin/brand/list" class="nav-item nav-link"><i class="fas fa-code-branch me-2"></i>Brand</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Booking</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="/admin/booking_service/index" class="dropdown-item">Services</a>
                            <a href="/admin/booking_list/list" class="dropdown-item">Booking List</a>
                            <a href="/admin/slot/list" class="dropdown-item">Slot</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Manager Order</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="/admin/manage_order/index" class="dropdown-item">Order</a>
                        </div>
                    </div>
                    <a href="/admin/shipping/index" class="nav-item nav-link"><i class="fas fa-shipping-fast me-2"></i>Shipping</a>
                    <a href="/admin/user/index" class="nav-item nav-link"><i class="fas fa-users me-2"></i>User</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            @if(Auth::user()->image_url)
                                <img class="rounded-circle me-lg-2" src="{{ asset('images/' . Auth::user()->image_url) }}" alt=""
                                    style="width: 40px; height: 40px;">
                            @else
                                <img class="rounded-circle me-lg-2" src="{{ asset('img/default-user.jpg') }}" alt=""
                                    style="width: 40px; height: 40px;">
                            @endif
                            <span class="d-none d-lg-inline-flex">{{Auth::user()->name}}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="{{ route('admin.users.profile') }}" class="dropdown-item">My Profile</a>
                            <a href="{{ route('admin.signout')}}" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>

            </nav>

            <!-- Navbar End -->


            @yield('content')
            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                            <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/lib/chart/chart.min.js')}}"></script>
    <script src="{{ asset('admin/lib/easing/easing.min.js')}}"></script>
    <script src="{{ asset('admin/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{ asset('admin/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('admin/lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{ asset('admin/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{ asset('admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{ asset('template/js/script.js')}}"></script>
    <script src="https://cdn.tiny.cloud/1/API_KEY/tinymce/6/tinymce.min.js"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('admin/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @yield('js-custom')
</body>

</html>
