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
                    <li class="breadcrumb-item active">Slot</li>
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
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="col-sm-12 col-xl-12">
            <div class="bg-secondary rounded h-100 p-4">
                <form action="{{ route('admin.slot.deleteAll') }}" method="post">
                    @csrf
                    <h6 class="mb-4">SLOT</h6>
                    <div class="function" style="display: flex;">
                        <div class="col-lg-8 col-md-12">
                            <button style="margin-bottom: 10px" class="btn btn-primary delete_all" type="submit">Delete All
                                Selected</button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px"><input id="selectAll" type="checkbox" name="checked[]"></th>
                                <th scope="col">#</th>
                                <th scope="col">Day</th>
                                <th scope="col">slot</th>
                                <th scope="col">Booked</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($slots as $slot)
                                <tr>
                                    <th><input name='id[]' id="selectAll" value="{{ $slot->id }}" type="checkbox">
                                    </th>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $slot->booking_date }}</td>
                                    <td>{{ $slot->available_slots }}</td>
                                    <td>{{ $slot->booked_slots }}</td>
                                    <td>
                                        <form method="post" action="{{route('admin.slot.delete', ['id' => $slot->id])}}">
                                            @csrf
                                            {{ method_field('delete') }}
                                            <a href=" {{route('admin.slot.detail', ['id' => $slot->id])}}" class="btn btn-primary">Edit</a>
                                            <button onclick="return confirm('Are You Sure?')" type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        @if($slot->confirmed === 'unconfirmed')
                                            <form method="post" action="{{ route('admin.slot.confirm', ['id' => $slot->id]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Confirm</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">No Slot</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $slots->links('pagination::bootstrap-4') }}
                        </ul>
                    </div>
                </form>
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
