@extends('layouts.admin.master')
@section('title')
    Patterns
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
            <h1 class="h3 mb-2 text-gray-800">Pattern List</h1>
            @if (Auth::user()->can('product.add'))
                <div class="user-add-shedule-list">
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('pattern.create') }}">
                            <button class="btn-primary" data-toggle="modal" data-target="#add_schedule">Add Pattern</button>
                        </a>
                        {{-- <button class="btn-primary" data-toggle="modal" data-target="#add_shift"> Add Shifts</button> --}}
                    </div>
                </div>
            @endif

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- @if (Auth::user()->can('product.add'))
                        <a class="btn btn-primary" href="{{ route('product.create') }}">Add Pattern </a>
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
                                    <th>Pattern Name</th>
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
                                {{-- @dd($patterns) --}}
                                {{-- @foreach ($patterns as $groupName => $group) --}}
                                @foreach ($patterns as $pattern)
                                    <tr>
                                        <td>
                                            <p class="p-2"> {{ $pattern->name }}</p>
                                        </td>
                                        @if (Auth::user()->can('product.edit') || Auth::user()->can('product.delete'))
                                            <td>
                                                @if (Auth::user()->can('product.edit'))
                                                    <a href="{{ route('pattern.edit', ['pattern' => $pattern->id]) }}">
                                                        <input class="btn btn-warning" type="button" value="Edit">
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('product.delete'))
                                                    <form
                                                        action="{{ route('pattern.destroy', ['pattern' => $pattern->id]) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                                            onclick="return confirm('Do you want to delete this Pattern!')">
                                                    </form>
                                                @endif
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
