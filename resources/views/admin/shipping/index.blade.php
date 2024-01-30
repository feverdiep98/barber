<link rel="stylesheet" href="{{ asset('admin/css/ship.css') }}">
@extends('admin.layout.master')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Shipping</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
        </div>
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (session('message'))
            <span class="alert-success" style="font-size: 25px">
                {{ session('message') }}
            </span><br>
        @endif
        <div class="ship-title">
            <div class="title">
                <h1 class="name">Shipping</h1>
            </div>
        </div>
        <form action="{{ route('admin.insert-delivery') }}" method="post" role="form">
            @csrf
            <div class="container" style="margin-top: 20px">
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-secondary rounded h-100 p-4">
                        <div class="input">
                            <h6 class="mb-4">Select City</h6>
                            <select class="form-select mb-3 choose city" aria-label="Default select example" name="city"
                                id="city">
                                <option value=""> ---Select city---</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->matp }}">{{ $city->name_city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input">
                            <h6 class="mb-4">Select Province</h6>
                            <select class="form-select mb-3 province choose" aria-label="Default select example"
                                name="province" id="province">
                                <option value=""> ---Select Province---</option>
                            </select>
                        </div>
                        <div class="input">
                            <h6 class="mb-4">Select Wards</h6>
                            <select class="form-select mb-3 wards" aria-label="Default select example" name="wards"
                                id="wards">
                                <option value=""> ---Select Wards---</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Shipping fee</label>
                            <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>
                        <button type="submit" name="add_delivery" class="btn btn-primary add_delivery">Add Shipping
                            Fee</button>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{ route('admin.update_delivery' , ['fee_id' => $feeship[0]->fee_id]) }}" method="POST" role="form">
            @csrf
            <div>
                <div class="bg-secondary rounded p-4" style="margin-top: 20px">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">City</th>
                                <th scope="col">Province</th>
                                <th scope="col">Wards</th>
                                <th scope="col">Shipping fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feeship as $fee )
                                <tr>
                                    <td>{{ $fee->city->name_city }}</td>
                                    <td>{{ $fee->province->name_quanhuyen }}</td>
                                    <td>{{ $fee->wards->name_xaphuong }}</td>
                                    <td>
                                        <input type="text" name="shipping_fee[]" value="{{ $fee->shipping_fee }}" />
                                        <input type="hidden" name="fee_id[]" value="{{ $fee->fee_id }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: end;">
                        <button type="submit" class="btn btn-primary ">Update Shipping
                            Fee</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js-custom')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.add_delivery').click(function() {
                e.preventDefault();
                var city = $('.city').val();
                var province = $('.province').val();
                var wards = $('.wards').val();
                var fee_ship = $('.fee_ship').val();
                var action = $('input[name="action"]').val();

                $.ajax({
                    url: '{{ route('admin.insert-delivery') }}',
                    method: 'POST',
                    data: {
                        city: city,
                        province: province,
                        _token: "{{ csrf_token() }}",
                        wards: wards,
                        fee_ship: fee_ship,
                        action: action
                    },
                    success: function(data) {
                        alert('Add Succes')
                    }
                });

            })
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
                    url: '{{ route('admin.select-delivery') }}',
                    method: 'POST',
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#' + result).html(data.output);
                    }
                });
            })
        })
    </script>
@endsection
