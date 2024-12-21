@extends('layouts.frontend.master')
@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/3.6.2/fabric.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.4/fabric.js"></script> --}}

    <style>
        /* Modal background and text styling */
        /* .modal-content {
                                                                                                                                                                                                    background-color: black;
                                                                                                                                                                                                    color: white;
                                                                                                                                                                                                } */

        /* Close button color */
        /* .close {
                                                                                                                                                                                                    color: white;
                                                                                                                                                                                                } */

        /* Image styling to make them black and white */
        /* Blur effect */
        .blur-effect {
            filter: blur(100px);
            /* Adjust blur intensity */
            transition: filter 0.1s ease;
            /* Smooth transition */
        }

        .modal-body img {
            /* filter: grayscale(100%); */
            transition: transform 0.3s ease, filter 0.3s ease;
            cursor: pointer;
        }

        /* Image hover effect */
        .modal-body img:hover {
            transform: scale(1.1);
            filter: grayscale(0%);
            /* Removes grayscale on hover */
        }

        /* Button styling */
        /* .btn-primary {
                                                                                                                                                                                        background-color: black;
                                                                                                                                                                                        border-color: white;
                                                                                                                                                                                        color: white;
                                                                                                                                                                                    }

                                                                                                                                                                                    .btn-primary:hover {
                                                                                                                                                                                        background-color: white;
                                                                                                                                                                                        color: black;
                                                                                                                                                                                    }

                                                                                                                                                                                    .btn-secondary {
                                                                                                                                                                                        background-color: white;
                                                                                                                                                                                        color: black;
                                                                                                                                                                                    }

                                                                                                                                                                                    .btn-secondary:hover {
                                                                                                                                                                                        background-color: black;
                                                                                                                                                                                        color: white;
                                                                                                                                                                                    } */

        .side-button {
            border: none;
            padding: 10px 20px;
            color: white;
            background-color: black;
            cursor: pointer;
            margin: 5px;
            font-size: 16px;
        }




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
    </style>
@endsection
@section('content')
    <div class="container-fluid pb-5" id="mainContent">
        <div class="row px-xl-5">

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <div id="canvasContainer">
                        <h3>Canvas</h3>
                        {{-- <dd>Product : {{$product_id}}</dd> --}}
                        {{-- @php
                            $product_id = session('product_id');
                        @endphp --}}
                        <canvas id="canvas" width="600" height="600" style="border: 1px solid #000000"></canvas>
                        <div class="mt-2">
                            {{-- <button onclick="frontside()" class="btn btn-primary">Front Side</button>
                            <button onclick="backside()" class="btn btn-primary">Back Side</button>
                            <button onclick="shoulder()" class="btn btn-primary">Shoulder</button> --}}

                            @if ($product->design_image_front_side)
                                <button class="side-button" onclick="changeHoodieImage('front')">Front Side</button>
                            @endif
                            @if ($product->design_image_back_side)
                                <button class="side-button" onclick="changeHoodieImage('back')">Back Side</button>
                            @endif
                            {{-- <button class="side-button" onclick="changeHoodieImage('shoulder')">Shoulder</button> --}}
                        </div>
                        <div class="mt-2">
                            {{-- <button class="color-button" style="background-color: #FF0000;"
                                onclick="changeColor('#FF0000')">Red</button>
                            <button class="color-button" style="background-color: #00FF00;"
                                onclick="changeColor('#00FF00')">Green</button>
                            <button class="color-button" style="background-color: #0000FF;"
                                onclick="changeColor('#0000FF')">Blue</button>
                            <button class="color-button" style="background-color: #FFA500;"
                                onclick="changeColor('#FFA500')">Orange</button>
                            <button class="color-button" style="background-color: #FFFF00;"
                                onclick="changeColor('#FFFF00')">Yellow</button> --}}


                            <div class="form-group color-palette ">
                                <div class="color-rows">
                                    @foreach ($colors as $color)
                                        @if ($color != null)
                                            {{-- @dd($color) --}}
                                            <button class="color-cell" style="background-color: {{ $color->code }};"
                                                onclick="changeColor('{{ $color->code }}')"></button>

                                            {{-- <div class="color-cell" style="background-color: {{ $key }};"
                                                    onclick="selectColor('{{ $key }}')"></div> --}}
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div id="design-gallery" style="display: flex; flex-wrap: wrap; gap: 10px;">
                            <!-- Thumbnails will appear here -->
                        </div>


                        @if ($product->customcolor == 'Yes')
                            <div class="mt-2">
                                <h4>Custom color</h4>
                                <label for="customcolor" class="col-md-12">If you want to use custom color,minimum order
                                    quantity will be
                                    {{ $product->minimum_order }}pcs and minimum required time
                                    {{ $product->minimum_time_required }} days. </label>
                                <input class="ml-3" type="color" id="colorPicker" value="#ff0000" />
                            </div>
                        @endif
                        <div class="mt-2">
                            <input class="btn btn-secondary px-3 m-2 " type="file" id="logoInput" accept="image/*">
                        </div>

                        <button onclick="saveCurrentDesign()">Save Design</button>
                        <button onclick="loadDesignGallery()">Load Gallery</button>
                        <button onclick="clearGallery()">Clear Gallery</button>
                        <div class="mt-2">
                            <!-- Font Selection -->
                            {{-- <label for="fontFamily">Text Font:</label>
                            <select id="fontFamily" class="form-select">
                                <option value="Arial">Arial</option>
                                <option value="Times New Roman">Times New Roman</option>
                                <option value="Verdana">Verdana</option>
                                <option value="Courier New">Courier New</option>
                            </select> --}}
                            <!-- Font Selection -->
                            <label for="fontFamily">Font:</label>
                            <select id="fontFamily" class="form-select">
                                <option value="" disabled selected>Select a font</option>
                            </select>
                            <!-- Search Input -->
                            {{-- <input type="text" id="searchFont" placeholder="Search Fonts..." class="form-control mt-2" /> --}}
                            <!-- Color Selection -->
                            <label for="textColor">Text Color:</label>
                            <input class="ml-3" type="color" id="textColor" value="#000000" class="form-control" />

                            <!-- Add Text Button -->
                            <button class="btn btn-success px-3 m-2" id="addTextButton">Add Text</button>
                        </div>
                        {{-- <button class="btn btn-success px-3 m-2 " id="saveButton">Save Mockup</button> --}}
                        <button class="btn btn-danger px-3 m-2 " id="delateSelectedButton">Delete Selected</button>
                        {{-- <button id="clear">Clear</button> --}}
                        <button type="button" class="btn btn-primary" onclick="preview()">
                            Preview
                        </button>
                    </div>

                    {{-- <img src="/app/storage/images/65daca0160274.jpg" alt="Uploaded Image"> --}}
                    {{-- <h3>Additional Details</h3>
                    <div class="d-flex mb-3">
                        <strong class="text-dark mr-3">Sizes:</strong>
                        <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-1" name="size">
                                <label class="custom-control-label" for="size-1">XS</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-2" name="size">
                                <label class="custom-control-label" for="size-2">S</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-3" name="size">
                                <label class="custom-control-label" for="size-3">M</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-4" name="size">
                                <label class="custom-control-label" for="size-4">L</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-5" name="size">
                                <label class="custom-control-label" for="size-5">XL</label>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex mb-4">
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
                    </div>
                    <div class="d-flex mb-4">
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
                            <div class="form-group">
                                <label for="message">Details:</label>
                                <textarea id="message"class="form-control" name="neck_level_details"></textarea>
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
                            <div class="form-group">
                                <label for="message">Details:</label>
                                <textarea id="message" class="form-control" name="swing_tag_details"></textarea>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                            </div>
                        </form>

                    </div> --}}

                </div>
            </div>

            <div class="col-md-5">
                <form action="{{ route('custom-product-design.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="h-100 bg-light p-30">
                        <input type="hidden" class="product-id" value="{{ $product->id }}" name="product_id">
                        <h3>Additional Details</h3>
                        <div class="form-group">
                            <label for="message">Design Details:</label>
                            <textarea id="message" cols="30" rows="3" class="form-control" name="design_details"></textarea>
                        </div>
                        {{-- <div class="d-flex mb-3">
                        <strong class="text-dark mr-3">Sizes:</strong>
                        <form>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-1" name="size">
                                <label class="custom-control-label" for="size-1">XS</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-2" name="size">
                                <label class="custom-control-label" for="size-2">S</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-3" name="size">
                                <label class="custom-control-label" for="size-3">M</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-4" name="size">
                                <label class="custom-control-label" for="size-4">L</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size-5" name="size">
                                <label class="custom-control-label" for="size-5">XL</label>
                            </div>
                        </form>
                             </div> --}}
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
                        <div class="d-flex mb-4">
                            <strong class="text-dark mr-3">Neck level?</strong>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="neck_level-1" name="neck_level"
                                    value="Yes">
                                <label class="custom-control-label" for="neck_level-1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="neck_level-2" name="neck_level"
                                    value="No">
                                <label class="custom-control-label" for="neck_level-2">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Neck level Design:</label>
                            <input class="btn btn-secondary px-3 m-2 " type="file" accept="image/*"
                                name="neck_level_design">
                        </div>
                        <div class="form-group">
                            <label for="message">Neck level Details:</label>
                            <textarea id="message"class="form-control" name="neck_level_details"></textarea>
                        </div>
                        <div class="d-flex mb-4">
                            <strong class="text-dark mr-3">Swing Tag?</strong>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="swing_tag-1" name="swing_tag"
                                    value="Yes">
                                <label class="custom-control-label" for="swing_tag-1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="swing_tag-2" name="swing_tag"
                                    value="No">
                                <label class="custom-control-label" for="swing_tag-2">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Swing Tag Design:</label>
                            <input class="btn btn-secondary px-3 m-2 " type="file" accept="image/*"
                                name="swing_tag_design">
                        </div>
                        <div class="form-group">
                            <label for="message">Swing Tag Details:</label>
                            <textarea id="message" class="form-control" name="swing_tag_details"></textarea>
                        </div>
                        {{-- <h4 class="mb-4">Design Your Product </h4> --}}
                        {{-- <div class="form-group">
                            <label for="email">Select Logo/Design</label>
                            <input type="file" class="form-control" id="email" name="design">
                            <div class="d-flex mb-3" >
                                <strong class="text-dark m-3">Position:</strong>
                                <div style="font-size: 16px!important;">

                                    <div class="custom-control custom-radio custom-control-inline mt-3" >
                                        <input type="radio" class="custom-control-input" id="positon-1" name="positon"
                                            value="center-chest">
                                        <label class="custom-control-label" for="positon-1">Center chest</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mt-3" >
                                        <input type="radio" class="custom-control-input" id="positon-2" name="positon"
                                            value="large-center">
                                        <label class="custom-control-label" for="positon-2">Large center</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mt-3" >
                                        <input type="radio" class="custom-control-input" id="positon-3" name="positon"
                                            value="left-chest">
                                        <label class="custom-control-label" for="positon-3">Left chest</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline mt-3" >
                                        <input type="radio" class="custom-control-input" id="positon-4" name="positon"
                                            value="full-back">
                                        <label class="custom-control-label" for="positon-4">Full back</label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="form-group">
                            <div class="col-md-6">
                                <label for="height">Height</label>
                                <input type="text" class="form-control" id="height" name="height">
                            </div>
                            <div class="col-md-6">
                                <label for="width">Width</label>
                                <input type="text" class="form-control" id="width" name="width">
                            </div>
                        </div> --}}
                        <div class="d-flex align-items-center mb-4 pt-2">
                            {{-- <div class="input-group quantity mr-3" style="width: 130px;">
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
                                </div> --}}
                            {{-- <a href="{{ route('shop.product-cart') }}" class="btn btn-primary px-3">
                                    <i class="fa fa-shopping-cart mr-1"></i>
                                    Next
                                    </a> --}}
                            <button type="submit" class="btn btn-primary px-3">Next</button>
                        </div>
                </form>

            </div>
        </div>
    </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageGalleryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Image Gallery</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Image gallery content -->
                    <div class="row">
                        {{-- <div class="col-md-4">
                            <img src=" {{ $category->front_image }} " class="img-fluid mb-2" alt="Image 1">
                        </div>
                        <div class="col-md-4">
                            <img src="{{ $category->back_image }}" class="img-fluid mb-2" alt="Image 2">
                        </div> --}}
                        {{-- <div class="col-md-4">
              <img src="image3.jpg" class="img-fluid mb-2" alt="Image 3">
            </div> --}}
                        <!-- Add more images as needed -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script>
        // Initiate a Canvas instance
        var canvas = new fabric.Canvas("canvas", {
            selection: true
        });

        // Function to add text to the canvas
        function addText() {
            var text = new fabric.Textbox('Your Text Here', {
                left: 300,
                top: 300,
                width: 150,
                fontSize: 20,
                fill: 'black'
            });

            canvas.add(text);
        }

        // Button to add text
        var addTextButton = document.createElement('button');
        addTextButton.innerHTML = 'Add Text';
        addTextButton.onclick = function() {
            addText();
        };
        document.body.appendChild(addTextButton);

        // Function to add an image/logo to the canvas
        function addImage(imageURL) {
            fabric.Image.fromURL(
                imageURL,
                function(img) {
                    img.set({
                        left: 100,
                        top: 100,
                        scaleX: 0.5,
                        scaleY: 0.5,
                        selectable: true // Image should be selectable
                    });
                    canvas.add(img);
                });
        }

        // Handle logo upload
        document.getElementById('logoInput').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function(event) {
                var imageURL = event.target.result;
                addImage(imageURL);
            }
            reader.readAsDataURL(file);
        });

        // Function to delete selected object
        function deleteSelected() {
            var activeObject = canvas.getActiveObject();
            if (activeObject) {
                canvas.remove(activeObject);
            }
        }

        // Button to delete selected object
        var deleteButton = document.createElement('button');
        deleteButton.innerHTML = 'Delete Selected';
        deleteButton.onclick = function() {
            deleteSelected();
        };
        document.body.appendChild(deleteButton);

        // Function to save canvas content as an image file
        function saveCanvas() {
            var link = document.createElement('a');
            link.href = canvas.toDataURL({
                format: 'png'
            });
            link.download = 'mockup.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function sendCanvasToBackend() {
            var imageData = canvas.toDataURL({
                format: 'png'
            });

            // Encode the image data
            var encodedImageData = encodeURIComponent(imageData);

            // Send imageData to backend using AJAX or fetch
            // Example using fetch:
            fetch('/image?imageData=' + encodedImageData, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    // Handle response from backend
                    console.log('Canvas image sent to backend successfully');
                })
                .catch(error => {
                    console.error('Error sending canvas image to backend:', error);
                });
        }

        // Button to save canvas
        var saveButton = document.createElement('button');
        saveButton.innerHTML = 'Save and next';
        saveButton.onclick = function() {
            // sendCanvasToBackend();
            saveCanvas();
        };
        document.body.appendChild(saveButton);

        // Add background image
        fabric.Image.fromURL(
            '{{ asset('product-2.jpg') }}', // URL of your background image
            function(img) {
                img.set({
                    left: 0,
                    top: 0,
                    width: canvas.width,
                    height: canvas.height,
                    selectable: false
                });
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
            });
    </script> --}}

    <script>
        // Get the canvas container element
        var canvasContainer = document.getElementById('canvasContainer');
        var selectedColor = '#FFFFFF'; // Default color
        // canvasContainer.style.border = 'none';

        // Function to change the hoodie color
        function changeColor(color) {
            selectedColor = color; // Store the selected color
            changeHoodieImage(currentSide); // Update the current hoodie image with the new color
        }
        // Initiate a Canvas instance inside the canvas container
        var canvas = new fabric.Canvas("canvas", {
            selection: true
        });

        // Remove border styles from both canvas layers
        document.querySelector('.lower-canvas').style.border = 'none';
        document.querySelector('.upper-canvas').style.border = 'none';
        document.querySelector('.canvas-container').style.marginLeft = '40px';
        // console.log(canvas.width);
        // Predefined font list (popular Google Fonts)

        // Function to add text to the canvas
        function addText() {

            var selectedFont = fontFamilySelect.value;
            var textColor = textColorInput.value;
            if (!selectedFont) {
                alert('Please select a font!');
                return;
            }

            var text = new fabric.Textbox('Your Text Here', {
                left: 300,
                top: 300,
                width: 150,
                fontSize: 20,
                fontFamily: selectedFont,
                fill: textColor
            });
            canvas.add(text);
            saveCurrentCanvasObjects(); // Save the new object for the current side
        }

        // Predefined font list (popular Google Fonts)

        var fonts = [
            'Arial',
            'Times New Roman',
            'Verdana',
            'Courier New',
            'Roboto',
            'Lato',
            'Montserrat',
            'Open Sans',
            'Oswald',
            'Raleway',
            'Poppins',
            'Playfair Display',
            'Source Sans Pro'
        ];
        var addTextButton = document.getElementById('addTextButton');
        var fontFamilySelect = document.getElementById('fontFamily');
        var searchFontInput = document.getElementById('searchFont');
        var textColorInput = document.getElementById('textColor');
        // Populate the font dropdown
        function populateFontDropdown(fontList) {
            fontList.forEach(font => {
                var option = document.createElement('option');
                option.value = font;
                option.textContent = font;
                fontFamilySelect.appendChild(option);
            });
        }

        // Load fonts dynamically from Google Fonts CDN
        function loadGoogleFont(font) {
            var link = document.createElement('link');
            link.href = `https://fonts.googleapis.com/css2?family=${font.replace(/ /g, '+')}&display=swap`;
            link.rel = 'stylesheet';
            document.head.appendChild(link);
        }


        // Initialize dropdown with fonts
        populateFontDropdown(fonts);

        // Load all fonts initially
        fonts.forEach(font => loadGoogleFont(font));

        // // Filter fonts as the user types
        // searchFontInput.addEventListener('input', function() {
        //     var searchValue = this.value.toLowerCase();
        //     var filteredFonts = fonts.filter(font => font.toLowerCase().includes(searchValue));

        //     // Clear and repopulate dropdown with filtered fonts
        //     fontFamilySelect.innerHTML = '<option value="" disabled selected>Select a font</option>';
        //     populateFontDropdown(filteredFonts);
        // });




        addTextButton.onclick = function() {
            addText();
        };

        // Button to add text
        // var addTextButton = document.createElement('button');
        // addTextButton.innerHTML = 'Add Text';
        // addTextButton.onclick = function() {
        //     addText();
        // };
        // canvasContainer.appendChild(addTextButton);

        // Function to add an image/logo to the canvas
        function addImage(imageURL) {
            fetch(imageURL)
                .then(res => res.blob())
                .then(blob => {
                    var productIdInput = document.querySelector('.product-id');
                    var productId = productIdInput.value;
                    var fileInput = document.getElementById('logoInput');
                    // console.log(productId);
                    // var productId = productIdInput.value;
                    // Create FormData object
                    let formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('imageFile', blob, 'image.jpg');

                    // Send image file to backend
                    // $.ajax({
                    //     url: "{{ route('save-canvas-image') }}",
                    //     method: 'POST',
                    //     data: formData,
                    //     processData: false, // Prevent jQuery from processing the data
                    //     contentType: false, // Prevent jQuery from setting contentType
                    //     headers: {
                    //         'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                    //     },
                    //     success: function(data) {
                    //         // console.log(data);
                    //         fileInput.value = '';
                    //         // alert('Mockup save successfully.')
                    //     },
                    //     error: function(xhr, status, error) {
                    //         console.error(error);
                    //         // Handle errors or display an error message to the user.
                    //     }
                    // });

                })
                .catch(error => {
                    console.error('Error converting data URL to Blob:', error);
                });


            fabric.Image.fromURL(
                imageURL,
                function(img) {
                    img.set({
                        left: 100,
                        top: 100,
                        scaleX: 0.5,
                        scaleY: 0.5,
                        selectable: true // Image should be selectable
                    });
                    canvas.add(img);

                    saveCurrentCanvasObjects(); // Save the new object for the current side

                });
        }
        // Handle logo upload
        document.getElementById('logoInput').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            // console.log(reader);
            reader.onload = function(event) {
                var imageURL = event.target.result;
                // console.log(imageURL);
                addImage(imageURL);
            }
            reader.readAsDataURL(file);
        });

        // Function to delete selected object
        function deleteSelected() {
            var activeObject = canvas.getActiveObject();
            // console.log(activeObject);
            if (activeObject) {
                var cacheKey = activeObject.cacheKey;

                var productIdInput = document.querySelector('.product-id');
                var productId = productIdInput.value;

                // $.ajax({
                //     url: "{{ route('delete-canvas-image') }}",
                //     method: 'POST',
                //     data: {
                //         product_id: productId,
                //         cacheKey: cacheKey,
                //     },
                //     headers: {
                //         'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                //     },
                //     success: function(data) {
                //         var cartBadgeValue = data;
                //         $('#cartBadge').text(cartBadgeValue);
                //         console.log(data);
                //     },
                //     error: function(xhr, status, error) {
                //         console.error(error);
                //         // Handle errors or display an error message to the user.
                //     }
                // });
                // console.log("Cache Key of Active Object:", cacheKey);
                // console.log(activeObject);
                canvas.remove(activeObject);
            }
        }

        // Button to delete selected object
        var delateSelectedButton = document.getElementById('delateSelectedButton');

        // Add click event listener to the existing button
        delateSelectedButton.onclick = function() {
            deleteSelected();
        };
        // var deleteButton = document.createElement('button');
        // deleteButton.innerHTML = 'Delete Selected';
        // deleteButton.onclick = function() {
        //     deleteSelected();
        // };
        // canvasContainer.appendChild(deleteButton);

        // Function to save canvas content as an image file
        function saveCanvas(side) {
            return new Promise((resolve, reject) => {
                var link = document.createElement('a');
                var imageURL = canvas.toDataURL({
                    format: 'png'
                });
                var images = canvas.getObjects('image').map(function(img) {
                    return img.getSrc();
                });

                // Convert the data URL to a Blob and send it to the server
                fetch(imageURL)
                    .then(res => res.blob())
                    .then(blob => {
                        var productIdInput = document.querySelector('.product-id');
                        var productId = productIdInput.value;

                        // Create FormData object
                        let formData = new FormData();
                        formData.append('product_id', productId);
                        formData.append('side', side);
                        formData.append('imageFile', blob, 'image.jpg');

                        // Append all image URLs used in the canvas
                        images.forEach((imageSrc, index) => {
                            formData.append(`imageURL_${index + 1}`, imageSrc);
                        });

                        // Send image file to backend via AJAX
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('save-canvas-mockup') }}",
                            method: 'POST',
                            data: formData,
                            processData: false, // Prevent jQuery from processing the data
                            contentType: false, // Prevent jQuery from setting contentType
                            // headers: {
                            //     'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                            // },
                            success: function(data) {
                                // console.log(data);
                                resolve(data); // Resolve the promise with the returned data
                            },
                            error: function(xhr, status, error) {
                                console.error('Error Status:', status);
                                console.error('Error:', error);
                                console.error('Response:', xhr.responseText);
                                reject(error); // Reject the promise in case of error
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error converting data URL to Blob:', error);
                        reject(error); // Reject the promise in case of an error during blob conversion
                    });
            });
        }

        // function saveCanvas(side) {
        //     var link = document.createElement('a');

        //     var imageURL = canvas.toDataURL({
        //         format: 'png'
        //     });
        //     link.href = canvas.toDataURL({
        //         format: 'png'
        //     });
        //     var images = canvas.getObjects('image').map(function(img) {
        //         return img.getSrc();
        //     });
        //     // console.log(images);
        //     // console.log(imageURL);
        //     fetch(imageURL)
        //         .then(res => res.blob())
        //         .then(blob => {
        //             var productIdInput = document.querySelector('.product-id');
        //             var productId = productIdInput.value;


        //             // Create FormData object
        //             let formData = new FormData();
        //             formData.append('product_id', productId);
        //             formData.append('side', side);
        //             formData.append('imageFile', blob, 'image.jpg');

        //             // Append all image URLs used in the canvas
        //             images.forEach((imageSrc, index) => {
        //                 formData.append(`imageURL_${index + 1}`, imageSrc);
        //             });
        //             // console.log( formData);
        //             // Send image file to backend
        //             $.ajax({
        //                 url: "{{ route('save-canvas-mockup') }}",
        //                 method: 'POST',
        //                 data: formData,
        //                 processData: false, // Prevent jQuery from processing the data
        //                 contentType: false, // Prevent jQuery from setting contentType
        //                 headers: {
        //                     'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
        //                 },
        //                 success: function(data) {
        //                     // console.log(data);

        //                     // alert('Mockup save successfully.')
        //                 },
        //                 error: function(xhr, status, error) {
        //                     console.error(error);

        //                     // Handle errors or display an error message to the user.
        //                 }
        //             });
        //         })
        //         .catch(error => {
        //             console.error('Error converting data URL to Blob:', error);
        //         });
        //     // link.download = 'mockup.png';
        //     // document.body.appendChild(link);
        //     // link.click();
        //     // document.body.removeChild(link);
        // }

        function sendCanvasToBackend() {
            var imageData = canvas.toDataURL({
                format: 'png'
            });

            // Encode the image data
            var encodedImageData = encodeURIComponent(imageData);

            // Send imageData to backend using AJAX or fetch
            // Example using fetch:
            fetch('/image', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        imageData: imageData
                    })
                })
                .then(response => {
                    // Handle response from backend
                    console.log('Canvas image sent to backend successfully');
                })
                .catch(error => {
                    console.error('Error sending canvas image to backend:', error);
                });
        }

        // Button to save canvas

        // var saveButton = document.getElementById('saveButton');
        // saveButton.onclick = function() {
        //     // sendCanvasToBackend();
        //     var hello = saveCanvas();
        //     //    console.log(hello);

        // };

        // canvasContainer.appendChild(saveButton);

        // document.getElementById('clear').addEventListener('click', function() {
        //     canvas.clear();
        // });

        //change Background image
        $('#imageGalleryModal').on('hidden.bs.modal', function() {
            document.getElementById('mainContent').classList.remove('blur-effect');
        });

        // let isCanvasModified = false;

        // // Listen for changes on the canvas
        // canvas.on('object:added', () => isCanvasModified = true);
        // canvas.on('object:modified', () => isCanvasModified = true);
        // canvas.on('object:removed', () => isCanvasModified = true);

        // async function handleSaveCanvas(side) {
        //     if (isCanvasModified) {
        //         console.log(`Saving canvas for side: ${side}`);
        //         await saveCanvas(side);
        //         // Reset the flag after saving
        //         isCanvasModified = false;
        //     } else {
        //         console.log(`No changes detected for side: ${side}. Skipping save.`);
        //     }
        // }

        async function preview() {
            document.getElementById('mainContent').classList.add('blur-effect');

            var productIdInput = document.querySelector('.product-id');
            var productId = productIdInput.value;
            var front_image = '';
            var back_image = '';

            var product = @json($product);
            if (product.design_image_front_side) {
                changeHoodieImage('front');
                await delay(400); // Add a small delay to ensure the canvas fully updates
                front_image = await saveCanvas('front');
            }

            if (product.design_image_back_side) {
                changeHoodieImage('back');
                await delay(2000); // Add a small delay to ensure the canvas fully updates
                back_image = await saveCanvas('back');
            }

            // if (product.design_image_front_side) {
            //     changeHoodieImage('front');
            //     await delay(400); // Add a small delay to ensure the canvas fully updates
            //     await handleSaveCanvas('front');
            // }

            // if (product.design_image_back_side) {
            //     changeHoodieImage('back');
            //     await delay(2000); // Add a small delay to ensure the canvas fully updates
            //     await handleSaveCanvas('back');
            // }
            // console.log(front_image);

            var modalBody = $('#imageGalleryModal .modal-body .row');
            modalBody.empty(); // Clear existing images


            // Check if front_image exists, and add it to the modal
            if (front_image) {
                modalBody.append(`
                    <div class="col-md-4">
                        <img src="${front_image}" class="img-fluid mb-2" alt="Front Image">
                    </div>
                `);
            }

            // Check if back_image exists, and add it to the modal
            if (back_image) {
                modalBody.append(`
                    <div class="col-md-4">
                        <img src="${back_image}" class="img-fluid mb-2" alt="Back Image">
                    </div>
                `);
            }

            // If no images exist, show a message
            if (!front_image && !back_image) {
                modalBody.append(`
                    <p class="text-center">No images available for preview.</p>
                `);
            }


            $('#imageGalleryModal').modal('show'); // Show the modal programmatically

        }
        // Add this delay function at the beginning of your script
        function delay(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        // function backside() {
        //     canvas.clear();

        //     // var canvas = new fabric.Canvas('canvas');
        //     var newImageURL =
        //         '{{ asset('frontend/img/hoodie back side.jpg') }}'; // Replace 'new_image_url.jpg' with the URL of your new background image

        //     fabric.Image.fromURL(newImageURL, function(img) {

        //         img.set({
        //             left: 0,
        //             top: 0,
        //             width: canvas.width,
        //             height: canvas.height,
        //             selectable: false
        //         });
        //         canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
        //     });
        // }

        // function frontside() {
        //     canvas.clear();

        //     // var canvas = new fabric.Canvas('canvas');
        //     var newImageURL =
        //         '{{ asset('frontend/img/white-hoodie.png') }}'; // Replace 'new_image_url.jpg' with the URL of your new background image
        //     fabric.Image.fromURL(newImageURL, function(img) {
        //         img.scaleToWidth(canvas.width);
        //         img.scaleToHeight(canvas.height);
        //         img.set({
        //             left: 0,
        //             top: 0,
        //             // width: canvas.width,
        //             // height: canvas.height,
        //             selectable: false
        //         });
        //         canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
        //     });
        // }

        // function shoulder() {
        //     canvas.clear();

        //     // var canvas = new fabric.Canvas('canvas');
        //     var newImageURL =
        //         '{{ asset('frontend/img/shoulder.jpeg') }}'; // Replace 'new_image_url.jpg' with the URL of your new background image

        //     fabric.Image.fromURL(newImageURL, function(img) {
        //         img.set({
        //             left: 0,
        //             top: 0,
        //             width: canvas.width,
        //             height: canvas.height,
        //             selectable: false
        //         });
        //         canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
        //     });
        // }
        // Add background image
        // fabric.Image.fromURL('{{ asset('frontend/img/white-hoodie.png') }}', function(img) {
        //     // Stretch the image to exactly fill the canvas
        //     img.scaleToWidth(canvas.width);
        //     img.scaleToHeight(canvas.height);

        //     img.set({
        //         left: 0,
        //         top: 0,
        //         selectable: false
        //     });

        //     // Add the image to the canvas
        //     canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
        //     canvas.renderAll();

        //     // Store the image globally so we can modify it later
        //     window.hoodieImage = img;
        // });
        // Function to change the hoodie image based on the selected side

        // Arrays to hold objects for each side
        var frontObjects = [];
        var backObjects = [];
        var shoulderObjects = [];
        var currentSide = 'front'; // Track the current side

        function changeHoodieImage(side) {
            var imagePath = ''; // Path of the hoodie image based on side

            // Determine the image path based on the clicked button
            if (side === 'front') {
                imagePath = '{{ asset($product->design_image_front_side) }}';
            } else if (side === 'back') {
                imagePath = '{{ asset($product->design_image_back_side) }}';
            } else if (side === 'shoulder') {
                imagePath = '{{ asset('frontend/img/shoulder.jpeg') }}';
            }

            // Save current canvas objects to the respective side array
            saveCurrentCanvasObjects();

            // Clear the canvas
            canvas.clear();

            // Update the current side
            currentSide = side;
            // Ensure canvas has appropriate size
            // canvas.setWidth(500);
            // canvas.setHeight(700);
            // Load the new image onto the canvas
            fabric.Image.fromURL(imagePath, function(img) {
                // Scale the image to fit the canvas
                // Define the padding value
                const padding = 20; // Adjust this value as needed

                // Scale the image while considering padding
                img.scaleToWidth(canvas.width - padding * 2); // Leave padding on both sides
                img.scaleToHeight(canvas.height - padding * 2); // Leave padding on top and bottom

                // Center the image with padding
                img.set({
                    left: padding, // Add left padding
                    top: padding, // Add top padding
                    selectable: false
                });

                // Apply the BlendColor filter to change the color of the image
                img.filters.push(new fabric.Image.filters.BlendColor({
                    color: selectedColor, // Use the currently selected color
                    mode: 'overlay',
                    alpha: 0.5
                }));

                // Apply the filters and render the canvas
                img.applyFilters();
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));

                // Load saved objects for the current side
                loadCurrentCanvasObjects();

            });
        }


        // Save current canvas objects to their respective side array
        function saveCurrentCanvasObjects() {
            // saveCurrentDesign();
            var objects = canvas.getObjects();
            if (currentSide === 'front') {
                frontObjects = objects;
            } else if (currentSide === 'back') {
                backObjects = objects;
            } else if (currentSide === 'shoulder') {
                shoulderObjects = objects;
            }
        }

        //design gallery start here

        let designGallery = []; // Array to store designs

        // Function to Save Current Design
        // function saveCurrentDesign() {
        //     var objects = canvas.getObjects();
        //     if (currentSide === 'front') {
        //         frontDesign = objects;
        //     } else if (currentSide === 'back') {
        //         backDesign = objects;
        //     }

        //     // Save designs to localStorage or any other storage you prefer
        //     var designs = JSON.parse(localStorage.getItem('designs')) || [];
        //     designs.push({
        //         side: currentSide,
        //         objects: objects
        //     });
        //     localStorage.setItem('designs', JSON.stringify(designs));

        //     alert('Design saved successfully!');
        // }
        function saveCurrentDesign() {
            var objects = canvas.getObjects();
            if (currentSide === 'front') {
                frontDesign = objects;
            } else if (currentSide === 'back') {
                backDesign = objects;
            }

            // Create a temporary canvas for generating the preview
            var tempCanvas = new fabric.StaticCanvas(null, {
                width: 600,
                height: 600,
            });

            // Add objects to the temporary canvas
            objects.forEach(function(obj) {
                tempCanvas.add(obj);
            });
            // Generate the preview image
            var previewImage = tempCanvas.toDataURL({
                format: 'png',
                quality: 0.8,
            });

            // Save designs to localStorage
            var designs = JSON.parse(localStorage.getItem('designs')) || [];
            designs.push({
                side: currentSide,
                objects: objects,
                preview: previewImage, // Save the preview image
            });

            localStorage.setItem('designs', JSON.stringify(designs));
            alert('Design saved successfully!');
        }



        // function loadDesignGallery() {
        //     var galleryContainer = document.getElementById('design-gallery');
        //     galleryContainer.innerHTML = ''; // Clear existing gallery

        //     var designs = JSON.parse(localStorage.getItem('designs')) || [];

        //     // Loop through each saved design
        //     designs.forEach((design, index) => {
        //         var tempCanvas = new fabric.StaticCanvas(null, {
        //             width: 600,
        //             height: 600
        //         }); // Create a temporary canvas for each design

        //         // Add each object from the saved design to the temporary canvas
        //         fabric.util.enlivenObjects(design.objects, function(enlivenedObjects) {
        //             // console.log(enlivenedObjects); // Debugging: Check if objects are properly enlivened

        //             enlivenedObjects.forEach(function(obj) {
        //                 // console.log(obj.left, obj.top); // Check if objects are within canvas bounds

        //                 obj.set({
        //                     left: 0 , // Adjust position if needed
        //                     top:  0 ,
        //                     scaleX: 0.5,
        //                     scaleY: 0.5,
        //                 });
        //                 tempCanvas.add(obj); // Add object to the temporary canvas
        //             });

        //             // Now that all objects are added, we render the canvas
        //             // tempCanvas.backgroundColor = '#0000'; // Set a white background for debugging purposes
        //            tempCanvas.renderAll();

        //             // Generate the preview image (thumbnail) after rendering the canvas
        //             // var dataUrl = tempCanvas.toDataURL(); // Get the image data URL for the preview
        //             var dataUrl = tempCanvas.toDataURL(); // Get the image data URL for the preview

        //             // Log dataUrl to debug
        //             // console.log('Generated Data URL:', dataUrl);

        //             if (dataUrl) {
        //                 // Create an image element for the gallery
        //                 var imgElement = document.createElement('img');
        //                 imgElement.src = dataUrl;
        //                 imgElement.alt = `Design ${index + 1}`;
        //                 imgElement.style = 'width: 150px; height: 150px; cursor: pointer; object-fit: contain;';
        //                 imgElement.onclick = () => applyDesignToCanvas(design
        //                     .objects); // Apply the design when clicked

        //                 galleryContainer.appendChild(imgElement); // Append the image to the gallery
        //             } else {
        //                 console.log('Error generating data URL for design', index + 1);
        //             }


        //         });
        //     });
        // }
        function loadDesignGallery() {
            var galleryContainer = document.getElementById('design-gallery');
            galleryContainer.innerHTML = ''; // Clear existing gallery

            var designs = JSON.parse(localStorage.getItem('designs')) || [];

            // Loop through saved designs and create image elements for the gallery
            designs.forEach((design, index) => {
                // Create an image element for the gallery
                var imgElement = document.createElement('img');
                imgElement.src = design.preview; // Use saved preview image
                imgElement.alt = `Design ${index + 1}`;
                imgElement.style = 'width: 150px; height: 150px; cursor: pointer; object-fit: contain;';
                imgElement.onclick = () => applyDesignToCanvas(design
                    .objects); // Apply the design when clicked

                galleryContainer.appendChild(imgElement); // Append the image to the gallery
            });
        }

        function clearGallery() {
            if (confirm('Are you sure you want to clear all saved designs?')) {
                localStorage.removeItem('designs');
                loadDesignGallery(); // Reload the gallery to reflect changes
            }
        }


        function applyDesignToCanvas(objects) {
            // canvas.clear(); // Clear the current canvas

            // Revive the saved objects asynchronously
            fabric.util.enlivenObjects(objects, function(enlivenedObjects) {
                enlivenedObjects.forEach(function(obj) {
                    // Add each revived object to the canvas
                    canvas.add(obj);
                });
                canvas.renderAll();
                // alert('Design loaded successfully!');
            });
        }


        //end of gallery design

        //custom color start

        // Select the color picker input
        var colorPicker = document.getElementById('colorPicker');

        // Add an event listener for the color change
        colorPicker.addEventListener('input', function() {
            // Get the selected color
            var selectedColor = colorPicker.value;
            // console.log(selectedColor);

            // Apply the selected color as an overlay on the canvas
            changeColor(selectedColor);
        });

        //custom color end

        // Load saved objects for the current side
        function loadCurrentCanvasObjects() {
            var objectsToLoad = [];
            if (currentSide === 'front') {
                objectsToLoad = frontObjects;
            } else if (currentSide === 'back') {
                objectsToLoad = backObjects;
            } else if (currentSide === 'shoulder') {
                objectsToLoad = shoulderObjects;
            }
            objectsToLoad.forEach(function(obj) {
                canvas.add(obj);
            });
        }
        // Load the front image by default when the page loads
        window.onload = function() {
            changeHoodieImage('front'); // Default to 'front' side
        };
        // Function to change the color of the hoodie
        // function changeColor(color) {
        //     if (window.hoodieImage) {
        //         // Remove any previous filters
        //         window.hoodieImage.filters = [];

        //         // Apply the BlendColor filter to change the color of the image
        //         window.hoodieImage.filters.push(new fabric.Image.filters.BlendColor({
        //             color: color, // Color passed from button click
        //             mode: 'multiply', // Blending mode
        //             alpha: 0.6 // Adjust opacity
        //         }));

        //         // Apply the filters and render the canvas
        //         window.hoodieImage.applyFilters();
        //         canvas.renderAll();
        //     }
        // }
    </script>
@endsection
