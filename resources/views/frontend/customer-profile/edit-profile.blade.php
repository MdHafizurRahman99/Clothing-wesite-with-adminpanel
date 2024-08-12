@extends('layouts.frontend.master')

@section('css')
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
    <style>
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-header h2 {
            margin: 10px 0 5px;
        }

        .profile-header p {
            margin: 0;
            color: #888;
        }

        .profile-section {
            margin-bottom: 20px;
        }

        .profile-section h3 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
            color: #555;
        }

        .profile-section .form-group {
            margin-bottom: 1rem;
        }

        .edit-link {
            text-align: right;
            margin-bottom: 10px;
        }

        .edit-link a {
            color: #007bff;
            text-decoration: none;
        }

        .edit-link a:hover {
            text-decoration: underline;
        }

        .radio-group {
            display: flex;
            align-items: center;
        }

        .radio-group input {
            margin-right: 5px;
        }

        .radio-group label {
            margin-right: 15px;
        }
    </style>
@endsection


@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Profile</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="{{ route('user-profile.update', ['user_profile' => $user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob', $user->dob) }}">
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gender">Gender</label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', $userProfile->company_name) }}">
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile', $userProfile->mobile) }}">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fax">Fax</label>
                            <input type="text" class="form-control @error('fax') is-invalid @enderror" id="fax" name="fax" value="{{ old('fax', $userProfile->fax) }}">
                            @error('fax')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Address -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Billing Address</h5>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="billing_address1">Street Address 1</label>
                            <input type="text" class="form-control @error('billing_address1') is-invalid @enderror" id="billing_address1" name="billing_address1" value="{{ old('billing_address1', $userProfile->billing_address1) }}">
                            @error('billing_address1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="billing_address2">Street Address 2</label>
                            <input type="text" class="form-control @error('billing_address2') is-invalid @enderror" id="billing_address2" name="billing_address2" value="{{ old('billing_address2', $userProfile->billing_address2) }}">
                            @error('billing_address2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="billing_city">City</label>
                            <input type="text" class="form-control @error('billing_city') is-invalid @enderror" id="billing_city" name="billing_city" value="{{ old('billing_city', $userProfile->billing_city) }}">
                            @error('billing_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="billing_state">State</label>
                            <input type="text" class="form-control @error('billing_state') is-invalid @enderror" id="billing_state" name="billing_state" value="{{ old('billing_state', $userProfile->billing_state) }}">
                            @error('billing_state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="billing_postcode">Postcode</label>
                            <input type="text" class="form-control @error('billing_postcode') is-invalid @enderror" id="billing_postcode" name="billing_postcode" value="{{ old('billing_postcode', $userProfile->billing_postcode) }}">
                            @error('billing_postcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="billing_country">Country</label>
                            <input type="text" class="form-control @error('billing_country') is-invalid @enderror" id="billing_country" name="billing_country" value="{{ old('billing_country', $userProfile->billing_country) }}">
                            @error('billing_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Shipping Address</h5>
                    <label class="form-check-label mx-3">
                        <input type="checkbox" class="form-check-input" id="same_as_billing" name="same_as_billing" value="true" {{ old('same_as_billing', $userProfile->same_as_billing) ? 'checked' : '' }}>
                        Same as Billing Address
                    </label>
                </div>
                <div class="card-body" id="shipping_address_section" style="{{ old('same_as_billing', $userProfile->same_as_billing) ? 'display: none;' : '' }}">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="shipping_address1">Street Address 1</label>
                            <input type="text" class="form-control @error('shipping_address1') is-invalid @enderror" id="shipping_address1" name="shipping_address1" value="{{ old('shipping_address1', $userProfile->shipping_address1) }}">
                            @error('shipping_address1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="shipping_address2">Street Address 2</label>
                            <input type="text" class="form-control @error('shipping_address2') is-invalid @enderror" id="shipping_address2" name="shipping_address2" value="{{ old('shipping_address2', $userProfile->shipping_address2) }}">
                            @error('shipping_address2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="shipping_city">City</label>
                            <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" id="shipping_city" name="shipping_city" value="{{ old('shipping_city', $userProfile->shipping_city) }}">
                            @error('shipping_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="shipping_state">State</label>
                            <input type="text" class="form-control @error('shipping_state') is-invalid @enderror" id="shipping_state" name="shipping_state" value="{{ old('shipping_state', $userProfile->shipping_state) }}">
                            @error('shipping_state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="shipping_postcode">Postcode</label>
                            <input type="text" class="form-control @error('shipping_postcode') is-invalid @enderror" id="shipping_postcode" name="shipping_postcode" value="{{ old('shipping_postcode', $userProfile->shipping_postcode) }}">
                            @error('shipping_postcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="shipping_country">Country</label>
                            <input type="text" class="form-control @error('shipping_country') is-invalid @enderror" id="shipping_country" name="shipping_country" value="{{ old('shipping_country', $userProfile->shipping_country) }}">
                            @error('shipping_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Payment Information</h5>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="primary_payment_method">Primary Payment Method</label>
                            <input type="text" class="form-control @error('primary_payment_method') is-invalid @enderror" id="primary_payment_method" name="primary_payment_method" value="{{ old('primary_payment_method', $userProfile->primary_payment_method) }}">
                            @error('primary_payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <label for="terms">Terms</label>
                            <input type="text" class="form-control @error('terms') is-invalid @enderror" id="terms" name="terms" value="{{ old('terms', $userProfile->terms) }}">
                            @error('terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="discount">Discount</label>
                            <input type="text" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount', $userProfile->discount) }}">
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="customer_type">Customer Type</label>
                            <input type="text" class="form-control @error('customer_type') is-invalid @enderror" id="customer_type" name="customer_type" value="{{ old('customer_type', $userProfile->customer_type) }}">
                            @error('customer_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Profile Picture -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Profile Picture</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" class="form-control-file @error('profile_picture') is-invalid @enderror" id="profile_picture" name="profile_picture">
                        @error('profile_picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <script>
        document.getElementById('same_as_billing').addEventListener('change', function() {
            document.getElementById('shipping_address_section').style.display = this.checked ? 'none' : 'block';
        });
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
@endsection




@section('js')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
