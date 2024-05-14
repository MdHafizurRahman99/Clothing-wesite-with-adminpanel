@extends('layouts.frontend.master')
@section('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/3.6.2/fabric.min.js"></script>
@endsection
@section('content')
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            {{-- <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('frontend/') }}/img/product-1.jpg" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="{{ asset('frontend/') }}/img/product-2.jpg" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="{{ asset('frontend/') }}/img/product-3.jpg" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="{{ asset('frontend/') }}/img/product-4.jpg" alt="Image">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div> --}}
            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <div id="canvasContainer">
                        <h3>Canvas</h3>
                        @php
                            $product_id = 1;
                        @endphp

                        <input type="hidden" class="product-id" value="{{ $product_id }}" name="product_id">

                        <canvas id="canvas" width="600" height="600" style="border: 1px solid #000000"></canvas>

                        <button onclick="frontside()" class="btn btn-primary">Front Side</button>
                        <button onclick="backside()" class="btn btn-primary">Back Side</button>
                        <button onclick="shoulder()" class="btn btn-primary">Shoulder</button>

                        <input class="btn btn-secondary px-3 m-2 " type="file" id="logoInput" accept="image/*">
                        <button class="btn btn-success px-3 m-2 " id="addTextButton">Add Text</button>
                        <button class="btn btn-success px-3 m-2 " id="saveButton">Save Mockup</button>
                        <button class="btn btn-danger px-3 m-2 " id="delateSelectedButton">Delete Selected</button>
                        {{-- <button id="clear">Clear</button> --}}
                    </div>
                    {{-- <img src="/app/storage/images/65daca0160274.jpg" alt="Uploaded Image"> --}}
                    <h3>Additional Details</h3>
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
                            {{-- <div class="custom-control custom-radio custom-control-inline">
                            <textarea name="neck_level_details" id="" cols="30" rows="2"
                                placeholder="Enter the Neck Level Details."></textarea>
                        </div> --}}
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
                                {{-- <input type="text" class="form-control bg-secondary border-0 text-center"
                                id="swing_tag-2" name="swing_tag"> --}}

                                {{-- <textarea name="swing_tag_details" id="" cols="30" rows="2"
                                placeholder="Enter the Neck Level Details."></textarea> --}}
                            </div>
                        </form>

                    </div>



                </div>
            </div>

            <div class="col-md-5">
                <div class="h-100 bg-light p-30">

                    <h4 class="mb-4">Design Your Product </h4>
                    <div class="form-group">
                        <label for="email">Select Logo/Design</label>
                        <input type="file" class="form-control" id="email">
                        <div class="d-flex mb-3">
                            <strong class="text-dark mr-3">Position:</strong>
                            <form>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="positon-1" name="positon"
                                        value="center-chest">
                                    <label class="custom-control-label" for="positon-1">Center chest</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="positon-2" name="positon"
                                        value="large-center">
                                    <label class="custom-control-label" for="positon-2">Large center</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="positon-3" name="positon"
                                        value="left-chest">
                                    <label class="custom-control-label" for="positon-3">Left chest</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="positon-4" name="positon"
                                        value="full-back">
                                    <label class="custom-control-label" for="positon-4">Full back</label>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="height">Height</label>
                            <input type="text" class="form-control" id="height">
                        </div>
                        <div class="col-md-6">
                            <label for="width">Width</label>
                            <input type="text" class="form-control" id="width">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message">Details:</label>
                        <textarea id="message" cols="30" rows="3" class="form-control" name="description"></textarea>
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
                        <a href="{{ route('shop.product-cart') }}" class="btn btn-primary px-3">
                            <i class="fa fa-shopping-cart mr-1"></i> Add to Cart
                        </a>
                    </div>
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

        // Initiate a Canvas instance inside the canvas container
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

        var addTextButton = document.getElementById('addTextButton');

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
                    // Create FormData object
                    let formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('imageFile', blob, 'image.jpg');

                    // Send image file to backend
                    $.ajax({
                        url: "{{ route('save-canvas-image') }}",
                        method: 'POST',
                        data: formData,
                        processData: false, // Prevent jQuery from processing the data
                        contentType: false, // Prevent jQuery from setting contentType
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                        },
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            // Handle errors or display an error message to the user.
                        }
                    });
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
                });
        }
        // Handle logo upload
        document.getElementById('logoInput').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
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

            if (activeObject) {
                var cacheKey = activeObject.cacheKey;

                var productIdInput = document.querySelector('.product-id');
                var productId = productIdInput.value;

                $.ajax({
                    url: "{{ route('delete-canvas-image') }}",
                    method: 'POST',
                    data: {
                        product_id: productId,
                        cacheKey: cacheKey,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                    },
                    success: function(data) {
                        var cartBadgeValue = data;
                        $('#cartBadge').text(cartBadgeValue);
                        console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Handle errors or display an error message to the user.
                    }
                });
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
        function saveCanvas() {
            var link = document.createElement('a');
            var imageURL = canvas.toDataURL({
                format: 'png'
            });
            link.href = canvas.toDataURL({
                format: 'png'
            });
            // console.log(imageURL);
            fetch(imageURL)
                .then(res => res.blob())
                .then(blob => {
                    var productIdInput = document.querySelector('.product-id');
                    var productId = productIdInput.value;
                    // Create FormData object
                    let formData = new FormData();
                    formData.append('product_id', productId);
                    formData.append('imageFile', blob, 'image.jpg');

                    // Send image file to backend
                    $.ajax({
                        url: "{{ route('save-canvas-mockup') }}",
                        method: 'POST',
                        data: formData,
                        processData: false, // Prevent jQuery from processing the data
                        contentType: false, // Prevent jQuery from setting contentType
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include the CSRF token in the headers
                        },
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            // Handle errors or display an error message to the user.
                        }
                    });
                })
                .catch(error => {
                    console.error('Error converting data URL to Blob:', error);
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
        // var saveButton = document.createElement('button');
        // saveButton.innerHTML = 'Save and next';
        var saveButton = document.getElementById('saveButton');

        saveButton.onclick = function() {
            // sendCanvasToBackend();
            saveCanvas();
        };
        canvasContainer.appendChild(saveButton);

        // document.getElementById('clear').addEventListener('click', function() {
        //     canvas.clear();
        // });

        //change Background image
        function backside() {
            canvas.clear();

            // var canvas = new fabric.Canvas('canvas');
            var newImageURL =
                '{{ asset('frontend/img/hoodie back side.jpg') }}'; // Replace 'new_image_url.jpg' with the URL of your new background image

            fabric.Image.fromURL(newImageURL, function(img) {
                img.set({
                    left: 0,
                    top: 0,
                    width: canvas.width,
                    height: canvas.height,
                    selectable: false
                });
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
            });
        }

        function frontside() {
            canvas.clear();

            // var canvas = new fabric.Canvas('canvas');
            var newImageURL =
                '{{ asset('frontend/img/product-2.jpg') }}'; // Replace 'new_image_url.jpg' with the URL of your new background image
            fabric.Image.fromURL(newImageURL, function(img) {
                img.set({
                    left: 0,
                    top: 0,
                    width: canvas.width,
                    height: canvas.height,
                    selectable: false
                });
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
            });
        }

        function shoulder() {
            canvas.clear();

            // var canvas = new fabric.Canvas('canvas');
            var newImageURL =
                '{{ asset('frontend/img/shoulder.jpeg') }}'; // Replace 'new_image_url.jpg' with the URL of your new background image

            fabric.Image.fromURL(newImageURL, function(img) {
                img.set({
                    left: 0,
                    top: 0,
                    width: canvas.width,
                    height: canvas.height,
                    selectable: false
                });
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
            });
        }
        // Add background image
        fabric.Image.fromURL(
            '{{ asset('frontend/img/product-2.jpg') }}', // URL of your background image
            function(img) {
                img.set({
                    left: 0,
                    top: 0,
                    width: canvas.width,
                    height: canvas.height,
                    selectable: false
                });
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
            }
        );
    </script>
@endsection
