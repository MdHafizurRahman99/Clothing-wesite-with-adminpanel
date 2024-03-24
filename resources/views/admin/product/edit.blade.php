@extends('layouts.admin.master')
@section('title')
    Edit Product
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/opensans-font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/roboto-font.css') }}">
    <link rel="stylesheet" type="text/css "
        href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    {{-- dropezone --}}
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" /> --}}



    <style>
        .underline-text {
            text-decoration: underline;
        }
    </style>
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
                    <h3 class="heading">Product Informations</h3>
                    {{-- <p>Fillup with currect Informations </p> --}}
                </div>
                <form class="form-register" id="myForm"
                    action="{{ route('product.update', ['product' => $product->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @method('PUT')

                    @csrf

                    {{-- <div class="inner"> --}}

                    <span> upload Product Imeges Here(Drop files here or click to upload).</span>
                    <div id="myDropzone" class="dropzone">
                        <div class="dz-message">
                            <span>Drop files here or click to upload.</span>
                        </div>
                    </div>
                    {{-- </div> --}}

                    {{-- <div id="myDropzone" class="dropzone">
                        <div class="dz-message">
                            <span>Drop files here or click to upload.</span>
                        </div>
                    </div> --}}
                    <div id="form-total">

                        <!-- SECTION 1 -->
                        <h2>
                            {{-- <span class="step-icon"><i class="zmdi zmdi-account"></i></span>
                            <span class="step-text"> General Details </span> --}}
                        </h2>
                        <section>
                            <div class="inner">
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input required type="text" id="name" name="name"
                                        value="{{ isset($product->name) ? $product->name : old('name') }} "
                                        class="form-control" placeholder="Product Name">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="product_category">Product Category</label>
                                    {{-- <input required type="text" id="product_category" name="product_category" value="{{ old('product_category') }}"
                                        class="form-control" placeholder="Category"> --}}
                                    <select class="form-control" name="category_id" id="product_category">
                                        <option value="">Select Option</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                {{ $category->category_name }}</option>
                                        @endforeach

                                    </select>
                                    @error('category_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Product Description</label>
                                    <textarea name="description" class="form-control" id="description" cols="70" rows="5">
@if ($errors->any())
{{ old('description') }}@else{{ $product->description }}
@endif
</textarea>

                                    {{-- <input required type="text" id="name" name="name" value="{{ old('name') }}"
                                        class="form-control" placeholder="Product Description"> --}}
                                    @error('description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <label for="image">Product Image</label> --}}

                                {{-- @error('image')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}
                                {{-- <div class="form-group">
                                    <label for="document">Documents</label>
                                    <div class="needsclick dropzone" id="document-dropzone">

                                    </div>
                                </div> --}}


                                {{-- <div class="form-group">
                                    <label for="name">Product Quentity</label>
                                    <input required type="number" id="quentity" name="quentity"
                                        value="{{ old('quentity') }}" class="form-control">
                                    @error('quentity')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div> --}}
                                <div class="form-group">
                                    <label for="name">Product Quentity</label>
                                    @php
                                        $sizes = ['XS', 'S', 'M', 'L', 'XL'];
                                        $colors = ['Aquamarine', 'DarkGoldenRod', 'Blue', 'Brown', 'Purple', 'White'];
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
                                                        <span class="color-circle"
                                                            style="background-color:{{ $color }}"></span>{{ $color }}
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
                                    {{-- <input required type="number" id="quentity" name="quentity"
                                        value="{{ old('quentity') }}" class="form-control"> --}}
                                    @error('quentity')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">Product Discount Price on Quentity</label>
                                    @php
                                        $sizes = ['1st-Range', '2nd-Range', '3rd-Range', '4th-Range', '5th-Range'];
                                        // $colors = ['Aquamarine', 'DarkGoldenRod', 'Blue', 'Brown', 'Purple', 'White'];

                                        // $productPrice = 10;
                                        $i = 0;
                                    @endphp
                                    <table id="productTable">
                                        <thead>
                                            <tr>
                                                <th>Units</th>
                                                @foreach ($sizes as $size)
                                                    <th><input type="text" name="{{ $size }}"
                                                            value="{{ isset($minQuantity[$i]) ? ($minQuantity[$i] == $maxQuantity[$i] ? $minQuantity[$i] . '+' : $minQuantity[$i] . '-' . $maxQuantity[$i]) : '' }}"
                                                            placeholder="{{ isset($minQuantity[$i]) ? ($minQuantity[$i] == $maxQuantity[$i] ? $minQuantity[$i] . '+' : $minQuantity[$i] . '-' . $maxQuantity[$i]) : $size }}">

                                                    </th>
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
                                                    <td><input type="text" name="{{ $size }}_price"
                                                            value="{{ isset($minQuantity[$i]) && isset($maxQuantity[$i]) && isset($prices[$minQuantity[$i]][$maxQuantity[$i]]) ? $prices[$minQuantity[$i]][$maxQuantity[$i]] : '' }}"
                                                            placeholder="{{ isset($minQuantity[$i]) && isset($maxQuantity[$i]) && isset($prices[$minQuantity[$i]][$maxQuantity[$i]]) ? $prices[$minQuantity[$i]][$maxQuantity[$i]] : '' }}">

                                                    </td>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            </tr>
                                            {{-- @foreach ($colors as $color)
                                                <tr>
                                                    <td>
                                                        <span class="color-circle"
                                                            style="background-color:{{ $color }}"></span>{{ $color }}
                                                    </td>
                                                    @foreach ($sizes as $size)
                                                        <td>
                                                            <input type="text"
                                                                name="{{ $size }}_{{ $color }}"
                                                                value=""
                                                                placeholder="{{ isset($predefinedValues[$size][$color]) ? $predefinedValues[$size][$color] : '' }}">
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach --}}
                                        </tbody>
                                    </table>
                                    {{-- <input required type="number" id="quentity" name="quentity"
                                        value="{{ old('quentity') }}" class="form-control"> --}}
                                    @error('quentity')
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
    <script>
        var myDropzone = new Dropzone("#myDropzone", {
            url: "{{ route('save-dropzone-image') }}",
            // url: "{{ route('product.store') }}",
            autoProcessQueue: false,
            paramName: 'file',
            maxFilesize: 5, // Set the maximum file size (in MB)
            maxFiles: 4,
            uploadMultiple: true,
            parallelUploads: 4, // number of file will upload at a time
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

                // submitButton.addEventListener("click", function(e) {
                $('.wizard-v4-content').on('click', 'a[href="#finish"]', function(event) {

                    console.log(myDropzone);

                    // e.preventDefault();
                    // e.stopPropagation();
                    myDropzone.processQueue();
                    if (myDropzone.getQueuedFiles().length === 0) {
                        // $('.wizard-v4-content').on('click', 'a[href="#finish"]', function(event) {
                        event.preventDefault(); // Prevent default link behavior
                        $('#myForm').submit(); // Submit the form with ID 'myForm'
                        // });
                    }
                });

                this.on("success", function(file, response) {
                    console.log(file);
                });

                this.on("error", function(file, errorMessage) {});
            }
        });
    </script>
    <!-- Add this script at the end of your HTML body -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.steps.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- <script>
        $(document).ready(function() {

            //start same As  Physical address (this code will disable postal address if there is a validation error on form)
            const sameAsPhysicalCheckbox = document.querySelector('#sameAsPhysical');
            const postalAddressFields = document.querySelectorAll('#postal_address input');
            // console.log(postalAddressFields);
            if ("{{ old('sameAsPhysical') }}") {
                // console.log('hello');
                postalAddressFields.forEach(field => {
                    field.disabled = true;
                });
            } else {
                postalAddressFields.forEach(field => {
                    field.disabled = false;
                });
            }
            //end sameAsPhysicalCheckbox

            //country code for phone

            var input = document.querySelector("#phone");

            var itiphone = window.intlTelInput(input, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('phone_iso2') }}"
            });

            // Retrieve selected country data
            function getSelectedCountryData() {
                var countryData = itiphone.getSelectedCountryData();
                // console.log(countryData);
                // console.log(countryData.iso2);
                // console.log(countryData.dialCode);
                var countryDialCode = countryData.dialCode;
                // Set the value of the hidden input field
                if (countryDialCode) {
                    document.getElementById('phone_country_dial_code').value = countryDialCode;
                    document.getElementById('phone_iso2').value = countryData.iso2;
                }
                // Check if there are old input values after validation

                var oldPhoneNumber = "{{ old('phone') }}";
                if (oldPhoneNumber !== '') {
                    $('#phone').val(oldPhoneNumber);
                }
            }

            // Event listener for when the country is changed
            input.addEventListener("countrychange", function() {
                getSelectedCountryData();
            });
            // Initial call to get selected country data
            getSelectedCountryData();
            //country code for fax

            var inputFax = document.querySelector("#fax");
            var iti = window.intlTelInput(inputFax, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('fax_iso2') }}"
            });

            // Retrieve selected country data
            function getSelectedCountryDatafax() {
                var countryData = iti.getSelectedCountryData();
                // console.log(countryData);
                // console.log(countryData.iso2);
                // console.log(countryData.dialCode);
                var countryDialCode = countryData.dialCode;
                // Set the value of the hidden inputFax field
                if (countryDialCode) {
                    document.getElementById('fax_country_dialCode').value = countryDialCode;
                    document.getElementById('fax_iso2').value = countryData.iso2;
                }
                // Check if there are old inputFax values after validation

                var oldfax = "{{ old('fax') }}";
                if (oldfax !== '') {
                    // Set the value manually and then reinitialize the fax inputFax
                    $('#fax').val(oldfax);
                }
            }
            // Event listener for when the country is changed
            inputFax.addEventListener("countrychange", function() {
                getSelectedCountryDatafax();
            });
            // Initial call to get selected country data
            getSelectedCountryDatafax();
        });
    </script> --}}

    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}


    {{-- <script>
        $(document).ready(function() {
            $('#emailInput').on('input', function() {
                var email = $(this).val();
                $('#email-val').text(email);
            });
        });
    </script> --}}

    {{-- this code will disable all the input fields of postal_address if (same as ) checked  --}}
    {{-- <script>
        function disablePostal() {
            const sameAsPhysicalCheckbox = document.querySelector('#sameAsPhysical');
            const postalAddressFields = document.querySelectorAll('#postal_address input');
            // console.log(postalAddressFields);
            // const isSameAsPhysicalFromServer = {{ old('sameAsPhysical') }};
            if (sameAsPhysicalCheckbox.checked == true) {
                // console.log('hello');
                postalAddressFields.forEach(field => {
                    field.disabled = true;
                });
            } else {
                postalAddressFields.forEach(field => {
                    field.disabled = false;
                });
                // text.style.display = "none";
            }
        }
    </script> --}}


    <!-- dropzone min -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script> --}}
    {{-- 
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('projects.storeMedia') }}',
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            },
            init: function() {
                @if (isset($project) && $project->document)
                    var files = {
                        !!json_encode($project - > document) !!
                    }
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                    }
                @endif
            }
        }
    </script> --}}

    {{-- 
    <script>
        $(document).ready(function() {
            $('.wizard-v4-content').on('click', 'a[href="#finish"]', function(event) {
                event.preventDefault(); // Prevent default link behavior
                $('#myForm').submit(); // Submit the form with ID 'myForm'
            });
        });
    </script> --}}
@endsection
