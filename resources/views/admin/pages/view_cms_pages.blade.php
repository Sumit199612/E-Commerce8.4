@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">CMS Pages</a> <a href="#" class="current">View CMS Pages</a> </div>
    <h1>CMS Pages</h1>
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
            <h5>View CMS Pages</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Page ID</th>
                  <th>Page Title</th>
                  <th>page Url</th>
                  <th>Page Status</th>
                  <th>Page Created On</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($cmspages as $cmspage)
                <tr class="gradeX">
                  <td>{{ $cmspage->id }}</td>
                  <td>{{ $cmspage->title }}</td>
                  <td>{{ $cmspage->url }}</td>
                  <td>@if($cmspage->status == 1) Active @else Inactive @endif</td>
                  <td>{{ $cmspage->created_at }}</td>
                  <td class="center">
                  <a href="{{ url('/admin/edit-cms-page/'.$cmspage->id) }}" class="btn btn-primary btn-mini" title="Edit Page">Edit</a>
                  <a href="#myModal{{ $cmspage->id }}" data-toggle="modal" class="btn btn-success btn-mini" title="View Page">View</a>
                  <a rel="{{ $cmspage->id }}" rell="delete-cms-page" <?php /*href="{{ url('/admin/delete-cms-page/'.$cmspage->id) }}" */?> href="javascript:" class="btn btn-danger btn-mini deletePage" title="Delete Page">Delete</a></td>
                </tr>
                  <div id="myModal{{ $cmspage->id }}" class="modal hide">
                    <div class="modal-header">
                      <button data-dismiss="modal" class="close" type="button">×</button>
                      <h3>{{ $cmspage->title }} Page Details </h3>
                    </div>
                    <div class="modal-body">
                      <p><strong>Page ID:</strong> {{ $cmspage->id }}</p>
                      <p><strong>Page Title:</strong> {{ $cmspage->title }}</p>
                      <p><strong>Page URL:</strong> {{ $cmspage->url }}</p>
                      <p><strong>Page Description:</strong> {{ $cmspage->description }}</p>
                      <p><strong>Page Status:</strong> @if($cmspage->status == 1) Active @else Inactive @endif</p>
                      <p><strong>Page Created </strong>On: {{ $cmspage->created_at }}</p>
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