@extends('layouts.frontLayout.front_design')
@section('content')

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
            <h3>Your COD order is placed Successfully.</h3>
            <p>Your order number is <b>{{Session::get('order_id')}}</b> and total payable amount is INR <b>{{Session::get('grand_total')}}</b></p>
        </div>
    </div>
</section>
@endsection

<?php 
Session::forget('grand_total');
Session::forget('order_id');
?>