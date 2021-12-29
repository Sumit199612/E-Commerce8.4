@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">View Products</a> </div>
    <h1>Products</h1>
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
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Products</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Product ID</th>
                  <th>Category ID</th>
                  <th>Category Name</th>
                  <th>Product Name</th>
                  <th>Product Code</th>
                  <th>Product Color</th>
                  <th>Product Price</th>
                  <th>Product Image</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $product)
                <tr class="gradeX">
                  <td>{{ $product->id }}</td>
                  <td>{{ $product->category_id }}</td>
                  <td>{{ $product->category_name }}</td>
                  <td>{{ $product->product_name }}</td>
                  <td>{{ $product->product_code }}</td>
                  <td>{{ $product->product_color }}</td>
                  <td>{{ $product->product_price }}</td>
                  <td>
                    @if(!empty($product->product_image))
                        <img src="{{ asset('/images/backend_images/products/small/'.$product->product_image ) }}" style="width:120px;">
                    @endif
                  </td>
                  <td class="center">
                  <a href="{{ url('/admin/add-attributes/'.$product->id) }}" class="btn btn-success btn-mini" title="Add Attributes">Add</a>
                  <a href="{{ url('/admin/edit-product/'.$product->id) }}" class="btn btn-primary btn-mini" title="Edit Product">Edit</a>
                  <a href="#myModal{{ $product->id }}" data-toggle="modal" class="btn btn-success btn-mini" title="View Product">View</a>
                  <a href="{{ url('/admin/add-images/'.$product->id) }}" class="btn btn-info btn-mini" title="Add Images">Add Image</a>
                  <a rel="{{ $product->id }}" rell="delete-product" <?php /*href="{{ url('/admin/delete-product/'.$product->id) }}" */?> href="javascript:" class="btn btn-danger btn-mini deleteProduct" title="Delete Product">Delete</a></td>
                </tr>
                  <div id="myModal{{ $product->id }}" class="modal hide">
                    <div class="modal-header">
                      <button data-dismiss="modal" class="close" type="button">×</button>
                      <h3>{{ $product->product_name }}</h3>
                    </div>
                    <div class="modal-body">
                      <p>Product ID: {{ $product->id }}</p>
                      <p>Category ID: {{ $product->category_id }}</p>
                      <p>Category Name: {{ $product->category_name }}</p>
                      <p>Product Description: {{ $product->product_description }}</p>
                      <p>Product Code: {{ $product->product_code }}</p>
                      <p>Product Color: {{ $product->product_color }}</p>
                      <p>Product Price: {{ $product->product_price }}</p>
                      <p>Product Image: @if(!empty($product->product_image))
                        <img src="{{ asset('/images/backend_images/products/small/'.$product->product_image ) }}" style="width:150px;"></p>
                      @endif
                    </div>
                  </div>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection