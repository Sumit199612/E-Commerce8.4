@extends('layouts.adminLayout.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Orders</a> </div>
    <h1>Order #{{ $orderDetails->id }}</h1>
    @if ($message = Session::get('error'))
            <div class="alert alert-error alert-block">
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
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span6">
      <div class="widget-box">
          <div class="widget-title">
            <h5>Order Details</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <td class="taskDesc"></i> <h6>Order Date</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->created_at }}</h6></span></td>
                </tr>
                <tr>
                  <td class="taskDesc"></i> <h6>Order Status</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->order_status }}</h6></span></td>
                </tr>
                <tr>
                  <td class="taskDesc"></i> <h6>Shipping Charges</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->shipping_charges }}</h6></span></td>
                </tr>
                <tr>
                  <td class="taskDesc"></i> <h6>Coupon Code</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->coupon_code }}</h6></span></td>
                </tr>
                <tr>
                  <td class="taskDesc"></i> <h6>Coupon Amount</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->coupon_amount }}</h6></span></td>
                </tr>
                <tr>
                  <td class="taskDesc"></i> <h6>Payment Method</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->payment_method }}</h6></span></td>
                </tr>
                <tr>
                  <td class="taskDesc"></i> <h6>Order Total Amount</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->grand_total }}</h6></span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="accordion" id="collapse-group">
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title">
                <h5>Billing Address</h5>
              </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td class="taskDesc"></i> <h6>Name :</h6></td>
                            <td class="taskStatus"><h6>{{ $userDetails->name }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>Address :</h6></td>
                            <td class="taskStatus"><h6>{{ $userDetails->address }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>City    :</h6></td>
                            <td class="taskStatus"><h6>{{ $userDetails->city }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>State   :</h6></td>
                            <td class="taskStatus"><h6>{{ $userDetails->state }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>Country :</h6></td>
                            <td class="taskStatus"><h6>{{ $userDetails->country }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>Pincode :</h6></td>
                            <td class="taskStatus"><h6>{{ $userDetails->pincode }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>Mobile No.  :</h6></td>
                            <td class="taskStatus"><h6>{{ $userDetails->mobile }}</h6></span></td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="span6">
      <div class="widget-box">
          <div class="widget-title">
            <h5>Customer Details</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <td class="taskDesc"></i> <h6>Customer Name</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->name }}</h6></span></td>
                </tr>
                <tr>
                  <td class="taskDesc"></i> <h6>Customer Email</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->user_email }}</h6></span></td>
                </tr>
                <tr>
                  <td class="taskDesc"></i> <h6>Customer Mobile No.</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->mobile }}</h6></span></td>
                </tr>
                <tr>
                  <td class="taskDesc"></i> <h6>Customer Address</h6></td>
                  <td class="taskStatus"><h6>{{ $orderDetails->address }}</h6></span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="accordion" id="collapse-group">
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title">
                <h5>Update Order Status</h5>
              </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content">
                  <form action="{{ url('admin/update-order-status') }}" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" name="order_id" value="{{ $orderDetails->id }}">
                      <table class="table table-striped table-bordered">
                            <tr>
                                <td>
                                    <select name="order_status" id="order_status" class="control-label" required="">
                                        <option value="" selected="">Select</option>
                                        <option value="New" @if($orderDetails->order_status=="New") selected @endif>New</option>
                                        <option value="Pending" @if($orderDetails->order_status=="Pending") selected @endif>Pending</option>
                                        <option value="Cancelled" @if($orderDetails->order_status=="Cancelled") selected @endif>Cancelled</option>
                                        <option value="In Progress" @if($orderDetails->order_status=="In Progress") selected @endif>In Progress</option>
                                        <option value="Shipped" @if($orderDetails->order_status=="Shipped") selected @endif>Shipped</option>
                                        <option value="Delivered" @if($orderDetails->order_status=="Delivered") selected @endif>Delivered</option>
                                        <option value="Paid" @if($orderDetails->order_status=="Paid") selected @endif>Paid</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="submit" value="update" class="btn btn-success">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
          </div>
        </div>
        <div class="accordion" id="collapse-group">
          <div class="accordion-group widget-box">
            <div class="accordion-heading">
              <div class="widget-title">
                <h5>Shipping Address</h5>
              </div>
            </div>
            <div class="collapse in accordion-body" id="collapseGOne">
              <div class="widget-content">
              <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td class="taskDesc"></i> <h6>Name :</h6></td>
                            <td class="taskStatus"><h6>{{ $orderDetails->name }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>Address :</h6></td>
                            <td class="taskStatus"><h6>{{ $orderDetails->address }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>City    :</h6></td>
                            <td class="taskStatus"><h6>{{ $orderDetails->city }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>State   :</h6></td>
                            <td class="taskStatus"><h6>{{ $orderDetails->state }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>Country :</h6></td>
                            <td class="taskStatus"><h6>{{ $orderDetails->country }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>Pincode :</h6></td>
                            <td class="taskStatus"><h6>{{ $orderDetails->pincode }}</h6></span></td>
                        </tr>
                        <tr>
                            <td class="taskDesc"></i> <h6>Mobile No.  :</h6></td>
                            <td class="taskStatus"><h6>{{ $orderDetails->mobile }}</h6></span></td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <h5>Product Details</h5>
            </div>
            <div class="widget-content nopadding">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th><h6>Product Code</h6></th>
                            <th><h6>Product Name</h6></th>
                            <th><h6>Product Size</h6></th>
                            <th><h6>Product Color</h6></th>
                            <th><h6>Product Price</h6></th>
                            <th><h6>Product Quantity</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orderDetails->orders as $pro)
                        <tr>
                            <td><h6>{{ $pro->product_code }}</h6></td>
                            <td><h6>{{ $pro->product_name }}</h6></td>
                            <td><h6>{{ $pro->size }}</h6></td>
                            <td><h6>{{ $pro->product_color }}</h6></td>
                            <td><h6>{{ $pro->product_price }}</h6></td>
                            <td><h6>{{ $pro->quantity }}</h6></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>
<!--main-container-part-->

@endsection
