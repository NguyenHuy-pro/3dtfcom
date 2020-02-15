<?php
/*
 *
 * $modelUser
 * $dataBuilding
 * $buildingObjectAccess
 *
 *
 */
?>
@extends('user.index')

@section('titlePage')
    user/activity
@endsection

{{--insert js --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-activity.js')}}"></script>
@endsection

@section('tf_user_content')
    <div id="tf_user_activity_wrap" class="col-xs-12 col-sm-12 com-md-12 col-lg-12" style="background-color: #d7d7d7;">
        @include('user.activity.activity.activity-list')
    </div>
@endsection