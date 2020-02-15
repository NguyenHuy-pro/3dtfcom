<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/8/2016
 * Time: 9:08 AM
 */
$hFunction = new Hfunction();
use Illuminate\Support\Facades\Session;
#$modelStaff = new \App\Models\Manage\Content\System\Staff\TfStaff();
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="3dtfcom">
    <meta name="author" content="3dtfcom">
    <title>Login</title>
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

    {{--3dtf css--}}
    <link href="{{ url('public/main/css/main.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{ url('public/main/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{ url('public/main/js/form/jquery.form.js')}}"></script>

    <!-- 3dtf js-->
    <script src="{{ url('public/main/js/main.js')}}"></script>
    <script type="text/javascript">
        var baseURL = "{!! url('/') !!}";
    </script>
</head>
<body style="height: 100%; background-color: grey;">
<div class="container-fluid tf-height-full">
    <div class="row">
        <div class="panel-default tf-padding-none col-md-6 col-md-offset-3 tf-bg-white tf-margin-top-50 tf-border-radius-10">
            <div class="panel-body tf-padding-top-30">
                <form id="frmLogin" name="frmLogin"
                      class="form-horizontal col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1" role="form"
                      method='post' action="{!! route('tf.m.login.post') !!}">
                    @if(Session::has('notifyLoginManage'))
                        <div class="form-group text-center tf-color-red">
                            {!! Session::get('notifyLoginManage') !!}
                            <?php
                            Session:: forget('notifyLoginManage');
                            ?>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="col-lg-3 control-label">
                            Account :
                        </label>

                        <div class="col-lg-9">
                            <input id="txtAccount" class="form-control" name="txtAccount" placeholder="Your account"
                                   onblur="" type="email"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">
                            Password:
                        </label>

                        <div class="col-lg-9">
                            <input id="txtPass" class="form-control" name="txtPass" type="password"
                                   placeholder="Enter password"/>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                        <button class="tf-m-login-a btn btn-primary btn-sm" type="submit">Login</button>
                    </div>
                </form>
            </div>
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

<!-- login JavaScript -->
<script src="{{ url('public/manage/login/js/login.js')}}"></script>
</body>
</html>
