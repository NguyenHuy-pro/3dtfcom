<?php
/*
 * modelUser
 */
$hFunction = new Hfunction();
date_default_timezone_set('Asia/Ho_Chi_Minh');
if ($modelUser->checkLogin()) {
    $loginStatus = 1;
} else {
    $loginStatus = 0;
}

?>
<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/Article">
<head>

    {{--google adsense--}}

    {{--@include('components.google.adsense.adsense')--}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="REFRESH" content="1800"/>

    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="author" content="3dtf">
    <meta name="copyright" content="3dtf"/>
    <meta name="keywords" content="@yield('metaKeyword')"/>
    <meta name="description" content="@yield('metaDescription')"/>

    {{--extend meta object--}}
    @yield('extendMetaPage')

    {{--title page--}}
    <title>
        @yield('titlePage')
    </title>


    @yield('shortcutPage')
    {{--Bootstrap Core CSS--}}
    <link href="{{ url('public/main/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/dist/css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}"
          rel="stylesheet">
    <link href="{{ url('public/main/bower_components/datatables-responsive/css/dataTables.responsive.css')}}"
          rel="stylesheet">

    {{--css all pages--}}
    <link href="{{ url('public/main/css/main.css')}}" rel="stylesheet">
    <link href="{{ url('public/master/css/master.css')}}" rel="stylesheet">

    {{-- ads all page --}}
    <link href="{{ url('public/ads/css/all-page.css')}}" rel="stylesheet">
    {{--include css per page--}}
    @yield('tf_master_page_css')

    {{--offline--}}
    <script type="text/javascript" src="{{ url('public/main/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/jquery-ui/jquery-ui.min.js')}}"></script>


    {{--online--}}
    {{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
    {{--<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>--}}

    <script type="text/javascript" src="{{ url('public/main/js/form/jquery.form.js')}}"></script>

    {{--drag on mobile--}}
    <script type="text/javascript" src="{{ url('public/main/js/touch-ui.js')}}"></script>

    {{--3dtf js--}}
    <script src="{{ url('public/main/js/main.js')}}"></script>
    <script src="{{ url('public/master/js/master.js')}}"></script>

    {{-- ads --}}
    <script src="{{ url('public/ads/js/all-page.js')}}"></script>

    {{--include js per page on top--}}
    @yield('tf_master_page_js_header')

    {{--ckeditor/ckfinder --}}
    <script type="text/javascript">
        //baseURL - config ckeditor
        baseURL = "{!! url('/') !!}";
    </script>
    <script src="{{ url('public/main/js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{ url('public/main/js/ckfinder/ckfinder.js')}}"></script>

    <script type="text/javascript">
        windowHeight = window.innerHeight;
        windowWidth = window.innerWidth;

        $(document).ready(function () {
            tf_main.tf_hide('#tf_main_loading_status');
        });
    </script>
    <script src="{{ url('public/main/js/func_ckfinder.js')}}"></script>

    {{-- google adsence --}}
    {{--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-4036003575293148",
            enable_page_level_ads: true
        });
    </script>--}}
    {{-- end google adsence --}}
</head>

<body id="tf_body" data-log="{!! route('tf.login.status.check') !!}" data-status="{!! $loginStatus !!}"
      data-device="{!! $hFunction->accessDevice() !!}">

{{--google analytics--}}
@include('components.google.analytics.analyticstracking')

{{--wrapper--}}
<div id="tf_main_wrap" class="tf_main_wrap tf-main-wrap">
    {{--container action form or notify when use 'include'--}}
    @yield('tf_main_action')

    {{--load status--}}
    @include('components.loading.loading')

    {{--header--}}
    <div class="row">
        <div id="tf_main_header_wrap" class="tf-main-header-wrap col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {{--active header content--}}
            @include('components.header.header')
        </div>
    </div>

    {{--Main container--}}
    <div class="row">
        <div id="tf_main_content" class="tf-main-content tf-bg-d7 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
            @yield('tf_main_content')
        </div>
    </div>

    {{--footer--}}
    @yield('tf_main_footer')

</div>

{{-- ================= bootstrap ============== --}}

{{--jQuery--}}
{{--<script src="{{ url('public/main/bower_components/jquery/dist/jquery.min.js')}}"></script>--}}

{{--Bootstrap Core JavaScript--}}
<script src="{{ url('public/main/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

{{--Custom Theme JavaScript--}}
<script src="{{ url('public/main/dist/js/sb-admin-2.js')}}"></script>

{{--DataTables JavaScript--}}
<script src="{{ url('public/main/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>

{{--include js per page on top--}}
@yield('tf_master_page_js_footer')

</body>

</html>
