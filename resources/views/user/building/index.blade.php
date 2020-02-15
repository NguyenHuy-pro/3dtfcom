<?php
/*
 *
 * $modelUser
 * $dataUser
 * accessObject
 *
 */

?>
@extends('user.index')

@section('titlePage')
    {!! trans('frontend_user.title_page_building') !!}
@endsection

{{--insert js to process  buildings  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-building.js')}}"></script>
@endsection

@section('tf_user_content')
    <div class="panel panel-default tf-border-bot-none">
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#">{!! trans('frontend_user.building_menu_list') !!}</a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            {{--list building--}}
            @include('user.building.building-list',
                [
                    'modelUser' =>$modelUser,
                    'dataUser' => $dataUser
                ])

            {{--extend--}}
            {{--.....--}}
        </div>
    </div>
@endsection