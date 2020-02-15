<?php
/*
 * $modelUser
 * $dataUser
 * $dataAccess
 *
 *
 */

$dataUserLogin = $modelUser->loginUserInfo();
# user info access
$userAccessId = $dataUser->userId();

# login info
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
} else {
    $loginStatus = false;
}

$imageObject = $dataAccess['imageObject']
?>
@extends('user.index')

@section('titlePage')
    {!! trans('frontend_user.title_page_image') !!}
@endsection

{{--insert js to process image  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-image.js')}}"></script>
@endsection


@section('tf_user_content')
    <div id="tfUserImage" class="panel panel-default tf-border-none tf-bg-white" data-user="{!! $userAccessId !!}">
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class="@if($imageObject == 'all') active  @endif">
                    <a href="{!! route('tf.user.image.get') !!}">
                        {!! trans('frontend_user.image_menu_all') !!}
                    </a>
                </li>
                <li class="@if($imageObject == 'avatar') active  @endif">
                    <a href="{!! route('tf.user.image.avatar.get', $userAccessId) !!}">
                        {!! trans('frontend_user.image_menu_avatar') !!}
                    </a>
                </li>
                <li class="@if($imageObject == 'banner') active  @endif">
                    <a href="{!! route('tf.user.image.banner.get', $userAccessId) !!}">
                        {!! trans('frontend_user.image_menu_banner') !!}
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            @if($imageObject == 'all')
                @include('user.image.image.image-list',
                    [
                        'modelUser'=>$modelUser,
                        'dataUser' => $dataUser
                    ])
            @elseif($imageObject == 'avatar')
                @include('user.image.avatar.avatar-list',
                    [
                        'modelUser'=>$modelUser,
                        'dataUser' => $dataUser
                    ])
            @elseif($imageObject == 'banner')
                @include('user.image.banner.banner-list',
                    [
                        'modelUser'=>$modelUser,
                        'dataUser' => $dataUser
                    ])
            @endif
        </div>
    </div>
@endsection