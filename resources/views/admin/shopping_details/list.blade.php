@extends('admin.layout.master')
@section('content')
    {{-- <div style="margin-left:50px">
        <form action="" method="GET">
            <input type="text" placeholder="Search..." name="keyword" value="{{ is_null(request()->keyword) ? "" : request()->keyword }}">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option @if(request()->status === '') selected @endif value="">----Select All----</option>
                <option @if(request()->status === '1') selected @endif value="1">Show</option>
                <option @if(request()->status === '0') selected @endif value="0">Hide</option>
            </select>

            <label for="sort">Sort</label>
            <select name="sort" id="sort">
                <option @if(request()->sort === '0') selected @endif value="0">Lastest</option>
                <option @if(request()->sort === '1') selected @endif value="1">Price low to high</option>
                <option @if(request()->sort === '2') selected @endif value="2">Price high to low</option>
            </select>
            <p>
                <label for="amount">Price range:</label>
                <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                <input type="hidden" id="amount_start" name="amount_start">
                <input type="hidden" id="amount_end" name="amount_end" >
            </p>
            <div id="slider-range"></div>
            <button type="submit">Search</button>

        </form>
    </div> --}}
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
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
            @if (session('message'))
                <span class="alert-success" style="font-size: 25px">
                    {{ session('message') }}
                </span><br>
            @endif
            <div class="col-lg-12 col-md-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div style="display: flex; justify-content: space-between;">
                        <h6 class="mb-4">Product Details</h6>
                        <div class="InputContainer" style="margin-right: 250px;">
                            <form action="" method="get">
                                <input  placeholder="Search.." class="input" name="keyword" value="{{ is_null(request()->keyword) ? "" : request()->keyword}}">
                            </form>
                        </div>
                    </div>
                    <form action="{{ route('admin.shopping_details.deleteAll') }}" method="post">
                        @csrf
                        <div class="function" style="display: flex;">
                            <div class="col-lg-8 col-md-12">
                                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" type="submit">Delete All
                                    Selected</button>
                            </div>
                            <div class="col-lg-8 col-md-12">
                                <a class="btn btn-primary" style="height: 40px; margin-left: 10px" href="{{ route('admin.shopping_details.create') }}">Create Product</a>
                          </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px"><input id="selectAll" type="checkbox"></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    {{-- <th scope="col">Slug</th> --}}
                                    <th scope="col">Price</th>
                                    {{-- <th scope="col">Discount Price</th> --}}
                                    {{-- <th scope="col">Short Description</th> --}}
                                    {{-- <th scope="col">Description</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Shipping</th>
                                    <th scope="col">Weight</th>
                                    <th scope="col">Information</th> --}}
                                    <th scope="col">Image</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Product Category</th>
                                    <th scope="col">Create</th>
                                    <th scope="col">Update</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product )
                                <tr>
                                    <th><input name='id[]' id="selectAll" value="{{ $product->id }}" type="checkbox">
                                    </th>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    {{-- <td>{{ $product->slug }}</td> --}}
                                    <td>{{ number_format($product->price, 0, ',', '.') }} VND</td>
                                    {{-- <td>{{ number_format($product->discount_price) }}</td> --}}
                                    {{-- <td>{{ $product->short_description }}</td>
                                    <td>{!! $product->description !!}</td>
                                    <td>{{ $product->qty }}</td>
                                    <td>{{ $product->shipping }}</td>
                                    <td>{{ $product->weight }}</td>
                                    <td>{{ $product->information }}</td> --}}
                                    <td>
                                        @php
                                            $imageLink = is_null($product->image_url) || !file_exists("images/" .$product->image_url) ? 'default-images.png' : $product->image_url;
                                        @endphp
                                        <img src="{{asset('images/'.$imageLink)}}" alt="{{$product->image_url}}" width="150" height="150" >
                                    </td>
                                    <td>
                                        <a class="btn btn-{{ $product->status ? 'success' : 'danger' }}">
                                            {{ $product->status ? 'Show' : 'Hide'}}
                                        </a>
                                    </td>
                                    <td>{{ $product->brand->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->created_at }}</td>
                                    <td>{{ $product->updated_at }}</td>
                                    <td>
                                        <form method="post" action="{{route('admin.shopping_details.destroy', ['id' => $product->id])}}">
                                            @csrf
                                            {{ method_field('delete') }}
                                            <a href=" {{route('admin.shopping_details.show', ['id' => $product->id])}}" class="btn btn-primary">Edit</a>
                                            <button onclick="return confirm('Are You Sure?')" type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        @if ($product->trashed())
                                            <form action="{{ route('admin.shopping_details.restore', ['product' => $product->id])}}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Restore</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12">No Product</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </form>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $products->links('pagination::bootstrap-4') }}
                        </ul>
                    </div>
                </div>
                {{-- <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        {{ $products->appends(request()->query())->links() }}
                    </ul>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
@section('js-custom')
    <script type="text/javascript">
        $(document).ready(function(){
            $( "#slider-range" ).slider({
                range: true,
                min: {{ $minPrice }},
                max: {{ $maxPrice }},
                values: [ {{ request()->amount_start ?? 0 }}, {{ request()->amount_end ?? $maxPrice }} ],
                slide: function( event, ui ) {
                    $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                    $('#amount_start').val(ui.values[0]);
                    $('#amount_end').val(ui.values[1]);
                }
            });
            $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
            $('#amount_start').val($( "#slider-range" ).slider( "values", 0 ));
            $('#amount_end').val($( "#slider-range" ).slider( "values", 1 ));
        });
        $(document).ready(function() {
            $("#selectAll").click(function() {
                $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
            });
        })
    </script>
@endsection
