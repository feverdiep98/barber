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
                        <li class="breadcrumb-item active">Booking</li>
                        <li class="breadcrumb-item active">Service</li>
                      </ol>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- /.container-fluid -->
              </div>
            @if (session('message'))
                <span class="alert-success" style="font-size: 25px">
                    {{ session('message') }}
                </span><br>
            @endif
            <div class="col-sm-12 col-xl-8">
                <div class="bg-secondary rounded h-100 p-4">
                    <div style="display: flex; justify-content: space-between;">
                        <h6 class="mb-4">Service</h6>
                        <div class="InputContainer" style="margin-right: 60px;">
                            <form action="" method="get">
                                <input  placeholder="Search.." class="input" name="keyword" value="{{ is_null(request()->keyword) ? "" : request()->keyword}}">
                            </form>
                        </div>
                    </div>
                    <form action="{{ route('admin.booking_service.deleteAll') }}" method="post">
                        @csrf
                        <div class="function" style="display: flex;">
                            <div class="col-lg-8 col-md-12">
                                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" type="submit">Delete All
                                    Selected</button>
                            </div>
                            <div class="col-lg-8 col-md-12" >
                                <a class="btn btn-primary" href="{{ route('admin.booking_service.create') }}">Create Booking Service</a>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px"><input id="selectAll" type="checkbox"></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booking_services as $booking_service)
                                    <tr>
                                        <th><input name='id[]' id="selectAll" value="{{ $booking_service->id }}"
                                                type="checkbox"></th>
                                        <th scope="row">{{ $booking_service->id }}</th>
                                        <td>{{ $booking_service->name }}</td>
                                        <td>{{ number_format($booking_service->price, 0, ',', '.') }} VND</td>
                                        <td><a class="btn btn-{{ $booking_service->status ? 'success' : 'danger' }}">
                                                {{ $booking_service->status ? 'Show' : 'Hide' }}
                                            </a></td>
                                        <td>
                                            <form method="post" action="{{ route('admin.booking_service.delete', ['id' => $booking_service->id]) }}">
                                                @csrf
                                                {{ method_field('delete') }}
                                                <a href=" {{ route('admin.booking_service.detail', ['id' => $booking_service->id]) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <button onclick="return confirm('Are You Sure?')" type="submit"
                                                    class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No Service</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $booking_services->links('pagination::bootstrap-4') }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-custom')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#selectAll").click(function() {
                $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
            });
        })
    </script>
@endsection
