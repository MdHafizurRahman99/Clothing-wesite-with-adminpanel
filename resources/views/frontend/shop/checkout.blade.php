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
    <form action=" {{ route('order.store') }} " method="POST">
        @csrf
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-lg-8">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing
                            Address</span></h5>

                    <div class="bg-light p-30 mb-5">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input class="form-control" name="first_name" type="text" placeholder="John">
                                @error('first_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="last_name" placeholder="Doe">
                                @error('last_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" name="email" type="text" placeholder="example@email.com">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" name="mobile" type="text" placeholder="+123 456 789">
                                @error('mobile')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address</label>
                                <input class="form-control" type="text" name="address" placeholder="123 Street">
                                @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" placeholder="123 Street">
                        </div> --}}
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select class="custom-select" name="country">
                                    <option value="Australia" selected>Australia</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                </select>
                                @error('country')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" name="city" placeholder="Melbourne">
                                @error('city')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" type="text" name="state" placeholder="Melbourne">
                                @error('state')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" type="text" name="zip_code" placeholder="123">
                                @error('zip_code')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- <div class="col-md-12 form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="create_an_account"
                                        value="1" id="create-new-account">
                                    <label class="custom-control-label" for="create-new-account" data-toggle="collapse"
                                        data-target="#create-new-account">Create an account</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="1"
                                        name="ship_to_different_address" id="shipto">
                                    <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                        data-target="#shipping-address">Ship to different address</label>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <div class="collapse mb-5" id="create-new-account">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span
                                class="bg-secondary pr-3">Create
                                New Account</span></h5>
                        <div class="bg-light p-30">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>First Name</label>
                                    <input class="form-control" type="text" placeholder="John">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" type="text" placeholder="Doe">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>E-mail</label>
                                    <input class="form-control" type="text" placeholder="example@email.com">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="text" placeholder="+123 456 789">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="text" placeholder="********">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control" type="text" placeholder="********">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Country</label>
                                    <select class="custom-select">
                                        <option selected>Australia</option>
                                        <option>Afghanistan</option>
                                        <option>Albania</option>
                                        <option>Algeria</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>City</label>
                                    <input class="form-control" type="text" placeholder="Melbourne">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>State</label>
                                    <input class="form-control" type="text" placeholder="Melbourne">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>ZIP Code</label>
                                    <input class="form-control" type="text" placeholder="123">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="collapse mb-5" id="shipping-address">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span
                                class="bg-secondary pr-3">Shipping
                                Address</span></h5>
                        <div class="bg-light p-30">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>First Name</label>
                                    <input class="form-control" name="ship_to_first_name" type="text"
                                        placeholder="John">
                                </div>
                                @error('ship_to_first_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="col-md-6 form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" name="ship_to_last_name" type="text"
                                        placeholder="Doe">
                                </div>
                                @error('ship_to_last_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="col-md-6 form-group">
                                    <label>E-mail</label>
                                    <input class="form-control" name="ship_to_email" type="text"
                                        placeholder="example@email.com">
                                </div>
                                @error('ship_to_email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="col-md-6 form-group">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="text" name="shipto_to_mobile_no"
                                        placeholder="+123 456 789">
                                </div>
                                @error('shipto_to_mobile_no')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="col-md-6 form-group">
                                    <label>Address</label>
                                    <input class="form-control" name="ship_to_address" type="text"
                                        placeholder="123 Street">
                                </div>

                                @error('ship_to_address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="col-md-6 form-group">
                                    <label>Country</label>
                                    <select name="ship_to_country" class="custom-select">
                                        <option selected>Australia</option>
                                        <option>Afghanistan</option>
                                        <option>Albania</option>
                                        <option>Algeria</option>
                                    </select>
                                </div>
                                @error('ship_to_country')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="col-md-6 form-group">
                                    <label>City</label>
                                    <input class="form-control" type="text" name="ship_to_city"
                                        placeholder="Melbourne">
                                </div>
                                @error('ship_to_city')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="col-md-6 form-group">
                                    <label>State</label>
                                    <input class="form-control" type="text" name="ship_to_state"
                                        placeholder="Melbourne">
                                </div>
                                @error('ship_to_state')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="col-md-6 form-group">
                                    <label>ZIP Code</label>
                                    <input class="form-control" type="text" name="ship_to_zip_code"
                                        placeholder="123">
                                </div>
                                @error('ship_to_zip_code')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order
                            Total</span></h5>
                    <div class="bg-light p-30 mb-5">
                        {{-- <div class="border-bottom">
                            <h6 class="mb-3">Products</h6>
                            <div class="d-flex justify-content-between">
                                <p>Product Name 1</p>
                                <p>$150</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Product Name 2</p>
                                <p>$150</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Product Name 3</p>
                                <p>$150</p>
                            </div>
                        </div> --}}
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
                                <input type="text" name="total_price" hidden value=" {{ $total }} ">
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span
                                class="bg-secondary pr-3">Payment</span></h5>
                        <div class="bg-light p-30">
                            {{-- <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" id="paypal">
                                    <label class="custom-control-label" for="paypal">Paypal</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                                    <label class="custom-control-label" for="directcheck">Direct Check</label>
                                </div>
                            </div> --}}
                            <div class="form-group mb-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment"
                                        value="banktransfer" id="banktransfer" checked>
                                    <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
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
