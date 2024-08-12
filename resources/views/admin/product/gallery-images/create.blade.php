@extends('layouts.admin.master')
@section('title')
    Add Gallery Images
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/opensans-font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/roboto-font.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    {{-- Dropzone --}}
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <style>
        .wizard-v4-content {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .wizard-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .dropzone {
            border: 2px dashed #007bff;
            border-radius: 5px;
            background: #f9f9f9;
            padding: 30px;
            text-align: center;
            cursor: pointer;
        }

        .dropzone .dz-message {
            font-size: 1.2em;
            color: #777;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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
                    <h3 class="heading">Add Gallery Images</h3>
                </div>
                <form class="form-register" id="myForm" action="{{ route('gallery-images.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" value="{{ $product_id }}" id="product_id" name="product_id">
                        <label for="colorSelect">Choose color:</label>
                        <select class="form-control" id="colorSelect" name="color">
                            @foreach ($colors as $color)
                                <option value="{{$color->name}}">{{$color->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Upload Product Gallery Images Here:</label>
                        <div id="myDropzone" class="dropzone">
                            <div class="dz-message">
                                <span>Drop files here or click to upload.</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary m-2" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        var myDropzone = new Dropzone("#myDropzone", {
            url: "{{ route('save-gallery-image') }}",
            // url: "{{ route('gallery-images.store') }}",
            autoProcessQueue: false,
            paramName: 'file',
            maxFilesize: 5, // Set the maximum file size (in MB)
            // maxFiles: 4,
            uploadMultiple: true,
            parallelUploads: 99999, // number of file will upload at a time
            acceptedFiles: ".jpg, .jpeg, .png, .gif",
            addRemoveLinks: true,
            dictDefaultMessage: "Drop files here or click to upload.",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            init: function() {

                // var submitButton = document.getElementById("formbutton");
                var submitButton = document.querySelector("#myForm button[type=submit]");
                var myDropzone = this;

                submitButton.addEventListener("click", function(e) {
                    myDropzone.processQueue();
                    if (myDropzone.getQueuedFiles().length === 0) {
                        event.preventDefault(); // Prevent default link behavior
                        $('#myForm').submit(); // Submit the form with ID 'myForm'
                    }
                });

                this.on("sending", function(file, xhr, formData) {
                    var product_id = document.querySelector("#product_id").value;
                    var color = document.querySelector("#colorSelect").value;
                    formData.append("product_id", product_id);
                    formData.append("color", color);
                });

                this.on("success", function(file, response) {
                    console.log(response);
                });

                this.on("error", function(file, errorMessage) {
                    console.log(file);

                });
            }
        });
    </script>
    <!-- Add this script at the end of your HTML body -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.steps.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
