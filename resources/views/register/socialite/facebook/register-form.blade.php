<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 5/14/2017
 * Time: 10:48 PM
 */
/*
 * modelUser
 * dataFacebookUser
 */
#get info from facebook
$socialiteCode = $dataFacebookUser->id;
$socialiteUserName = $dataFacebookUser->name;
$socialiteGender = $dataFacebookUser->user['gender'];
$socialiteEmail = $dataFacebookUser->email;
$socialiteAvatar = $dataFacebookUser->avatar;

$arrayName = explode(' ', $socialiteUserName);
$socialiteLastName = $arrayName[0];
$socialiteFirstName = substr($socialiteUserName, strlen($socialiteLastName) + 1, strlen($socialiteUserName));
#$gender = ($socialiteGender == 'male') ? 0 : 1;

$existEmail = false;
if (!empty($socialiteEmail)) {
    $existEmail = $modelUser->existAccount($socialiteEmail);
}
if ($existEmail) {
    $registerEmail = null;
} else {
    $registerEmail = $socialiteEmail;
}

$hFunction = new Hfunction();
?>
@extends('master')
@section('titlePage')
    Register
@endsection

@section('shortcutPage')
    <link rel="shortcut icon" href="{!! asset('public/main/icons/3dlogo128.png') !!}"/>
@endsection

{{--css--}}
@section('tf_master_page_css')
    <link href="{{ url('public/register/css/register.css')}}" rel="stylesheet">
@endsection

@section('tf_master_page_js_header')
    <script type="text/javascript" src="{!! asset('public/register/js/register.js') !!}"></script>
@endsection


@section('tf_main_content')
    <div class="tf-register-wrapper col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="container tf-padding-top-30 tf-padding-bot-50">
                <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-font-bold">
                        <h3>{!! trans('frontend.register_fb_title') !!}</h3>
                    </div>
                    <form id="frmFacebookRegister" name="frmFacebookRegister" role="form" method='post'
                          enctype='multipart/form-data' action="{!! route('tf.register.facebook.connect') !!}">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group" style="border-top: 5px solid #D7D7D7;"></div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div class="form-group text-left">
                                <em class="tf-color-red">Info connect to 3dtf.com</em>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <div id="tf_fb_register_notify" class="form-group text-center tf-color-red tf-em-1-5">

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>
                                            {!! trans('frontend.register_label_first_name') !!} <span
                                                    class="tf-color-red">*</span>:
                                        </label>
                                        <input id="txtFirstName" class="form-control" type="text" name="txtFirstName"
                                               value="{!! $socialiteFirstName !!}"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>
                                            {!! trans('frontend.register_label_last_name') !!} <span
                                                    class="tf-color-red">*</span>:
                                        </label>
                                        <input class="form-control" type="text" name="txtLastName"
                                               value="{!! $socialiteLastName !!}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>
                                    {!! trans('frontend.register_fb_label_account') !!} <span
                                            class="tf-color-red">*</span>
                                </label>
                                @if($existEmail)
                                    <br/>
                                    <em>Existing email: {!! $socialiteEmail !!}</em>
                                @endif
                                <input class="form-control" type="text" name="txtAccount"
                                       value="{!! $registerEmail !!}"/>
                            </div>
                            <div class="form-group">
                                <label>
                                    {!! trans('frontend.register_fb_label_password') !!} <span
                                            class="tf-color-red">*</span> :
                                </label>
                                <input class="form-control" type="password" name="txtPassword"/>
                            </div>
                            <div class="form-group">
                                <label>
                                    {!! trans('frontend.register_fb_label_gender') !!} <span
                                            class="tf-color-red">*</span>
                                </label>
                                <select class="form-control" name="txtGender">
                                    <option value="0" @if($socialiteGender == 'male') selected="selected" @endif >
                                        Male
                                    </option>
                                    <option value="1" @if($socialiteGender == 'female') selected="selected" @endif >
                                        Female
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group text-center">
                                <input type="hidden" name="fb_id" value="{!! $socialiteCode !!}">
                                <input type="hidden" name="fb_name" value="{!! $socialiteUserName !!}">
                                <input type="hidden" name="fb_email" value="{!! $socialiteEmail !!}">
                                <input type="hidden" name="fb_avatar" value="{!! $socialiteAvatar !!}">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <a class="tf_accept tf-margin-rig-20">
                                    <button class="btn btn-primary" type="button">Accept</button>
                                </a>

                                <a href="{!! route('tf.home') !!}">
                                    <button class="btn btn-default" type="button">Later</button>
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

{{--=========== ========== Footer map =========== =========--}}
@section('tf_main_footer')
    @include('components.footer.footer')
@endsection

