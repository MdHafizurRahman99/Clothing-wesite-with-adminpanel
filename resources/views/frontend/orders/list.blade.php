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
                            <th>Order Date</th>
                            <th>Total Amount</th>
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
                    <tbody class="align-middle">

                        @foreach ($orders as $order)
                            <tr>
                                <td class="align-middle">
                                    <p class="p-2">
                                        {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y h:i A') }}</p>

                                </td>
                                <td class="align-middle">
                                    <p class="p-2"> {{ $order->total_price }}</p>
                                </td>

                                <td class="align-middle">
                                    <a href="{{ route('order.show', ['order' => $order->id]) }}">
                                        <input class="btn btn-warning" type="button" value="Details">
                                    </a>
                                    {{-- <form action="{{ route('order.destroy', ['order' => $order->id]) }}" method="POST">
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
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
{{-- @section('js')
    <script>
        // Handle plus button click
        $('.btn-plus').click(function() {
            // Find the closest quantity container
            var quantityContainer = $(this).closest('.quantity');

            // Find the product ID input within the quantity container
            var productId = quantityContainer.find('.product-id').val();
            var key = quantityContainer.find('.key').val();

            // Find the quantity input within the quantity container
            var quantityInput = quantityContainer.find('.quantity-input');

            // Increment the quantity
            var quantity = parseInt(quantityInput.val());
            quantity++;
            quantityInput.val(quantity);

            // console.log(productId, quantity);
            $.ajax({
                url: "{{ route('increment-quantity') }}",
                method: 'POSt',
                data: {
                    key: key,
                    productId: productId,
                    quantity: quantity,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                },
                success: function(data) {
                    var cartBadgeValue = data;
                    $('#cartBadge').text(cartBadgeValue);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                    // console.log(data);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Handle errors or display an error message to the user.
                }
            });
        });

        // Handle minus button click
        $('.btn-minus').click(function() {
            var quantityContainer = $(this).closest('.quantity');

            // Find the product ID input within the quantity container
            var productId = quantityContainer.find('.product-id').val();
            var key = quantityContainer.find('.key').val();

            // Find the quantity input within the quantity container
            var quantityInput = quantityContainer.find('.quantity-input');

            // Increment the quantity
            var quantity = parseInt(quantityInput.val());
            // quantity++;
            // quantityInput.val(quantity);

            // console.log(productId, key);
            var quantity = parseInt(quantityInput.val());
            if (quantity > 0) {
                // console.log('hello');
                quantity--;
                // console.log(productId, quantity, key);

                quantityInput.val(quantity);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                // Send AJAX request to update cache and totalProduct
                $.ajax({
                    url: "{{ route('decrement-quantity') }}",
                    method: 'POSt',
                    data: {
                        key: key,
                        productId: productId,
                        quantity: quantity,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                    },
                    success: function(data) {
                        var cartBadgeValue = data;
                        $('#cartBadge').text(cartBadgeValue);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                        // console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Handle errors or display an error message to the user.
                    }
                });
            }
        });
    </script>
@endsection --}}
