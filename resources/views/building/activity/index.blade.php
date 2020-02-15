<?php
/*
 *
 * $modelUser
 * $dataBuilding
 * $buildingObjectAccess
 *
 *
 */


# info of user login
$dataUserLogin = $modelUser->loginUserInfo();
?>
@extends('building.index')
@section('extendMetaPage')
    {{--share on facebook--}}
@endsection

{{--css--}}
@section('tf_building_css')
    <link href="{{ url('public/building/css/building-activity.css')}}" rel="stylesheet">
@endsection

{{--js--}}
@section('tf_building_header_js')
    <script src="{{ url('public/building/js/building-activity.js')}}"></script>
@endsection

{{--content post--}}
@section('tf_building_content')
    <div class="row">
        <div id="tf_building_activity_index" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @yield('tf_building_activity_content')
        </div>
    </div>
@endsection