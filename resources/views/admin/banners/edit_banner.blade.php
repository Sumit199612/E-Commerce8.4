@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Banners</a> <a href="#" class="current">Edit Banner</a> </div>
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
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Banner</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/edit-banner/'.$bannerDetails->id ) }}" name="edit_banner" id="edit_banner" novalidate="novalidate">
            {{ csrf_field() }}

            <div class="control-group">
                <label class="control-label">Banner Image</label>
                <div class="controls">
                <div id="uniform-undefined" class="uploader"> 
                  <input type="file" name="banner_image" id="banner_image" size="19" style="opacity: 0;">
                    <span class="filename">No File Selected</span>
                    <span class="action">Choose File</span>
                  </div>
                  @if(!empty($bannerDetails->banner_image))
                  <input type="hidden" name="current_banner_image" value="{{$bannerDetails->banner_image}}"> 
                  @endif
                  @if(!empty($bannerDetails->banner_image))
                  <img style="width:50px;" src="{{ asset('images/frontend_images/banners'.'/'.$bannerDetails->banner_image) }}">
                  <a href="{{ url('/admin/delete-banner-image/'.$bannerDetails->id) }}">Delete</a>
                  @endif
                </div>
            </div>

              <div class="control-group">
                <label class="control-label">Banner Title</label>
                <div class="controls">
                  <input type="text" name="banner_title" id="banner_title" value="{{$bannerDetails->banner_title}}" required>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Banner Link</label>
                <div class="controls">
                  <input type="text" name="banner_link" id="product_code" value="{{$bannerDetails->banner_link}}" required>  
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1" @if($bannerDetails->status=="1") checked @endif>
                </div>
              </div>
              
              <div class="form-actions">
                <input type="submit" value="Edit Banner" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection