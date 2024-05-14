@extends('layouts.admin.master')

@section('title')
    Add Inventory
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/opensans-font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/roboto-font.css') }}">
    <link rel="stylesheet" type="text/css "
        href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css"> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <style>
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
            /* width: 30%; */
            /* Adjust the width as per your requirement */
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        input[type="text"] {
            width: 100%;
            border: none;
            padding: 4px;
            box-sizing: border-box;
        }

        .underline-text {
            text-decoration: underline;
        }

        .color-circle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            border: 1px solid #000;
            /* You can adjust the border properties */
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="wizard-v4-content">
            <div class="wizard-form">
                <div class="wizard-header">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ 'There is invalid information in Form Data' }}
                        </div>
                    @endif
                    <h3 class="heading">Add Inventory </h3>
                    {{-- <p>Add Permissions </p> --}}
                </div>
                <form class="form-register" id="myForm" action="{{ route('inventory.store') }}" method="post">
                    @csrf
                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">

                    <div id="form-total">
                        <h2>
                            {{-- <span class="step-icon"><i class="zmdi zmdi-lock"></i></span> --}}
                            {{-- <span class="step-text">Contact Details</span> --}}
                        </h2>
                        <section>
                            <div class="inner">
                                <div class="form-group">
                                    {{-- <label for="name">Product Pattern:</label>
                                    @php
                                        $pattern = App\Models\Pattern::find($product->pattern_id);
                                    @endphp
                                    <span>{{ $pattern->name }}</span>
                                   
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}

                                    @php
                                        $colors = ['Aquamarine', 'DarkGoldenRod', 'Blue', 'Brown', 'Purple', 'White'];
                                    @endphp
                                    @if ($product->productsizetype == 2)
                                        @php
                                            $sizes = ['8', '10', '12', '14', '18'];
                                        @endphp
                                    @else
                                        @php
                                            $sizes = ['XS', 'S', 'M', 'L', 'XL'];
                                        @endphp
                                    @endif
                                    {{-- <div class="form-group">
                                    <label for="product_pattern">Product Size</label>
                                 
                                    <select class="form-control" name="size" id="product_pattern">
                                        <option value="">Select Option</option>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size }}"
                                                {{ $size == old('size') ? 'selected' : '' }}>
                                                {{ $size }}</option>
                                        @endforeach
                                    </select>
                                    @error('size')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}
                                    {{-- <div class="form-group">
                                    <label for="product_pattern">Product Color</label>
                                    <select class="form-control" name="color" id="product_pattern">
                                        <option value="">Select Option</option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color }}"
                                                {{ $color == old('color') ? 'selected' : '' }}>
                                                {{ $color }}</option>
                                        @endforeach
                                    </select>
                                    @error('color')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}

                                    <div class="form-group">
                                        <label for="name">Product Quentity</label>
                                        @php
                                            $productPrice = 10;
                                        @endphp
                                        <table id="productTable">
                                            <thead>
                                                <tr>
                                                    <th>Colour\Size</th>
                                                    @foreach ($sizes as $size)
                                                        <th>{{ $size }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($colors as $color)
                                                    <tr>
                                                        <td>
                                                            {{-- <span class="color-circle"
                                                            style="background-color:{{ $color }}"></span> --}}
                                                            {{ $color }}
                                                        </td>
                                                        @foreach ($sizes as $size)
                                                            <td>
                                                                <input type="text"
                                                                    name="{{ $size }}_{{ $color }}"
                                                                    value="{{ isset($quentity[$size][$color]) ? $quentity[$size][$color] : '' }}"
                                                                    placeholder="{{ isset($quentity[$size][$color]) ? $quentity[$size][$color] : '' }}">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        @error('quentity')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group">
                                    <label for="weight">Product Weight</label>
                                    <input required type="text" id="weight" name="weight"
                                        value="{{ old('weight') }}" class="form-control" placeholder="Product Weight">
                                    @error('weight')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}

                                    {{-- <div class="form-group">
                                    <label for="quantity">Product Quantity</label>
                                    <input required type="text" id="quantity" name="quantity"
                                        value="{{ old('quantity') }}" class="form-control" placeholder="Product Quantity">
                                    @error('quantity')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}
                                </div>
                        </section>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.steps.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
    {{-- this code will disable all the input fields of postal_address if (same as ) checked  --}}

    <script>
        $(document).ready(function() {
            $('.wizard-v4-content').on('click', 'a[href="#finish"]', function(event) {
                event.preventDefault(); // Prevent default link behavior
                $('#myForm').submit(); // Submit the form with ID 'myForm'
            });
        });
    </script>
@endsection
