<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/29/2016
 * Time: 1:47 PM
 */
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="3dtfcom">
    <meta name="author" content="3dtf.com">

    <title>Notify</title>

    @yield('shortcutPage')

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

    {{--js all page--}}
    <script type="text/javascript" src="{{ url('public/main/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/form/jquery.form.js')}}"></script>

    <script src="{{ url('public/main/js/main.js')}}"></script>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>3DTF.COM</h1>

            <p class="tf-color-red">
                Sorry, You have not permission to access in this field.
            </p>

            <p>
                to <a class="tf-link tf-text-under" href="{!! route('tf.m.index') !!}">Control panel</a>
            </p>

        </div>
    </div>
</div>
{{--jQuery--}}
{{--<script src="{{ url('public/main/bower_components/jquery/dist/jquery.min.js')}}"></script>--}}

{{--Bootstrap Core JavaScript--}}
<script src="{{ url('public/main/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

{{--Metis Menu Plugin JavaScript--}}
<script src="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

{{--Custom Theme JavaScript--}}
<script src="{{ url('public/main/dist/js/sb-admin-2.js')}}"></script>

{{--DataTables JavaScript--}}
<script src="{{ url('public/main/bower_components/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
</body>

</html>
