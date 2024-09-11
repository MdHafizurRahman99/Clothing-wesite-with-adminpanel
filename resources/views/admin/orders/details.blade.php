@extends('layouts.admin.master')
@section('title')
    Order Details
@endsection

@section('content')

    <!-- Breadcrumb Start -->
    {{-- <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shopping Cart</span>
                </nav>
            </div>
        </div>
    </div> --}}

    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Base Price</th>
                            <th>Size</th>
                            <th>color</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @if (!empty($order_details) && isset($order_details))
                            {{-- @dd($cartproducts) --}}
                            {{-- @foreach ($cartproducts as $cartproduct)
                                @if (!empty($cartproduct['input']))
                                    @php
                                        $inputData = $cartproduct['input'];
                                        // Remove the first element
                                        array_shift($inputData);
                                        // // Remove the second element
                                        // array_shift($inputData);
                                    @endphp --}}
                            @foreach ($order_details as $details)
                                {{-- @if ($key === 'product_id')
                                            @php
                                                $product_id = $quantity;
                                            @endphp
                                            @continue
                                        @endif --}}
                                {{-- @dd($key) --}}
                                {{-- @if ($quantity !== null && $quantity > 0) --}}
                                <!-- Check if quantity is not null and greater than 0 -->
                                @php
                                    $size = $details->size; // Extract size from key
                                    $color = $details->color; // Extract color from key
                                    $product = App\Models\Product::find($details->product_id);

                                @endphp
                                <tr>
                                    <td class="align-middle"><img src="{{ asset('frontend/') }}/img/product-2.jpg"
                                            alt="" style="width: 50px; fornt-size:12">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="{{ route('shop.details', ['id' => $product->id]) }}">
                                            {{ $product->display_name }}
                                        </a>
                                    </td>
                                    <td class="align-middle">${{ $product->price }}</td>
                                    <td class="align-middle">{{ $size }} </td>
                                    <td class="align-middle">{{ $color }}</td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">

                                            {{-- <span> {{ $details->quantity }}</span> --}}
                                            <input type="text" readonly
                                                class="form-control form-control-sm  border-0 text-center quantity-input"
                                                value="{{ $details->quantity }}">

                                        </div>
                                    </td>
                                </tr>
                                {{-- @endif --}}
                            @endforeach
                            {{-- @endif
                            @endforeach --}}
                        @else
                            <tr>
                                <td>There is no product</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class=" pr-3">Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>${{ $order->sub_total }}</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Total Discount</h6>
                            @php
                                $discount = $order->sub_total + 50 - $order->total_price;
                                $total = $order->total_price;
                            @endphp
                            <h6>${{ $discount }}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$50</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>${{ $total }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-4">
                @php
                    $steps = [
                        'Order Submitted',
                        'Processing',
                        'Order Confirmed',
                        'Queue For Production',
                        'Production Assessment',
                        'Fabric Organization',
                        'Cutting',
                        'Screen Print/Embroidery',
                        'Sewing',
                        'Finishing',
                        'Packaging',
                        'Ready To Ship',
                        'Shipped',
                        'Delivered',
                        'Order Closed',
                    ];

                    // Determine the index of the current step

                @endphp


                <h5 class=" text-uppercase mb-3"><span class=" pr-3">Change Order Process</span>
                </h5>
                <select name="order_status" class="order_status" data-order-id="{{ $order->id }}">
                    @foreach ($steps as $step)
                        <option value="{{ $step }}" {{ $step == $order->order_status ? 'selected' : '' }}>
                            {{ $step }}
                        </option>
                    @endforeach
                </select>

            </div>

        </div>
    </div>

    <!-- Cart End -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            function updateStatus(element) {

                var orderStatus = $(element).val(); // Get the selected value
                var orderId = $(element).data('order-id'); // Get the order ID.
                // console.log(orderId);
                $.ajax({
                    url: `/order/${orderId}/update-status`, // Replace with your route URL
                    method: 'POST',
                    data: {
                        order_status: orderStatus,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                    },
                    success: function(data) {
                        alert("Order status updated successfully!");

                        // console.log(data.success);
                        // Optionally, display a success message or update the UI
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Optionally, display an error message to the user
                    }
                });


                // $.ajax({
                //     url: "{{ route('increment-quantity') }}",
                //     method: 'POST',
                //     data: {
                //         key: key,
                //         newkey: newkey,
                //         productId: productId,
                //         quantity: quantity,
                //     },
                //     headers: {
                //         'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                //     },
                //     success: function(data) {
                //         // Update the cart badge value
                //         $('#cartBadge').text(data);

                //         // Optionally, reload the page after a short delay
                //         setTimeout(function() {
                //             location.reload();
                //         }, 1000);
                //     },
                //     error: function(xhr, status, error) {
                //         console.error(error);
                //         // Handle errors or display an error message to the user.
                //     }
                // });

            }
            $(document).on('change', '.order_status', function() {
                updateStatus(this);
            });
        });
    </script>
@endsection
