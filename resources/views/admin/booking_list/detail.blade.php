@extends('admin.layout.master')
@section('content')
    <div class="content">
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-secondary rounded h-100 p-4">
                        <h6 class="mb-4">Update Booking</h6>
                        <form method="POST" action="{{route('admin.booking_list.update', ['id' => $booking->id])}}">
                            @csrf
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $booking->name }}" class="form-control" id="name" placeholder="name" name="name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $booking->email }}" class="form-control" id="email" placeholder="email" name="email">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $booking->phone }}" class="form-control" id="phone" placeholder="phone" name="phone">
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="type" name="type"
                                    aria-label="Floating label select example">
                                    <option value="" selected>----Please Select----</option>
                                    @foreach ($bookingservice as $servicelist)
                                    <option @if ($service->id == $servicelist->id) selected @endif
                                        value="{{ $servicelist->id }}">{{ $servicelist->name }}</option>
                                    @endforeach
                                </select>
                                <label for="type">Brand Product</label>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Number</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $booking->slot }}" class="form-control" id="number" placeholder="number" name="number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Note</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $booking->note }}" class="form-control" id="note" placeholder="note" name="note">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Booking Date</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $booking->booking_date }}" class="form-control" id="Booking Date" placeholder="Booking Date" name="booking_date">
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="id" value="{{ $booking->id }}">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-custom')
    <script type="text/javascript">
        $(document).ready(function (){
            $('#name').on('keyup', function(){
                let name = $(this).val();
                $.ajax({
                    method: 'POST', // method of form
                    url: "{{ route('admin.shopping_category.slug')}}",
                    data: {
                        name: name,
                        _token: "{{ csrf_token()}}"
                    },
                    success: function(res){
                        $('#slug').val(res.slug);
                    },
                    error: function(res){

                    }
                });
            })
        })
    </script>
@endsection
