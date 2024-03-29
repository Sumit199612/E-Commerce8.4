<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- @dd($meta_title); --}}
    <title>@if(!empty($meta_title)) {{ $meta_title }} @else Keshri's Fashion @endif</title>
    @if(!empty($meta_description))<meta name="description" content="{{ $meta_description }}"> @endif
    @if(!empty($meta_keywords))<meta name="keywords" content="{{ $meta_keywords }}"> @endif
    <link rel="icon" type="image/x-icon" width="100%" height="100%" href="/images/backend_images/Logo2.png" />

    <!-- Google Task Manager GTM -->
        <!-- Google Tag Manager -->
            {{-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-WG4LV82');</script> --}}
        <!-- End Google Tag Manager -->
    <!-- End Google Task Manager GTM -->


    <link href="{{ asset('css/frontend_css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/passtrength.css') }}" rel="stylesheet">
    <!--<link href="{{ asset('css/frontend_css/easyzoom.css') }}" rel="stylesheet">-->


    <!--[if lt IE 9]>
    <script src="{{ asset('js/frontend_js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/frontend_js/respond.min.js') }}"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{ asset('images/frontend_images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/frontend_images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/frontend_images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/frontend_images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/frontend_images/ico/apple-touch-icon-57-precomposed.png') }}">
</head><!--/head-->

<body>

    @include('layouts.frontLayout.front_header')

	@yield('content')

	@include('layouts.frontLayout.front_footer')


    <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WG4LV82"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <script src="{{ asset('js/frontend_js/jquery.js') }}"></script>
	<script src="{{ asset('js/frontend_js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/frontend_js/jquery.scrollUp.min.js') }}"></script>
	<script src="{{ asset('js/frontend_js/price-range.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.prettyPhoto.js') }}"></script>
    <!-- <script src="{{ asset('js/frontend_js/ajax.js') }}"></script> -->
    <!--<script src="{{ asset('js/frontend_js/easyzoom.js') }}"></script>-->
    <script src="{{ asset('js/frontend_js/main.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/frontend_js/passtrength.js') }}"></script>
</body>
</html>
