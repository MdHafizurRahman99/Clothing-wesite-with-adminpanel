{{-- @extends('layouts.message.master')

@section('content')
    @include('messenger.partials.flash')

    @each('messenger.partials.thread', $threads, 'thread', 'messenger.partials.no-threads')
@stop --}}


@extends('layouts.frontend.master')

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                {{-- <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shopping Cart</span>
                </nav> --}}
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-bordered table-light table-borderless table-hover text-center mb-0" id="dataTable"
                    width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            {{-- <th>Order Id</th> --}}
                            <th>Email Date</th>
                            <th>Subject</th>
                            <th>Body</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('messages.create') }}">
                            <input class="btn btn-primary mb-3" type="button" value="Compose">
                        </a>
                    </div>


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
                    <tbody class="align-middle">

                        @foreach ($threads as $thread)
                        <?php $class = $thread->isUnread(Auth::id()) ? 'alert-info' : ''; ?>

                            <tr class=" alert {{ $class }}">
                                <td class="align-middle">
                                    <p class="p-2">
                                        {{ \Carbon\Carbon::parse($thread->created_at)->format('M d, Y h:i A') }}</p>
                                </td>
                                <td class="align-middle">
                                    <p class="p-2"> {{ $thread->subject }}</p>
                                </td>
                                <td class="align-middle">
                                    <p class="p-2"> {{ $thread->latestMessage->body }}</p>
                                </td>


                                <td class="align-middle">
                                    <a href="{{ route('messages.show', ['id' => $thread->id]) }}">
                                        <input class="btn btn-warning" type="button" value="Details">
                                    </a>
                                    {{-- <a href="{{ route('cart.reorder', ['order' => $thread->id]) }}">
                                        <input class="btn btn-warning" type="button" value="Re-order">
                                    </a> --}}
                                    {{-- <form action="{{ route('order.destroy', ['order' => $thread->id]) }}" method="POST">
                                        @csrf
                                        <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                            onclick="return confirm('Do you want to delete this staff!')">
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('js')
<script>
    //to disable initial ordering
$(document).ready(function() {
    $('#dataTable').DataTable({
        "order": [], // Disable initial ordering
        "columnDefs": [{
                "orderable": false,
                // "targets": [4]
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

