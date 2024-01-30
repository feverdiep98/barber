<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Form - HAIRCUT</title>
    <link rel="stylesheet" href="{{ asset('client/css/checkout.css') }}">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <form action="{{ route('cart.place-order') }}" method="POST">
            @csrf
            <div class="wrapper">
                <h2>Payment Form</h2>
                <form action="{{ route('cart.form') }}" method="POST">
                    @csrf
                    <h4>Account</h4>
                    <div class="input_group">
                        <div class="input_box">
                            <input type="text" placeholder="Full Name" name="customer_name" class="name">
                            <i class="fa fa-user icon"></i>
                        </div>
                        <div>
                            @if ($errors->has('customer_name'))
                                {{ $errors->first('customer_name') }}
                            @endif
                        </div>
                        <div class="input_box">
                            <input type="text" placeholder="Phone Number" name="customer_phone" class="name">
                            <i class="fa-solid fa-mobile icon"></i>
                        </div>
                        <div>
                            @if ($errors->has('customer_phone'))
                                {{ $errors->first('customer_phone') }}
                            @endif
                        </div>
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <input type="email" placeholder="Email Address" name="email" class="name"
                                value="{{ Auth::check() ? Auth::user()->email : '' }}">
                            <i class="fa fa-envelope icon"></i>
                        </div>
                    </div>
                    <div>
                        @if ($errors->has('email'))
                            {{ $errors->first('email') }}
                        @endif
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <input type="text" placeholder="Address" name="address" class="name">
                            <i class="fa fa-map-marker icon" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div>
                        @if ($errors->has('address'))
                            {{ $errors->first('address') }}
                        @endif
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <input type="text" placeholder="City" name="town" class="name">
                            <i class="fa-solid fa-city icon" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div>
                        @if ($errors->has('town'))
                            {{ $errors->first('town') }}
                        @endif
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <h4>Gender</h4>
                            <input type="radio" name="gender" value="male" class="radio" required id="b1" checked>
                            <label for="b1">Male</label>
                            <input type="radio" name="gender" value="female" class="radio" required id="b2" checked>
                            <label for="b2">Female</label>
                        </div>
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <h4>Payment Methods</h4>
                            <input type="radio" name="payment_method" value="COD" class="radio" id="bc1" checked>
                            <label for="bc1">
                                <span><i class="fa-solid fa-truck-fast"></i>Ship COD</span>
                            </label>
                            <input type="radio" name="payment_method" value="vnpay_atm" id="vnpay_atm"
                                class="radio" checked>
                            <label for="vnpay_atm">
                                <span><i class="fa-brands fa-paypal"></i>VN PAY</span>
                            </label>
                        </div>
                    </div>
                    <textarea name="note" id="note" cols="55" rows="5" placeholder="Please note if you have a idea"></textarea>
                    <div class="input_group">
                        <div class="input_box">
                            <button type="submit">Pay Now</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="Order-summary">
                <h2>Calculate Shipping Fee</h2>
                <form action="{{ route('cart.calculate-fee') }}" method="POST">
                    @csrf
                    <div class="input">
                        <div class="select-province">
                            <select class="form-select mb-3 choose city" aria-label="Default select example"
                                name="city" id="city">
                                <option value=""> Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->matp }}">{{ $city->name_city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="input">
                        <div class="select-province">
                            <select class="form-select mb-3 province choose" aria-label="Default select example"
                                name="province" id="province">
                                <option value=""> Select Province</option>
                            </select>
                        </div>
                    </div>
                    <div class="input">
                        <div class="select-province">
                            <select class="form-select mb-3 wards" aria-label="Default select example"
                                name="wards" id="wards">
                                <option value=""> Select Wards</option>
                            </select>
                        </div>
                    </div>
                    <input type="button" value="Calculate Delivery" name="calculate_order"
                        class="btn btn-primary btn-sm calculate_delivery">
                </form>
                <h2 style="margin-top: 20px;">Order Summary</h2>
                <div class="line"></div>
                @php
                    $total = 0;
                @endphp
                @foreach ($cart as $productId => $item)
                    @php
                        $total += (int) $item['price'] * (int) $item['qty'];
                    @endphp
                    <div class='order-table'>
                        <div class="img">
                            <img src='{{ $item['image_url'] }}' class='full-width'>
                        </div>
                        <div class="product-detail">
                            <div class="name">{{ $item['name'] }}</div>
                            <div class="qty">Quantity: <span>{{ $item['qty'] }}</span></div>
                            <div class="price">{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }} VND
                            </div>
                        </div>
                    </div>
                    <div class="line"></div>
                @endforeach
                @if (Session::has('fee') && Session::get('fee') > 0)
                    <div class="shipping-fee">
                        <div class="checkout-total" >Shipping Fee:
                            <span>{{ number_format(Session::get('fee'), 0, ',', '.') }} VND</span>
                            <button class="btn-fee"><a href="{{ route('cart.delete-shippingfee') }}">
                                <svg viewBox="0 0 15 17.5" height="17.5" width="15" xmlns="http://www.w3.org/2000/svg" class="icon-del">
                                <path transform="translate(-2.5 -1.25)" d="M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z" id="Fill"></path>
                              </svg>
                            </a></button>
                        </div>
                    </div>
                    <input type="hidden" name="shipping_fee" value="{{ Session::get('fee') }}">
                @endif
                <div class="checkout-total">Total: <span>{{ number_format($total + Session::get('fee'), 0, '.', '.') }} VND</span></div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        document.querySelectorAll('.dob').forEach(function(input) {
            input.addEventListener('input', function() {
                // Lấy giá trị từ ba trường input
                var day = document.querySelector('[name="day"]').value;
                var month = document.querySelector('[name="month"]').value;
                var year = document.querySelector('[name="year"]').value;

                // Kiểm tra và định dạng ngày tháng
                if (day.length === 2 && month.length === 2 && year.length === 4) {
                    var formattedDate = year + '-' + month + '-' + day;
                    console.log(formattedDate);
                    // Bạn có thể thực hiện các xử lý khác với formattedDate ở đây
                }
            });
        });
        $(document).ready(function() {
            $('.choose').on('change', function() {
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var result = '';

                if (action == 'city') {
                    result = 'province';
                } else {
                    result = 'wards'
                }
                $.ajax({
                    url: '{{ route('cart.choose-delivery') }}',
                    method: 'POST',
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        console.log(data);
                        $('#' + result).html(data.output);
                    }
                });
            })
            $('.calculate_delivery').click(function() {
                var matp = $('.city').val();
                var maqh = $('.province').val();
                var xaid = $('.wards').val();
                if (matp == '' && maqh == '' && xaid == '') {
                    alert('please select to calculate shipping fee')
                } else {

                    localStorage.setItem('selectedCity', matp);
                    localStorage.setItem('selectedProvince', maqh);
                    localStorage.setItem('selectedWards', xaid);

                    $.ajax({
                        url: '{{ route('cart.calculate-fee') }}',
                        method: 'POST',
                        data: {
                            matp: matp,
                            maqh: maqh,
                            xaid: xaid,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            location.reload();
                        }
                    });
                }
            });
            $('.city, .province, .wards').change(function() {
                console.log('City:', $('.city').val());
                console.log('Province:', $('.province').val());
                console.log('Wards:', $('.wards').val());

                localStorage.setItem('selectedCity', $('.city').val());
                localStorage.setItem('selectedProvince', $('.province').val());
                localStorage.setItem('selectedWards', $('.wards').val());
            });
        })
    </script>
</body>

</html>
