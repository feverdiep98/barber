<link rel="stylesheet" href="{{ asset('template/css/style.css') }}">
<link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
<script src="{{ asset('template/js/main.js') }}"></script>
<link rel="stylesheet" href="{{ asset('client/css/header.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<header>
    <nav class="navbar navbar-expand-lg bg-secondary navbar-dark sticky-top py-lg-0 px-lg-5 wow fadeIn"
        data-wow-delay="0.1s">
        <a href="{{route("home")}}" class="navbar-brand ms-4 ms-lg-0">
            <h1 class="mb-0 text-primary text-uppercase"><i class="fa fa-cut me-3"></i >HairCut</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{route("home")}}" class="nav-item nav-link">Home</a>
                <a href="{{route("about")}}" class="nav-item nav-link">About</a>
                <a href="{{route("service")}}" class="nav-item nav-link">Service</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Shopping</a>
                    <div class="dropdown-menu m-0" style="background-color:  #343a40;">
                        <a href="{{route("shop-list")}}" class="dropdown-item">Shopping List</a>
                        <a href="{{route("cart.index")}}" class="dropdown-item">Shopping Cart</a>
                        <a href="{{ route("cart.checkout") }}" class="dropdown-item">Check Out</a>
                    </div>
                </div>
                <a href="{{route("contact")}}" class="nav-item nav-link">Contact</a>
            </div>

            @if (session()->has('users'))
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user" style="color: #f2f2f3;"></i>
                            <span class="d-none d-lg-inline-flex">{{ session()->get('users')['0']['name'] }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="{{ route("cart.view-order") }}" class="dropdown-item">View Order</a>
                            <a href="{{ route('logout') }}" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('dangky') }}"><button class="Btn">
                        <div class="sign"><svg viewBox="0 0 512 512">
                                <path
                                    d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                                </path>
                            </svg>
                        </div>
                        <div class="text">Login</div>
                    </button></a>
            @endif
            @php
                $total = session()->has('cart') ? count(session()->get('cart')) : 0;
            @endphp
            <a href="{{ route('cart.index') }}"><i class="fa-solid fa-cart-shopping" style="color: #f4f5f5;"style="height:100px; "><span id="total_product" style="font-size: 15px;">{{ $total }}</span></i></a>
        </div>

    </nav>
</header>
