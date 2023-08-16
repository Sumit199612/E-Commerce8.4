<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style>
    .invoice-title h2,
    .invoice-title h3 {
        display: inline-block;
    }

    .table>tbody>tr>.no-line {
        border-top: none;
    }

    .table>thead>tr>.no-line {
        border-bottom: none;
    }

    .table>tbody>tr>.thick-line {
        border-top: 2px solid;
    }

</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>Invoice</h2>
                <h3 class="pull-right">Order # {{ $orderDetails->id }}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Billed To:</strong><br>
                        {{ $userDetails->name }}<br>
                        {{ $userDetails->address }}<br>
                        {{ $userDetails->city }}, {{ $userDetails->state }}<br>
                        {{ $userDetails->country }}<br>
						{{ $userDetails->pincode }}<br>
						{{ $userDetails->mobile }}

                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Shipped To:</strong><br>
                        {{ $orderDetails->name }}<br>
                        {{ $orderDetails->address }}<br>
                        {{ $orderDetails->city }}, {{ $orderDetails->state }}<br>
                        {{ $orderDetails->country }}<br>
						{{ $orderDetails->pincode }}<br>
						{{ $orderDetails->mobile }}
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Payment Method:</strong><br>
                        {{ $orderDetails->payment_method }}
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        {{ $orderDetails->created_at }}<br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
								<tr>
									<th><h6>Product Code</h6></th>
									<th class="text-left"><h6>Name</h6></th>
									<th><h6>Size</h6></th>
									<th><h6>Color</h6></th>
									<th><h6>Price</h6></th>
									<th><h6>Quantity</h6></th>
									<th><h6>Total</h6></th>
								</tr>
							</thead>
                            <tbody>
                                <?php 
									$subtotal = 0; 
									$grand_total = 0;
								?>
								@foreach($orderDetails->orders as $pro)
								<tr>
									<td><h6>{{ $pro->product_code }}</h6></td>
									<td class="text-left"><h6>{{ $pro->product_name }}</h6></td>
									<td><h6>{{ $pro->size }}</h6></td>
									<td><h6>{{ $pro->product_color }}</h6></td>
									<td><h6>{{ $pro->product_price }}</h6></td>
									<td><h6>{{ $pro->quantity }}</h6></td>
									<td><h6>{{ $pro->product_price * $pro->quantity }}</h6></td>
								</tr>
								<?php $subtotal = $subtotal + ($pro->product_price * $pro->quantity) ?>
							@endforeach
                                <tr>
                                    
                                    <td class="thick-line" style="width: 11rem"><strong>Subtotal</strong></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line"></td>
                                    <td class="thick-line">INR {{ $subtotal }}</td>
                                </tr>
                                <tr>
                                    
                                    <td class="no-line" style="width: 11rem"><strong>Shipping Charges (+)</strong></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
									@if(empty($orderDetails->shipping_charges))
                                    	<td class="no-line">INR 0</td>
									@else
										<td class="no-line">INR {{ $orderDetails->shipping_charges }}</td>
									@endif
                                </tr>
								<tr>
                                    
                                    <td class="no-line" style="width: 11rem"><strong>Coupon Discount (-)</strong></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
									@if(empty($orderDetails->coupon_amount))
                                    	<td class="no-line">INR 0</td>
									@else
										<td class="no-line">INR {{ $orderDetails->coupon_amount }}</td>
									@endif
                                </tr>
                                <tr>
                                    
                                    <td class="no-line" style="width: 11rem"><strong>Grand Total</strong></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line">INR {{ $orderDetails->grand_total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
