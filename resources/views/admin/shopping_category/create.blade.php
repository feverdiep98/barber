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
                            <li class="breadcrumb-item active">Category</li>
                            <li class="breadcrumb-item active">Shopping Category</li>
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
                        <h6 class="mb-4">Create Product Category</h6>
                        <form role="form" method="POST" action="{{ route('admin.shopping_category.save') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="Name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="name"
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
                                <label for="slug" class="col-sm-2 col-form-label">Slug</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="slug" placeholder="slug"
                                        name="slug">
                                </div>
                            </div>
                            <div>
                                @error('slug')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="status" name="status"
                                    aria-label="Floating label select example">
                                    <option value="" selected>----Please Select----</option>
                                    <option value="1">Show</option>
                                    <option value="0">Hide</option>
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
