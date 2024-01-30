@extends('admin.layout.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Shopping Category</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-secondary rounded h-100 p-4">
                        <h6 class="mb-4">Update Booking Service</h6>
                        <form role="form" method="POST" action="{{ route('admin.booking_service.update', ['id' => $booking->id]) }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $booking->name }}" class="form-control" id="name"
                                        placeholder="name" name="name">
                                </div>
                            </div>
                            <div>
                                @error('name')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $booking->price }}" class="form-control" id="price"
                                        placeholder="price" name="price">
                                </div>
                            </div>
                            <div>
                                @error('price')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="short_description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea type="text" value="{{ $booking->short_description }}" class="form-control" id="short_description" placeholder="Short Description"
                                        name="short_description" ></textarea>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="status" name="status"
                                    aria-label="Floating label select example">
                                    <option value="" selected>----Please Select----</option>
                                    <option {{ $booking->status ? 'selected' : '' }} value="1">Show
                                    </option>
                                    <option {{ !$booking->status ? 'selected' : '' }} value="0">Hide
                                    </option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                            <div>
                                @error('status')
                                    <small style="color: orange">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-custom')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#name').on('keyup', function() {
                let name = $(this).val();
                $.ajax({
                    method: 'POST', // method of form
                    url: "{{ route('admin.shopping_category.slug') }}",
                    data: {
                        name: name,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        $('#slug').val(res.slug);
                    },
                    error: function(res) {

                    }
                });
            })
        })
    </script>
@endsection
