<?php
/*
 *
 * $modelUser
 * modelBuilding
 * dataBuilding
 * dataBuildingAccess
 *
 */
# info of user login
$mobileDetect = new Mobile_Detect();
$dataUserLogin = $modelUser->loginUserInfo();
?>
@extends('building.index')

@section('extendMetaPage')
    {{-- develop later --}}
@endsection

{{--css--}}
@section('tf_building_css')
    <link href="{{ url('public/building/css/building-service.css')}}" rel="stylesheet">
@endsection


{{--js--}}
@section('tf_building_header_js')
    <script src="{{ url('public/building/js/building-service.js')}}"></script>
@endsection

{{--menu--}}
@section('tf_building_menu')
    @include('building.components.menu.menu',
        [
            'modelUser'=>$modelUser,
            'dataBuildingAccess'=>$dataBuildingAccess,
        ])
@endsection

@section('tf_building_content')
    <div id="tf_building_services_index" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @yield('tf_building_service_content')
    </div>
@endsection