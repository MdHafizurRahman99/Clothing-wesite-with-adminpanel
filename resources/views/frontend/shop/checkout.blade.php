@extends('layouts.frontend.master')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Start -->
    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-lg-8">
                    <div class="bg-light p-30 mb-5">
                        <div class="collapse mb-5" id="create-new-account">
                            <div class="bg-light p-30">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>First Name</label>
                                        <input class="form-control" name="first_name" type="text" placeholder="John"
                                            value="{{ old('first_name') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Last Name</label>
                                        <input class="form-control" name="last_name" type="text" placeholder="Doe"
                                            value="{{ old('last_name') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>E-mail</label>
                                        <input class="form-control" name="email" type="text"
                                            placeholder="example@email.com" value="{{ old('email') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Company Name</label>
                                        <input class="form-control" name="company_name" type="text" placeholder=""
                                            value="{{ old('company_name') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Mobile No</label>
                                        <input class="form-control" name="mobile" type="text" placeholder="+123 456 789"
                                            value="{{ old('mobile') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Password</label>
                                        <input class="form-control" name="password" type="password" placeholder="********">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Confirm Password</label>
                                        <input class="form-control" name="password_confirmation" type="password"
                                            placeholder="********">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Country</label>
                                        <select class="custom-select" name="country">
                                            <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>
                                                Australia</option>
                                            <option value="Albania" {{ old('country') == 'Albania' ? 'selected' : '' }}>
                                                Albania</option>
                                            <option value="Algeria" {{ old('country') == 'Algeria' ? 'selected' : '' }}>
                                                Algeria</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>City</label>
                                        <input class="form-control" name="city" type="text" placeholder="Melbourne"
                                            value="{{ old('city') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>State</label>
                                        <input class="form-control" name="state" type="text" placeholder="Melbourne"
                                            value="{{ old('state') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>ZIP Code</label>
                                        <input class="form-control" name="zip_code" type="text" placeholder="123"
                                            value="{{ old('zip_code') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title position-relative text-uppercase mb-3" style="text-decoration: underline">
                            <span class="bg-secondary pr-3">Billing DETAILS</span>
                        </h5>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input class="form-control" name="first_name" type="text" placeholder="John"
                                    value="{{ old('first_name') }}">
                                @error('first_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" name="last_name" type="text" placeholder="Doe"
                                    value="{{ old('last_name') }}">
                                @error('last_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Company Name</label>
                                <input class="form-control" name="company_name" type="text" placeholder=""
                                    value="{{ old('company_name') }}">
                                @error('company_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" name="email" type="email"
                                    placeholder="example@email.com" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" name="mobile" type="text" placeholder="+123 456 789"
                                    value="{{ old('mobile') }}">
                                @error('mobile')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address</label>
                                <input class="form-control" name="address" type="text" placeholder="123 Street"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select class="custom-select" name="country">
                                    <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>
                                        Australia</option>
                                    <option value="Albania" {{ old('country') == 'Albania' ? 'selected' : '' }}>Albania
                                    </option>
                                    <option value="Algeria" {{ old('country') == 'Algeria' ? 'selected' : '' }}>Algeria
                                    </option>
                                </select>
                                @error('country')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" name="city" type="text" placeholder="Melbourne"
                                    value="{{ old('city') }}">
                                @error('city')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" name="state" type="text" placeholder="Melbourne"
                                    value="{{ old('state') }}">
                                @error('state')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" name="zip_code" type="text" placeholder="123"
                                    value="{{ old('zip_code') }}">
                                @error('zip_code')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-12 pb-2 mt-5">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="1"
                                        name="ship_to_different_address" id="shipto"
                                        {{ old('ship_to_different_address') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                        data-target="#shipping-address" style="text-decoration: underline">Ship to
                                        Different Address</label>
                                </div>
                            </div>

                            <div class="collapse mb-5 {{ old('ship_to_different_address') ? 'show' : '' }}"
                                id="shipping-address">
                                <div class="bg-light p-30">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>First Name</label>
                                            <input class="form-control" name="ship_to_first_name" type="text"
                                                placeholder="John" value="{{ old('ship_to_first_name') }}">
                                            @error('ship_to_first_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Last Name</label>
                                            <input class="form-control" name="ship_to_last_name" type="text"
                                                placeholder="Doe" value="{{ old('ship_to_last_name') }}">
                                            @error('ship_to_last_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Company Name</label>
                                            <input class="form-control" name="ship_to_company_name" type="text"
                                                placeholder="" value="{{ old('ship_to_company_name') }}">
                                            @error('ship_to_company_name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>E-mail</label>
                                            <input class="form-control" name="ship_to_email" type="text"
                                                placeholder="example@email.com" value="{{ old('ship_to_email') }}">
                                            @error('ship_to_email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Mobile No</label>
                                            <input class="form-control" type="text" name="ship_to_mobile_no"
                                                placeholder="+123 456 789" value="{{ old('ship_to_mobile_no') }}">
                                            @error('ship_to_mobile_no')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Address</label>
                                            <input class="form-control" name="ship_to_address" type="text"
                                                placeholder="123 Street" value="{{ old('ship_to_address') }}">
                                            @error('ship_to_address')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Country</label>
                                            <select name="ship_to_country" class="custom-select">
                                                <option value="Australia"
                                                    {{ old('ship_to_country') == 'Australia' ? 'selected' : '' }}>Australia
                                                </option>
                                                <option value="Afghanistan"
                                                    {{ old('ship_to_country') == 'Afghanistan' ? 'selected' : '' }}>
                                                    Afghanistan</option>
                                                <option value="Albania"
                                                    {{ old('ship_to_country') == 'Albania' ? 'selected' : '' }}>Albania
                                                </option>
                                                <option value="Algeria"
                                                    {{ old('ship_to_country') == 'Algeria' ? 'selected' : '' }}>Algeria
                                                </option>
                                            </select>
                                            @error('ship_to_country')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>City</label>
                                            <input class="form-control" type="text" name="ship_to_city"
                                                placeholder="Melbourne" value="{{ old('ship_to_city') }}">
                                            @error('ship_to_city')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>State</label>
                                            <input class="form-control" type="text" name="ship_to_state"
                                                placeholder="Melbourne" value="{{ old('ship_to_state') }}">
                                            @error('ship_to_state')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>ZIP Code</label>
                                            <input class="form-control" type="text" name="ship_to_zip_code"
                                                placeholder="123" value="{{ old('ship_to_zip_code') }}">
                                            @error('ship_to_zip_code')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order
                            Total</span></h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom pt-3 pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>
                                <h6>${{ $totalPrice }}</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Total Discount</h6>
                                @php
                                    $discount = $totalPrice - $discountedPrice;
                                    $total = $discountedPrice + 50;
                                @endphp
                                <h6>${{ $discount }}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">$50</h6>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total</h5>
                                <h5>${{ $total }}</h5>
                                <input type="text" name="total_price" hidden value="{{ $total }}">
                            </div>
                        </div>
                    </div>

                    <form class="mb-30" action="">
                        <div class="input-group p-4 mb-2">
                            <input type="text" class="form-control p-4" placeholder="Coupon Code">
                            <div class="input-group-append">
                                <button class="btn btn-primary">Apply Coupon</button>
                            </div>
                        </div>
                    </form>

                    <div class="mb-5">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span
                                class="bg-secondary pr-3">Payment</span></h5>
                        <div class="bg-light p-30">
                            {{-- <div class="form-group">
                                <label for="card-element">Credit or debit card</label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                            <button type="submit">Submit Payment</button> --}}
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input disabled type="radio" class="custom-control-input" name="payment" id="paypal">
                                    <label class="custom-control-label" for="paypal">Paypal</label>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                                    <label class="custom-control-label" for="directcheck">Direct Check</label>
                                </div>
                            </div> --}}
                            <div class="form-group mb-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment"
                                        value="banktransfer" id="banktransfer" checked>
                                    <label class="custom-control-label" for="banktransfer">Credit or debit card</label>
                                </div>
                            </div>
                            <button class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <!-- Checkout End -->
@endsection

{{-- @section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            form.submit();
        }
    </script>
@endsection --}}
