@extends('layouts.frontend.master')
@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/3.6.2/fabric.min.js"></script>

    <style>
        /* .upload-zone {
            position: absolute;
            top: 100px;
            left: 300px;
            width: 100px;
            height: 100px;
            border: 2px dashed #b3b3b3;
            background: rgba(255, 248, 248, 0.1);
        } */

        .upload-zone-alt {
            position: absolute;
            top: 210px;
            left: 252px;
            width: 178px;
            height: 175px;
            border: 2px dashed #b3b3b3;
            background: rgba(255, 248, 248, 0.1);
        }

        /* for text modal */
        /* Modal styles */
        .modal-text {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content-text {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
        }

        /* for text modal */

        .border {
            border: none !important;
        }

        /* side bar design */

        .menu-button {
            width: 80px;
            height: 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .menu-button i {
            margin-bottom: 5px;
        }

        .menu-button div {
            font-size: 12px;
        }

        .btn-light {
            border: none;
            font-size: 12px;
            color: #333;
            text-align: center;
        }

        .btn-light img {
            display: block;
            margin: 0 auto 5px;
        }

        .btn-light:hover {
            background-color: #e2e6ea;
            color: #000;
        }

        .btn-danger {
            border: none;
            font-size: 12px;
            /* color: #ac1a1a; */
            text-align: center;
        }

        .btn-danger img {
            display: block;
            margin: 0 auto 5px;
        }

        /* .btn-danger:hover {
                                                                                                                                                                                                                                                                        background-color: #e2e6ea;
                                                                                                                                                                                                                                                                        color: #000;
                                                                                                                                                                                                                                                                    } */

        /* side bar design */

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

        /* Modal Styles for images gallery */
        .design-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            /* Semi-transparent background */
            backdrop-filter: blur(8px);
            /* Blur effect */
            display: none;
            /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 80%;
            max-height: 80%;
            overflow-y: auto;
            position: relative;
        }

        .close-btn {
            font-size: 24px;
            color: black;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .design-modal img {
            width: 250px;
            height: 250px;
            cursor: pointer;
            object-fit: contain;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 16px;
            color: red;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            padding: 5px;
        }

        body.inert {
            pointer-events: none;
            overflow: hidden;
        }

        /* Ensure the zoom modal is on top of the preview modal */
        .modal-backdrop {
            z-index: 1039;
            /* Set this lower than the preview modal */
        }

        #imageGalleryModal {
            z-index: 1040;
        }

        #zoomModal {
            z-index: 1050;
        }

        /* Button styling */
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
    <dd>
        {{-- {{$product}} --}}
    </dd>
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
                        <!-- Include Font Awesome for icons -->

                        <!-- Include Font Awesome for icons -->
                        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> --}}

                        <div class="container-fluid">
                            <div class="row">
                                <!-- Left Vertical Menu -->
                                <div
                                    class="col-md-1 col-sm-12 d-flex flex-column flex-sm-row flex-md-column align-items-center py-3">

                                    {{-- <button class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0" onclick="uploadAction()" title="Upload">
                                    <i class="fas fa-upload fa-2x"></i>
                                    <div>Upload</div>
                                </button> --}}
                                    <label for="logoInput" class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0"><i
                                            class="fas fa-upload fa-2x"></i>
                                        <div>Upload</div>
                                    </label>
                                    <input type="file" id="logoInput" accept="image/*" style="display: none;">


                                    <button class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0" onclick="openModal()"
                                        title="Add Text">
                                        <i class="fas fa-text-height fa-2x"></i>
                                        <div>Add Text</div>
                                    </button>



                                    <button class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0"
                                        onclick="loadDesignGallery()" title="My Library">
                                        <i class="fas fa-folder-open fa-2x"></i>
                                        <div>Graphics</div>
                                    </button>
                                    <button class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0"
                                        onclick="saveCurrentDesign()" title="Graphics">
                                        <i class="fas fa-palette fa-2x"></i>
                                        <div>Save Graphics</div>
                                    </button>
                                    {{-- <button class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0" onclick="openTemplates()"
                                        title="My Templates">
                                        <i class="fas fa-book fa-2x"></i>
                                        <div>My Templates</div>
                                    </button> --}}
                                    <!-- Delete Button -->
                                    <button class="menu-button btn btn-danger mb-3" onclick="deleteAction()"
                                        title="Delete Selected" id="delateSelectedButton">
                                        <i class="fas fa-trash-alt fa-2x"></i>
                                        <div>Delete</div>
                                    </button>
                                </div>



                                <!-- Main Content -->
                                <div class="col-md-11 col-sm-12">
                                    <div class="row align-items-center">
                                        <!-- Canvas Section -->
                                        <div class="col-md-12 col-sm-12">
                                            <div class="canvas-container text-center">
                                                <canvas id="canvas" width="600" height="600"
                                                    class="img-fluid border"></canvas>
                                                {{-- <div class="upload-zone" id="uploadZone" style="display: block; pointer-events: none;"></div> --}}
                                                <!-- Initially hidden -->
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            @if ($product->design_image_front_side)
                                                <button class="side-button" onclick="changeHoodieImage('front')">Front
                                                    Side</button>
                                            @endif
                                            @if ($product->design_image_back_side)
                                                <button class="side-button" onclick="changeHoodieImage('back')">Back
                                                    Side</button>
                                            @endif
                                            @if ($product->design_image_right_side)
                                                <button class="side-button" onclick="changeHoodieImage('right')">Right
                                                    Sleeve</button>
                                            @endif
                                            @if ($product->design_image_left_side)
                                                <button class="side-button" onclick="changeHoodieImage('left')">Left
                                                    Sleeve</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        {{-- <div class="mt-2">
                            @if ($product->design_image_front_side)
                                <button class="side-button" onclick="changeHoodieImage('front')">Front Side</button>
                            @endif
                            @if ($product->design_image_back_side)
                                <button class="side-button" onclick="changeHoodieImage('back')">Back Side</button>
                            @endif
                            @if ($product->design_image_right_side)
                                <button class="side-button" onclick="changeHoodieImage('right')">Right Sleeve</button>
                            @endif
                            @if ($product->design_image_left_side)
                                <button class="side-button" onclick="changeHoodieImage('left')">Left Sleeve</button>
                            @endif
                        </div> --}}

                        {{-- <div class="mt-2">
                            <div class="form-group color-palette ">
                                <div class="color-rows">
                                    @foreach ($colors as $color)
                                        @if ($color != null)
                                            <button class="color-cell" style="background-color: {{ $color->code }};"
                                                onclick="changeColor('{{ $color->code }}')"></button>
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
                            <label for="fontFamily">Font:</label>
                            <select id="fontFamily" class="form-select">
                                <option value="" disabled selected>Select a font</option>
                            </select>
                            <label for="textColor">Text Color:</label>
                            <input class="ml-3" type="color" id="textColor" value="#000000" class="form-control" />

                            <!-- Add Text Button -->
                            <button class="btn btn-success px-3 m-2" id="addTextButton">Add Text</button>
                        </div> --}}
                        {{-- <button class="btn btn-success px-3 m-2 " id="saveButton">Save Mockup</button> --}}
                        {{-- <button class="btn btn-danger px-3 m-2 " id="delateSelectedButton">Delete Selected</button> --}}
                        {{-- <button id="clear">Clear</button> --}}
                        {{-- <button type="button" class="btn btn-primary" onclick="preview()">
                            Preview
                        </button> --}}
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
                <div class="h-10 bg-light p-30">
                    <div class="mt-2">

                        <div class="form-group color-palette ">
                            <h6 class="mb-2">Colors:</h6>
                            <div class="color-rows">
                                @foreach ($colors as $color)
                                    @if ($color != null)
                                        <button class="color-cell" style="background-color: {{ $color->code }};"
                                            onclick="changeColor('{{ $color->code }}')"></button>
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
                            {{-- <h6>Custom color:</h6> --}}
                            <span> <b>Custom color:</b></span>
                            <input class="ml-3" type="color" id="colorPicker" value="#ff0000" />
                            <label for="customcolor" class="col-md-12">(Custom colors require a minimum order of
                                {{ $product->minimum_order }}pcs and
                                {{ $product->minimum_time_required }} days lead time. )</label>
                        </div>
                    @endif
                    {{-- <div class="mt-4 ">
                        <h6> Text:</h6>
                        <label for="fontFamily">Font:</label>
                        <select id="fontFamily" class="form-select">
                            <option value="" disabled selected>Select a font</option>
                        </select>
                        <label for="textColor">Color:</label>
                        <input class="ml-3" type="color" id="textColor" value="#000000" class="form-control" />
                        <button class="btn btn-success px-3 m-2" id="addTextButton">Add Text</button>
                    </div> --}}
                    {{-- <button class="btn btn-success px-3 m-2 " id="saveButton">Save Mockup</button> --}}
                    {{-- <button id="clear">Clear</button> --}}
                    <div class="mt-2">
                        {{-- <span>Upload Design:</span>
                        <input class="btn btn-secondary px-3 m-2 " type="file" id="logoInput" placeholder="Upload Design"
                            accept="image/*"> --}}
                        <!-- Custom File Input -->
                        {{-- <label for="logoInput" class="btn btn-primary px-3 m-2">Upload a Design</label>
                        <input type="file" id="logoInput" accept="image/*" style="display: none;"> --}}

                    </div>
                    {{-- <button class="btn btn-primary ml-2" onclick="saveCurrentDesign()">Save Design</button> --}}
                    <!-- Button to load designs -->
                    {{-- <button class="btn btn-primary" onclick="loadDesignGallery()">Load Designs</button> --}}

                    <!-- Gallery modal -->
                    <div id="design-modal" class="design-modal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-content" role="dialog" aria-labelledby="design-modal-title">
                            <span class="close-btn" onclick="closeModal()" aria-label="Close">&times;</span>
                            <h2 id="design-modal-title">Design Gallery</h2>
                            <div id="modal-gallery" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                        </div>
                    </div>

                    {{-- <button class="btn btn-primary" onclick="clearGallery()">Clear Gallery</button> --}}
                    <button type="button" class="btn btn-primary px-3 m-2" onclick="preview()">
                        Preview
                    </button>
                    {{-- <button class="btn btn-danger px-3 m-2 " id="delateSelectedButton">Delete Selected</button> --}}
                </div>

                <form id="mockupForm" action="{{ route('custom-product-design.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="h-100 bg-light p-30">
                        <input type="hidden" class="product-id" value="{{ $product->id }}" name="product_id">
                        <input class="ml-3" type="hidden" id="customColorPicker" name="custom_color" value="" />
                        @php
                            $firstColor = $colors->first();
                            $firstSize = $product->sizeDetails->keyBy('size')->keys()->first();
                        @endphp
                        {{-- First Color: {{ $firstColor->name }} --}}

                        @if (!empty($firstColor->name))
                            <input type="hidden" class="product-id" value="{{ $firstColor->name }}" name="color">
                        @endif

                        @if (!empty($firstSize))
                            <input type="hidden" value="{{ $firstSize }}" name="size">
                        @endif


                        <input type="hidden" value="1" name="quantity">
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
                        <div class="d-flex mb-4">
                            <strong class="text-dark mr-3">Right Sleeve?</strong>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="right_sleeve-1"
                                    name="right_sleeve" value="Yes">
                                <label class="custom-control-label" for="right_sleeve-1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="right_sleeve-2"
                                    name="right_sleeve" value="No">
                                <label class="custom-control-label" for="right_sleeve-2">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Right Sleeve Design:</label>
                            <input class="btn btn-secondary px-3 m-2 " type="file" accept="image/*"
                                name="right_sleeve_design">
                        </div>
                        <div class="form-group">
                            <label for="message">Right Sleeve Details:</label>
                            <textarea id="message" class="form-control" name="right_sleeve_details"></textarea>
                        </div>
                        <div class="d-flex mb-4">
                            <strong class="text-dark mr-3">Left Sleeve?</strong>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="left_sleeve-1" name="left_sleeve"
                                    value="Yes">
                                <label class="custom-control-label" for="left_sleeve-1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="left_sleeve-2" name="left_sleeve"
                                    value="No">
                                <label class="custom-control-label" for="left_sleeve-2">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Left Sleeve Design:</label>
                            <input class="btn btn-secondary px-3 m-2 " type="file" accept="image/*"
                                name="left_sleeve_design">
                        </div>
                        <div class="form-group">
                            <label for="message">Left Sleeve Details:</label>
                            <textarea id="message" class="form-control" name="left_sleeve_details"></textarea>
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

    <!-- Zoom Modal -->
    <div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="zoomModalLabel">Zoomed Image</h5> --}}
                    <button type="button" class="close" aria-label="Close" onclick="closeZoomModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="zoomedImage" class="img-fluid" alt="Zoomed Image" />
                </div>
            </div>
        </div>
    </div>

    <!-- textModal -->
    <div id="textModal" class="design-modal" style="display: none;">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <span class="close" onclick="closeTextModal()">&times;</span>
                <div class="mt-4">
                    <h6>Text:</h6>
                    <label for="fontFamily">Font:</label>
                    <select id="fontFamily" class="form-select">
                        {{-- <option value="" disabled selected>Select a font</option> --}}
                    </select>
                    <label for="textColor">Color:</label>
                    <input class="ml-3" type="color" id="textColor" value="#000000" class="form-control" />
                    <button class="btn btn-success px-3 m-2" id="addTextButton">Add
                        Text</button>
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
        const uploadZone = document.getElementById('uploadZone');

        //for text modal
        function openModal() {
            document.getElementById("textModal").style.display = "block";
        }

        function closeTextModal() {
            document.getElementById("textModal").style.display = "none";
        }
        //clip path
        // var storeclipPath;
        //for text modal
        // Get the canvas container element
        var canvasContainer = document.getElementById('canvasContainer');
        var selectedColor = '#FFFFFF'; // Default color
        // canvasContainer.style.border = 'none';
        var rightSleeveRightSide;
        var rightSleeveLeftSide;
        var leftSleeveRightSide;
        var leftSleeveLeftSide;

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
            // console.log(storeclipPath);

            var text = new fabric.Textbox('Your Text Here', {
                left: 300,
                top: 300,
                width: 150,
                fontSize: 20,
                fontFamily: selectedFont,
                fill: textColor,
                // clipPath: storeclipPath,
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
            closeTextModal();

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

            const sleeveClipPath = new fabric.Rect({
                left: 198, // Adjust based on sleeve position
                top: 210, // Adjust based on sleeve position
                width: 178, // Adjust based on sleeve dimensions
                height: 175, // Adjust based on sleeve dimensions
                absolutePositioned: true,
            });
            fabric.Image.fromURL(
                imageURL,
                function(img) {
                    img.set({
                        top: 210,
                        left: 252,
                        // left: 100,
                        // top: 100,
                        scaleX: 0.2,
                        scaleY: 0.2,
                        // clipPath: storeclipPath,
                        // clipPath: sleeveClipPath, // Apply the clip path
                        selectable: true, // Image should be selectable
                        evented: true,
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
            document.getElementById("logoInput").value = "";

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

        // Arrays to hold objects for each side
        var frontObjects = [];
        var backObjects = [];
        var rightObjects = [];
        var leftObjects = [];
        var shoulderObjects = [];
        var currentSide = 'front'; // Track the current side


        function changeHoodieImage(side) {

            // Save current canvas objects to the respective side array
            saveCurrentCanvasObjects();

            // switch (currentSide) {
            //     case 'front':
            //         front_image = saveCanvas(currentSide);
            //         console.log(front_image);

            //         break;
            //     case 'back':
            //         back_image = saveCanvas(currentSide);
            //         break;
            //     case 'right':
            //         right_image = saveCanvas(currentSide);
            //         break;
            //     case 'left':
            //         left_image = saveCanvas(currentSide);
            //         break;
            //     default:
            //         console.error('Invalid side provided:', side);
            // }

            // Save the current canvas before changing the side
            // console.log(currentSide);

            // Clear the canvas
            canvas.clear();

            var imagePath = ''; // Path of the hoodie image based on side
            // Determine the image path based on the clicked button
            if (side === 'front') {
                // uploadZone.style.display = "none";
                imagePath = '{{ asset($product->design_image_front_side) }}';
            } else if (side === 'back') {
                // uploadZone.style.display = "none";
                imagePath = '{{ asset($product->design_image_back_side) }}';
            } else if (side === 'right') {
                imagePath = '{{ asset($product->design_image_right_side) }}';
                // uploadZone.style.display = "block";
                // uploadZone.classList.remove('upload-zone-alt');
                // uploadZone.classList.add('upload-zone');
            } else if (side === 'left') {
                imagePath = '{{ asset($product->design_image_left_side) }}';
                // uploadZone.style.display = "block";
                // uploadZone.classList.remove('upload-zone');
                // uploadZone.classList.add('upload-zone-alt');
            } else if (side === 'shoulder') {
                imagePath = '{{ asset('frontend/img/shoulder.jpeg') }}';
            }
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


                // creating clip path dynamically for whole background image
                const tempCanvas = document.createElement('canvas');
                const tempCtx = tempCanvas.getContext('2d');
                tempCanvas.width = canvas.width;
                tempCanvas.height = canvas.height;

                // Draw the image onto the temporary canvas
                tempCtx.drawImage(img.getElement(), 0, 0);

                // Get the image data
                const imageData = tempCtx.getImageData(0, 0, canvas.width, canvas.height);

                // Get contour points using marching squares
                const contourPoints = marchingSquares(imageData);

                // Simplify the path while preserving important details
                const simplifiedPoints = simplifyPath(contourPoints, 2); // Adjust tolerance as needed

                // Create the clipping path
                const clipPath = new fabric.Polygon(simplifiedPoints, {
                    absolutePositioned: true,
                    selectable: false,
                    fill: 'red',
                    opacity: 0.01
                });
                // canvas.add(clipPath);
                // storeclipPath = clipPath;
                // Load saved objects for the current side
                loadCurrentCanvasObjects();
            });
        }


        async function changeSideForPreview(side) {
            let imagePath = '';
            let objectsToLoad = [];

            // Save current canvas objects to the respective side array
            saveCurrentCanvasObjects();
            // Determine image path and objects based on the side
            if (side === 'front') {
                objectsToLoad = frontObjects;
                imagePath = '{{ asset($product->design_image_front_side) }}';
            } else if (side === 'back') {
                objectsToLoad = backObjects;
                imagePath = '{{ asset($product->design_image_back_side) }}';
            } else if (side === 'right') {
                objectsToLoad = rightObjects;
                imagePath = '{{ asset($product->design_image_right_side) }}';
            } else if (side === 'left') {
                objectsToLoad = leftObjects;
                imagePath = '{{ asset($product->design_image_left_side) }}';
            } else if (side === 'shoulder') {
                imagePath = '{{ asset('frontend/img/shoulder.jpeg') }}';
            }

            // Create a temp canvas
            const tempCanvas = new fabric.StaticCanvas(null);
            tempCanvas.setWidth(600);
            tempCanvas.setHeight(600);

            return new Promise((resolve) => {
                // Load the background image
                fabric.Image.fromURL(imagePath, function(img) {
                    const padding = 20;

                    // Scale and position the image
                    img.scaleToWidth(tempCanvas.width - padding * 2);
                    img.scaleToHeight(tempCanvas.height - padding * 2);
                    img.set({
                        left: padding,
                        top: padding,
                        selectable: false,
                    });

                    // Apply filters (e.g., color overlay)
                    img.filters.push(new fabric.Image.filters.BlendColor({
                        color: selectedColor,
                        mode: 'overlay',
                        alpha: 0.5,
                    }));
                    img.applyFilters();

                    // Set the image as the canvas background
                    tempCanvas.setBackgroundImage(img, tempCanvas.renderAll.bind(tempCanvas));

                    // Add objects to the canvas
                    objectsToLoad.forEach((obj) => {
                        tempCanvas.add(obj);
                    });

                    // Resolve the Promise with the modified canvas
                    resolve(tempCanvas);
                });
            });
        }


        function marchingSquares(imageData) {
            const points = [];
            const width = imageData.width;
            const height = imageData.height;
            const data = imageData.data;

            // Increased alpha threshold for better edge detection
            const ALPHA_THRESHOLD = 100;

            // Find the first non-transparent pixel with higher threshold
            let startX = 0,
                startY = 0;
            let found = false;

            for (let y = 0; y < height && !found; y++) {
                for (let x = 0; x < width && !found; x++) {
                    const alpha = data[(y * width + x) * 4 + 3];
                    if (alpha > ALPHA_THRESHOLD) {
                        startX = x;
                        startY = y;
                        found = true;
                    }
                }
            }

            if (!found) return points;

            // Modified direction vectors for smoother contours
            const dx = [1, 1, 0, -1, -1, -1, 0, 1];
            const dy = [0, 1, 1, 1, 0, -1, -1, -1];

            let x = startX;
            let y = startY;
            let dir = 7;
            let steps = 0;
            const MAX_STEPS = width * height; // Prevent infinite loops

            do {
                points.push({
                    x,
                    y
                });

                // Look for next boundary pixel with improved edge detection
                let nextDir = (dir + 6) % 8;
                let found = false;
                let bestAlpha = ALPHA_THRESHOLD;
                let bestDir = nextDir;

                // Check all 8 directions to find the best next point
                for (let i = 0; i < 8; i++) {
                    const newX = x + dx[nextDir];
                    const newY = y + dy[nextDir];

                    if (newX >= 0 && newX < width && newY >= 0 && newY < height) {
                        const alpha = data[(newY * width + newX) * 4 + 3];
                        if (alpha > bestAlpha) {
                            bestAlpha = alpha;
                            bestDir = nextDir;
                            found = true;
                        }
                    }
                    nextDir = (nextDir + 1) % 8;
                }

                if (!found || steps++ > MAX_STEPS) break;

                x += dx[bestDir];
                y += dy[bestDir];
                dir = bestDir;

            } while ((x !== startX || y !== startY) && steps < MAX_STEPS);

            return points;
        }

        function simplifyPath(points, tolerance = 1) {
            if (points.length <= 2) return points;

            // Reduced maxDist calculation for less aggressive simplification
            let maxDist = 0;
            let index = 0;
            const end = points.length - 1;

            for (let i = 1; i < end; i++) {
                const dist = pointLineDistance(points[i], points[0], points[end]);
                if (dist > maxDist) {
                    maxDist = dist;
                    index = i;
                }
            }

            // Lowered tolerance threshold for better detail preservation
            if (maxDist > tolerance) {
                const left = simplifyPath(points.slice(0, index + 1), tolerance);
                const right = simplifyPath(points.slice(index), tolerance);
                return left.slice(0, -1).concat(right);
            }

            return [points[0], points[end]];
        }

        function pointLineDistance(point, lineStart, lineEnd) {
            const numerator = Math.abs(
                (lineEnd.y - lineStart.y) * point.x -
                (lineEnd.x - lineStart.x) * point.y +
                lineEnd.x * lineStart.y -
                lineEnd.y * lineStart.x
            );

            const denominator = Math.sqrt(
                Math.pow(lineEnd.y - lineStart.y, 2) +
                Math.pow(lineEnd.x - lineStart.x, 2)
            );

            return numerator / denominator;
        }

        // Save current canvas objects to their respective side array
        function saveCurrentCanvasObjects() {
            // saveCurrentDesign();
            var objects = canvas.getObjects();
            if (currentSide === 'front') {
                frontObjects = objects;
            } else if (currentSide === 'back') {
                backObjects = objects;
            } else if (currentSide === 'right') {
                rightObjects = objects;
            } else if (currentSide === 'left') {
                leftObjects = objects;
            } else if (currentSide === 'shoulder') {
                shoulderObjects = objects;
            }
        }

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
                switch (currentSide) {
                    case 'front':
                        objects = frontObjects;
                        break;
                    case 'back':
                        objects = backObjects;
                        break;
                    case 'right':
                        objects = rightObjects;
                        break;
                    case 'left':
                        objects = leftObjects;
                        break;
                    case 'left':
                        objects = shoulderObjects;
                        break;
                    default:
                        console.error('Invalid side provided:', side);
                }
                // console.log(objects);


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
                        formData.append('objects', objects);
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

        // Define the openZoomModal function globally
        // Define the openZoomModal function globally
        function openZoomModal(imageUrl) {
            document.getElementById('zoomedImage').src = imageUrl;
            const modal = document.getElementById('zoomModal');
            modal.removeAttribute('aria-hidden');
            modal.removeAttribute('inert');

            $('#zoomModal').modal('show');
        }

        function closeZoomModal() {
            const modal = document.getElementById('zoomModal');

            $('#zoomModal').modal('hide');
            modal.setAttribute('aria-hidden', 'true');
            modal.setAttribute('inert', '');
        }

        // var front_image = '';
        // var back_image = '';
        // var right_image = '';
        // var left_image = '';
        document.getElementById("mockupForm").addEventListener("submit", async function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Call the saveAllMockup function and wait for it to complete
            await saveAllMockup();

            // Submit the form after the function completes
            this.submit();
        });
        async function saveAllMockup() {
            var front_image = '';
            var back_image = '';
            var right_image = '';
            var left_image = '';

            var product = @json($product);
            if (product.design_image_front_side) {
                changeHoodieImage('front');
                await delay(400); // Add a small delay to ensure the canvas fully updates
                front_image = await saveCanvas('front');
            }

            if (product.design_image_back_side) {
                changeHoodieImage('back');
                await delay(500); // Add a small delay to ensure the canvas fully updates
                back_image = await saveCanvas('back');
            }
            if (product.design_image_right_side) {
                changeHoodieImage('right');
                await delay(700); // Add a small delay to ensure the canvas fully updates
                right_image = await saveCanvas('right');
            }
            if (product.design_image_left_side) {
                changeHoodieImage('left');
                await delay(1000); // Add a small delay to ensure the canvas fully updates
                left_image = await saveCanvas('left');
            }
        }

        function addDesignToSleeve(objects, side) {
            var productIdInput = document.querySelector('.product-id');
            var productId = productIdInput.value;
            // console.log(productId);
            if (productId == 'MPC-HAC200372749962') {
                var leftImage_left = 405;
                var leftImage_rotate = -11;
                var sleeve_top = 220;
                var leftImage_right = 436;
                var leftImage_right_rotate = -5;
                var rightImage_left = 30;
                var rightImage_rotate = 11;
                var rightImage_right = 86;
                var rightImage_right_rotate = 11;

            } else if (productId == 'MPC-SZCRepudiandae modi sun2038874817') {
                var leftImage_left = 480;
                var leftImage_rotate = -50;
                var sleeve_top = 138;
                var leftImage_right = 554;
                var leftImage_right_rotate = -53;
                var rightImage_left = 71;
                var rightImage_rotate = 51;
                var rightImage_right = 99;
                var rightImage_right_rotate = 53;
            }
            // else {
            //     var leftImage_left = 405;
            //     var leftImage_rotate = -11;
            //     var sleeve_top = 220;
            //     var leftImage_right = 436;
            //     var leftImage_right_rotate = -5;
            //     var rightImage_left = 30;
            //     var rightImage_rotate = 11;
            //     var rightImage_right = 86;
            //     var rightImage_right_rotate = 11;
            // }
            // console.log("Product ID:", productId);
            // console.log("Comparison result:", productId === 'MPC-SZCRepudiandae modi sun2038874817');


            // Create a temporary canvas for generating the preview
            var tempCanvas = new fabric.StaticCanvas(null, {
                width: 600, // Size of the temporary canvas (adjust as necessary)
                height: 600,
            });

            // Add objects to the temporary canvas
            objects.forEach(function(obj) {
                // console.log(obj);
                tempCanvas.add(obj);
            });

            // Generate the preview image
            var previewImage = tempCanvas.toDataURL({
                format: 'png',
                quality: 0.8,
            });
            var img = new Image();
            img.src = previewImage;

            img.onload = function() {
                // Create a temporary canvas to draw the image
                var canvasTemp = document.createElement('canvas');
                var ctxTemp = canvasTemp.getContext('2d');

                // Set the canvas dimensions to match the image
                canvasTemp.width = img.width;
                canvasTemp.height = img.height;

                // Draw the image onto the temporary canvas
                ctxTemp.drawImage(img, 0, 0);

                // Get the image data
                var imageData = ctxTemp.getImageData(0, 0, canvasTemp.width, canvasTemp.height);
                var data = imageData.data;

                // Initialize variables to store the bounds of the non-transparent areas
                var left = canvasTemp.width,
                    right = 0,
                    top = canvasTemp.height,
                    bottom = 0;

                // Loop through the image data to find the bounds of the non-transparent pixels
                for (var y = 0; y < canvasTemp.height; y++) {
                    for (var x = 0; x < canvasTemp.width; x++) {
                        var index = (y * canvasTemp.width + x) * 4;
                        var alpha = data[index + 3]; // Get the alpha value (transparency)

                        if (alpha > 0) { // If not transparent
                            if (x < left) left = x;
                            if (x > right) right = x;
                            if (y < top) top = y;
                            if (y > bottom) bottom = y;
                        }
                    }
                }

                // Create a new canvas with the cropped dimensions
                var canvasCropped = document.createElement('canvas');
                var ctxCropped = canvasCropped.getContext('2d');
                canvasCropped.width = right - left;
                canvasCropped.height = bottom - top;

                // Draw the cropped image onto the new canvas
                ctxCropped.drawImage(canvasTemp, left, top, canvasCropped.width, canvasCropped.height, 0, 0,
                    canvasCropped.width, canvasCropped.height);

                // Now, create a Fabric.js image from the cropped canvas
                fabric.Image.fromURL(canvasCropped.toDataURL(), function(croppedImage) {
                    // Variables for cutting the image into two halves
                    var cutWidth = croppedImage.width / 2;
                    // Logic to handle the left and right side operations
                    // var side = 'left'; // Or 'right' based on your requirement
                    var leftImage, rightImage;
                    // 1. Crop and store the left half
                    var canvasLeft = document.createElement('canvas');
                    var ctxLeft = canvasLeft.getContext('2d');
                    canvasLeft.width = cutWidth;
                    canvasLeft.height = croppedImage.height;

                    // Draw the left half onto the new canvas
                    ctxLeft.drawImage(croppedImage.getElement(), 0, 0, cutWidth, croppedImage.height, 0, 0,
                        cutWidth, croppedImage.height);

                    // Create the left half image
                    fabric.Image.fromURL(canvasLeft.toDataURL(), function(leftFabricImage) {
                        leftImage = leftFabricImage; // Store the left image in the variable

                        // Apply transformations like scaling or rotation (if needed

                        // Store the left image for later use
                        if (side == 'left') {
                            leftImage.set({
                                left: leftImage_left, // Position on the canvas (adjust as needed)
                                top: sleeve_top,
                            });
                            leftImage.scaleToWidth(
                                20);
                            leftImage.rotate(leftImage_rotate);
                            // console.log("left");
                            leftSleeveLeftSide = leftImage;
                            // canvas.add(leftImage); // Add the left image to the Fabric canvas
                        } else {
                            leftImage.set({
                                left: leftImage_right, // Position on the canvas (adjust as needed)
                                top: sleeve_top,
                            });
                            leftImage.scaleToWidth(
                                20);
                            leftImage.rotate(leftImage_right_rotate);
                            // console.log("right1");
                            // canvas.add(leftImage); // Add the left image to the Fabric canvas
                            rightSleeveLeftSide = leftImage;
                            console.log(rightSleeveLeftSide);
                        }
                    });

                    // 2. Crop and store the right half
                    var canvasRight = document.createElement('canvas');
                    var ctxRight = canvasRight.getContext('2d');
                    canvasRight.width = cutWidth;
                    canvasRight.height = croppedImage.height;

                    // Draw the right half onto the new canvas
                    ctxRight.drawImage(croppedImage.getElement(), cutWidth, 0, cutWidth, croppedImage.height, 0,
                        0, cutWidth, croppedImage.height);

                    // Create the right half image
                    fabric.Image.fromURL(canvasRight.toDataURL(), function(rightFabricImage) {
                        rightImage = rightFabricImage; // Store the right image in the variable



                        // Store the right image for later use
                        if (side == 'left') {
                            // Apply transformations like scaling or rotation (if needed)
                            rightImage.set({
                                left: rightImage_left, // Position on the canvas (adjust as needed)
                                top: sleeve_top,
                            });
                            rightImage.scaleToWidth(
                                20);
                            rightImage.rotate(rightImage_rotate);
                            // rightImage.set({
                            //     left: 30, // Position on the canvas (adjust as needed)
                            //     top: 220,
                            // });
                            // rightImage.scaleToWidth(
                            //     20);
                            // rightImage.rotate(11);
                            leftSleeveRightSide = rightImage;
                            // console.log("left2");
                            // canvas.add(rightImage); // Add the right image to the Fabric canvas
                        } else {
                            // Apply transformations like scaling or rotation (if needed)
                            rightImage.set({
                                left: rightImage_right, // Position on the canvas (adjust as needed)
                                top: sleeve_top,
                            });
                            rightImage.scaleToWidth(
                                20);
                            rightImage.rotate(rightImage_rotate);
                            // rightImage.set({
                            //     left: 86, // Position on the canvas (adjust as needed)
                            //     top: 220,
                            // });
                            // rightImage.scaleToWidth(
                            //     20);
                            // rightImage.rotate(11);
                            // console.log("right2");
                            // canvas.add(rightImage); // Add the right image to the Fabric canvas
                            rightSleeveRightSide = rightImage;
                            console.log(rightSleeveRightSide);
                        }
                    });
                });
            };


            // var img = new Image();
            // img.src = previewImage;

            // img.onload = function() {
            //     // Create a temporary canvas to draw the image
            //     var canvasTemp = document.createElement('canvas');
            //     var ctxTemp = canvasTemp.getContext('2d');

            //     // Set the canvas dimensions to match the image
            //     canvasTemp.width = img.width;
            //     canvasTemp.height = img.height;

            //     // Draw the image onto the temporary canvas
            //     ctxTemp.drawImage(img, 0, 0);

            //     // Get the image data
            //     var imageData = ctxTemp.getImageData(0, 0, canvasTemp.width, canvasTemp.height);
            //     var data = imageData.data;

            //     // Initialize variables to store the bounds of the non-transparent areas
            //     var left = canvasTemp.width,
            //         right = 0,
            //         top = canvasTemp.height,
            //         bottom = 0;

            //     // Loop through the image data to find the bounds of the non-transparent pixels
            //     for (var y = 0; y < canvasTemp.height; y++) {
            //         for (var x = 0; x < canvasTemp.width; x++) {
            //             var index = (y * canvasTemp.width + x) * 4;
            //             var alpha = data[index + 3]; // Get the alpha value (transparency)

            //             if (alpha > 0) { // If not transparent
            //                 if (x < left) left = x;
            //                 if (x > right) right = x;
            //                 if (y < top) top = y;
            //                 if (y > bottom) bottom = y;
            //             }
            //         }
            //     }

            //     // Create a new canvas with the cropped dimensions
            //     var canvasCropped = document.createElement('canvas');
            //     var ctxCropped = canvasCropped.getContext('2d');
            //     canvasCropped.width = right - left;
            //     canvasCropped.height = bottom - top;

            //     // Draw the cropped image onto the new canvas
            //     ctxCropped.drawImage(canvasTemp, left, top, canvasCropped.width, canvasCropped.height, 0, 0,
            //         canvasCropped.width, canvasCropped.height);

            //     // Now, create a Fabric.js image from the cropped canvas
            //     fabric.Image.fromURL(canvasCropped.toDataURL(), function(croppedImage) {
            //         // Variables for cutting the image into two halves
            //         var cutWidth = croppedImage.width / 2;

            //         // Logic to add cut images to the canvas based on the side
            //         var newImage;

            //         // For the first half (left side)
            //         if (side === 'left') {
            //             newImage = croppedImage.set({
            //                 left: 405, // Position for the left sleeve
            //                 top: 220, // Position vertically
            //                 width: cutWidth, // Use only the left half
            //                 height: croppedImage.height,
            //             });

            //             // Apply transformations like scaling or rotation
            //            // Rotate by 45 degrees (or adjust as needed)
            //             newImage.scaleToWidth(20); // Resize to 200px width (or whatever size you prefer)
            //             newImage.rotate(-11);
            //         }
            //         // For the second half (right side)
            //         else if (side === 'right') {
            //             newImage = croppedImage.set({
            //                 left: cutWidth, // Start from the middle of the image for right side
            //                 top: 50, // Keep the same vertical positioning as left side
            //                 width: cutWidth, // Use only the right half
            //                 height: croppedImage.height,
            //             });

            //             newImage.scaleToWidth(20); // Resize to 200px width (or whatever size you prefer)
            //             newImage.rotate(-11);
            //         }

            //         // Apply transformations like scaling or rotation
            //         if (newImage) {

            //             canvas.add(newImage); // Add to the canvas
            //         }
            //     });
            // };
        }


        async function preview() {

            document.getElementById('mainContent').classList.add('blur-effect');
            var productIdInput = document.querySelector('.product-id');
            var productId = productIdInput.value;

            var front_image = '';
            var back_image = '';
            var right_image = '';
            var left_image = '';

            //for sleeves to cut it in half
            if (rightObjects.length > 0) {
                objects = rightObjects;
                addDesignToSleeve(objects, 'right');
            }
            if (leftObjects.length > 0) {
                objects = leftObjects;
                addDesignToSleeve(objects, 'left');
            }

            await delay(200);

            var product = @json($product);

            if (product.design_image_front_side) {
                // changeHoodieImage('front');
                // objects = rightObjects;
                // addDesignToSleeve(objects, 'right');
                // objects = leftObjects;
                // addDesignToSleeve(objects, 'left');
                // if (leftSleeveLeftSide) {
                //     canvas.add(leftSleeveLeftSide);
                // }
                // if (rightSleeveRightSide) {
                //     canvas.add(rightSleeveRightSide);
                // }
                // await delay(400); // Add a small delay to ensure the canvas fully updates

                // front_image = await saveCanvas('front');
                await delay(400); // Add a small delay to ensure the canvas fully updates
                tempCanvas = await changeSideForPreview('front');
                if (leftSleeveLeftSide) {
                    tempCanvas.add(leftSleeveLeftSide);
                }
                if (rightSleeveRightSide) {
                    tempCanvas.add(rightSleeveRightSide);
                }
                tempCanvas.renderAll();
                front_image = tempCanvas.toDataURL({
                    format: 'png',
                    quality: 0.8,
                });
            }

            if (product.design_image_back_side) {
                // changeHoodieImage('back');
                // if (leftSleeveRightSide) {
                //     canvas.add(leftSleeveRightSide);
                // }
                // if (rightSleeveLeftSide) {
                //     canvas.add(rightSleeveLeftSide);
                // }
                // await delay(500); // Add a small delay to ensure the canvas fully updates
                // back_image = await saveCanvas('back');

                await delay(500); // Add a small delay to ensure the canvas fully updates
                tempCanvas = await changeSideForPreview('back');
                if (leftSleeveRightSide) {
                    tempCanvas.add(leftSleeveRightSide);
                }
                if (rightSleeveLeftSide) {
                    tempCanvas.add(rightSleeveLeftSide);
                }
                tempCanvas.renderAll();
                back_image = tempCanvas.toDataURL({
                    format: 'png',
                    quality: 0.8,
                });
            }
            if (product.design_image_right_side) {
                // changeHoodieImage('right');
                // await delay(700); // Add a small delay to ensure the canvas fully updates
                // right_image = await saveCanvas('right');
                await delay(500); // Add a small delay to ensure the canvas fully updates
                tempCanvas = await changeSideForPreview('right');
                tempCanvas.renderAll();
                right_image = tempCanvas.toDataURL({
                    format: 'png',
                    quality: 0.8,
                });
            }
            if (product.design_image_left_side) {
                // changeHoodieImage('left');
                // await delay(1000); // Add a small delay to ensure the canvas fully updates
                // left_image = await saveCanvas('left');
                await delay(500); // Add a small delay to ensure the canvas fully updates
                tempCanvas = await changeSideForPreview('left');
                tempCanvas.renderAll();
                left_image = tempCanvas.toDataURL({
                    format: 'png',
                    quality: 0.8,
                });
            }

            var modalBody = $('#imageGalleryModal .modal-body .row');
            modalBody.empty(); // Clear existing images

            // Check if front_image exists, and add it to the modal
            if (front_image) {
                modalBody.append(`
            <div class="col-md-4">
                <img src="${front_image}" class="img-fluid mb-2" alt="Front Image" onclick="openZoomModal('${front_image}')">
                </div>
            `);
            }

            // Check if back_image exists, and add it to the modal
            if (back_image) {
                modalBody.append(`
                <div class="col-md-4">
                    <img src="${back_image}" class="img-fluid mb-2" alt="Back Image" onclick="openZoomModal('${back_image}')">
                </div>
            `);
            }
            if (right_image) {
                modalBody.append(`
                <div class="col-md-4">
                    <img src="${right_image}" class="img-fluid mb-2" alt="Right Image" onclick="openZoomModal('${right_image}')">
                </div>
            `);
            }
            if (left_image) {
                modalBody.append(`
                <div class="col-md-4">
                    <img src="${left_image}" class="img-fluid mb-2" alt="Left Image" onclick="openZoomModal('${left_image}')">
                </div>
            `);
            }

            // If no images exist, show a message
            if (!front_image && !back_image && !right_image && !left_image) {
                modalBody.append(`
                <p class="text-center">No images available for preview.</p>
            `);
            }

            $('#imageGalleryModal').modal('show'); // Show the preview modal programmatically
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
            } else if (currentSide === 'right') {
                rightDesign = objects;
            } else if (currentSide === 'left') {
                leftDesign = objects;
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
        // function loadDesignGallery() {
        //     var galleryContainer = document.getElementById('design-gallery');
        //     galleryContainer.innerHTML = ''; // Clear existing gallery

        //     var designs = JSON.parse(localStorage.getItem('designs')) || [];

        //     // Loop through saved designs and create image elements for the gallery
        //     designs.forEach((design, index) => {
        //         // Create an image element for the gallery
        //         var imgElement = document.createElement('img');
        //         imgElement.src = design.preview; // Use saved preview image
        //         imgElement.alt = `Design ${index + 1}`;
        //         imgElement.style = 'width: 150px; height: 150px; cursor: pointer; object-fit: contain;';
        //         imgElement.onclick = () => applyDesignToCanvas(design
        //             .objects); // Apply the design when clicked

        //         galleryContainer.appendChild(imgElement); // Append the image to the gallery
        //     });
        // }

        // Function to open the modal and load gallery
        // Function to load designs into the modal
        function loadDesignGallery() {
            // Show the modal
            var modal = document.getElementById('design-modal');
            var galleryContainer = document.getElementById('modal-gallery');
            galleryContainer.innerHTML = ''; // Clear existing gallery

            var designs = JSON.parse(localStorage.getItem('designs')) || [];

            // Loop through saved designs and create image elements for the gallery
            designs.forEach((design, index) => {
                var imgWrapper = document.createElement('div');
                imgWrapper.style.position = 'relative';

                // Create the image element for the design
                var imgElement = document.createElement('img');
                imgElement.src = design.preview; // Use saved preview image
                imgElement.alt = `Design ${index + 1}`;
                imgElement.onclick = () => applyDesignToCanvas(design.objects); // Apply the design when clicked

                // Create the remove button (X)
                var removeBtn = document.createElement('span');
                removeBtn.className = 'remove-btn';
                removeBtn.innerHTML = 'X';
                removeBtn.onclick = () => removeDesign(index); // Remove the design when clicked

                // Append the image and remove button to the wrapper
                imgWrapper.appendChild(imgElement);
                imgWrapper.appendChild(removeBtn);
                galleryContainer.appendChild(imgWrapper);
            });

            // Make modal visible and accessible
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            modal.querySelector('.modal-content').focus(); // Focus on modal content
            document.body.classList.add('inert'); // Disable interactions with background
        }

        // Function to remove design from localStorage and update modal
        function removeDesign(index) {
            // Retrieve existing designs from localStorage
            var designs = JSON.parse(localStorage.getItem('designs')) || [];

            // Remove the design at the specified index
            designs.splice(index, 1);

            // Save the updated designs array back to localStorage
            localStorage.setItem('designs', JSON.stringify(designs));

            // Reload the design gallery
            loadDesignGallery();
        }

        // Function to close the modal
        function closeModal() {
            const modal = document.getElementById('design-modal');
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('inert'); // Enable interactions with background
        }

        function clearGallery() {
            if (confirm('Are you sure you want to clear all saved designs?')) {
                localStorage.removeItem('designs');
                // loadDesignGallery(); // Reload the gallery to reflect changes
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
            closeModal();
        }
        //end of gallery design

        //custom color start

        // Select the color picker input
        var colorPicker = document.getElementById('colorPicker');
        if (colorPicker) {
            // Add an event listener for the color change
            colorPicker.addEventListener('input', function() {
                // Get the selected color
                var selectedColor = colorPicker.value;
                // console.log(selectedColor);
                document.getElementById('customColorPicker').value = selectedColor;
                // Apply the selected color as an overlay on the canvas
                changeColor(selectedColor);
            });
        }

        //custom color end

        // Load saved objects for the current side
        function loadCurrentCanvasObjects() {
            var objectsToLoad = [];
            if (currentSide === 'front') {
                objectsToLoad = frontObjects;
            } else if (currentSide === 'back') {
                objectsToLoad = backObjects;
            } else if (currentSide === 'right') {
                objectsToLoad = rightObjects;
            } else if (currentSide === 'left') {
                objectsToLoad = leftObjects;
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
    </script>
@endsection
