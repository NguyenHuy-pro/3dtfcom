<?php
/*
 * $modelUser
 * $dataUser
 * accessObject
 *
 */
$dataUserLogin = $modelUser->loginUserInfo();

# access user
$userId = $dataUser->userId();
$actionStatus = false;
if (count($dataUserLogin) > 0) {
    # image owner
    if ($dataUserLogin->userId() == $userId) $actionStatus = true;
}

$landObject = $dataAccess['landObject'];
?>
@extends('user.index')

@section('titlePage')
    {!! trans('frontend_user.title_page_land') !!}
@endsection

{{--insert js to process ad  land  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-land.js')}}"></script>
@endsection

@section('tf_user_content')
    <div class="panel panel-default tf-border-bot-none">
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class="@if($landObject == 'list') active  @endif">
                    <a href="{!! route('tf.user.land.get', $userId) !!}">{!! trans('frontend_user.land_menu_list') !!}</a>
                </li>
                @if($actionStatus)
                    <li class="@if($landObject == 'invited') active  @endif">
                        <a class="tf-link" href="{!! route('tf.user.land.invited.get') !!}">
                            {!! trans('frontend_user.banner_menu_invited') !!}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="panel-body">
            {{--list land--}}
            @if($landObject == 'list')
                {{--list banner--}}
                @include('user.land.land.land-list',
                [
                    'modelUser' => $modelUser,
                    'dataUser' => $dataUser
                ])

            @elseif($landObject == 'invited')
                @include('user.land.invite.invite-list',
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser
                    ])
            @endif

            {{--extend--}}
            {{--.....--}}
        </div>
    </div>
@endsection