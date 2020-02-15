<?php
/*
 * modelUser
 * dataUser
 * accessObject
 *
 */
?>
@extends('user.index')

@section('titlePage')
    {!! trans('frontend_user.title_page_ads') !!}
@endsection

{{--insert js to process ads  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-ads.js')}}"></script>
@endsection


@section('tf_user_content')
    <div id="tf_user_ads_wrap" class=" panel panel-default tf-border-bot-none">
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#">
                        {!! trans('frontend_user.ads_menu_list') !!}
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            {{--list land--}}
            @include('user.ads.ads-banner-list',
                [
                    'modelUser' => $modelUser,
                    'dataUser' => $dataUser
                ])
        </div>
    </div>
@endsection