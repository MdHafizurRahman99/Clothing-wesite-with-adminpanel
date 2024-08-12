@extends('layouts.frontend.master')
@section('css')
    <style>
        .color-rows {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(30px, 1fr));
            gap: 10px;
            /* Adjust gap between color cells as needed */
            max-width: 100%;
            /* Set a max-width if needed */
            margin: 0 auto;
            /* Center the grid */
        }

        .color-cell {
            width: 30px;
            /* Width of each color cell */
            height: 30px;
            /* Height of each color cell */
            border: 1px solid #ccc;
            /* Add a border to each cell */
        }


        .palette-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .selected-color-label {
            font-weight: bold;
            text-transform: uppercase;
        }

        .selected-color-cell {
            width: 25px;
            height: 25px;
        }


        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th:first-child {
            /* Targeting the first th element */
            width: 30%;
            /* Adjust the width as per your requirement */
        }

        th {
            /* background-color: #f2f2f2; */
            font-weight: bold;
        }

        tr:nth-child(even) {
            /* background-color: #f2f2f2; */
        }

        input[type="text"] {
            width: 100%;
            border: none;
            padding: 4px;
            box-sizing: border-box;
        }

        .color-circle {
            width: 20px;
            height: 20px;
            /* border-radius: 50%; */
            display: inline-block;
            margin-right: 5px;
            border: 1px solid #000;
            /* You can adjust the border properties */
        }


        table {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            border-collapse: collapse;
            width: auto;
            /* Set table width to fit content */
        }

        th {
            background-color: #ddd;
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
        }

        td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .responsive-table-container {
            overflow-x: auto;
            width: 100%;
        }

        #productTable {
            width: 100%;
            border-collapse: collapse;
        }

        #productTable th,
        #productTable td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        #productTable input[type="number"] {
            width: 100%;
            box-sizing: border-box;
        }



        /*
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    .table-container {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            display: inline-block;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            vertical-align: top;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            width: 100%;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    .add-to-cart {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        display: inline-block;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        vertical-align: top;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        margin-top: 5px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        margin-left: calc(100% - 100px);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } */
    </style>
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- @foreach ($data as $key => $quantity)
        @if (isset($errors[$key]))
            <span class="error-message">{{ $errors[$key][0] }}</span>
        @endif
    @endforeach --}}
    <!-- Breadcrumb Start -->
    {{-- <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shop Detail</span>
                </nav>
            </div>
        </div>
    </div> --}}
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        @if (count($galleryImages) > 0)
                            @foreach ($galleryImages as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img class="w-100 h-100" src="{{ asset($image->image_url) }}" alt="Image">
                                </div>
                            @endforeach
                        @else
                            {{-- {{ 'hello' }} --}}
                            <div class="carousel-item active">
                                <img class="w-100 h-100" src="{{ asset('assets/product/images/image.png') }}"
                                    alt="">
                            </div>
                        @endif

                    </div>

                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">

                    <h3>
                        {{ $product->display_name }}

                    </h3>
                    {{-- <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">(99 Reviews)</small>
                    </div> --}}
                    {{-- <h3 class="font-weight-semi-bold mb-4">$150.00</h3> --}}
                    <a href="#tab-pane-2" id="descriptionButton">Description</a>

                    <img data-scroll-to="#tab-pane-2" class="arrow-down"
                        src="https://cdn11.bigcommerce.com/s-lqiq2tqil5/stencil/90a14080-f3cf-013c-939a-26a0343d0efa/e/bc1bcf60-d99c-013a-0c0c-0a826e8002bf/icons/icon-arrow-down.svg"
                        alt="Arrow Down">
                    {{-- <p class="mb-4">{{ $product->description }}</p> --}}
                    <div class="form-group">
                        <label for="name">Product Discount Price on Quantity:</label>
                        @php
                            $i = 0;
                        @endphp
                        @php
                            $sizes = ['1st-Range', '2nd-Range', '3rd-Range', '4th-Range', '5th-Range'];
                        @endphp
                        {{-- <table id="productTable"> --}}
                        <table>
                            <thead>
                                <tr>
                                    <th>Units</th>
                                    @foreach ($sizes as $size)
                                        @if (isset($minQuantity[$i]))
                                            <th>
                                                <span>{{ isset($minQuantity[$i]) ? ($minQuantity[$i] == $maxQuantity[$i] ? $minQuantity[$i] . '+' : $minQuantity[$i] . '-' . $maxQuantity[$i]) : '' }}</span>
                                            </th>
                                        @endif
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Price</td>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($sizes as $size)
                                        @if (isset($minQuantity[$i]))
                                            <td>
                                                <span>
                                                    {{ isset($minQuantity[$i]) && isset($maxQuantity[$i]) && isset($prices[$minQuantity[$i]][$maxQuantity[$i]]) ? $prices[$minQuantity[$i]][$maxQuantity[$i]] : '' }}
                                                </span>
                                            </td>
                                        @endif
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        {{-- Removed commented color section as it's not used in current logic --}}
                        @error('quantity')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-flex mb-3">
                        <strong class="text-dark mr-3">Sizes:</strong>
                        <form id="sizeForm">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-1" name="size"
                                    value="XS">
                                <label class="custom-control-label" for="size-1">XS</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-2" name="size"
                                    value="S">
                                <label class="custom-control-label" for="size-2">S</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-3" name="size"
                                    value="M">
                                <label class="custom-control-label" for="size-3">M</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-4" name="size"
                                    value="L">
                                <label class="custom-control-label" for="size-4">L</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-5" name="size"
                                    value="XL">
                                <label class="custom-control-label" for="size-5">XL</label>
                            </div>
                            <input type="hidden" id="productId" value="{{ $product->id }}">
                        </form>
                    </div>
                    {{-- <div class="d-flex mb-4">
                        <strong class="text-dark mr-3">Colors:</strong>
                        <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-1" name="color">
                                <label class="custom-control-label" for="color-1">Black</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-2" name="color">
                                <label class="custom-control-label" for="color-2">White</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-3" name="color">
                                <label class="custom-control-label" for="color-3">Red</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-4" name="color">
                                <label class="custom-control-label" for="color-4">Blue</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-5" name="color">
                                <label class="custom-control-label" for="color-5">Green</label>
                            </div>
                        </form>
                    </div> --}}
                    {{-- <div class="d-flex mb-4">
                        <strong class="text-dark mr-3">Neck level?</strong>
                        <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="neck_level-1" name="neck_level">
                                <label class="custom-control-label" for="neck_level-1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="neck_level-2" name="neck_level">
                                <label class="custom-control-label" for="neck_level-2">No</label>
                            </div>

                        </form>
                    </div>
                    <div class="d-flex mb-4">
                        <strong class="text-dark mr-3">Swing Tag?</strong>
                        <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="swing_tag-1" name="swing_tag">
                                <label class="custom-control-label" for="swing_tag-1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="swing_tag-2" name="swing_tag">
                                <label class="custom-control-label" for="swing_tag-2">No</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                            </div>
                        </form>
                    </div> --}}

                    <div class="form-group color-palette">
                        <div class="palette-header">
                            <label>Colour.</label>
                            <div class="selected-color-cell " id="selectedColorCell" style="background-color: ;"></div>
                            <!-- Example selected color -->
                        </div>
                        {{-- @php
                            $colors = [
                                'Aquamarine',
                                'DarkGoldenRod',
                                'Blue',
                                'Red',
                                'Purple',
                                'White',
                                'SlateBlue',
                                'Orange',
                                'DodgerBlue',
                                'MediumSeaGreen',
                                'LightGray',
                            ];
                        @endphp --}}
                        <div class="color-rows">
                            @foreach ($colorImages as $key => $color)
                                @if ($key != null)
                                    {{-- @dd($key) --}}

                                    <div class="color-cell" style="background-color: {{ $key }};"
                                        onclick="selectColor('{{ $key }}')"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>




                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-primary px-3" id="addToCartButton">
                            <i class="fa fa-shopping-cart mr-1"></i> Add To Cart
                        </button>
                        <a href="#tab-pane-1" id="buyBulkButton" class="btn btn-primary px-3 m-2">
                            Buy Blank
                        </a>


                    </div>
                    {{-- <div class="responsive-table-container">
                        <p>Available inventory is shown below.</p>
                        @php
                            $colors = ['Aquamarine', 'DarkGoldenRod', 'Blue', 'Brown', 'Purple', 'White'];
                            $productPrice = 10;
                        @endphp
                        @if ($product->productsizetype == 1)
                            @php
                                $sizes = ['XS', 'S', 'M', 'L', 'XL'];
                            @endphp
                        @else
                            @php
                                $sizes = ['8', '10', '12', '14', '18'];
                            @endphp
                        @endif
                        <table id="productTable">
                            <thead>
                                <tr>
                                    <th>Colour \ Size</th>
                                    @foreach ($sizes as $size)
                                        <th>{{ $size }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <?php $data = session()->get('data'); ?>
                                @foreach ($colors as $color)
                                    <tr>
                                        <td>
                                            <span class="color-circle" style="background-color:{{ $color }}"></span>
                                            {{ $color }}
                                        </td>
                                        @foreach ($sizes as $size)
                                            <td>
                                                <input type="number" name="{{ $size }}_{{ $color }}"
                                                    value="{{ isset($data[$size . '_' . $color]) ? $data[$size . '_' . $color] : '' }}"
                                                    {{ isset($quentity[$size][$color]) && $quentity[$size][$color] > '0' ? '' : 'disabled' }}
                                                    placeholder="{{ isset($quentity[$size][$color]) ? $quentity[$size][$color] : '' }}">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>Total Price:</td>
                                    @foreach ($sizes as $index => $size)
                                        @if ($index < count($sizes) - 1)
                                            <td></td>
                                        @endif
                                    @endforeach
                                    <td>
                                        <input id="totalPrice" type="text" readonly name="total_price" value="$0">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-right mb-3">
                            <button id="addToCartBtn" class="btn btn-primary px-3 mt-2"><i
                                    class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                        </div>
                    </div> --}}
                    {{-- <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <form action="{{ route('home.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="row px-xl-5">
                <div class="col">
                    <div class="bg-light p-30">
                        <div class="nav nav-tabs mb-4">
                            <a class="nav-item nav-link text-dark active" id="orderGridTab" data-toggle="tab"
                                href="#tab-pane-1">Order Grid</a>

                            <a class="nav-item nav-link text-dark " data-toggle="tab" id="descriptionTab"
                                href="#tab-pane-2">Description</a>
                            <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Information</a>
                            <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-4">Reviews (0)</a>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-pane-1">
                                <p>Inventory available is shown.</p>
                                {{-- <table id="productTable">
                                <!-- Rows and columns will be added dynamically by JavaScript -->
                            </table> --}}
                                @php
                                    $colors = ['Aquamarine', 'DarkGoldenRod', 'Blue', 'Brown', 'Purple', 'White'];
                                    $productPrice = 10;
                                @endphp
                                @if ($product->productsizetype == 1)
                                    @php
                                        $sizes = ['XS', 'S', 'M', 'L', 'XL'];
                                    @endphp
                                @else
                                    @php
                                        $sizes = ['8', '10', '12', '14', '18'];
                                    @endphp
                                @endif
                                <table id="productTable">
                                    <thead>
                                        <tr>
                                            <th>Colour \ Size</th>
                                            @foreach ($sizes as $size)
                                                <th>{{ $size }}</th>
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $data = session()->get('data'); ?>
                                        @foreach ($colors as $color)
                                            <tr>
                                                <td>
                                                    <span class="color-circle"
                                                        style="background-color:{{ $color }}">
                                                    </span>
                                                    {{ $color }}
                                                </td>


                                                {{-- @dd($data); --}}
                                                @foreach ($sizes as $size)
                                                    <td>
                                                        <input type="number"
                                                            name="{{ $size }}_{{ $color }}"
                                                            value="{{ isset($data[$size . '_' . $color]) ? $data[$size . '_' . $color] : '' }}"
                                                            {{ isset($quentity[$size][$color]) && $quentity[$size][$color] > '0' ? '' : 'disabled' }}
                                                            placeholder=" {{ isset($quentity[$size][$color]) ? $quentity[$size][$color] : '' }}">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>Total Price:</td>
                                            @foreach ($sizes as $index => $size)
                                                @if ($index < count($sizes) - 1)
                                                    <td></td>
                                                @endif
                                            @endforeach
                                            <td>
                                                {{-- <input type="hidden" readonly name="product_price"
                                                    value="{{ $productPrice }}"> --}}
                                                <input id="totalPrice" type="text" readonly name="total_price"
                                                    value="$0">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-right mb-3">
                                    {{-- <span ></span> --}}
                                    <button id="addToCartBtn" class="btn btn-primary px-3 mt-2"><i
                                            class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                                    {{-- <a href="{{ route('shop.custom-design') }}" class="btn btn-primary px-3 mt-2">
                                        Add to cart
                                    </a> --}}
                                </div>
                                {{-- </div> --}}
                            </div>
                            <div class="tab-pane fade show" id="tab-pane-2">
                                <h4 class="mb-3">Product Description</h4>
                                <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam
                                    invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod
                                    consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum
                                    diam.
                                    Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing,
                                    eos
                                    dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod
                                    nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt
                                    tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                                <p>Dolore magna est eirmod sanctus dolor, amet diam et eirmod et ipsum. Amet dolore tempor
                                    consetetur sed lorem dolor sit lorem tempor. Gubergren amet amet labore sadipscing clita
                                    clita diam clita. Sea amet et sed ipsum lorem elitr et, amet et labore voluptua sit
                                    rebum.
                                    Ea erat sed et diam takimata sed justo. Magna takimata justo et amet magna et.</p>
                            </div>
                            <div class="tab-pane fade" id="tab-pane-3">
                                <h4 class="mb-3">Additional Information</h4>
                                <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam
                                    invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod
                                    consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum
                                    diam.
                                    Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing,
                                    eos
                                    dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod
                                    nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt
                                    tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0">
                                                Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0">
                                                Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                            </li>
                                            <li class="list-group-item px-0">
                                                Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-pane-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="mb-4">1 review for "Product Name"</h4>
                                        <div class="media mb-4">
                                            <img src="{{ asset('frontend/') }}/img/user.jpg" alt="Image"
                                                class="img-fluid mr-3 mt-1" style="width: 45px;">
                                            <div class="media-body">
                                                <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                                <div class="text-primary mb-2">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <i class="far fa-star"></i>
                                                </div>
                                                <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam
                                                    ipsum
                                                    et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="mb-4">Leave a review</h4>
                                        <small>Your email address will not be published. Required fields are marked
                                            *</small>
                                        <div class="d-flex my-3">
                                            <p class="mb-0 mr-2">Your Rating * :</p>
                                            <div class="text-primary">
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                        </div>
                                        <form>
                                            <div class="form-group">
                                                <label for="message">Your Review *</label>
                                                <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Your Name *</label>
                                                <input type="text" class="form-control" id="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Your Email *</label>
                                                <input type="email" class="form-control" id="email">
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="submit" value="Leave Your Review"
                                                    class="btn btn-primary px-3">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Shop Detail End -->


    <!-- Products Start -->
    {{-- <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May
                Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('frontend/') }}/img/product-1.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5>
                                <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('frontend/') }}/img/product-2.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5>
                                <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('frontend/') }}/img/product-3.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5>
                                <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('frontend/') }}/img/product-4.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5>
                                <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('frontend/') }}/img/product-5.jpg"
                                alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                        class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5>
                                <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Products End -->
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnMinus = document.querySelector('.btn-minus');
            const btnPlus = document.querySelector('.btn-plus');
            const input = document.querySelector('.form-control');
            const addToCartButton = document.getElementById('addToCartButton');
            const productId = document.getElementById('productId').value;
            let selectedColor = '';

            btnMinus.addEventListener('click', function() {
                let value = parseInt(input.value);
                if (value > 1) {
                    value--;
                    input.value = value;
                }
            });

            btnPlus.addEventListener('click', function() {
                let value = parseInt(input.value);
                value++;
                input.value = value;
            });

            window.selectColor = function(color) {
                selectedColor = color;
                document.querySelector('.selected-color-cell').style.backgroundColor = color;
            };

            addToCartButton.addEventListener('click', function() {
                const quantity = parseInt(input.value);
                const size = document.querySelector('input[name="size"]:checked') ? document.querySelector(
                    'input[name="size"]:checked').value : null;

                if (!size) {
                    alert('Please select a size.');
                    return;
                }

                if (!selectedColor) {
                    alert('Please select a color.');
                    return;
                }

                const cartItem = {
                    product_id: productId,
                    quantity: quantity,
                    size: size,
                    color: selectedColor
                };

                console.log('Item added to cart:', cartItem);

                fetch('/add-to-cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(cartItem)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        if (data.error == true) {
                            alert(data.message);
                        } else {
                            window.location.href = data.redirect_url;
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert(error.message);
                    });
            });
        });
    </script>
    {{-- <script>
        function selectColor(color) {
            document.querySelector('.selected-color-cell').style.backgroundColor = color;

            // const colorCells = document.querySelectorAll('.color-cell');
            // // Get the carousel image elements
            // const carouselImages = document.querySelectorAll('#product-carousel .carousel-item img');

            // Attach event listeners to color cells
            // colorCells.forEach((cell) => {
            // console.log('hello');
            // cell.addEventListener('click', () => {
            // const selectedColor = cell.style.backgroundColor;
            // Update the carousel images with the selected color
            // carouselImages.forEach((img) => {
            //     // console.log('hello');

            //     const coloredImageUrl = `{{ asset('assets/frontend/product/colored') }}/${color}.jpeg`;
            //     img.src = coloredImageUrl;
            // });
            // });
            // });
        }
    </script> --}}
    {{-- <script>
        const productTable = $('#productTable');
        const sizes = ['XS', 'S', 'M', 'L', 'XL'];
        const colors = ['Red', 'Green', 'Blue', 'Yellow', 'Purple', 'White'];

        // Create table header
        const headerRow = $('<tr></tr>');
        headerRow.append('<th></th>'); // Empty cell for row number
        sizes.forEach(size => headerRow.append(`<th>${size}</th>`));
        productTable.append(headerRow);

        // Create table rows and columns with input fields
        colors.forEach((color, rowIndex) => {
            const row = $('<tr></tr>');
            row.append(`<td>${color}</td>`); // Row number
            sizes.forEach(color => {
                const cell = $('<td><input type="text" value="0"></input></td>');
                row.append(cell);
            });
            productTable.append(row);
        });
    </script> --}}
    <script>
        $(document).ready(function() {

            // Get the carousel inner element
            const carouselInner = document.querySelector('#product-carousel .carousel-inner');

            const colorCells = document.querySelectorAll('.color-cell');

            // Attach event listeners to color cells
            colorCells.forEach((cell) => {
                cell.addEventListener('click', () => {

                    // const selectedColor = cell.style.backgroundColor;
                    function capitalizeFirstLetter(string) {
                        return string.charAt(0).toUpperCase() + string.slice(1);
                    }

                    var selectedColor = cell.style.backgroundColor;
                    selectedColor = capitalizeFirstLetter(selectedColor);
                    var colorImages = @json($colorImages);

                    console.log(selectedColor);
                    // const colorImages = {
                    //     'blue': ['assets/frontend/product/gallery-images/51942121.jpeg',
                    //         'blue-image2.jpg', 'blue-image3.jpg', 'blue-image4.jpg',
                    //         'assets/frontend/product/gallery-images/51942121.jpeg'
                    //     ],
                    //     'green': ['green-image1.jpg', 'green-image2.jpg', 'green-image3.jpg',
                    //         'green-image4.jpg',
                    //         'green-image5.jpg', 'green-image6.jpg', 'green-image7.jpg'
                    //     ],
                    //     'red': ['assets/frontend/product/gallery-images/51942121.jpeg',
                    //         'red-image2.jpg', 'red-image3.jpg'
                    //     ]
                    // };

                    const imagesForSelectedColor = colorImages[selectedColor];

                    // Clear existing carousel items
                    carouselInner.innerHTML = '';
                    // console.log(asset('/'));
                    // Populate carousel with new set of images
                    imagesForSelectedColor.forEach((imageUrl, index) => {
                        const carouselItem = document.createElement('div');
                        carouselItem.classList.add('carousel-item');
                        if (index === 0) {
                            carouselItem.classList.add('active');
                        }
                        const img = document.createElement('img');
                        var baseURL = '/';
                        imageUrl = `${baseURL}${imageUrl}`;

                        img.src = `${imageUrl}`;
                        img.classList.add('w-100', 'h-100');
                        img.alt = 'Image';
                        carouselItem.appendChild(img);
                        carouselInner.appendChild(carouselItem);
                    });
                });
            });


            $('#productTable input[type="number"]').on('input', function() {
                calculateTotalPrice();
            });
            // var total = 0;
            // $('#addToCartBtn').on('click', function() {
            //     $('#cartBadge').text(total);
            // });

            function calculateTotalPrice() {
                var total = 0;
                $('#productTable input[type="number"]').each(function() {
                    var quantity = parseInt($(this).val());
                    if (!isNaN(quantity)) {
                        total += quantity;
                    }
                });
                $('#totalPrice').val('$' + (total * <?php echo $product->price; ?>));
                // $('#totalPrice').text(' $' + (total * <?php echo $productPrice; ?>));
            }
            // console.log(total);

        });
    </script>
    <script>
        document.getElementById('buyBulkButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default anchor behavior

            // Activate the Order Grid tab
            var orderGridTab = document.getElementById('orderGridTab');
            $(orderGridTab).tab('show');

            // Use a slight delay to ensure the tab content is visible before scrolling
            setTimeout(function() {
                var tabPane = document.querySelector('#tab-pane-1');
                tabPane.scrollIntoView({
                    behavior: 'smooth'
                });
            }, 200); // Adjust the delay if necessary
        });
        // for description
        document.getElementById('descriptionButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default anchor behavior

            // Activate the Order Grid tab
            var descriptionTab = document.getElementById('descriptionTab');
            $(descriptionTab).tab('show');

            // Use a slight delay to ensure the tab content is visible before scrolling
            setTimeout(function() {
                var tabPane = document.querySelector('#tab-pane-2');
                tabPane.scrollIntoView({
                    behavior: 'smooth'
                });
            }, 200); // Adjust the delay if necessary
        });
    </script>
@endsection
