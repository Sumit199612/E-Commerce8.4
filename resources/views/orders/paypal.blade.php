@extends('layouts.frontLayout.front_design')
@section('content')
<?php use App\Models\Order;?>
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Thanks</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="heading" align="center">
            <h3>Your order has been placed Successfully.</h3>
            <p>Your order number is <b>{{Session::get('order_id')}}</b> and total payable amount is INR <b>{{Session::get('grand_total')}}</b></p>
            <p>Please make payment by clicking on below Pay Now button. </p>
            <?php
$orderDetails = Order::getOrderDetails(Session::get('order_id'));
$orderDetails = json_decode(json_encode($orderDetails));
// echo "<pre>"; print_r($orderDetails); die;
$nameArr = explode(' ', $orderDetails->name);
$getCountryCode = Order::getCountryCode($orderDetails->country);
?>
            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="business" value="keshrisumit441.sk@gmail.com">
                <input type="hidden" name="item_name" value="{{Session::get('order_id')}}">
                <input type="hidden" name="currency_code" value="INR">
                <input type="hidden" name="amount" value="{{Session::get('grand_total')}}">
                <input type="hidden" name="first_name" value="{{ $nameArr[0] }}">
                <input type="hidden" name="last_name" value="{{ $nameArr[1] }}">
                <input type="hidden" name="address1" value="{{ $orderDetails->address }}">
                <input type="hidden" name="city" value="{{ $orderDetails->city }}">
                <input type="hidden" name="state" value="{{ $orderDetails->state }}">
                <input type="hidden" name="zip" value="{{ $orderDetails->pincode }}">
                <input type="hidden" name="country" value="{{ $getCountryCode->country_code }}">
                <input type="hidden" name="email" value="{{ $orderDetails->user_email }}">
                <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png" alt="Pay Now">
                <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>
    </div>
</section>
@endsection

<?php
// Session::forget('grand_total');
// Session::forget('order_id');
?>