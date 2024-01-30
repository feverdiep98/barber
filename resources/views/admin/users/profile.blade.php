@extends('admin.layout.master')
@section('content')
<div class="container-xl px-4 mt-4">
    <div class="bg-secondary rounded h-100 p-4">
        <hr class="mt-0 mb-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('message'))
            <span class="alert-success" style="font-size: 25px">
                {{ session('message') }}
            </span><br>
        @endif
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data" role="form">
            @csrf
            <div class="row">
                    <div class="col-xl-4">
                        <!-- Profile picture card-->
                        <div class="bg-secondary rounded h-100 p-4">
                            <div class="card-header">Profile Picture</div>
                            <div class="card-body text-center">
                                <!-- Profile picture image-->
                                @php
                                    $imageLink = is_null($user->image_url) || !file_exists(public_path('images/' .$user->image_url)) ? 'default-images.png' : $user->image_url;
                                @endphp
                                <img src="{{asset('images/'.$imageLink)}}" id="profile-image" alt="{{$user->image_url}}" width="300" height="300" >
                                <!-- Profile picture help block-->
                                <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                <!-- Profile picture upload button-->
                                <label for="formFile" class="form-label"></label>
                                <input class="form-control bg-dark" type="file" id="imgInp" name="image_url" placeholder="Image">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="bg-secondary rounded h-100 p-4">
                            <div class="card-header">Account Details</div>
                            <div class="card-body">
                                <form>
                                    <!-- Form Group (username)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputUsername">Name</label>
                                        <input class="form-control" id="name" name="name" type="text" value="{{ $user->name }}" placeholder="Enter your username" value="name">
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" value="{{ $user->password }}" type="tel">
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="confirmPassword">New Password</label>
                                        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="newPassword">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="confirmPassword">Confirm New Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password">
                                    </div>
                                    <!-- Form Group (email address)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                        <input class="form-control" id="email" name="email" type="email" value="{{ $user->email }}" placeholder="Enter your email address" value="name@example.com">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (phone number)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputPhone">Phone number</label>
                                            <input class="form-control" id="phone" name="phone" value="{{ $user->phone }}" type="tel" placeholder="Enter your phone number" value="555-123-4567">
                                        </div>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <!-- Form Group (birthday)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputBirthday">Birthday</label>
                                            <input class="form-control" id="dob" type="date" value="{{ $user->dob }}" name="dob" placeholder="Enter your birthday">
                                        </div>
                                        @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js-custom')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // Hiển thị hình ảnh trong thẻ img
                    $('#profile-image').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                // Hiển thị hình ảnh mặc định nếu không có tệp nào được chọn
                $('#profile-image').attr('src', 'default-images.png');
            }
        }

        // Gán sự kiện onchange cho input file
        $("#imgInp").change(function () {
            readURL(this);
        });
    </script>
@endsection
