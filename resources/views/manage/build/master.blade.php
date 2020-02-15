<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="3dtfcom">
    <meta name="author" content="Vu Quoc Tuan">
    <title>@yield('titlePage')</title>
    @yield('shortcutPage')
    {{-- Bootstrap Core CSS --}}
    <link href="{{ url('public/main/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/dist/css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css">
    <link href="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}"
          rel="stylesheet">
    <link href="{{ url('public/main/bower_components/datatables-responsive/css/dataTables.responsive.css')}}"
          rel="stylesheet">

    {{--=========== 3dtf css =============--}}
    <link href="{{ url('public/main/css/main.css')}}" rel="stylesheet">
    <link href="{{ url('public/manage/build/css/build.css')}}" rel="stylesheet">
    {{--include css per page--}}
    @yield('tf_m_build_css_page')

    {{--offline--}}
    <script type="text/javascript" src="{{ url('public/main/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/form/jquery.form.js')}}"></script>

    {{--online--}}
    {{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>--}}



    {{--3dtf js--}}
    <script type="text/javascript" src="{{ url('public/main/js/main.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/manage/build/js/build.js')}}"></script>

    {{--include js per page on top--}}
    @yield('tf_m_build_js_page_header')


    {{--ckeditor/ckfinder--}}
    <script type="text/javascript" src="{{ url('public/main/js/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/ckfinder/ckfinder.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/func_ckfinder.js')}}"></script>

    <script type="text/javascript">
        var baseURL = "{!! url('/') !!}";
    </script>
</head>

<body>
{{--wrapper--}}
<div id="tf_m_build_wrapper" class="tf-position-rel">
    <img id="tf_m_build_load_status" class="tf-m-build-load-status" src="{!! asset('public/main/icons/loading.gif') !!}">
    {{--header--}}
    @include('manage.build.header')

    {{--page Content--}}
    <div class="container-fluid">
        <div id="tf_m_build_main" class="row tf-m-build-main " style="background-color: brown;">
            @yield('tf_m_build_main_content')
        </div>
    </div>

</div>

{{--Bootstrap Core JavaScript--}}
{{--<script src="{{ url('public/main/bower_components/jquery/dist/jquery.min.js')}}"></script>--}}
<script src="{{ url('public/main/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>
<script src="{{ url('public/main/dist/js/sb-admin-2.js')}}"></script>
<script src="{{ url('public/main/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>

{{--include js per page on footer--}}
@yield('tf_m_build_js_page_footer')

</body>

</html>
