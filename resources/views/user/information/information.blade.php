<?php
/*
 *
 * $modelUser
 * $dataUser
 *
 */

#access user info
$userId = $dataUser->userId();

# login user info
$dataUserLogin = $modelUser->loginUserInfo();
$actionStatus = false;
if (count($dataUserLogin) > 0) {
    $userLoginId = $dataUserLogin->userId();
    if ($userId == $userLoginId) {
        $actionStatus = true;
        $dataUser = $dataUserLogin;
    }
} else {
    $userLoginId = null;
}

#refresh user info when update
#if($actionStatus) $dataUser = $modelUser->getInfo($dataUserLogin->userId());
?>
@extends('user.index')

{{--insert js to process information  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-information.js')}}"></script>
@endsection

@section('tf_user_content')
    <div class="tf_user_information panel panel-default tf-border-none tf-margin-none">
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a class="tf-font-bold" href="#">
                        {!! trans('frontend_user.info_menu_public') !!}
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel-body tf-border-none ">
            {{--basic info--}}
            <div class="row ">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <label>{!! trans('frontend_user.info_basic_label_title') !!}</label>
                    @if($actionStatus)
                        <a class="pull-right tf_info_edit tf-link"
                           data-href="{!! route('tf.user.info.basic.edit.get') !!}">
                            {!! trans('frontend_user.info_basic_label_edit') !!}
                        </a>
                    @endif
                    <hr class="tf-margin-none"/>
                </div>
                <div id="tf_user_info_content" class="col-xs-12 col-sm-12 col-md-12 tf-user-info-content">
                    @include('user.information.basic.basic',
                        [
                            'modelUser',
                            'dataUser'=>$dataUser
                        ])
                </div>
            </div>

            {{--contact info--}}
            <div class="row">
                <div class="col-x12 col-sm-12 col-md-12">
                    <label>{!! trans('frontend_user.info_contact_label_title') !!}</label>
                    @if($actionStatus)
                        <a class="tf_info_edit pull-right tf-link"
                           data-href="{!! route('tf.user.info.contact.edit.get') !!}">
                            {!! trans('frontend_user.info_contact_label_edit') !!}
                        </a>
                    @endif
                    <hr class="tf-margin-none"/>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 tf-user-info-content ">
                    @include('user.information.contact.contact',
                        [
                            'dataUser'=>$dataUser
                        ])
                </div>
            </div>

            @if($actionStatus)
                {{--password info--}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <label>{!! trans('frontend_user.info_account_label_title') !!}</label>
                        <a class="tf_info_edit pull-right tf-link"
                           data-href="{!! route('tf.user.info.password.edit.get') !!}">
                            {!! trans('frontend_user.info_account_label_title') !!}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection