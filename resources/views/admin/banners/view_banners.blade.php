@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Banners</a> <a href="#" class="current">View Banners</a> </div>
    <h1>Banners</h1>
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
            <h5>View Banners</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Banner ID</th>
                  <th>Banner Title</th>
                  <th>Banner Link</th>
                  <th>Banner Status</th>
                  <th>Banner Image</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($banners as $banner)
                <tr class="gradeX">
                  <td>{{ $banner->id }}</td>
                  <td>{{ $banner->banner_title }}</td>
                  <td>{{ $banner->banner_link }}</td>
                  <td>
                    @if($banner->status=="1") Active @else Closed @endif
                  </td>
                  <td>
                    @if(!empty($banner->banner_image))
                        <img src="{{ asset('images/frontend_images/banners/'.'/'.$banner->banner_image ) }}" style="width:150px; height:120px">
                    @endif
                  </td>
                  <td class="center">
                  <a href="{{ url('/admin/edit-banner/'.$banner->id) }}" class="btn btn-primary btn-mini" title="Edit Banner">Edit</a>
                  <a href="#myModal{{ $banner->id }}" data-toggle="modal" class="btn btn-success btn-mini" title="View Banner">View</a>
                  <a rel="{{ $banner->id }}" rell="delete-banner" <?php /*href="{{ url('/admin/delete-banner/'.$banner->id) }}" */?> href="javascript:" class="btn btn-danger btn-mini deleteBanner" title="Delete Banner">Delete</a></td>
                </tr>
                  <div id="myModal{{ $banner->id }}" class="modal hide">
                    <div class="modal-header">
                      <button data-dismiss="modal" class="close" type="button">×</button>
                      <h3>{{ $banner->banner_title }}</h3>
                    </div>
                    <div class="modal-body">
                      <p>Banner ID: {{ $banner->id }}</p>
                      <p>Banner Title: {{ $banner->banner_title }}</p>
                      <p>Banner Link: {{ $banner->banner_link }}</p>
                      <p>Banner Image: @if(!empty($banner->banner_image))
                      <img src="{{ asset('images/frontend_images/banners/'.'/'.$banner->banner_image ) }}" style="width:150px;"></p>
                      <p>Banner Status: {{ $banner->status }}</p>
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