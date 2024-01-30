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
                    <li class="breadcrumb-item active">Product</li>
                    <li class="breadcrumb-item active">Shopping Details</li>
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
                        <h6 class="mb-4">Update Product Detail</h6>
                        <form role="form"  method="POST" action="{{ route('admin.shopping_details.update', ['id'=>$product->id]) }}" enctype="multipart/form-data" role="form">
                            @csrf
                            <div class="row mb-3">
                                <label for="Name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $product->name }}" class="form-control" id="name" placeholder="Name"
                                        name="name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="slug" class="col-sm-2 col-form-label">Slug</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $product->slug }}" class="form-control" id="slug" placeholder="Slug"
                                        name="slug">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="price" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" value="{{ $product->price }}" class="form-control" id="price" placeholder="Price"
                                        name="price">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="discount_price" class="col-sm-2 col-form-label">Discount Price</label>
                                <div class="col-sm-10">
                                    <input type="number" value="{{ $product->discount_price }}" class="form-control" id="discount_price" placeholder="Discount Price"
                                        name="discount_price">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="short_description" class="col-sm-2 col-form-label">Short Description</label>
                                <div class="col-sm-10">
                                    <input type="number" value="{{ $product->short_description }}" class="form-control" id="short_description" placeholder="Short Description"
                                        name="short_description">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="qty" class="col-sm-2 col-form-label">QTY</label>
                                <div class="col-sm-10">
                                    <input type="number" value="{{ $product->qty }}" class="form-control" id="qty" placeholder=""
                                        name="qty">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="shipping" class="col-sm-2 col-form-label">Shipping</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $product->shipping }}"  class="form-control" id="shipping" placeholder="Shipping"
                                        name="shipping">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="weight" class="col-sm-2 col-form-label">Weight</label>
                                <div class="col-sm-10">
                                    <input type="number" value="{{ $product->weight }}"  class="form-control" id="weight" placeholder="Weight"
                                        name="weight">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" >{{ $product->description }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="information" class="col-sm-2 col-form-label">Information</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $product->information }}" class="form-control" id="information" placeholder=""
                                        name="information">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Choose Image</label>
                                    <input id="imgInp" class="form-control bg-dark" accept="image/png, image/jpeg" value="{{ $product->image_url }}" type="file" id="image_url" name="image_url" placeholder="Image">
                                    @php
                                        $imageLink = is_null($product->image_url) || !file_exists("images/" .$product->image_url) ? 'default-images.png' : $product->image_url;
                                    @endphp

                                    <img  id="blah" src="{{asset('images/'.$imageLink)}}" alt="{{$product->image_url}}" width="150" height="150" >

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Choose Image Detail</label>
                                    <input class="form-control bg-dark"  type="file" id="galleryInput" name="gallery[]" placeholder="Image" multiple>
                                </div>
                                <div class="gallery-container" style="display: flex; gap: 10px;">
                                    @if(is_array($product->gallery))
                                        @foreach($product->gallery as $galleryImage)
                                            @php
                                                $galleryPath = public_path('images/' . $galleryImage);
                                            @endphp

                                            <div class="image-container">
                                                @if($galleryPath)
                                                    <img src="{{ url($galleryImage) }}" alt="{{ $galleryImage }}" width="150" height="150" >
                                                @else
                                                    <p class="error-message">Hình ảnh không tồn tại</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="status" name="status"
                                    aria-label="Floating label select example">
                                    <option value="">----Please Select----</option>
                                    <option {{ $product->status ? 'selected' : '' }} value="1">Show</option>
                                    <option {{ !$product->status ? 'selected' : '' }} value="0">Hide</option>
                                </select>
                                <label for="status">Status</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="brand_product" name="brand_product_id"
                                    aria-label="Floating label select example">
                                    <option value="" selected>----Please Select----</option>
                                    @foreach ($listBrand as $brandproduct)
                                    <option @if ($brandproducts->id == $brandproduct->id) selected @endif
                                        value="{{ $brandproduct->id }}">{{ $brandproduct->name }}</option>
                                    @endforeach
                                </select>
                                <label for="brand_product_id">Brand Product</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="product_category" name="product_category_id"
                                    aria-label="Floating label select example">
                                    <option value="" selected>----Please Select----</option>

                                    @foreach ($productCategories as $productCategory )
                                    <option @if($product->product_category_id === $productCategory->id) selected @endif value="{{ $productCategory->id }}">{{$productCategory->name}}</option>
                                    @endforeach
                                </select>
                                <label for="product_category_id">Product Category</label>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="id" value="{{ $product->id }}">
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
