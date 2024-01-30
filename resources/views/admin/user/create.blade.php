@extends('admin.layout.master');
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">User</a></li>
                <li class="breadcrumb-item"><a href="#">Create New member</a></li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="bg-secondary rounded h-100 p-4">
                        <h6 class="mb-4">Create New Member</h6>
                        <form role="form"  method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data" role="form">
                            @csrf
                            <div class="row mb-3">
                                <label for="Name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="Name"
                                        name="name">
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
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="email" placeholder="email"
                                        name="email">
                                </div>
                            </div>
                            <div>
                                @error('email')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone" placeholder="phone"
                                        name="phone">
                                </div>
                            </div>
                            <div>
                                @error('phone')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" placeholder="password"
                                        name="password">
                                </div>
                            </div>
                            <div>
                                @error('password')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="confirm_password" placeholder="confirm_password"
                                        name="confirm_password">
                                </div>
                            </div>
                            <div>
                                @error('confirm_password')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="role" name="role"
                                    aria-label="Floating label select example">
                                    <option value="" selected>----Please Select----</option>
                                    <option value="1">Admin</option>
                                    <option value="0">User</option>
                                </select>
                                <label for="role">Role</label>
                            </div>
                            <div>
                                @error('status')
                                    <small style="color: orange">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Choose Image</label>
                                    <input class="form-control bg-dark" type="file" id="image_url" name="image_url" placeholder="Image">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
@endsection
