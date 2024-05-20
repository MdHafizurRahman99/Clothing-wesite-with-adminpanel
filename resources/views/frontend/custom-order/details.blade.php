@extends('layouts.frontend.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Order Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="form-label fw-bold">Name :</label>
                            <span class="text-muted ms-2">{{ $order->name }}</span>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-label fw-bold">Company Name:</label>
                            <span class="text-muted ms-2">{{ $order->company_name }}</span>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label fw-bold">Email :</label>
                            <span class="text-muted ms-2">{{ $order->email }}</span>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label fw-bold">Phone Number :</label>
                            <span class="text-muted ms-2">{{ $order->phone }}</span>
                        </div>
                        <div class="form-group">
                            <label for="clothing_type" class="form-label fw-bold">Type of Clothing :</label>
                            <span class="text-muted ms-2">{{ $order->clothing_type }}</span>
                        </div>
                        <div class="form-group">
                            <label for="specific_preferences" class="form-label fw-bold">Specific Preferences</label>
                            <textarea id="specific_preferences" name="specific_preferences" class="form-control {{ $errors->has('specific_preferences') ? 'is-invalid' : '' }}" rows="3" disabled>{{ $order->specific_preferences }}</textarea>
                        </div>
                        <div class="text-center mt-4">
                            <button onclick="goBack()" class="btn btn-primary btn-lg px-5">Go Back</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @section('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(to right, #0d6efd, #6c757d);
        }
    </style>
@endsection --}}

@section('js')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
