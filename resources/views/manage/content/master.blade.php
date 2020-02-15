<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="3dtfcom">
    <meta name="author" content="3dtfcom">
    <title>@yield('tf_m_c_titlePage')</title>
    <link rel="shortcut icon" href="{!! asset('public/imgtest/0.gif') !!}">
    {{--Bootstrap Core CSS--}}
    <link href="{{ url('public/main/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/dist/css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="{{ url('public/main/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css">
    {{--DataTables CSS--}}
    <link href="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}"
          rel="stylesheet">
    {{--DataTables Responsive CSS--}}
    <link href="{{ url('public/main/bower_components/datatables-responsive/css/dataTables.responsive.css')}}"
          rel="stylesheet">

    {{--3dtf css--}}
    <link href="{{ url('public/main/css/main.css')}}" rel="stylesheet">
    <link href="{{ url('public/manage/content/css/content.css')}}" rel="stylesheet">

    {{--include css per page--}}
    @yield('tf_m_c_css_page')

    <script type="text/javascript" src="{{ url('public/main/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/form/jquery.form.js')}}"></script>

    {{--3dtf js--}}
    <script src="{{ url('public/main/js/main.js')}}"></script>
    <script src="{{ url('public/manage/js/manage.js')}}"></script>
    <script src="{{ url('public/manage/content/js/content.js')}}"></script>

    {{--include js per page on top--}}
    @yield('tf_m_js_page_top')

    {{--ckeditor/ckfinder--}}
    <script type="text/javascript">
        var baseURL = "{!! url('/') !!}";
    </script>
    <script src="{{ url('public/main/js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{ url('public/main/js/ckfinder/ckfinder.js')}}"></script>

    <script src="{{ url('public/main/js/func_ckfinder.js')}}"></script>
</head>
<body style="height: auto;">
{{--load status--}}
<img class="tf_loading_status tf-loading-status tf-zindex-10" src="{!! asset('public/main/icons/loading.gif') !!}">

<div id="tf_m_c_wrapper" class="container-fluid tf-position-rel tf-bg-white tf-zindex-1 tf-height-full">
    {{--Page Content--}}
    <div class="row">
        {{--menu --}}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @yield('tf_m_c_menu')
        </div>

        {{--content body--}}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="min-height: 1000px;">
            @yield('tf_m_c_content')
        </div>
    </div>

</div>

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


{{--include js per page on footer--}}
@yield('tf_m_js_page_footer')

</body>

</html>
