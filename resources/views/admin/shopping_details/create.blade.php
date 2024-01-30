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
                <li class="breadcrumb-item"><a href="#">Product</a></li>
                <li class="breadcrumb-item"><a href="#">Shopping Details</a></li>
                <li class="breadcrumb-item active">Create Shopping</li>
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
                        <h6 class="mb-4">Create Product Detail</h6>
                        <form method="POST" action="{{ route('admin.shopping_details.store') }}" enctype="multipart/form-data" role="form">
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
                                <label for="slug" class="col-sm-2 col-form-label">Slug</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="slug" placeholder="Slug"
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
                            <div class="row mb-3">
                                <label for="price" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="price" placeholder="Price"
                                        name="price">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="discount_price" class="col-sm-2 col-form-label">Discount Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="discount_price" placeholder="Discount Price"
                                        name="discount_price">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="short_description" class="col-sm-2 col-form-label">Short Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="short_description" placeholder="Short Description"
                                        name="short_description">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="qty" class="col-sm-2 col-form-label">QTY</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="qty" placeholder=""
                                        name="qty">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="shipping" class="col-sm-2 col-form-label">Shipping</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="shipping" placeholder="Shipping"
                                        name="shipping">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="weight" class="col-sm-2 col-form-label">Weight</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="weight" placeholder="Weight"
                                        name="weight">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" ></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="information" class="col-sm-2 col-form-label">Information</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="information" placeholder=""
                                        name="information">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Choose Image</label>
                                    <input class="form-control bg-dark" type="file" id="imgInp" name="image_url" placeholder="Image">
                                    <img style="width: 150px" id="blah" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Choose Image Detail</label>
                                    <input class="form-control bg-dark" type="file" id="imgInp" name="gallery[]" placeholder="Image" multiple>
                                    <img style="width: 150px" id="blah" />
                                </div>
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
                            <div class="form-floating mb-3">
                                <select class="form-select" id="brand_product" name="brand_product_id"
                                    aria-label="Floating label select example">
                                    <option value="" selected>----Please Select----</option>
                                    @foreach ($brandproducts as $brandproduct )
                                        <option value="{{ $brandproduct->id }}">{{$brandproduct->name}}</option>
                                    @endforeach
                                </select>
                                <label for="brand_product_id">Brand Product</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="product_category" name="product_category_id"
                                    aria-label="Floating label select example">
                                    <option value="" selected>----Please Select----</option>
                                    @foreach ($productCategories as $productCategory )
                                        <option value="{{ $productCategory->id }}">{{$productCategory->name}}</option>
                                    @endforeach
                                </select>
                                <label for="product_category_id">Product Category</label>
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
        $(document).ready(function (){
            $('#name').on('keyup', function(){
                let name = $(this).val();
                $.ajax({
                    method: 'POST', // method of form
                    url: "{{ route('admin.shopping_details.slug')}}",
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
        $(document).ready(function(){
            ClassicEditor
                .create( document.querySelector( '#description' ),{
                    ckfinder: {
                        uploadUrl: '{{route('admin.shopping_details.image.upload').'?_token='.csrf_token()}}',
                    }
                })
        })
    </script>
@endsection
