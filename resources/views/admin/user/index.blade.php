<link rel="stylesheet" href="{{ asset('admin/css/switcher_toggle.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                                <li class="breadcrumb-item active">User</li>
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
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div style="display: flex; justify-content: space-between;">
                        <h6 class="mb-4">User Administration</h6>
                        <div class="InputContainer" style="margin-right: 195px;">
                            <form action="" method="get">
                                <input  placeholder="Search.." class="input" name="keyword" value="{{ is_null(request()->keyword) ? "" : request()->keyword}}"
                                    >
                            </form>
                        </div>
                    </div>
                    <form action="{{ route('admin.user.deleteAll') }}" method="post">
                        @csrf
                        <div class="function" style="display: flex;">
                            <div class="col-lg-8 col-md-12">
                                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" type="submit">Delete
                                    All
                                    Selected</button>
                            </div>
                            <div class="col-lg-8 col-md-12" style="display:flex;">
                                <a class="btn btn-primary" style="height: 40px; margin-left: 10px" href="{{ route('admin.user.create') }}">Create New
                                    Member</a>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px"><input id="selectAll" type="checkbox" name="checked[]"></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Avatar</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Role</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($users) && is_object($users))
                                    @foreach ($users as $user)
                                        <tr>
                                            <th><input name='' id="selectAll" value="" type="checkbox">
                                            </th>
                                            <td>{{ $user->id }}</td>
                                            <td>
                                                @php
                                                    $imageLink = is_null($user->image_url) || !file_exists("images/" .$user->image_url) ? 'default-images.png' : $user->image_url;
                                                @endphp
                                                <img src="{{asset('images/'.$imageLink)}}" alt="{{$user->image_url}}" width="150" height="150" >
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td class="text-center">
                                                <label class="switch">
                                                    <input type="checkbox" class="toggleSwitch" data-user-id="{{ $user->id }}" {{ $user->active ? 'checked' : '' }}>                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-{{ $user->role ? 'success' : 'danger' }}">
                                                    {{ $user->role ? 'Admin' : 'User'}}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{route('admin.user.destroy', ['id' => $user->id])}}" method="post">
                                                @csrf
                                                {{ method_field('delete') }}
                                                    <a href="{{route('admin.user.detail', ['id' => $user->id])}}" class="btn btn-primary">Edit</a>
                                                    <button onclick="return confirm('Are You Sure?')" type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                {{ $users->links('pagination::bootstrap-4') }}
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-custom')
    <script>
        $(document).ready(function () {
            $('.toggleSwitch').change(function () {
                var userId = $(this).data('user-id');
                var isChecked = $(this).prop('checked');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '/activate-user/' + userId,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: csrfToken,
                        active: isChecked ? 1 : 0,
                    },
                    success: function (response) {
                        // Xử lý kết quả từ controller
                        alert(response.message);
                    },
                    error: function (error) {
                        // Xử lý lỗi nếu cần
                        alert('Đã xảy ra lỗi: ' + error.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endsection
