<?php
/*
 * $modelUser
 * $dataUser
 * accessObject
 */

?>
@extends('user.index')

@section('titlePage')
    {!! trans('frontend_user.title_page_follow') !!}
@endsection

{{--insert js  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-follow-building.js')}}"></script>
@endsection


@section('tf_user_content')
    <div id="tfUserFollow" class="panel panel-default tf-border-bot-none" >
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#">{!! trans('frontend_user.follow_menu_building') !!}</a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            {{--list building--}}
            @include('user.follow.follow-list',
                [
                    'modelUser' => $modelUser,
                    'dataUser' => $dataUser
                ])
        </div>
    </div>
@endsection