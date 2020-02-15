<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/29/2016
 * Time: 11:05 AM
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="3dtfcom">
    <meta name="author" content="3dtf.com">
    <title>Notify</title>
    @yield('shortcutPage')
            <!-- Bootstrap Core CSS -->
    <link href="{{ url('public/main/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ url('public/main/dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ url('public/main/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <!-- DataTables CSS -->
    <link href="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ url('public/main/bower_components/datatables-responsive/css/dataTables.responsive.css')}}" rel="stylesheet">

    <!-- css pages-->
    <link href="{{ url('public/main/css/main.css')}}" rel="stylesheet">

    <!-- js all page -->
    <script type="text/javascript" src="{{ url('public/main/js/jquery-1.9.0.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/jquery-ui-1.10.1.custom.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/jquery.form.js')}}"></script>
    <script src="{{ url('public/main/js/main.js')}}"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>3DTF.COM</h1>
                <span class="tf-color-red">
                    Sorry, This information does not exist.
                </span>
                <p>
                    Go to <a class="tf-link-bold tf-text-under" href="{!! route('tf.home') !!}">Home</a>
                </p>
            </div>
        </div>
    </div>
<!-- jQuery -->
<script src="{{ url('public/main/bower_components/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ url('public/main/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ url('public/main/dist/js/sb-admin-2.js')}}"></script>
<!-- DataTables JavaScript -->
<script src="{{ url('public/main/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
</body>

</html>

