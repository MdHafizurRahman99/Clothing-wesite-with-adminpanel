@extends('layouts.admin.master')

@section('title')
    Edit Inventory
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
                    <h3 class="heading">Edit Inventory </h3>
                    {{-- <p>Edit Permissions </p> --}}
                </div>
                <form class="form-register" id="myForm"
                    action="{{ route('inventory.update', ['inventory' => $inventory->id]) }}" method="post">
                    @method('PUT')
                    @csrf
                    <input type="hidden" id="product_id" name="product_id" value="{{ $inventory->product_id }}">

                    <div id="form-total">
                        <h2>
                            {{-- <span class="step-icon"><i class="zmdi zmdi-lock"></i></span> --}}
                            {{-- <span class="step-text">Contact Details</span> --}}
                        </h2>
                        <section>
                            <div class="inner">
                                @php
                                    $colors = ['Aquamarine', 'DarkGoldenRod', 'Blue', 'Brown', 'Purple', 'White'];
                                @endphp
                                <div class="form-group">
                                    <label for="product_pattern">Product Size</label>
                                    @if ($product->productsizetype == 2)
                                        @php
                                            $sizes = ['8', '10', '12', '14', '18'];
                                        @endphp
                                        <select class="form-control" name="size" id="product_pattern">
                                            <option value="">Select Option</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size }}"
                                                    {{ $size == $inventory->size ? 'selected' : '' }}>
                                                    {{ $size }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        @php
                                            $sizes = ['XS', 'S', 'M', 'L', 'XL','XXL'];
                                        @endphp
                                        <select class="form-control" name="size" id="product_pattern">
                                            <option value="">Select Option</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size }}"
                                                    {{ $size == $inventory->size ? 'selected' : '' }}>
                                                    {{ $size }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('size')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_pattern">Product Color</label>
                                    <select class="form-control" name="color" id="product_pattern">
                                        <option value="">Select Option</option>
                                        {{-- <option value="Oversized">Oversized</option> --}}
                                        @foreach ($colors as $color)
                                            <option value="{{ $color }}"
                                                {{ $color == $inventory->color ? 'selected' : '' }}>
                                                {{ $color }}</option>
                                        @endforeach
                                    </select>
                                    @error('color')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- <div class="form-group">
                                    <label for="weight">Product Weight</label>
                                    <input required type="text" id="weight" name="weight"
                                        value="{{ old('weight') !== null ? old('weight') : $inventory->weight }}"
                                        class="form-control" placeholder="Product Weight">
                                    @error('weight')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}
                                <div class="form-group">
                                    <label for="quantity">Product Quantity</label>
                                    <input required type="text" id="quantity" name="quantity"
                                        value="{{ old('quantity') !== null ? old('quantity') : $inventory->quantity }}"
                                        class="form-control" placeholder="Product Quantity">
                                    @error('quantity')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
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
