<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <title>Document</title>
    <!-- Css Styles -->
    <!-- Favicon -->
    <link  href="{{ asset('template/img/favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Oswald:wght@600&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('template/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{ asset('template/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('template/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('template/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.css"
    integrity="sha512-+1GzNJIJQ0SwHimHEEDQ0jbyQuglxEdmQmKsu8KI7QkMPAnyDrL9TAnVyLPEttcTxlnLVzaQgxv2FpLCLtli0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- Header Section Begin -->
    @include('client.pages.header.header')
    <!-- Header Section End -->

    @yield('content')

    <!-- Footer Section Begin -->
    @include('client.pages.footer.footer')
    <!-- Footer Section End -->



    <!-- JavaScript Libraries -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/lib/wow/wow.min.js')}}"></script>
    <script src="{{ asset('template/lib/easing/easing.min.js')}}"></script>
    <script src="{{ asset('template/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{ asset('template/lib/owlcarousel/assets/owl.carousel.min.css')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('template/js/main.js')}}"></script>
 <!-- Script -->
 @yield('js-custom')
</body>

</html>
