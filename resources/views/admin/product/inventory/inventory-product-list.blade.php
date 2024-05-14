@extends('layouts.admin.master')
@section('title')
    Products
@endsection

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .user-add-shedule-list {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .user-add-shedule-list button.btn-primary,
        .user-add-shedule-list button.btn-primary span {
            color: white !important;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Product List</h1>
            @if (Auth::user()->can('product.add'))
                <div class="user-add-shedule-list">
                    <div class="col-auto float-right ml-auto">

                        {{-- <button class="btn-primary" data-toggle="modal" data-target="#add_shift"> Add Shifts</button> --}}
                    </div>
                </div>
            @endif

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- @if (Auth::user()->can('product.add'))
                        <a class="btn btn-primary" href="{{ route('product.create') }}">Add Product </a>
                    @endif --}}
                    @if (session('message'))
                        <div class="alert alert-success mt-3">
                            {{ session('message') }}
                        </div>
                    @endif
                    {{-- <h6 class="m-0 font-weight-bold text-primary">products List</h6> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Pattern</th>
                                    @if (Auth::user()->can('product.edit') || Auth::user()->can('product.delete'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            {{-- <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </tfoot> --}}
                            <tbody>
                                {{-- @dd($products) --}}
                                {{-- @foreach ($products as $groupName => $group) --}}
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <p class="p-2"> {{ $product->name }}</p>
                                        </td>
                                        @php
                                            $pattern = App\Models\Pattern::where('id', $product->pattern_id)->first();
                                        @endphp
                                        <td>
                                            <p class="p-2"> {{ $pattern->name }}</p>
                                        </td>
                                        @if (Auth::user()->can('product.edit') || Auth::user()->can('product.delete'))
                                            <td>
                                                <a
                                                    href="{{ route('product.inventories', ['product_id' => $product->id]) }}">
                                                    <input class="btn btn-warning" type="button" value="View Inventory">
                                                </a>
                                            </td>
                                        @endif

                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
