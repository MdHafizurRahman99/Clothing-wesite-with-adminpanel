@extends('layouts.frontend.master')
@section('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>

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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>color</th> {{-- <th>Color</th> --}}
                            <th>Quantity</th>
                            {{-- <th>Total</th> --}}
                            {{-- <th>Remove</th> --}}
                        </tr>
                    </thead>
                    <button id="addRowBtn" class="btn btn-primary mb-3 ">Add Row</button>

                    <tbody class="align-middle" id="productTableBody">
                        @if (!empty($cartproducts) && isset($cartproducts))
                            {{-- @dd($cartproducts) --}}
                            @foreach ($cartproducts as $cartproduct)
                                {{-- @dd($cartproduct) --}}
                                @if (!empty($cartproduct['input']))
                                    @php
                                        $inputData = $cartproduct['input'];
                                        // Remove the first element
                                        // array_shift($inputData);
                                        // // Remove the second element
                                        // array_shift($inputData);
                                    @endphp
                                    {{-- @dd($cartproducts) --}}
                                    @foreach ($inputData as $key => $quantity)
                                        {{-- @dd($key) --}}
                                        @if ($key === 'product_id')
                                            @php
                                                $product_id = $quantity;
                                            @endphp
                                            @continue
                                        @endif
                                        @if ($key === '_token')
                                            @continue
                                        @endif
                                        @if ($quantity !== null && $quantity > 0)
                                            <!-- Check if quantity is not null and greater than 0 -->
                                            @php
                                                $product_size = substr($key, 0, strpos($key, '_')); // Extract size from key
                                                $product_color = substr($key, strpos($key, '_') + 1); // Extract color from key
                                                $product = App\Models\Product::find($product_id);

                                                $productQuentity = App\Models\Inventory::where(
                                                    'product_id',
                                                    $product_id,
                                                )
                                                    ->whereNotNull('quantity')
                                                    ->get();

                                                $sizes = $productQuentity->pluck('size')->unique()->toArray();
                                                $colors = $productQuentity->pluck('color')->unique()->toArray();
                                            @endphp
                                            {{-- @dd($productQuentity) --}}
                                            <tr>
                                                <td class="align-middle"><img
                                                        src="{{ asset('frontend/') }}/img/product-2.jpg" alt=""
                                                        style="width: 50px;fornt-size:12;">
                                                    {{ $product->display_name }}
                                                </td>
                                                <td class="align-middle">${{ $product->price }}</td>

                                                <td class="align-middle">
                                                    <select class="form-control size" name="size_{{ $product_id }}">
                                                        @foreach ($sizes as $size)
                                                            <option value="{{ $size }}"
                                                                {{ $product_size == $size ? 'selected' : '' }}>
                                                                {{ $size }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="align-middle">
                                                    <select class="form-control color" name="color_{{ $product_id }}">
                                                        @foreach ($colors as $color)
                                                            <option value="{{ $color }}"
                                                                {{ $product_color == $color ? 'selected' : '' }}>
                                                                {{ $color }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                {{-- <td class="align-middle">{{ $quantity }}</td> --}}
                                                <td class="align-middle">
                                                    <div class="input-group quantity mx-auto" style="width: max-content;">
                                                        <input type="hidden" class="product-id"
                                                            value="{{ $product_id }}" name="product_id">
                                                        <input type="hidden" class="key" value="{{ $key }}"
                                                            name="key">

                                                        <div class="input-group-btn">
                                                            <button class="btn btn-sm btn-primary btn-minus">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text" readonly
                                                            class="form-control form-control-sm bg-secondary border-0 text-center quantity-input"
                                                            value="{{ $quantity }}">

                                                        <div class="input-group-btn">
                                                            <button class="btn btn-sm btn-primary btn-plus">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-sm btn-danger btn-delete mx-2">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td>There is no product in cart</td>
                            </tr>
                        @endif
                        {{--
                        <tr>
                            <td class="align-middle"><img src="{{ asset('frontend/') }}/img/product-2.jpg" alt=""
                                    style="width: 50px;">
                                Product Name</td>
                            <td class="align-middle">$150</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text"
                                        class="form-control form-control-sm bg-secondary border-0 text-center"
                                        value="{{ $quantity }}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">$150</td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger"><i
                                        class="fa fa-times"></i></button></td>
                        </tr> --}}

                        {{-- <tr>
                            <td class="align-middle"><img src="{{ asset('frontend/') }}/img/product-3.jpg" alt=""
                                    style="width: 50px;">
                                Product Name</td>
                            <td class="align-middle">$150</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text"
                                        class="form-control form-control-sm bg-secondary border-0 text-center"
                                        value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">$150</td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger"><i
                                        class="fa fa-times"></i></button></td>
                        </tr>
                        <tr>
                            <td class="align-middle"><img src="{{ asset('frontend/') }}/img/product-4.jpg" alt=""
                                    style="width: 50px;">
                                Product Name</td>
                            <td class="align-middle">$150</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text"
                                        class="form-control form-control-sm bg-secondary border-0 text-center"
                                        value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">$150</td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger"><i
                                        class="fa fa-times"></i></button></td>
                        </tr>
                        <tr>
                            <td class="align-middle"><img src="{{ asset('frontend/') }}/img/product-5.jpg" alt=""
                                    style="width: 50px;">
                                Product Name</td>
                            <td class="align-middle">$150</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text"
                                        class="form-control form-control-sm bg-secondary border-0 text-center"
                                        value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">$150</td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger"><i
                                        class="fa fa-times"></i></button></td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                {{-- <form class="mb-30" action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form> --}}
                @if (isset($totalPrice))
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                            Summary</span></h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>
                                <h6>${{ $totalPrice }}</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Total Quantity Discount</h6>
                                @php
                                    $discount = $totalPrice - $discountedPrice;
                                    $total = $discountedPrice + 50;
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
                            @if (isset(auth()->user()->id))
                                <a href="{{ route('shop.product-checkout') }}"
                                    class="btn btn-block btn-primary font-weight-bold my-3 py-3">
                                    Proceed To Checkout
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="btn btn-block btn-primary font-weight-bold my-3 py-3">
                                    Please Login To Checkout
                                </a>
                            @endif
                            {{-- <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button> --}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('js')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}
    <script>
        $(document).ready(function() {

            // Function to add a new row to the table
            $('#addRowBtn').click(function() {
                var newRow = `
                    <tr>
                        <td class="align-middle">
                            <input type="text" class="form-control product-search" placeholder="Search Product">
                            <input type="hidden" class="product-id" value="">
                        </td>
                        <td class="align-middle product-price">$0</td>
                        <td class="align-middle">
                            <select class="form-control size">
                                <option value="">Select Size</option>
                                <!-- Other sizes -->
                            </select>
                        </td>
                        <td class="align-middle">
                            <select class="form-control color">
                                <option value="">Select Color</option>
                                <!-- Other colors -->
                            </select>
                        </td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <input type="hidden" class="key" value="">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" readonly class="form-control form-control-sm bg-secondary border-0 text-center quantity-input" value="0">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                $('#productTableBody').prepend(newRow);

                // Initialize autocomplete for the new input
                $('.product-search').autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('search-products') }}",
                            method: 'GET',
                            data: {
                                term: request.term
                            },
                            success: function(data) {
                                response(data);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    },
                    select: function(event, ui) {
                        var row = $(this).closest('tr');
                        row.find('.product-id').val(ui.item.id);
                        row.find('.product-price').text(`$${ui.item.price}`);
                        // Fetch sizes and colors for the selected product
                        $.ajax({
                            url: "{{ route('get-product-details') }}", // This route will fetch sizes and colors
                            method: 'GET',
                            data: {
                                product_id: ui.item.id
                            },
                            success: function(data) {
                                // console.log(data);
                                if (data.sizes.length === 0 && data.colors
                                    .length === 0) {
                                    alert('Product is out of stock');
                                    row
                                        .remove(); // Optionally, remove the row if no product is available
                                    return;
                                }
                                var sizeOptions =
                                    '<option value="">Select Size</option>';
                                var colorOptions =
                                    '<option value="">Select Color</option>';

                                data.sizes.forEach(function(size) {
                                    sizeOptions +=
                                        `<option value="${size}">${size}</option>`;
                                });

                                data.colors.forEach(function(color) {
                                    colorOptions +=
                                        `<option value="${color}">${color}</option>`;
                                });

                                row.find('.size').html(sizeOptions);
                                row.find('.color').html(colorOptions);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                });
            });

            // Initialize autocomplete for the existing input (if any)
            $('.product-search').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('search-products') }}",
                        method: 'GET',
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                },
                select: function(event, ui) {
                    var row = $(this).closest('tr');
                    row.find('.product-id').val(ui.item.id);
                    row.find('.product-price').text(`$${ui.item.price}`);
                }
            });
            // Function to handle the quantity update and AJAX request
            function updateQuantity(element) {
                // Find the closest quantity container
                // var quantityContainer = $(element).closest('.quantity');

                // Find the product ID input within the quantity container
                // var productId = quantityContainer.find('.product-id').val();
                // var key = quantityContainer.find('.key').val();

                // Find the parent row
                var parentRow = $(element).closest('tr');

                // Select the size and color within the same parent row
                var size = parentRow.find('.size option:selected').val();
                var color = parentRow.find('.color option:selected').val();
                var key = parentRow.find('.key').val();
                var productId = parentRow.find('.product-id').val();
                var quantity = parentRow.find('.quantity-input').val();

                // Create the new key
                var newkey = `${size}_${color}`;

                // Find the quantity input within the quantity container
                // var quantityInput = quantityContainer.find('.quantity-input');

                // Get the current quantity
                // var quantity = parseInt(quantityInput.val());

                // If the element is the plus button, increment the quantity
                // if ($(element).hasClass('btn-plus')) {
                //     quantity++;
                // }

                // Update the quantity input value
                // quantityInput.val(productId);
                // console.log(quantity);
                // Make the AJAX request to increment the quantity
                if (size && color) {

                    $.ajax({
                        url: "{{ route('increment-quantity') }}",
                        method: 'POST',
                        data: {
                            key: key,
                            newkey: newkey,
                            productId: productId,
                            quantity: quantity,
                        },
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                        },
                        success: function(data) {
                            // Update the cart badge value
                            $('#cartBadge').text(data);

                            // Optionally, reload the page after a short delay
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            // Handle errors or display an error message to the user.
                        }
                    });
                } else {
                    // Optionally, you can provide feedback to the user if size, color, or quantity is not selected or quantity is 0
                    console.warn("Please select size, color.");
                }
            }
            function deleteProduct(element) {
                var parentRow = $(element).closest('tr');
                var size = parentRow.find('.size option:selected').val();
                var color = parentRow.find('.color option:selected').val();
                var key = parentRow.find('.key').val();
                var productId = parentRow.find('.product-id').val();
                var quantity = 0;
                var newkey = `${size}_${color}`;

                // if (size && color) {

                    $.ajax({
                        url: "{{ route('increment-quantity') }}",
                        method: 'POST',
                        data: {
                            key: key,
                            newkey: newkey,
                            productId: productId,
                            quantity: quantity,
                        },
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                        },
                        success: function(data) {
                            // Update the cart badge value
                            $('#cartBadge').text(data);

                            // Optionally, reload the page after a short delay
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            // Handle errors or display an error message to the user.
                        }
                    });
                // } else {
                //     // Optionally, you can provide feedback to the user if size, color, or quantity is not selected or quantity is 0
                //     console.warn("Please select size, color.");
                // }
            }

            function addNewproduct(element) {
                // Find the closest quantity container
                // var quantityContainer = $(element).closest('.quantity');

                // Find the product ID input within the quantity container
                // var productId = quantityContainer.find('.product-id').val();
                // var key = quantityContainer.find('.key').val();

                // Find the parent row
                var parentRow = $(element).closest('tr');

                // Select the size and color within the same parent row
                var size = parentRow.find('.size option:selected').val();
                var color = parentRow.find('.color option:selected').val();
                var key = parentRow.find('.key').val();
                var productId = parentRow.find('.product-id').val();
                var quantity = parentRow.find('.quantity-input').val();

                // Create the new key
                var newkey = `${size}_${color}`;

                // Find the quantity input within the quantity container
                // var quantityInput = quantityContainer.find('.quantity-input');

                // Get the current quantity
                // var quantity = parseInt(quantityInput.val());

                // If the element is the plus button, increment the quantity
                // if ($(element).hasClass('btn-plus')) {
                //     quantity++;
                // }

                // Update the quantity input value
                // quantityInput.val(productId);
                // console.log(quantity);
                // Make the AJAX request to increment the quantity
                if (size && color && quantity != 0) {

                    $.ajax({
                        url: "{{ route('increment-quantity') }}",
                        method: 'POST',
                        data: {
                            key: key,
                            newkey: newkey,
                            productId: productId,
                            quantity: quantity,
                        },
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                        },
                        success: function(data) {
                            // Update the cart badge value
                            $('#cartBadge').text(data);

                            // Optionally, reload the page after a short delay
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            // Handle errors or display an error message to the user.
                        }
                    });
                } else {
                    // Optionally, you can provide feedback to the user if size, color, or quantity is not selected or quantity is 0
                    console.warn("Please select size, color .");
                }
            }


            // Attach click event to the plus button
            $(document).on('click', '.btn-plus', function() {
                var quantityContainer = $(this).closest('.quantity');
                var quantityInput = quantityContainer.find('.quantity-input');
                var quantity = parseInt(quantityInput.val());

                quantity++;
                quantityInput.val(quantity);
                updateQuantity(this);
            });
            $(document).on('click', '.btn-minus', function() {
                var quantityContainer = $(this).closest('.quantity');
                var quantityInput = quantityContainer.find('.quantity-input');
                var quantity = parseInt(quantityInput.val());

                if (quantity > 0) {
                    // console.log('hello');
                    quantity--;
                    // console.log(productId, quantity, key);
                    quantityInput.val(quantity);
                    updateQuantity(this);
                }
            });
            $(document).on('click', '.btn-delete', function() {

                        deleteProduct(this);

            });

            // Attach change event to the size and color select elements
            $(document).on('change', '.size, .color', function() {
                // console.log('hello');
                addNewproduct(this);
            });
        });



        // Handle plus button click
        // $('.btn-plus').click(function() {
        //     // Find the closest quantity container
        //     var quantityContainer = $(this).closest('.quantity');

        //     // Find the product ID input within the quantity container
        //     var productId = quantityContainer.find('.product-id').val();
        //     var key = quantityContainer.find('.key').val();


        //     var parentRow = $(this).closest('tr');
        //     // Select the size and color within the same parent tr
        //     var size = parentRow.find('.size option:selected').val();
        //     var color = parentRow.find('.color option:selected').val();

        //     var newkey = `${size}_${color}`;
        //     // console.log(newkey);
        //     // Find the quantity input within the quantity container
        //     var quantityInput = quantityContainer.find('.quantity-input');

        //     // Increment the quantity
        //     var quantity = parseInt(quantityInput.val());
        //     quantity++;
        //     quantityInput.val(quantity);

        //     // console.log(productId, quantity);
        //     $.ajax({
        //         url: "{{ route('increment-quantity') }}",
        //         method: 'POSt',
        //         data: {
        //             key: key,
        //             newkey: newkey,
        //             productId: productId,
        //             quantity: quantity,
        //         },
        //         headers: {
        //             'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
        //         },
        //         success: function(data) {
        //             var cartBadgeValue = data;
        //             $('#cartBadge').text(cartBadgeValue);
        //             setTimeout(function() {
        //                 location.reload();
        //             }, 1000);
        //             // console.log(data);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(error);
        //             // Handle errors or display an error message to the user.
        //         }
        //     });
        // });

        // Handle minus button click
        // $('.btn-minus').click(function() {
        //     var quantityContainer = $(this).closest('.quantity');

        //     // Find the product ID input within the quantity container
        //     var productId = quantityContainer.find('.product-id').val();
        //     var key = quantityContainer.find('.key').val();

        //     var parentRow = $(this).closest('tr');
        //     // Select the size and color within the same parent tr
        //     var size = parentRow.find('.size option:selected').val();
        //     var color = parentRow.find('.color option:selected').val();

        //     var newkey = `${size}_${color}`;

        //     // Find the quantity input within the quantity container
        //     var quantityInput = quantityContainer.find('.quantity-input');

        //     // Increment the quantity
        //     var quantity = parseInt(quantityInput.val());
        //     // quantity++;
        //     // quantityInput.val(quantity);

        //     // console.log(productId, key);
        //     var quantity = parseInt(quantityInput.val());
        //     if (quantity > 0) {
        //         // console.log('hello');
        //         quantity--;
        //         // console.log(productId, quantity, key);

        //         quantityInput.val(quantity);
        //         var csrfToken = $('meta[name="csrf-token"]').attr('content');
        //         // Send AJAX request to update cache and totalProduct
        //         $.ajax({
        //             url: "{{ route('decrement-quantity') }}",
        //             method: 'POSt',
        //             data: {
        //                 key: key,
        //                 newkey: newkey,
        //                 productId: productId,
        //                 quantity: quantity,
        //             },
        //             headers: {
        //                 'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
        //             },
        //             success: function(data) {
        //                 var cartBadgeValue = data;
        //                 $('#cartBadge').text(cartBadgeValue);
        //                 setTimeout(function() {
        //                     location.reload();
        //                 }, 1000);
        //                 console.log(data);
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error(error);
        //                 // Handle errors or display an error message to the user.
        //             }
        //         });
        //     }
        // });
    </script>
@endsection
