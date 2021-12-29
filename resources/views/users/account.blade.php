@extends('layouts.frontLayout.front_design')
@section('content')

<style>
  .error{
    color: red;
    /* background: pink; */
  }
  label,
  input,
  /* button {
    border: 0;
    margin-bottom: 3px;
    display: block;
    width: 100%;
  } */
 /* .common_box_body {
    padding: 15px;
    border: 12px solid #28BAA2;
    border-color: #28BAA2;
    border-radius: 15px;
    margin-top: 10px;
    background: #d4edda;
} */
</style>

<section id="form" style="margin-top:30px;"><!--form-->
    <div class="container">
        <div class="row">
        <div class="table-responsive cart_info">
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
                </div>
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">
                    <h2>Update Account</h2>
                    <form id="accountForm" name="accountForm" action="{{ url('/account') }}" method="POST">
                    {{ csrf_field() }}
                        <input value ="{{ $userDetails->email }}" readonly="" />
                        <input value ="{{ $userDetails->name }}" id="name" name="name" type="text" placeholder="Name"/>
                        <input value ="{{ $userDetails->address }}" id="address" name="address" type="text" placeholder="Address"/>
                        <input value ="{{ $userDetails->city }}" id="city" name="city" type="text" placeholder="City"/>
                        <input value ="{{ $userDetails->state }}" id="state" name="state" type="text" placeholder="State"/>
                        <select id="country" name="country">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->country_name }}" @if($country->country_name == $userDetails->country) selected @endif>{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        <input value ="{{ $userDetails->pincode }}" style="margin-top:10px;" id="pincode" name="pincode" type="text" placeholder="Pincode"/>
                        <input value ="{{ $userDetails->mobile }}" id="mobile" name="mobile" type="text" placeholder="Mobile"/>

                        <button type="submit" class="btn btn-default">Update</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">
                    <h2>Update Password</h2>
                    <form id="passwordForm" name="passwordForm" action="{{ url('/update-user-pwd') }}" method="POST">
                    {{ csrf_field() }}
                    <input id="current_pwd" name="current_pwd" type="password" placeholder="Current Password"/>
                    <span id="chkPwd"></span>
                    <input id="new_pwd" name="new_pwd" type="password" placeholder="New Password"/>
                    <input id="confirm_pwd" name="confirm_pwd" type="password" placeholder="Confirm Password"/>

                    <button type="submit" class="btn btn-default">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section><!--/form-->

@endsection
