@extends('layouts.frontend.master')

@section('css')
    <style>
        .order-process {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .progressbar {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .progressbar li {
            width: calc(100% / 14);
            /* Evenly distributing space */
            text-align: center;
            position: relative;
            font-size: 12px;
            color: #999;
            font-weight: 600;
        }

        .progressbar li:before {
            content: '';
            width: 20px;
            height: 20px;
            border: 2px solid #999;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: #fff;
            line-height: 20px;
            /* Center content inside the circle */
        }

        .progressbar li:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: #999;
            top: 10px;
            left: -50%;
            z-index: -1;
        }

        .progressbar li:first-child:after {
            content: none;
        }

        .progressbar li.completed:before {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            content: '\2713';
            /* Check mark */
            line-height: 18px;
            /* Align the checkmark inside the circle */
            font-size: 16px;
        }

        .progressbar li.in-progress:before {
            background-color: #ffc107;
            /* In-progress color */
            border-color: #ffc107;
        }

        .progressbar li.active+li:after {
            background-color: #0d6efd;
        }

        .order-process-title {
            text-align: center;
            /* Center text horizontally */
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
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
                                                class="form-control form-control-sm bg-secondary border-0 text-center quantity-input"
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
                <h5 class="section-title position-relative text-uppercase mb-3"><span
                        class="bg-secondary pr-3">Summary</span></h5>
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
                <h5 class="order-process-title text-uppercase mb-3"><span class="bg-secondary pr-3">Order Process</span>
                </h5>
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
                    $currentStepIndex = array_search($order->order_status, $steps);
                @endphp
                <div class="order-process">
                    <ul class="progressbar">
                        @foreach($steps as $index => $step)
                        <li class="{{ $index < $currentStepIndex ? 'completed' : ($index == $currentStepIndex ? 'in-progress' : '') }}">
                            {{ $step }}
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <!-- Cart End -->
@endsection


{{-- @section('js')
    document.addEventListener("DOMContentLoaded", function() {
    var currentStep = 5; // Replace this with the actual current step index (1-based)
    var totalSteps = document.querySelectorAll(".progress-steps .step").length;
    var progressPercentage = (currentStep / totalSteps) * 100;

    document.querySelector("#orderProgress .progress-bar").style.width = progressPercentage + "%";

    var steps = document.querySelectorAll(".progress-steps .step");
for (var i = 0; i < currentStep; i++) { steps[i].classList.add("active"); } }); @endsection  --}}
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
