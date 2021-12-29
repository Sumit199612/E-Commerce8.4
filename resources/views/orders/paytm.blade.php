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
            <h3>Your order is placed Successfully.</h3>
            <p>Your order number is <b>{{Session::get('order_id')}}</b> and total payable amount is INR <b>{{Session::get('grand_total')}}</b></p>
            <p>Please make payment using below Payment Button</p>
            <form action="{{ route('make.payment') }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}

                @if($message = Session::get('message'))
                        <p>{!! $message !!}</p>
                    <?php Session::forget('success'); ?>
                @endif
            <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png" alt="Pay Now">
            <img alt="" src="https://paypalobjects.com/en_US/i/src/pixel.gif" width="1" height="1">

            </form>
        </div>
    </div>
</section>
@endsection

<?php 
Session::forget('grand_total');
Session::forget('order_id');
?>