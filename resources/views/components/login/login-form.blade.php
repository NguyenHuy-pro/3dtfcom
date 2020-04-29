<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/8/2016
 * Time: 8:44 AM
 *
 *
 */
/*
 * returnUrl
 */

$moBileDetect = new Mobile_Detect();
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    {{--temporary solution--}}
    <form id="frm_main_login" name="frm_main_login"
          class="form-horizontal col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1"
          role="form" method='get' action="{!! route('tf.login.post') !!}">
        <div id="tf_main_login_notify" class="form-group text-center tf-color-red tf-padding-10"></div>
        <div class="form-group">
            <label>
                {!! trans('frontend.login_label_email') !!}
            </label>
            <input id="txtAccount" class="form-control" name="txtAccount" type="email" autofocus
                   placeholder="{!! trans('frontend.login_input_email_placeholder') !!}"/>
        </div>
        <div class="form-group">
            <label>
                {!! trans('frontend.login_label_password') !!}
            </label>
            <input id="txtPass" class="form-control" name="txtPass" type="password"
                   placeholder="{!! trans('frontend.login_input_password_placeholder') !!}"/>
        </div>

        <div class="form-group text-center">
            <input class="tf_login_return_url" type="hidden" name="txtReturnUrl" value="{!! $returnUrl !!}">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
            <button class="tf_main_login_post btn btn-primary btn-sm tf-link-white" type="button">
                {!! trans('frontend.login_button_login') !!}
            </button>
            <button class="tf_main_contain_action_close btn btn-default btn-sm tf-link" type="button">
                {!! trans('frontend.login_button_close') !!}
            </button>
        </div>
        <div class="form-group text-center">
            <a class="tf_forget_pass tf-link" data-href="{!! route('tf.login.forget-pass.get') !!}">
                {!! trans('frontend.login_link_forget_password') !!}
            </a>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="tf-color-grey">Or</span>
                </div>
                {{--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <a class="btn btn-default tf-link-full tf-link-hover-white tf-bg-hover text-center"
                       style="border-color: blue;" href="{!! route('tf.register.facebook.get') !!}">
                        Facebook
                    </a>
                </div>--}}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a class="btn btn-default tf-link-full tf-link-hover-white tf-bg-hover text-center"
                       style="border-color: orangered;" href="{!! route('tf.register.google.get') !!}">
                        Google+
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection

