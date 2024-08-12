@extends('layouts.frontend.master')

@section('css')
<style>
    :root {
        --primary-color: #007bff;
        --secondary-color: #6c757d;
        --background-color: #f8f9fa;
    }

    body {
        background-color: var(--background-color);
    }

    .container {
        max-width: 1000px;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .profile-header img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 4px solid white;
        object-fit: cover;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .profile-header h2 {
        color: white;
        margin: 1rem 0 0.5rem;
        font-size: 2rem;
    }

    .profile-header p {
        margin: 0;
        opacity: 0.8;
    }

    .edit-button {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    .profile-section {
        background-color: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .profile-section h3 {
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        color: var(--primary-color);
        display: flex;
        align-items: center;
    }

    .profile-section h3 i {
        margin-right: 0.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-control:disabled {
        background-color: #f8f9fa;
        opacity: 0.8;
        cursor: not-allowed;
    }

    .radio-group {
        display: flex;
        align-items: center;
    }

    .radio-group input {
        margin-right: 0.5rem;
    }

    .radio-group label {
        margin-right: 1rem;
    }

    @media (min-width: 768px) {
        .profile-section .row {
            display: flex;
            flex-wrap: wrap;
        }

        .profile-section .col-sm-3 {
            flex: 0 0 30%;
            max-width: 30%;
        }

        .profile-section .col-sm-9 {
            flex: 0 0 70%;
            max-width: 70%;
        }
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="profile-header position-relative">
        <img src="{{ asset($userData->profile_picture) }}" alt="Profile Picture" class="mb-3">
        <h2>{{ $userData->name }}</h2>
        <p>{{ $userData->email }}</p>
        <a href="{{ route('user-profile.edit', ['user_profile' => $userData->id]) }}" class="btn btn-light edit-button">
            <i class="fas fa-edit"></i> Edit Profile
        </a>
    </div>

    <div class="profile-section">
        <h3><i class="fas fa-user"></i> Personal Information</h3>
        <form>
            <div class="form-group row">
                <label for="fullName" class="col-sm-3 col-form-label">Name:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="fullName" value="{{ $userData->name }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="dob" class="col-sm-3 col-form-label">Date Of Birth:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="dob" value="{{ $userData->dob }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Gender:</label>
                <div class="col-sm-9 radio-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="Male" {{ $userData->gender == 'Male' ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="Female" {{ $userData->gender == 'Female' ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label">Phone Number:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="phone" value="{{ $userData->phone }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="companyName" class="col-sm-3 col-form-label">Company Name:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="companyName" value="{{ $userProfile->company_name }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="mobile" class="col-sm-3 col-form-label">Mobile:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="mobile" value="{{ $userProfile->mobile }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="fax" class="col-sm-3 col-form-label">Fax:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="fax" value="{{ $userProfile->fax }}" disabled>
                </div>
            </div>
        </form>
    </div>

    <div class="profile-section">
        <h3><i class="fas fa-map-marker-alt"></i> Billing Address</h3>
        <form>
            <div class="form-group row">
                <label for="billingAddress1" class="col-sm-3 col-form-label">Street Address 1:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="billingAddress1" value="{{ $userProfile->billing_address1 }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="billingAddress2" class="col-sm-3 col-form-label">Street Address 2:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="billingAddress2" value="{{ $userProfile->billing_address2 }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="billingCity" class="col-sm-3 col-form-label">City:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="billingCity" value="{{ $userProfile->billing_city }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="billingState" class="col-sm-3 col-form-label">State:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="billingState" value="{{ $userProfile->billing_state }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="billingPostcode" class="col-sm-3 col-form-label">Postcode:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="billingPostcode" value="{{ $userProfile->billing_postcode }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="billingCountry" class="col-sm-3 col-form-label">Country:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="billingCountry" value="{{ $userProfile->billing_country }}" disabled>
                </div>
            </div>
        </form>
    </div>

    @if (!$userProfile->same_as_billing)
        <div class="profile-section">
            <h3><i class="fas fa-truck"></i> Shipping Address</h3>
            <form>
                <div class="form-group row">
                    <label for="shippingAddress1" class="col-sm-3 col-form-label">Street Address 1:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="shippingAddress1" value="{{ $userProfile->shipping_address1 }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="shippingAddress2" class="col-sm-3 col-form-label">Street Address 2:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="shippingAddress2" value="{{ $userProfile->shipping_address2 }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="shippingCity" class="col-sm-3 col-form-label">City:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="shippingCity" value="{{ $userProfile->shipping_city }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="shippingState" class="col-sm-3 col-form-label">State:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="shippingState" value="{{ $userProfile->shipping_state }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="shippingPostcode" class="col-sm-3 col-form-label">Postcode:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="shippingPostcode" value="{{ $userProfile->shipping_postcode }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="shippingCountry" class="col-sm-3 col-form-label">Country:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="shippingCountry" value="{{ $userProfile->shipping_country }}" disabled>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <div class="profile-section">
        <h3><i class="fas fa-credit-card"></i> Payment Information</h3>
        <form>
            <div class="form-group row">
                <label for="primaryPaymentMethod" class="col-sm-3 col-form-label">Primary Payment Method:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="primaryPaymentMethod" value="{{ $userProfile->primary_payment_method }}" disabled>
                </div>
            </div>
            {{-- <div class="form-group row">
                <label for="terms" class="col-sm-3 col-form-label">Terms:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="terms" value="{{ $userProfile->terms }}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label for="discount" class="col-sm-3 col-form-label">Discount:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="discount" value="{{ $userProfile->discount }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="customerType" class="col-sm-3 col-form-label">Customer Type:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="customerType" value="{{ $userProfile->customer_type }}" disabled>
                </div>
            </div> --}}
        </form>
    </div>
</div>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

@endsection
