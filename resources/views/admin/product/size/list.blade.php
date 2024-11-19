@extends('layouts.admin.master')
@section('title')
    Sizes
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
            <h1 class="h3 mb-2 text-gray-800">Sizes List</h1>
            @if (Auth::user()->can('product.add'))
                <div class="user-add-shedule-list">
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('productSize.create') }}">
                            <button class="btn-primary" data-toggle="modal" data-target="#add_schedule">Add Size</button>
                        </a>
                        {{-- <button class="btn-primary" data-toggle="modal" data-target="#add_shift"> Add Shifts</button> --}}
                    </div>
                </div>
            @endif
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>

                                    <th>Type</th>
                                    <th>Size</th>
                                    <th>Action</th>

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

                                @foreach ($sizes as $size)
                                    <tr>
                                        <td>
                                            <p class="p-2"> {{ $size->type == '1' ? 'XS,S,M,L,XL...' : '8,10,12,14,16...' }}
                                            </p>
                                        </td>

                                        <td>
                                            <p class="p-2"> {{ $size->size }}</p>
                                        </td>
                                        {{-- @if (Auth::user()->can('size.edit') || Auth::user()->can('size.delete')) --}}
                                            <td>
                                                {{-- @if (Auth::user()->can('size.edit'))
                                                    <a href="{{ route('size.edit', ['size' => $size->id]) }}">
                                                        <input class="btn btn-warning" type="button" value="Edit">
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('size.delete')) --}}
                                        <form action="{{ route('productSize.destroy', ['productSize' => $size->id]) }}"
                                            method="POST">
                                            @method('Delete')
                                            @csrf
                                            <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                                onclick="return confirm('Do you want to delete this client request!')">
                                        </form>
                                        {{-- @endif --}}
                                            </td>
                                        {{-- @endif --}}
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
