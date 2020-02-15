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

$bannerObject = $dataAccess['bannerObject'];
?>
@extends('user.index')

@section('titlePage')
    {!! trans('frontend_user.title_page_banner') !!}
@endsection

{{--insert js to process ad  banner  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-banner.js')}}"></script>
@endsection


@section('tf_user_content')
    <div class="panel panel-default tf-border-bot-none">
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class=" @if($bannerObject == 'normal') active  @endif">
                    <a class="tf-link" href="{!! route('tf.user.banner.get', $userId) !!}">
                        {!! trans('frontend_user.banner_menu_list') !!}
                    </a>
                </li>
                @if($actionStatus)
                    <li class="@if($bannerObject == 'invited') active  @endif">
                        <a class="tf-link" href="{!! route('tf.user.banner.invited.get') !!}">
                            {!! trans('frontend_user.banner_menu_invited') !!}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="panel-body">
            @if($bannerObject == 'normal')
                {{--list banner--}}
                @include('user.banner.banner.banner-list',
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser
                    ])

            @elseif($bannerObject == 'invited')
                @include('user.banner.invite.invite-list',
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser
                    ])
            @endif

        </div>
    </div>
@endsection