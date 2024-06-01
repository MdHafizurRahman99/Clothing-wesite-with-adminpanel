@extends('layouts.admin.master')
@section('title')
    Orders
@endsection

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Orders List</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    {{-- <h6 class="m-0 font-weight-bold text-primary">orders List</h6> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Order Date</th>
                                    <th>Total Amount</th>
                                    @if (Auth::user()->can('order.edit') || Auth::user()->can('order.delete'))
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
                                {{-- @dd($orders) --}}
                                {{-- @foreach ($orders as $groupName => $group) --}}
                                @foreach ($orders as $order)
                                    <tr>
                                        {{-- @dd($order->customer_id) --}}
                                        @php
                                            $customer_info = \App\Models\User::find($order->customer_id);
                                        @endphp
                                        <td>
                                            <p class="p-2"> {{ $customer_info->name }} </p>
                                        </td>
                                        <td>
                                            <p class="p-2">
                                                {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y h:i A') }}</p>
                                        </td>
                                        <td>
                                            <p class="p-2"> {{ $order->total_price }}</p>
                                        </td>
                                        @if (Auth::user()->can('order.edit') || Auth::user()->can('order.delete'))
                                            <td>
                                                @if (Auth::user()->can('order.edit'))
                                                    <a href="{{ route('order.edit', ['order' => $order->id]) }}">
                                                        <input class="btn btn-warning" type="button" value="Edit">
                                                    </a>
                                                @endif
                                                @if (Auth::user()->can('order.delete'))
                                                    <form action="{{ route('order.destroy', ['order' => $order->id]) }}"
                                                        method="POST">
                                                        {{-- @method('DELETE') --}}
                                                        @csrf
                                                        <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                                            onclick="return confirm('Do you want to delete this client request!')">
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
    <script>
            //to disable initial ordering

        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [], // Disable initial ordering
                "columnDefs": [{
                        "orderable": false,
                        "targets": [4]
                    } // Disable ordering on the Action column
                ]
            });
        });
    </script>
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
