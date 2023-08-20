@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Cms Pages</a> <a href="#" class="current">Edit CMS Page</a> </div>
    <h1>Cms Pages</h1>
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
            <h5>Edit CMS Page</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/edit-cms-page/'.$csmPageDetails->id ) }}" name="edit_product" id="edit_product" novalidate="novalidate">
            {{ csrf_field() }}

              <div class="control-group">
                <label class="control-label">Title</label>
                <div class="controls">
                  <input type="text" name="title" id="title" value="{{$csmPageDetails->title}}">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Url</label>
                <div class="controls">
                  <input type="text" name="url" id="url" value="{{$csmPageDetails->url}}">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea name="description" id="description" >{{$csmPageDetails->description}}</textarea>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Meta Title</label>
                <div class="controls">
                  <textarea name="meta_title" id="meta_title">{{ $csmPageDetails->meta_title }}</textarea>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Meta Description</label>
                <div class="controls">
                  <textarea name="meta_description" id="meta_description">{{ $csmPageDetails->meta_description }}</textarea>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Meta Keywords</label>
                <div class="controls">
                  <textarea name="meta_keywords" id="meta_keywords">{{ $csmPageDetails->meta_keywords }}</textarea>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" @if($csmPageDetails->status=="1") checked @endif value="1">
                </div>
              </div>

              <div class="form-actions">
                <input type="submit" value="Edit CMS Page" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection