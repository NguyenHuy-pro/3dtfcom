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

$pointObject = $dataAccess['pointObject'];

$dataUserCard = $dataUser->userCard;
?>
@extends('user.index')
@section('titlePage')
    {!! trans('frontend_user.title_page_point') !!}
@endsection

{{--insert js to process point  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-point.js')}}"></script>
@endsection

@section('tf_user_content')
    <div class="panel panel-default tf-border-bot-none">
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class=" @if($pointObject == 'recharge') active  @endif">
                    <a class="tf-link" href="{!! route('tf.user.point.recharge.get', $userId) !!}">
                        {!! trans('frontend_user.point_menu_recharge') !!}
                        &nbsp;({!! count($dataUserCard->infoRecharge($dataUserCard->cardId())) !!})
                    </a>
                </li>
                <li class=" @if($pointObject == 'nganluong') active  @endif">
                    <a class="tf-link" href="{!! route('tf.user.point.nganluong.get', $userId) !!}">
                        {!! trans('frontend_user.point_menu_nganluong') !!}
                        &nbsp;({!! count($dataUserCard->infoNganLuongOrder($dataUserCard->cardId())) !!})
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <em>Card ID: {!! $dataUserCard->name() !!}</em>
            </div>
            {{--recharge--}}
            @if($pointObject == 'recharge')
                @include('user.point.recharge.recharge-list',
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser
                    ])

                {{--nganluong.vn--}}
            @elseif($pointObject == 'nganluong')
                @include('user.point.nganluong.nganluong-list',
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser
                    ])
            @endif

        </div>
    </div>
@endsection