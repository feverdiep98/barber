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
                                <li class="breadcrumb-item active">Manage Order</li>
                                <li class="breadcrumb-item active">Order</li>
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
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="col-lg-12 col-md-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <form action="{{ route('admin.manage_order.deleteAll') }}" method="post">
                        @csrf
                        <h6 class="mb-4">Product Details</h6>
                        <div class="function" style="display: flex;">
                            <div class="col-lg-8 col-md-12">
                                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" type="submit">Delete
                                    All
                                    Selected</button>
                            </div>
                            <div class="col-lg-8 col-md-12">
                                <a class="btn btn-primary" href="">Create Order</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 10px"><input id="selectAll" type="checkbox"></th>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Payment_method</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($manages as $manage)
                                        <tr>
                                            <th><input name='id[]' id="selectAll" value="{{ $manage->id }}"
                                                    type="checkbox">
                                            </th>
                                            <td>{{ $manage->id }}</td>
                                            <td>{{ $manage->customer_name }}</td>
                                            <td>
                                                @php
                                                    $orderStatus = $manage->status;
                                                    $statusClass = ($orderStatus === 'pending') ? 'danger' : (($orderStatus === 'completed') ? 'success' : 'warning');
                                                @endphp

                                                <a class="btn btn-{{ $statusClass }}">
                                                    {{ ucfirst($orderStatus) }}
                                                </a>
                                            </td>
                                            <td>{{ $manage->delivery_date ?? 'N/A' }}</td>
                                            <td>{{ $manage->payment_method }}</td>
                                            <td>{{ number_format($manage->total, 0, ',', '.') }} VND <br> Quantity:
                                                {{ $manage->calculateTotalQuantity() }}
                                            </td>
                                            <td>
                                                <form method="post"
                                                    action="{{ route('admin.manage_order.delete', ['id' => $manage->id]) }}">
                                                    @csrf
                                                    {{ method_field('delete') }}
                                                    <a href=" {{ route('admin.manage_order.detail', ['id' => $manage->id]) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    <button onclick="return confirm('Are You Sure?')" type="submit"
                                                        class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12">No Order</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $manages->links('pagination::bootstrap-4') }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
