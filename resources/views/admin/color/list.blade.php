@extends('layouts.admin.master')
@section('title')
    Colors
@endsection

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Colors List</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    {{-- <h6 class="m-0 font-weight-bold text-primary">colors List</h6> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Color Code</th>
                                    {{-- @if (Auth::user()->can('color.edit') || Auth::user()->can('color.delete'))
                                        <th>Action</th>
                                    @endif --}}

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
                                {{-- @dd($colors) --}}
                                {{-- @foreach ($colors as $groupName => $group) --}}
                                @foreach ($colors as $color)
                                    <tr>
                                        <td>
                                            <p class="p-2"> {{ $color->name }}</p>
                                        </td>

                                        <td>
                                            <p class="p-2"> {{ $color->code }}</p>
                                        </td>
                                        {{-- @if (Auth::user()->can('color.edit') || Auth::user()->can('color.delete'))
                                            <td>
                                                @if (Auth::user()->can('color.edit'))
                                                    <a href="{{ route('color.edit', ['color' => $color->id]) }}">
                                                        <input class="btn btn-warning" type="button" value="Edit">
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('color.delete'))
                                                    <form action="{{ route('color.destroy', ['color' => $color->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                                            onclick="return confirm('Do you want to delete this client request!')">
                                                    </form>
                                                @endif
                                            </td>
                                        @endif --}}
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
