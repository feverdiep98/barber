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
              <li class="breadcrumb-item active">Slot</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Update SLot</h6>
                    <form role="form" method="POST" action="{{route('admin.slot.update', ['id' => $slot[0]->id])}}">
                        @csrf
                        <div class="row mb-3">
                            <label for="slug" class="col-sm-2 col-form-label">Add Slot</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $slot[0]->available_slots }}" class="form-control" id="available_slots" placeholder="Available Slot"
                                    name="available_slots">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="slug" class="col-sm-2 col-form-label">Add Booked Slot</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $slot[0]->booked_slots }}" class="form-control" id="booked_slots" placeholder="Slot"
                                    name="booked_slots">
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" value="{{ $slot[0]->id }}">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
@endsection
