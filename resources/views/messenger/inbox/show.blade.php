{{-- @extends('layouts.message.master')

@section('content')
    <div class="col-md-6">
        <h1>{{ $thread->subject }}</h1>
        @each('messenger.partials.messages', $thread->messages, 'message')

        @include('messenger.partials.form-message')
    </div>
@stop --}}

@extends('layouts.frontend.master')

@section('css')
    {{-- <style>
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: .875rem;
        }



        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            color: #888;
        }



        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            color: #888;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .file-upload:hover {
            border-color: #000000;
        }

        .file-upload-text {
            color: #000000;
            text-decoration: underline;
            cursor: pointer;
        }

        #preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .preview-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Gallery container */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            padding: 10px;
        }

        /* Image container */
        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Image styling */
        .image-container img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s ease-in-out;
        }

        /* Hover effect */
        .image-container:hover img {
            transform: scale(1.05);
        }

        /* Optional: Add a title or caption inside the image container */
        .image-container::after {
            /* content: "View Image"; */
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .message {
            display: flex;
            margin-bottom: 10px;
            max-width: 60%;
            /* Adjust max-width as needed */
        }

        .message-right {
            justify-content: flex-end;
            /* Align to the right */
            margin-left: auto;
            /* Push to the right */
        }

        .message-left {
            justify-content: flex-start;
            /* Align to the left */
            margin-right: auto;
            /* Push to the left */
        }

        .message-body {
            padding: 10px;
            border-radius: 8px;
            background-color: #f1f1f1;
            /* Background color for messages */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            word-wrap: break-word;
        }

        .message-right .message-body {
            background-color: #d1f1d1;
            /* Different color for user's messages */
        }
    </style> --}}
    <style>
        /* Input and Select Styling */
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: .875rem;
        }

        /* File Upload Styling */
        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            color: #888;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .file-upload:hover {
            border-color: #000000;
        }

        .file-upload-text {
            color: #000000;
            text-decoration: underline;
            cursor: pointer;
        }

        /* Preview Container Styling */
        #preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .preview-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Scrollable Gallery Container */
        .scrollable-gallery {
            display: flex;
            /* Enables flexbox for horizontal alignment */
            overflow-x: auto;
            /* Adds horizontal scroll */
            gap: 10px;
            /* Adds spacing between images */
            padding: 10px 0;
            /* Adds padding for a nicer look */
            white-space: nowrap;
            /* Prevents images from wrapping to the next line */
            scrollbar-width: thin;
            /* Firefox */
            max-width: 100%;
            /* Ensures the gallery fits within the container */
        }

        .scrollable-gallery::-webkit-scrollbar {
            height: 8px;
            /* Height of the scrollbar */
        }

        .scrollable-gallery::-webkit-scrollbar-thumb {
            background-color: #888;
            /* Scrollbar color */
            border-radius: 10px;
            /* Rounded corners */
        }

        .scrollable-gallery::-webkit-scrollbar-thumb:hover {
            background-color: #555;
            /* Scrollbar hover color */
        }

        /* Image Container and Styling */
        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
            /* Prevents shrinking of images */
        }

        .image-container img {
            height: 200px;
            /* Set a consistent height for all images */
            width: auto;
            /* Auto width to maintain aspect ratio */
            display: block;
            /* Ensures images are displayed correctly */
            border-radius: 4px;
            /* Rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            transition: transform 0.3s ease-in-out;
            /* Hover effect */
        }

        .image-container img:hover {
            transform: scale(1.05);
            /* Scale up on hover */
        }

        /* Optional: Add a title or caption inside the image container */
        .image-container::after {
            /* content: "View Image"; */
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }


        /* Image Container and Styling */
        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .image-container img {
            width: 150px;
            /* Set a consistent width */
            height: auto;
            /* Adjust height automatically */
            border-radius: 4px;
            /* Rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            transition: transform 0.3s ease-in-out;
            /* Hover effect */
        }

        .image-container img:hover {
            transform: scale(1.05);
            /* Scale up on hover */
        }

        /* Optional: Add a title or caption inside the image container */
        .image-container::after {
            /* content: "View Image"; */
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Message Styling */
        .message {
            display: flex;
            margin-bottom: 10px;
            max-width: 60%;
            /* Adjust max-width as needed */
        }

        .message-right {
            justify-content: flex-end;
            /* Align to the right */
            margin-left: auto;
            /* Push to the right */
        }

        .message-left {
            justify-content: flex-start;
            /* Align to the left */
            margin-right: auto;
            /* Push to the left */
        }

        .message-body {
            padding: 10px;
            border-radius: 8px;
            background-color: #f1f1f1;
            /* Background color for messages */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            word-wrap: break-word;
        }

        .message-right .message-body {
            background-color: #d1f1d1;
            /* Different color for user's messages */
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $thread->subject }}</h5>
                        <span class="text-muted">{{ $thread->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            {{-- <img src="{{ asset('path/to/avatar.png') }}" class="rounded-circle mr-3" width="50" height="50" alt="User Avatar"> --}}
                            <div>
                                <strong>MPC Clothing Support</strong>
                                {{-- <strong>{{ $thread->messages->last()->user->name }}</strong>
                                <span class="text-muted">&lt;{{ $thread->messages->last()->user->email }}&gt;</span>
                                @php
                                    $recepent_email = $thread->messages->last()->participants->last()->user->email;
                                @endphp
                                <div class="text-muted">to <strong>me</strong></div> --}}
                                {{-- <div class="text-muted">to <strong>{{ $recepent_email == auth()->user()->email ? 'me' : $recepent_email }}</strong></div> --}}
                            </div>
                        </div>
                        <div class="mt-4">
                            @foreach ($messages as $message)
                                @if ($message->user_id == auth()->user()->id)
                                    <!-- Right-aligned message for the authenticated user -->
                                    <div class="message message-right">
                                        <div class="message-body">
                                            {!! nl2br(e($message->body)) !!}
                                        </div>

                                    </div>
                                    <div class="message message-right">

                                        @if ($message->images->isNotEmpty())
                                            <div class=" scrollable-gallery">
                                                @foreach ($message->images as $image)
                                                    <div class="image-container">
                                                        <img src="{{ asset($image->image_url) }}"
                                                            alt="Image for Message {{ $message->id }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <!-- Left-aligned message for other users -->
                                    <div class="message message-left">
                                        <div class="message-body">
                                            {!! nl2br(e($message->body)) !!}
                                        </div>

                                    </div>
                                    <div class="message message-left">
                                        @if ($message->images->isNotEmpty())
                                            <div class="scrollable-gallery">
                                                @foreach ($message->images as $image)
                                                    <div class="image-container">
                                                        <img src="{{ asset($image->image_url) }}"
                                                            alt="Image for Message {{ $message->id }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{--
                        <div class="gallery">
                            @if (!empty($galleryImages))
                                @foreach ($galleryImages as $imageUrl)
                                    <div class="image-container">
                                        <img src="{{ asset($imageUrl->image_url) }}" alt="Uploaded Image"
                                            style="max-width: 200px; height: auto;">
                                    </div>
                                @endforeach
                            @else
                                <p>No images have been uploaded yet.</p>
                            @endif
                        </div> --}}

                    </div>
                    <div class="card-footer bg-light d-flex justify-content-end">
                        <button id="replyButton" class="btn btn-primary mr-2">Reply</button>
                        {{-- <a href="#" class="btn btn-outline-secondary">Forward</a> --}}
                        <a href="{{ route('messages.index') }}" class="btn btn-primary">Back to Inbox</a>

                    </div>
                </div>

                <!-- Reply Form -->
                <div id="replyForm" style="display: none;" class="mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Reply</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('messages.reply', $thread->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    {{-- <label for="to">To:</label> --}}
                                    <input type="hidden" class="form-control" id="to" name="recipients[]"
                                        value="{{ $thread->messages->last()->user->id }}" readonly>
                                    <input type="hidden" class="form-control" id="to" name="to"
                                        value="{{ $thread->messages->last()->user->email }}" readonly>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="cc">Cc:</label>
                                    <input type="text" class="form-control" id="cc" name="cc">
                                </div> --}}
                                {{-- <div class="form-group">
                                    <label for="bcc">Bcc:</label>
                                    <input type="text" class="form-control" id="bcc" name="bcc">
                                </div> --}}
                                <div class="form-group">
                                    <label for="message">Message:</label>
                                    <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                                </div>
                                <div class="form-group form-input">
                                    <label for="inspiration-images">Upload images</label>
                                    <div class="file-upload" id="file-upload">
                                        <input type="file" id="inspiration-images" name="inspiration_images[]" multiple
                                            accept="image/*" style="display: none;">
                                        <p>Drag and drop some files here, or <span class="file-upload-text">click to select
                                                files</span></p>
                                        <div id="preview-container"></div>
                                    </div>
                                    @error('inspiration_images')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">Send</button>
                                    <button type="button" id="cancelButton" class="btn btn-secondary ml-2">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <div class="mt-3 text-center">
                </div> --}}
            </div>
        </div>
    </div>

    <script>
        document.getElementById("replyButton").addEventListener("click", function() {
            document.getElementById("replyForm").style.display = "block";
        });

        document.getElementById("cancelButton").addEventListener("click", function() {
            document.getElementById("replyForm").style.display = "none";
        });
    </script>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileUpload = document.getElementById('file-upload');
            const fileInput = document.getElementById('inspiration-images');
            const previewContainer = document.getElementById('preview-container');

            fileUpload.addEventListener('click', () => {
                fileInput.click();
            });

            fileUpload.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUpload.style.borderColor = '#007bff';
            });

            fileUpload.addEventListener('dragleave', () => {
                fileUpload.style.borderColor = '#ddd';
            });

            fileUpload.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUpload.style.borderColor = '#ddd';
                handleFiles(e.dataTransfer.files);
            });

            fileInput.addEventListener('change', () => {
                handleFiles(fileInput.files);
            });

            function handleFiles(files) {
                previewContainer.innerHTML = '';
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('preview-image');
                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        console.warn('Skipping non-image file:', file.name);
                    }
                });
            }



            // $(function() {
            //     let emailList = [];

            //     function split(val) {
            //         return val.split(/,\s*/);
            //     }

            //     function extractLast(term) {
            //         return split(term).pop();
            //     }

            //     $("#bcc").on("keydown", function(event) {
            //         if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu
            //             .active) {
            //             event.preventDefault();
            //         }
            //     }).autocomplete({
            //         source: function(request, response) {
            //             $.getJSON("{{ route('autocomplete') }}", {
            //                 term: extractLast(request.term)
            //             }, response);
            //         },
            //         search: function() {
            //             // Custom minLength to trigger autocomplete
            //             let term = extractLast(this.value);
            //             if (term.length < 2) {
            //                 return false;
            //             }
            //         },
            //         focus: function() {
            //             return false;
            //         },
            //         select: function(event, ui) {
            //             let terms = split(this.value);
            //             terms.pop(); // Remove the current input
            //             terms.push(ui.item.value); // Add the selected item
            //             terms.push(""); // Add placeholder to get comma-and-space at the end
            //             this.value = terms.join(", ");
            //             return false;
            //         }
            //     });
            // });


            $('#bcc').on('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

        });
        document.querySelector('.scrollable-gallery').addEventListener('wheel', (event) => {
            event.preventDefault();
            event.currentTarget.scrollBy({
                left: event.deltaY < 0 ? -300 : 300, // Adjust scroll speed here
                behavior: 'smooth'
            });
        });
    </script>
@endsection
