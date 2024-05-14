@extends('layouts.frontend.master')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Didn't find what you wanted? Please Submit This form.</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('custom-order.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Your Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Your Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number (optional)</label>
                            <input type="tel" id="phone" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="clothing_type" class="form-label">Type of Clothing <span class="text-danger">*</span></label>
                            <select id="clothing_type" name="clothing_type" class="form-control {{ $errors->has('clothing_type') ? 'is-invalid' : '' }}" required>
                                <option value="">Select an option</option>
                                <option value="Shirts" {{ old('clothing_type') == 'Shirts' ? 'selected' : '' }}>Shirts</option>
                                <option value="Pants" {{ old('clothing_type') == 'Pants' ? 'selected' : '' }}>Pants</option>
                                <option value="Dresses" {{ old('clothing_type') == 'Dresses' ? 'selected' : '' }}>Dresses</option>
                                <option value="Outerwear" {{ old('clothing_type') == 'Outerwear' ? 'selected' : '' }}>Outerwear</option>
                                <option value="Accessories" {{ old('clothing_type') == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                                <option value="Other" {{ old('clothing_type') == 'Other' ? 'selected' : '' }}>Other (please specify)</option>
                            </select>
                            @error('clothing_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="specific_preferences" class="form-label">Specific Preferences (optional)</label>
                            <textarea id="specific_preferences" name="specific_preferences" class="form-control {{ $errors->has('specific_preferences') ? 'is-invalid' : '' }}" rows="3">{{ old('specific_preferences') }}</textarea>
                            @error('specific_preferences')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
