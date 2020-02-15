<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="3dtfcom">
    <meta name="author" content="3dtfcom">
    <title>3dtf</title>
    <link rel="shortcut icon" href="{!! asset('public/imgtest/0.gif') !!}">
    <!-- Bootstrap Core CSS -->
    <link href="{{ url('public/main/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ url('public/main/dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ url('public/main/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css">
    <!-- DataTables CSS -->
    <link href="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}"
          rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ url('public/main/bower_components/datatables-responsive/css/dataTables.responsive.css')}}"
          rel="stylesheet">

    <!-- 3dtf css-->
    <link href="{{ url('public/main/css/main.css')}}" rel="stylesheet">
    <link href="{{ url('public/manage/css/manage.css')}}" rel="stylesheet">
    <!-- end 3dtf css-->

    <script type="text/javascript" src="{{ url('public/main/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/form/jquery.form.js')}}"></script>

    <!-- 3dtf js-->
    <script src="{{ url('public/main/js/main.js')}}"></script>
    <script src="{{ url('public/manage/js/manage.js')}}"></script>
    <!-- end 3dtf js-->

    <script type="text/javascript">
        var baseURL = "{!! url('/') !!}";
    </script>
</head>
<body class="tf-margin-padding-none">
<table id="tf_m_panel" class="table table-bordered tf_m_panel tf-margin-none">
    <tr>
        <td class="tf-color-white col-xs-3 col-sm-3 col-md-3 col-lg-3 ">
            <p>
                <em>Welcome:</em> {!! $dataStaff->lastName !!}
            </p>
            <a class="tf-link-red-bold" href="{!! route('tf.m.logout.get') !!}">
                Logout
            </a>
        </td>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold" href="{!! route('tf.m.c.system') !!}">System info</a>
            <br/>
            <em class="tf-color-green">(System 1,2)</em>
        </td>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold" href="{!! route('tf.m.c.sample') !!}">Sample</a>
            <br/>
            <em class="tf-color-green">(System 1 - Design 1,2)</em>
        </td>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold" href="{!! route('tf.m.c.help') !!}">Help</a>
            <br/>
            <em class="tf-color-green">(System 1,2)</em>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold" href="{!! route('tf.m.c.design') !!}">Playground Design</a>
            <br/>
            <em class="tf-color-green">(System 1 - Design 1,2)</em>
        </td>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold" href="{!! route('tf.m.c.ads') !!}">Ads</a>
            <br/>
            <em class="tf-color-green">(System 1,2 - Business 1,2)</em>
        </td>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold" href="{!! route('tf.m.c.building') !!}">Building info</a>
            <br/>
            <em class="tf-color-green">(System 1 - Build 1,2)</em>
        </td>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold" href="{!! route('tf.m.c.map') !!}">Map info</a>
            <br/>
            <em class="tf-color-green">(System 1 - Build 1,2)</em>
        </td>
    </tr>
    <tr>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold" href="{!! route('tf.m.c.user') !!}">User</a>
            <br/>
            <em class="tf-color-green">(System 1,2)</em>
        </td>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold" href="{!! route('tf.m.build.map') !!}">Build map</a>
            <br/>
            <em class="tf-color-green">(System 1 - Build 1,2)</em>
        </td>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold" href="{!! route('tf.m.c.seller') !!}">Affiliate</a>
            <br/>
            <em class="tf-color-green">(System 1,2 - Business 1,2)</em>
        </td>
        <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="tf-link-white-bold glyphicon glyphicon-plus" href="#"></a>
        </td>
    </tr>
</table>
<!-- jQuery -->
<script src="{{ url('public/main/bower_components/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ url('public/main/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ url('public/main/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ url('public/main/dist/js/sb-admin-2.js')}}"></script>

<!-- DataTables JavaScript -->
<script src="{{ url('public/main/bower_components/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('public/main/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>

</body>


</html>
