@extends('layouts.frontLayout.front_design')
@section('content')
<!--slider-->
{{-- <section id="slider">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>
                    
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="images/frontend_images/banners/banner.jpg">
                        </div>
                        <div class="item">
                            <img src="images/frontend_images/banners/banner2.jpg">
                        </div>
                        
                        <div class="item">
                            <img src="images/frontend_images/banners/banner3.jpg">
                        </div>
                        
                    </div>
                    
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</section> --}}
<!--/slider-->
	
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('layouts.frontLayout.front_sidebar')
            </div>
            
            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">{{ $cmsPageDetails->title }}</h2>
                    <p>{{ $cmsPageDetails->description }}</p>
                    {{-- <div align="center">{{ $productsAll->links() }}</div> --}}
                </div><!--features_items-->
            </div>
        </div>
    </div>
</section>
@endsection