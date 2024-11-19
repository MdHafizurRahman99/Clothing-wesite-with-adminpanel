@extends('layouts.admin.master')

@section('title')
    Add Size
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
                    <h3 class="heading">Add Size </h3>
                    {{-- <p>Add Sizes </p> --}}
                </div>
                <form class="form-register" id="myForm" action="{{ route('productSize.store') }}" method="post">
                    @csrf
                    <div id="form-total">
                        <h2>
                            {{-- <span class="step-icon"><i class="zmdi zmdi-lock"></i></span> --}}
                            {{-- <span class="step-text">Contact Details</span> --}}
                        </h2>
                        <section>
                            <div class="inner">
                                {{-- <div class="form-group">
                                    <label for="name">Size Name</label>
                                    <input required type="text" id="name" name="name"
                                        value="{{ old('name') }}" class="form-control"
                                        placeholder="Enter Size Name">

                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="code">Size Name</label>
                                    <input required type="text" id="code" name="code"
                                        value="{{ old('code') }}" class="form-control"
                                        placeholder="Enter Size Code">
                                    @error('color_code')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}
                                <div class="form-group">
                                    <label for="name">Product Size Type</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type"
                                            id="type1" value="1" checked>
                                        <label class="form-check-label" for="type1">
                                            XS,S,M,L,XL...
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type"
                                            id="type2" value="2">
                                        <label class="form-check-label" for="type2">
                                            8,10,12,14,16...
                                        </label>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type="text" id="type" name="type" class="form-control" required>
                                </div> --}}
                                <div class="form-group">
                                    <label for="size">Size</label>
                                    <input type="text" id="size" name="size" class="form-control" required>
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
