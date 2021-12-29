@extends('layouts.frontLayout.front_design')
@section('content')

<section id="form" style="margin-top:30px;"><!--form-->
    <div class="container">
        <form action="{{ url('/checkout') }}" method="post">
            {{ csrf_field() }}
                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li class="active">Checkout</li>
                    </ol>
                </div>
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-1">
                        <div class="login-form"><!--login form-->
                            <h2>Bill To</h2> 
                            <div class="form-group">
                                <input name="billing_name" id="billing_name" @if(!empty($userDetails->name)) value="{{ $userDetails->name }}" @endif type="text" class="form-control" placeholder="Billing Name" />
                            </div>
                            <div class="form-group">
                                <input name="billing_address" id="billing_address" @if(!empty($userDetails->address)) value ="{{ $userDetails->address }}" @endif type="text" class="form-control" placeholder="Billing Address" />
                            </div>
                            <div class="form-group">
                                <input name="billing_city" id="billing_city" @if(!empty($userDetails->city)) value="{{ $userDetails->city }}" @endif type="text" class="form-control" placeholder="Billing City" />
                            </div>
                            <div class="form-group">
                                <input name="billing_state" id="billing_state" @if(!empty($userDetails->state)) value="{{ $userDetails->state }}" @endif type="text" class="form-control" placeholder="Billing State" />
                            </div>
                            <div class="form-group">
                                <select id="billing_country" name="billing_country" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->country_name }}" @if(!empty($userDetails->country) && $country->country_name == $userDetails->country) selected @endif>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input name="billing_pincode" id="billing_pincode" @if(!empty($userDetails->pincode)) value="{{ $userDetails->pincode }}" @endif type="text" class="form-control" placeholder="Billing Pincode" />
                            </div>
                            <div class="form-group">
                                <input name="billing_mobile" id="billing_mobile" @if(!empty($userDetails->mobile)) value="{{ $userDetails->mobile }}" @endif type="text" class="form-control" placeholder="Billing Mobile" />
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="billtoship">
                                <label class="form-check-label" for="billtoship">Shipping Address same as Billing Address</label>
                            </div>
                        </div><!--/login form-->
                    </div>
                    <div class="col-sm-1">
                        <h2></h2>
                    </div>
                        <div class="col-sm-4">
                            <div class="signup-form"><!--sign up form-->
                                <h2>Ship To</h2>
                                <div class="form-group">
                                    <input name="shipping_name" id="shipping_name" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->name }}" @endif type="text" class="form-control" placeholder="Shipping Name" />
                                </div>
                                <div class="form-group">
                                    <input name="shipping_address" id="shipping_address" @if(!empty($shippingDetails->address)) value="{{ $shippingDetails->address }}" @endif type="text" class="form-control" placeholder="Shipping Address" />
                                </div>
                                <div class="form-group">
                                    <input name="shipping_city" id="shipping_city" @if(!empty($shippingDetails->city)) value="{{ $shippingDetails->city }}" @endif type="text" class="form-control" placeholder="Shipping City" />
                                </div>
                                <div class="form-group">
                                    <input name="shipping_state" id="shipping_state" @if(!empty($shippingDetails->state)) value="{{ $shippingDetails->state }}" @endif type="text" class="form-control" placeholder="Shipping State" />
                                </div>
                                <div class="form-group">
                                    <select id="shipping_country" name="shipping_country" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->country_name }}" @if(!empty($shippingDetails->country) && $country->country_name == $shippingDetails->country) selected @endif>{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input name="shipping_pincode" id="shipping_pincode" @if(!empty($shippingDetails->pincode)) value="{{ $shippingDetails->pincode }}" @endif type="text" class="form-control" placeholder="Shipping Pincode" />
                                </div>
                                <div class="form-group">
                                    <input name="shipping_mobile" id="shipping_mobile" @if(!empty($shippingDetails->mobile)) value="{{ $shippingDetails->mobile }}" @endif type="text" class="form-control" placeholder="Shipping Mobile" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Checkout</button>
                                </div>
                            </div><!--/sign up form-->
                        </div>

                    
                </div>
        </form>
    </div>
</section><!--/form-->

@endsection