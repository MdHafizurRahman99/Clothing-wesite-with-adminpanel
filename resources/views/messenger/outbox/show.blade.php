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
     <style>
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
                                <strong>{{ $thread->messages->last()->user->name }}</strong>
                                <span class="text-muted">&lt;{{ $thread->messages->last()->user->email }}&gt;</span>
                                @php
                                    $recepent_email = $thread->messages->last()->participants->last()->user->email;
                                @endphp
                                <div class="text-muted">to <strong>{{ $recepent_email == auth()->user()->email ? 'me' : $recepent_email }}</strong></div>
                            </div>
                        </div>
                        <div class="mt-4">
                            {!! nl2br(e($thread->messages->last()->body)) !!}
                        </div>

                        <div class="gallery">
                            @if(!empty($galleryImages))
                                @foreach($galleryImages as $imageUrl)
                                    <div class="image-container">
                                        <img src="{{ asset($imageUrl->image_url) }}" alt="Uploaded Image" style="max-width: 200px; height: auto;">
                                    </div>
                                @endforeach
                            @else
                                <p>No images have been uploaded yet.</p>
                            @endif
                        </div>

                    </div>
                    <div class="card-footer bg-light d-flex justify-content-end">
                        {{-- <button id="replyButton" class="btn btn-primary mr-2">Reply</button> --}}
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
                            <form action="{{ route('messages.reply', $thread->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="to">To:</label>
                                    <input type="hidden" class="form-control" id="to" name="recipients[]" value="{{ $thread->messages->last()->user->id }}" readonly>
                                    <input type="text" class="form-control" id="to" name="to" value="{{ $thread->messages->last()->user->email }}" readonly>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="cc">Cc:</label>
                                    <input type="text" class="form-control" id="cc" name="cc">
                                </div> --}}
                                <div class="form-group">
                                    <label for="bcc">Bcc:</label>
                                    <input type="text" class="form-control" id="bcc" name="bcc">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message:</label>
                                    <textarea class="form-control" id="message" name="message" rows="4"></textarea>
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
