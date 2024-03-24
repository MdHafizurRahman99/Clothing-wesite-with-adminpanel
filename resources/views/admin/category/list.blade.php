@extends('layouts.admin.master')
@section('title')
    Categories
@endsection

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Category List</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    {{-- <h6 class="m-0 font-weight-bold text-primary">categorys List</h6> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    @if (Auth::user()->can('category.edit') || Auth::user()->can('category.delete'))
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
                                {{-- @dd($categorys) --}}
                                {{-- @foreach ($categorys as $groupName => $group) --}}
                                @foreach ($Categories as $category)
                                    <tr>
                                        <td>
                                            <p class="p-2"> {{ $category->category_name }}</p>
                                        </td>
                                        @if (Auth::user()->can('category.edit') || Auth::user()->can('category.delete'))
                                            <td>
                                                @if (Auth::user()->can('category.edit'))
                                                    <a href="{{ route('category.edit', ['category' => $category->id]) }}">
                                                        <input class="btn btn-warning" type="button" value="Edit">
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('category.delete'))
                                                    <form
                                                        action="{{ route('category.destroy', ['category' => $category->id]) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                                            onclick="return confirm('Do you want to delete this Category!')">
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
