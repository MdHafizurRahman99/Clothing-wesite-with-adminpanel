{{-- @extends('layouts.frontend.master')
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
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="company_name" class="form-label">Company Name </label>
                                <input type="text" id="company_name" name="company_name"
                                    class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}"
                                    value="{{ old('company_name') }}" required>
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" id="phone" name="phone"
                                    class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="clothing_type" class="form-label">Type of Clothing <span
                                        class="text-danger">*</span></label>
                                <select id="clothing_type" name="clothing_type"
                                    class="form-control {{ $errors->has('clothing_type') ? 'is-invalid' : '' }}" required>
                                    <option value="">Select an option</option>
                                    <option value="Shirts" {{ old('clothing_type') == 'Shirts' ? 'selected' : '' }}>Shirts
                                    </option>
                                    <option value="Pants" {{ old('clothing_type') == 'Pants' ? 'selected' : '' }}>Pants
                                    </option>
                                    <option value="Dresses" {{ old('clothing_type') == 'Dresses' ? 'selected' : '' }}>
                                        Dresses</option>
                                    <option value="Outerwear" {{ old('clothing_type') == 'Outerwear' ? 'selected' : '' }}>
                                        Outerwear</option>
                                    <option value="Accessories"
                                        {{ old('clothing_type') == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                                    <option value="Other" {{ old('clothing_type') == 'Other' ? 'selected' : '' }}>Other
                                        (please specify)</option>
                                </select>
                                @error('clothing_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="specific_preferences" class="form-label">Specific Preferences </label>
                                <textarea id="specific_preferences" name="specific_preferences"
                                    class="form-control {{ $errors->has('specific_preferences') ? 'is-invalid' : '' }}" rows="3">{{ old('specific_preferences') }}</textarea>
                                @error('specific_preferences')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (!auth()->check())
                                <div class="form-group">
                                    <label for="password" class="form-label"> Password <span class="text-danger">(Not
                                            required if you allready have an account with this email.)</span></label>
                                    <input type="password" id="password" name="password"
                                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                        value="{{ old('password') }}">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span
                                            class="text-danger"></span></label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                        value="{{ old('password_confirmation') }}">

                                </div>
                            @endif
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                    <div id="email-feedback" class="text-danger"></div>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="clothing_type" class="form-label">Type of Clothing <span class="text-danger">*</span></label>
                                    <select id="clothing_type" name="clothing_type[]" multiple class="form-control" required>
                                        <option value="">Select an option</option>
                                        <option value="Shirts">Shirts</option>
                                        <option value="Pants">Pants</option>
                                        <option value="Dresses">Dresses</option>
                                        <option value="Outerwear">Outerwear</option>
                                        <option value="Accessories">Accessories</option>
                                        <option value="Other">Other (please specify)</option>
                                    </select>
                                </div> --}}
                                <div class="form-group">
                                    <label class="form-label">Type of Clothing <span class="text-danger">*</span></label>
                                    <div>
                                        <input type="checkbox" id="shirts" name="clothing_type[]" value="Shirts">
                                        <label for="shirts">Shirts</label><br>
                                        <input type="checkbox" id="pants" name="clothing_type[]" value="Pants">
                                        <label for="pants">Pants</label><br>
                                        <input type="checkbox" id="dresses" name="clothing_type[]" value="Dresses">
                                        <label for="dresses">Dresses</label><br>
                                        <input type="checkbox" id="outerwear" name="clothing_type[]" value="Outerwear">
                                        <label for="outerwear">Outerwear</label><br>
                                        <input type="checkbox" id="accessories" name="clothing_type[]" value="Accessories">
                                        <label for="accessories">Accessories</label><br>
                                        <input type="checkbox" id="other" name="clothing_type[]" value="Other">
                                        <label for="other">Other (please specify)</label><br>
                                    </div>
                                </div>

                                <div id="other_clothing_type_div" class="form-group hidden">
                                    <label for="other_clothing_type" class="form-label">Please specify</label>
                                    <input type="text" id="other_clothing_type" name="other_clothing_type" class="form-control">
                                </div>
                                <div class="form-group" id="password-fields" style="display: none;">
                                    <label for="password" class="form-label">Password <span class="text-danger"> (Please enter password that will to make an account.)</span></label>
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>
                                <div class="form-group" id="password-confirmation-field" style="display: none;">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                </div>
                                <div id="login-message" class="text-danger" style="display: none;">Please log in.</div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" id="company_name" name="company_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="specific_preferences" class="form-label">Specific Preferences</label>
                                    <textarea id="specific_preferences" name="specific_preferences" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
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

@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#email').on('change', function() {
            var email = $(this).val();
            $.ajax({
                url: '{{ route('check.email') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: email
                },
                success: function(response) {
                    if (response.exists) {
                        $('#password-fields').hide();
                        $('#password-confirmation-field').hide();
                        $('#login-message').show();
                    } else {
                        $('#password-fields').show();
                        $('#password-confirmation-field').show();
                        $('#login-message').hide();
                    }
                }
            });
        });
    });
</script>
@endsection
