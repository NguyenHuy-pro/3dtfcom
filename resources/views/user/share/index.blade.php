<?php
/*
 *
 * $modelUser
 * $dataUser
 * dataAccess
 *
 */
#user login info
$dataUserLogin = $modelUser->loginUserInfo();

# access user
$userId = $dataUser->userId();
$actionStatus = false;
if (count($dataUserLogin) > 0) {
    # image owner
    if ($dataUserLogin->userId() == $userId) $actionStatus = true;
}

$shareObject = $dataAccess['shareObject'];
?>
@extends('user.index')

@section('titlePage')
    {!! trans('frontend_user.title_page_share') !!}
@endsection

{{--insert js to process shre  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-share.js')}}"></script>
@endsection


@section('tf_user_content')
    <div class="panel panel-default tf-border-bot-none">
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class=" @if($shareObject == 'banner') active  @endif">
                    <a class="tf-link" href="{!! route('tf.user.share.banner.get', $userId) !!}">
                        {!! trans('frontend_user.share_menu_banner') !!}
                        &nbsp;({!! count($dataUser->infoBannerShare($userId)) !!})
                    </a>
                </li>
                <li class="@if($shareObject == 'building') active  @endif">
                    <a class="tf-link" href="{!! route('tf.user.share.building.get', $userId) !!}">
                        {!! trans('frontend_user.share_menu_building') !!}
                        &nbsp;({!! count($dataUser->infoBuildingShare($userId)) !!})
                    </a>
                </li>
                <li class="@if($shareObject == 'land') active  @endif">
                    <a class="tf-link" href="{!! route('tf.user.share.land.get', $userId) !!}">
                        {!! trans('frontend_user.share_menu_land') !!}
                        &nbsp;({!! count($dataUser->infoLandShare($userId)) !!})
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            {{--share banner--}}
            @if($shareObject == 'banner')
                @include('user.share.banner.share-list',
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser
                    ])

            {{--share building--}}
            @elseif($shareObject == 'building')
                @include('user.share.building.share-list',
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser
                    ])
                {{--share building--}}
            @elseif($shareObject == 'land')
                @include('user.share.land.share-list',
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser
                    ])
            @endif

        </div>
    </div>
@endsection