{{-- @extends('layouts.message.master')

@section('content')
    <h1>Create a new message</h1>
    <form action="{{ route('messages.store') }}" method="post">
        {{ csrf_field() }}
        <div class="col-md-6">
            <!-- Subject Form Input -->
            <div class="form-group">
                <label class="control-label">Subject</label>
                <input type="text" class="form-control" name="subject" placeholder="Subject"
                       value="{{ old('subject') }}">
            </div>

            <!-- Message Form Input -->
            <div class="form-group">
                <label class="control-label">Message</label>
                <textarea name="message" class="form-control">{{ old('message') }}</textarea>
            </div>

            @if ($users->count() > 0)
                <div class="checkbox">
                    @foreach ($users as $user)
                        <label title="{{ $user->name }}"><input type="checkbox" name="recipients[]"
                                                                value="{{ $user->id }}">{!!$user->name!!}</label>
                    @endforeach
                </div>
            @endif

            <!-- Submit Form Input -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary form-control">Submit</button>
            </div>
        </div>
    </form>
@stop --}}
@extends('layouts.frontend.master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify@4.9.4/dist/tagify.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify@4.9.4/dist/tagify.min.js"></script>


    <style>
        #bcc-container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
            min-height: 38px;
            width: 100%;
            /* Ensures the container takes full width */
        }

        #bcc-container input {
            flex-grow: 1;
            border: none;
            outline: none;
            min-width: 100px;
            /* Minimum width of the input */
            padding: 5px 0;
            margin: 3px;
            width: auto;
            /* Adjusts according to available space */
            box-sizing: border-box;
        }

        .bcc-tag {
            background-color: #e1e4e8;
            padding: 5px;
            margin: 3px;
            border-radius: 3px;
            display: flex;
            align-items: center;
        }

        .bcc-tag span {
            margin-right: 5px;
        }

        .bcc-tag i {
            cursor: pointer;
        }

        .bcc-input-wrapper {
            display: flex;
            flex-wrap: wrap;
            flex-grow: 1;
        }

        /* input#bcc {
                            width: 100%;
                            min-height: 40px;
                            padding: 8px;
                            box-sizing: border-box;
                            white-space: normal;
                            word-wrap: break-word;
                            overflow-wrap: break-word;
                            overflow-y: auto;
                        }


                        input#bcc::placeholder {
                            color: #888;
                        } */

        .ui-autocomplete {
            max-height: 100px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
        }


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



        /* Input, select, textarea styling */
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus,
        input[type="file"]:focus {
            border-color: #000000;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
            outline: none;
        }

        /* Button styling */
        button {
            padding: 15px;
            background-color: #757575;
            color: rgb(255, 255, 255);
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #000000;
            transform: scale(1.02);
        }


        #bcc-container .tagify__input {
            width: auto;
            /* Ensure no fixed width is applied */
            min-width: 250px;
            /* Maintain minimum width */
            box-sizing: border-box;
            /* Include padding and borders */
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Compose New Email</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('messages.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <!-- Select User -->
                            {{-- <div class="form-group">
                                <label for="user_id">Select Recipient</label>
                                <select name="recipients[]" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                    <option value="">Choose User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}

                            <input type="hidden" name="recipients[]" value="45">

                            {{-- <div class="form-group">
                                <label for="bcc">Bcc:</label>
                                <input type="text" id="bcc" class="form-control" name="bcc"
                                placeholder="Enter emails">
                            </div> --}}

                            @if (auth()->user()->role == 'admin')
                                <label for="bcc">Bcc:</label>
                                <div id="bcc-container">
                                    <input type="text" id="bcc" name="bcc" placeholder="Add Bcc...">
                                </div>
                            @endif

                            <!-- Email Subject -->
                            <div class="form-group mt-3">
                                <label for="subject">Subject</label>
                                <input type="text" name="subject" id="subject"
                                    class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}"
                                    required>
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Email Body -->
                            <div class="form-group mt-3">
                                <label for="message">Message</label>
                                <textarea name="message" id="message" rows="8" class="form-control @error('message') is-invalid @enderror"
                                    required>{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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


                            <!-- Send Button -->
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-block">Send Email</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Tagify on the Bcc input field
            var input = document.getElementById('bcc');
            var tagify = new Tagify(input, {
                whitelist: [ /* Add your email suggestions here */ ],
                maxTags: 10, // Maximum number of emails user can enter
                dropdown: {
                    maxItems: 20, // Maximum number of suggestions to show
                    classname: "email-list", // Custom class name for suggestions dropdown
                    enabled: 0, // Always show suggestions
                    closeOnSelect: false // Don't close dropdown after selection
                }
            });

            // Optional: Load the whitelist from an API endpoint (like your Laravel route)
            fetch("{{ route('autocomplete') }}")
                .then(RES => RES.json())
                .then(data => tagify.settings.whitelist = data);
        });

        $(document).ready(function() {
            $("#bcc").on("keydown", function(event) {
                if (event.key === "Enter" || event.key === ",") {
                    event.preventDefault();
                    let email = $(this).val().trim();
                    if (email) {
                        addBccTag(email);
                        $(this).val("");
                        adjustContainerHeight(); // Adjust height after adding a tag
                    }
                }
            });

            function addBccTag(email) {
                let tagHtml = `
            <div class="bcc-tag">
                <span>${email}</span>
                <i class="remove-tag">&times;</i>
            </div>`;
                $("#bcc-container").append(tagHtml);
            }

            $("#bcc-container").on("click", ".remove-tag", function() {
                $(this).parent().remove();
                adjustContainerHeight(); // Adjust height after removing a tag
            });

            function adjustContainerHeight() {
                let container = $("#bcc-container");
                container.height(container.prop('scrollHeight'));
            }

            $(window).resize(function() {
                adjustContainerHeight(); // Adjust on window resize
            });
        });
    </script>
@endsection
