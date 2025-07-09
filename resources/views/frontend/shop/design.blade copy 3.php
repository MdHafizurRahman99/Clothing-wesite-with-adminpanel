@extends('layouts.frontend.master')

@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        #coordinates {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
        }
        .pointer-marker {
            stroke: red;
            strokeWidth: 2;
            fill: none;
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
                        <div id="coordinates">X: 0, Y: 0</div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-1 col-sm-12 d-flex flex-column flex-sm-row flex-md-column align-items-center py-3">
                                    <label for="logoInput" class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0">
                                        <i class="fas fa-upload fa-2x"></i>
                                        <div>Upload</div>
                                    </label>
                                    <input type="file" id="logoInput" accept="image/*" style="display: none;">
                                    <button class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0" onclick="openModal()" title="Add Text">
                                        <i class="fas fa-text-height fa-2x"></i>
                                        <div>Add Text</div>
                                    </button>
                                    <button class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0" onclick="loadDesignGallery()" title="My Library">
                                        <i class="fas fa-folder-open fa-2x"></i>
                                        <div>Graphics</div>
                                    </button>
                                    <button class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0" onclick="saveCurrentDesign()" title="Graphics">
                                        <i class="fas fa-palette fa-2x"></i>
                                        <div>Save Graphics</div>
                                    </button>
                                    <button class="menu-button btn btn-danger mb-3" onclick="deleteAction()" title="Delete Selected" id="delateSelectedButton">
                                        <i class="fas fa-trash-alt fa-2x"></i>
                                        <div>Delete</div>
                                    </button>
                                    <button class="menu-button btn btn-light mb-3 me-sm-3 mb-sm-0" onclick="logCoordinates()" title="Log Coordinates">
                                        <i class="fas fa-map-pin fa-2x"></i>
                                        <div>Log Coordinates</div>
                                    </button>
                                </div>
                                <div class="col-md-11 col-sm-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="canvas-container text-center">
                                                <canvas id="canvas" width="600" height="600" class="img-fluid border"></canvas>
                                            </div>
                                        </div>
                                        <div class="mt-2">
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
                        <div class="form-group color-palette">
                            <h6 class="mb-2">Colors:</h6>
                            <div class="color-rows">
                                @foreach ($colors as $color)
                                    @if ($color != null)
                                        <button class="color-cell" style="background-color: {{ $color->code }};" onclick="changeColor('{{ $color->code }}')"></button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="design-gallery" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                    @if ($product->customcolor == 'Yes')
                        <div class="mt-2">
                            <span><b>Custom color:</b></span>
                            <input class="ml-3" type="color" id="colorPicker" value="#ff0000" />
                            <label for="customcolor" class="col-md-12">(Custom colors require a minimum order of {{ $product->minimum_order }}pcs and {{ $product->minimum_time_required }} days lead time.)</label>
                        </div>
                    @endif
                    <div id="design-modal" class="design-modal" tabindex="-1" aria-hidden="true" style="display: none;">
                        <div class="modal-content" role="dialog" aria-labelledby="design-modal-title">
                            <span class="close-btn" onclick="closeModal()" aria-label="Close">×</span>
                            <h2 id="design-modal-title">Design Gallery</h2>
                            <div id="modal-gallery" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary px-3 m-2" onclick="preview()">Preview</button>
                </div>
                <form id="mockupForm" action="{{ route('custom-product-design.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="h-100 bg-light p-30">
                        <input type="hidden" class="product-id" value="{{ $product->product_id }}" name="product_id">
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
                                <input type="radio" class="custom-control-input" id="neck_level-1" name="neck_level" value="Yes">
                                <label class="custom-control-label" for="neck_level-1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="neck_level-2" name="neck_level" value="No">
                                <label class="custom-control-label" for="neck_level-2">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Neck level Design:</label>
                            <input class="btn btn-secondary px-3 m-2" type="file" accept="image/*" name="neck_level_design">
                        </div>
                        <div class="form-group">
                            <label for="message">Neck level Details:</label>
                            <textarea id="message" class="form-control" name="neck_level_details"></textarea>
                        </div>
                        <div class="d-flex mb-4">
                            <strong class="text-dark mr-3">Swing Tag?</strong>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="swing_tag-1" name="swing_tag" value="Yes">
                                <label class="custom-control-label" for="swing_tag-1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="swing_tag-2" name="swing_tag" value="No">
                                <label class="custom-control-label" for="swing_tag-2">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Swing Tag Design:</label>
                            <input class="btn btn-secondary px-3 m-2" type="file" accept="image/*" name="swing_tag_design">
                        </div>
                        <div class="form-group">
                            <label for="message">Swing Tag Details:</label>
                            <textarea id="message" class="form-control" name="swing_tag_details"></textarea>
                        </div>
                        <div class="d-flex mb-4">
                            <strong class="text-dark mr-3">Right Sleeve?</strong>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="right_sleeve-1" name="right_sleeve" value="Yes">
                                <label class="custom-control-label" for="right_sleeve-1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="right_sleeve-2" name="right_sleeve" value="No">
                                <label class="custom-control-label" for="right_sleeve-2">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Right Sleeve Design:</label>
                            <input class="btn btn-secondary px-3 m-2" type="file" accept="image/*" name="right_sleeve_design">
                        </div>
                        <div class="form-group">
                            <label for="message">Right Sleeve Details:</label>
                            <textarea id="message" class="form-control" name="right_sleeve_details"></textarea>
                        </div>
                        <div class="d-flex mb-4">
                            <strong class="text-dark mr-3">Left Sleeve?</strong>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="left_sleeve-1" name="left_sleeve" value="Yes">
                                <label class="custom-control-label" for="left_sleeve-1">Yes</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="left_sleeve-2" name="left_sleeve" value="No">
                                <label class="custom-control-label" for="left_sleeve-2">No</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Left Sleeve Design:</label>
                            <input class="btn btn-secondary px-3 m-2" type="file" accept="image/*" name="left_sleeve_design">
                        </div>
                        <div class="form-group">
                            <label for="message">Left Sleeve Details:</label>
                            <textarea id="message" class="form-control" name="left_sleeve_details"></textarea>
                        </div>
                        <div class="d-flex align-items-center mb-4 pt-2">
                            <button type="submit" class="btn btn-primary px-3">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-label="Close" onclick="closeZoomModal()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="zoomedImage" class="img-fluid" alt="Zoomed Image" />
                </div>
            </div>
        </div>
    </div>
    <div id="textModal" class="design-modal" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <span class="close" onclick="closeTextModal()">×</span>
                <div class="mt-4">
                    <h6>Text:</h6>
                    <label for="fontFamily">Font:</label>
                    <select id="fontFamily" class="form-select"></select>
                    <label for="textColor">Color:</label>
                    <input class="ml-3" type="color" id="textColor" value="#000000" class="form-control" />
                    <button class="btn btn-success px-3 m-2" id="addTextButton">Add Text</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="imageGalleryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Image Gallery</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/design.js') }}"></script>
    <script>
        function openModal() {
            document.getElementById("textModal").style.display = "block";
        }

        function closeTextModal() {
            document.getElementById("textModal").style.display = "none";
        }

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

        $('#imageGalleryModal').on('hidden.bs.modal', function() {
            document.getElementById('mainContent').classList.remove('blur-effect');
        });

        const fonts = [
            'Arial', 'Times New Roman', 'Verdana', 'Courier New', 'Roboto',
            'Lato', 'Montserrat', 'Open Sans', 'Oswald', 'Raleway', 'Poppins',
            'Playfair Display', 'Source Sans Pro'
        ];

        const fontFamilySelect = document.getElementById('fontFamily');
        const textColorInput = document.getElementById('textColor');
        const addTextButton = document.getElementById('addTextButton');

        function populateFontDropdown(fontList) {
            fontList.forEach(font => {
                const option = document.createElement('option');
                option.value = font;
                option.textContent = font;
                fontFamilySelect.appendChild(option);
            });
        }

        function loadGoogleFont(font) {
            const link = document.createElement('link');
            link.href = `https://fonts.googleapis.com/css2?family=${font.replace(/ /g, '+')}&display=swap`;
            link.rel = 'stylesheet';
            document.head.appendChild(link);
        }

        populateFontDropdown(fonts);
        fonts.forEach(font => loadGoogleFont(font));

        addTextButton.onclick = function() {
            const selectedFont = fontFamilySelect.value;
            const textColor = textColorInput.value;
            if (!selectedFont) {
                Swal.fire('Error', 'Please select a font!', 'error');
                return;
            }

            const sideConfig = sideConfigs.find(config => config.side === currentSide);
            if (!sideConfig) return;

            const text = new fabric.Textbox('Your Text Here', {
                left: sideConfig.design_area.x,
                top: sideConfig.design_area.y,
                width: sideConfig.design_area.width,
                fontSize: 20,
                fontFamily: selectedFont,
                fill: textColor,
                selectable: true
            });
            canvas.add(text);
            saveCurrentCanvasObjects();
            canvas.renderAll();
            renderAdjacentDesigns();
            closeTextModal();
        };

        function changeColor(color) {
            selectedColor = color;
            changeHoodieImage(currentSide);
        }
    </script>
@endsection
