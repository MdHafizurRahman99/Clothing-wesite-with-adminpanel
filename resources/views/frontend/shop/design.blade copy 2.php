@extends('layouts.frontend.master')
@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/3.6.2/fabric.min.js"></script>

    <style>
        .upload-zone-alt {
            position: absolute;
            top: 210px;
            left: 252px;
            width: 178px;
            height: 175px;
            border: 2px dashed #b3b3b3;
            background: rgba(255, 248, 248, 0.1);
        }
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

        .border {
            border: none !important;
        }

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
            text-align: center;
        }

        .btn-danger img {
            display: block;
            margin: 0 auto 5px;
        }

        .blur-effect {
            filter: blur(100px);
            transition: filter 0.1s ease;
        }

        .modal-body img {
            transition: transform 0.3s ease, filter 0.3s ease;
            cursor: pointer;
        }

        .modal-body img:hover {
            transform: scale(1.1);
            filter: grayscale(0%);
        }

        .design-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            display: none;
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

        .modal-backdrop {
            z-index: 1039;
        }

        #imageGalleryModal {
            z-index: 1040;
        }

        #zoomModal {
            z-index: 1050;
        }

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
            max-width: 100%;
            margin: 0 auto;
        }

        .color-cell {
            width: 30px;
            height: 30px;
            border: 1px solid #ccc;
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
                        <div class="container-fluid">
                            <div class="row">
                                <div
                                    class="col-md-1 col-sm-12 d-flex flex-column flex-sm-row flex-md-column align-items-center py-3">

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
                    </div>
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
                    <div class="mt-2">
                    </div>
                    <!-- Gallery modal -->
                    <div id="design-modal" class="design-modal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-content" role="dialog" aria-labelledby="design-modal-title">
                            <span class="close-btn" onclick="closeModal()" aria-label="Close">&times;</span>
                            <h2 id="design-modal-title">Design Gallery</h2>
                            <div id="modal-gallery" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary px-3 m-2" onclick="preview()">
                        Preview
                    </button>
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
                        <div class="d-flex align-items-center mb-4 pt-2">
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

    <script>
        const uploadZone = document.getElementById('uploadZone');

        function openModal() {
            document.getElementById("textModal").style.display = "block";
        }

        function closeTextModal() {
            document.getElementById("textModal").style.display = "none";
        }
        var canvasContainer = document.getElementById('canvasContainer');
        var selectedColor = '#FFFFFF'; // Default color
        var rightSleeveRightSide;
        var rightSleeveLeftSide;
        var leftSleeveRightSide;
        var leftSleeveLeftSide;

        function changeColor(color) {
            selectedColor = color; // Store the selected color
            changeHoodieImage(currentSide); // Update the current hoodie image with the new color
        }
        var canvas = new fabric.Canvas("canvas", {
            selection: true
        });


        document.querySelector('.lower-canvas').style.border = 'none';
        document.querySelector('.upper-canvas').style.border = 'none';
        document.querySelector('.canvas-container').style.marginLeft = '40px';

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
                fill: textColor,
            });
            canvas.add(text);
            saveCurrentCanvasObjects(); // Save the new object for the current side
        }

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
        function populateFontDropdown(fontList) {
            fontList.forEach(font => {
                var option = document.createElement('option');
                option.value = font;
                option.textContent = font;
                fontFamilySelect.appendChild(option);
            });
        }
        function loadGoogleFont(font) {
            var link = document.createElement('link');
            link.href = `https://fonts.googleapis.com/css2?family=${font.replace(/ /g, '+')}&display=swap`;
            link.rel = 'stylesheet';
            document.head.appendChild(link);
        }

        populateFontDropdown(fonts);

        fonts.forEach(font => loadGoogleFont(font));

        addTextButton.onclick = function() {
            addText();
            closeTextModal();

        };

        function addImage(imageURL) {
            fetch(imageURL)
                .then(res => res.blob())
                .then(blob => {
                    var productIdInput = document.querySelector('.product-id');
                    var productId = productIdInput.value;
                    var fileInput = document.getElementById('logoInput');
                    let formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('imageFile', blob, 'image.jpg');
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
                        scaleX: 0.2,
                        scaleY: 0.2,
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
            reader.onload = function(event) {
                var imageURL = event.target.result;
                addImage(imageURL);
            }
            reader.readAsDataURL(file);
            document.getElementById("logoInput").value = "";

        });

        function deleteSelected() {
            var activeObject = canvas.getActiveObject();
            if (activeObject) {
                var cacheKey = activeObject.cacheKey;

                var productIdInput = document.querySelector('.product-id');
                var productId = productIdInput.value;
                canvas.remove(activeObject);
            }
        }

        var delateSelectedButton = document.getElementById('delateSelectedButton');

        delateSelectedButton.onclick = function() {
            deleteSelected();
        };
        var frontObjects = [];
        var backObjects = [];
        var rightObjects = [];
        var leftObjects = [];
        var shoulderObjects = [];
        var currentSide = 'front'; // Track the current side


        function changeHoodieImage(side) {

            saveCurrentCanvasObjects();
            canvas.clear();

            var imagePath = ''; // Path of the hoodie image based on side
            if (side === 'front') {
                imagePath = '{{ asset($product->design_image_front_side) }}';
            } else if (side === 'back') {
                imagePath = '{{ asset($product->design_image_back_side) }}';
            } else if (side === 'right') {
                imagePath = '{{ asset($product->design_image_right_side) }}';

            } else if (side === 'left') {
                imagePath = '{{ asset($product->design_image_left_side) }}';

            } else if (side === 'shoulder') {
                imagePath = '{{ asset('frontend/img/shoulder.jpeg') }}';
            }
            currentSide = side;

            fabric.Image.fromURL(imagePath, function(img) {

                const padding = 20; // Adjust this value as needed
                img.scaleToWidth(canvas.width - padding * 2); // Leave padding on both sides
                img.scaleToHeight(canvas.height - padding * 2); // Leave padding on top and bottom
                img.set({
                    left: padding, // Add left padding
                    top: padding, // Add top padding
                    selectable: false
                });
                img.filters.push(new fabric.Image.filters.BlendColor({
                    color: selectedColor, // Use the currently selected color
                    mode: 'overlay',
                    alpha: 0.5
                }));

                img.applyFilters();

                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));

                const tempCanvas = document.createElement('canvas');
                const tempCtx = tempCanvas.getContext('2d');
                tempCanvas.width = canvas.width;
                tempCanvas.height = canvas.height;

                tempCtx.drawImage(img.getElement(), 0, 0);

                const imageData = tempCtx.getImageData(0, 0, canvas.width, canvas.height);
                const contourPoints = marchingSquares(imageData);
                const simplifiedPoints = simplifyPath(contourPoints, 2); // Adjust tolerance as needed
                const clipPath = new fabric.Polygon(simplifiedPoints, {
                    absolutePositioned: true,
                    selectable: false,
                    fill: 'red',
                    opacity: 0.01
                });
                loadCurrentCanvasObjects();
            });
        }


        async function changeSideForPreview(side) {
            let imagePath = '';
            let objectsToLoad = [];

            saveCurrentCanvasObjects();
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

            const tempCanvas = new fabric.StaticCanvas(null);
            tempCanvas.setWidth(600);
            tempCanvas.setHeight(600);

            return new Promise((resolve) => {
                fabric.Image.fromURL(imagePath, function(img) {
                    const padding = 20;

                    img.scaleToWidth(tempCanvas.width - padding * 2);
                    img.scaleToHeight(tempCanvas.height - padding * 2);
                    img.set({
                        left: padding,
                        top: padding,
                        selectable: false,
                    });

                    img.filters.push(new fabric.Image.filters.BlendColor({
                        color: selectedColor,
                        mode: 'overlay',
                        alpha: 0.5,
                    }));
                    img.applyFilters();

                    tempCanvas.setBackgroundImage(img, tempCanvas.renderAll.bind(tempCanvas));

                    objectsToLoad.forEach((obj) => {
                        tempCanvas.add(obj);
                    });

                    resolve(tempCanvas);
                });
            });
        }


        function marchingSquares(imageData) {
            const points = [];
            const width = imageData.width;
            const height = imageData.height;
            const data = imageData.data;

            const ALPHA_THRESHOLD = 100;

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

                let nextDir = (dir + 6) % 8;
                let found = false;
                let bestAlpha = ALPHA_THRESHOLD;
                let bestDir = nextDir;

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

        function saveCurrentCanvasObjects() {
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


                fetch(imageURL)
                    .then(res => res.blob())
                    .then(blob => {
                        var productIdInput = document.querySelector('.product-id');
                        var productId = productIdInput.value;

                        let formData = new FormData();
                        formData.append('product_id', productId);
                        formData.append('side', side);
                        formData.append('objects', objects);
                        formData.append('imageFile', blob, 'image.jpg');

                        images.forEach((imageSrc, index) => {
                            formData.append(`imageURL_${index + 1}`, imageSrc);
                        });

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

                            success: function(data) {
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

        function sendCanvasToBackend() {
            var imageData = canvas.toDataURL({
                format: 'png'
            });

            var encodedImageData = encodeURIComponent(imageData);

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
                    console.log('Canvas image sent to backend successfully');
                })
                .catch(error => {
                    console.error('Error sending canvas image to backend:', error);
                });
        }


        $('#imageGalleryModal').on('hidden.bs.modal', function() {
            document.getElementById('mainContent').classList.remove('blur-effect');
        });

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

        document.getElementById("mockupForm").addEventListener("submit", async function(event) {
            event.preventDefault(); // Prevent the default form submission

            await saveAllMockup();

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

            var tempCanvas = new fabric.StaticCanvas(null, {
                width: 600, // Size of the temporary canvas (adjust as necessary)
                height: 600,
            });

            objects.forEach(function(obj) {
                tempCanvas.add(obj);
            });

            var previewImage = tempCanvas.toDataURL({
                format: 'png',
                quality: 0.8,
            });
            var img = new Image();
            img.src = previewImage;

            img.onload = function() {
                var canvasTemp = document.createElement('canvas');
                var ctxTemp = canvasTemp.getContext('2d');

                canvasTemp.width = img.width;
                canvasTemp.height = img.height;

                ctxTemp.drawImage(img, 0, 0);

                var imageData = ctxTemp.getImageData(0, 0, canvasTemp.width, canvasTemp.height);
                var data = imageData.data;

                var left = canvasTemp.width,
                    right = 0,
                    top = canvasTemp.height,
                    bottom = 0;

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

                var canvasCropped = document.createElement('canvas');
                var ctxCropped = canvasCropped.getContext('2d');
                canvasCropped.width = right - left;
                canvasCropped.height = bottom - top;

                ctxCropped.drawImage(canvasTemp, left, top, canvasCropped.width, canvasCropped.height, 0, 0,
                    canvasCropped.width, canvasCropped.height);

                fabric.Image.fromURL(canvasCropped.toDataURL(), function(croppedImage) {
                    var cutWidth = croppedImage.width / 2;
                    var leftImage, rightImage;
                    var canvasLeft = document.createElement('canvas');
                    var ctxLeft = canvasLeft.getContext('2d');
                    canvasLeft.width = cutWidth;
                    canvasLeft.height = croppedImage.height;

                    ctxLeft.drawImage(croppedImage.getElement(), 0, 0, cutWidth, croppedImage.height, 0, 0,
                        cutWidth, croppedImage.height);

                    fabric.Image.fromURL(canvasLeft.toDataURL(), function(leftFabricImage) {
                        leftImage = leftFabricImage; // Store the left image in the variable

                        if (side == 'left') {
                            leftImage.set({
                                left: leftImage_left, // Position on the canvas (adjust as needed)
                                top: sleeve_top,
                            });
                            leftImage.scaleToWidth(
                                20);
                            leftImage.rotate(leftImage_rotate);
                            leftSleeveLeftSide = leftImage;
                        } else {
                            leftImage.set({
                                left: leftImage_right, // Position on the canvas (adjust as needed)
                                top: sleeve_top,
                            });
                            leftImage.scaleToWidth(
                                20);
                            leftImage.rotate(leftImage_right_rotate);
                            rightSleeveLeftSide = leftImage;
                            console.log(rightSleeveLeftSide);
                        }
                    });

                    var canvasRight = document.createElement('canvas');
                    var ctxRight = canvasRight.getContext('2d');
                    canvasRight.width = cutWidth;
                    canvasRight.height = croppedImage.height;

                    ctxRight.drawImage(croppedImage.getElement(), cutWidth, 0, cutWidth, croppedImage.height, 0,
                        0, cutWidth, croppedImage.height);

                    fabric.Image.fromURL(canvasRight.toDataURL(), function(rightFabricImage) {
                        rightImage = rightFabricImage; // Store the right image in the variable

                        if (side == 'left') {
                            rightImage.set({
                                left: rightImage_left, // Position on the canvas (adjust as needed)
                                top: sleeve_top,
                            });
                            rightImage.scaleToWidth(
                                20);
                            rightImage.rotate(rightImage_rotate);

                            leftSleeveRightSide = rightImage;
                        } else {
                            rightImage.set({
                                left: rightImage_right, // Position on the canvas (adjust as needed)
                                top: sleeve_top,
                            });
                            rightImage.scaleToWidth(
                                20);
                            rightImage.rotate(rightImage_rotate);

                            rightSleeveRightSide = rightImage;
                            console.log(rightSleeveRightSide);
                        }
                    });
                });
            };
        }


        async function preview() {

            document.getElementById('mainContent').classList.add('blur-effect');
            var productIdInput = document.querySelector('.product-id');
            var productId = productIdInput.value;

            var front_image = '';
            var back_image = '';
            var right_image = '';
            var left_image = '';

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
                await delay(500); // Add a small delay to ensure the canvas fully updates
                tempCanvas = await changeSideForPreview('right');
                tempCanvas.renderAll();
                right_image = tempCanvas.toDataURL({
                    format: 'png',
                    quality: 0.8,
                });
            }
            if (product.design_image_left_side) {
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
            if (front_image) {
                modalBody.append(`
            <div class="col-md-4">
                <img src="${front_image}" class="img-fluid mb-2" alt="Front Image" onclick="openZoomModal('${front_image}')">
                </div>
            `);
            }

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

            if (!front_image && !back_image && !right_image && !left_image) {
                modalBody.append(`
                <p class="text-center">No images available for preview.</p>
            `);
            }

            $('#imageGalleryModal').modal('show'); // Show the preview modal programmatically
        }

        function delay(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        let designGallery = []; // Array to store designs

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
            var tempCanvas = new fabric.StaticCanvas(null, {
                width: 600,
                height: 600,
            });

            objects.forEach(function(obj) {
                tempCanvas.add(obj);
            });
            var previewImage = tempCanvas.toDataURL({
                format: 'png',
                quality: 0.8,
            });

            var designs = JSON.parse(localStorage.getItem('designs')) || [];
            designs.push({
                side: currentSide,
                objects: objects,
                preview: previewImage, // Save the preview image
            });

            localStorage.setItem('designs', JSON.stringify(designs));
            alert('Design saved successfully!');
        }

        function loadDesignGallery() {
            var modal = document.getElementById('design-modal');
            var galleryContainer = document.getElementById('modal-gallery');
            galleryContainer.innerHTML = ''; // Clear existing gallery

            var designs = JSON.parse(localStorage.getItem('designs')) || [];

            designs.forEach((design, index) => {
                var imgWrapper = document.createElement('div');
                imgWrapper.style.position = 'relative';

                var imgElement = document.createElement('img');
                imgElement.src = design.preview; // Use saved preview image
                imgElement.alt = `Design ${index + 1}`;
                imgElement.onclick = () => applyDesignToCanvas(design.objects); // Apply the design when clicked

                var removeBtn = document.createElement('span');
                removeBtn.className = 'remove-btn';
                removeBtn.innerHTML = 'X';
                removeBtn.onclick = () => removeDesign(index); // Remove the design when clicked

                imgWrapper.appendChild(imgElement);
                imgWrapper.appendChild(removeBtn);
                galleryContainer.appendChild(imgWrapper);
            });

            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            modal.querySelector('.modal-content').focus(); // Focus on modal content
            document.body.classList.add('inert'); // Disable interactions with background
        }

        function removeDesign(index) {
            var designs = JSON.parse(localStorage.getItem('designs')) || [];

            designs.splice(index, 1);

            localStorage.setItem('designs', JSON.stringify(designs));

            loadDesignGallery();
        }

        function closeModal() {
            const modal = document.getElementById('design-modal');
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('inert'); // Enable interactions with background
        }

        function clearGallery() {
            if (confirm('Are you sure you want to clear all saved designs?')) {
                localStorage.removeItem('designs');
            }
        }


        function applyDesignToCanvas(objects) {
            fabric.util.enlivenObjects(objects, function(enlivenedObjects) {
                enlivenedObjects.forEach(function(obj) {
                    canvas.add(obj);
                });
                canvas.renderAll();
            });
            closeModal();
        }

        var colorPicker = document.getElementById('colorPicker');
        if (colorPicker) {
            colorPicker.addEventListener('input', function() {
                var selectedColor = colorPicker.value;
                document.getElementById('customColorPicker').value = selectedColor;
                changeColor(selectedColor);
            });
        }

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
        window.onload = function() {
            changeHoodieImage('front'); // Default to 'front' side
        };
    </script>
@endsection
