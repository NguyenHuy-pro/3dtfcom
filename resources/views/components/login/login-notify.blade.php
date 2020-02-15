<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/14/2016
 * Time: 10:43 AM
 */
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')

    {{--user is not login--}}
    <div class="tf-padding-20 col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <p><b>You must login to use this function.</b></p>

        <p>
            <em>If you do not have an account, please select button register.</em><br/>
            <em>If you have an account, please select button login.</em>
        </p>

    </div>
    <div class="tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <button class="btn btn-primary" type="button">
            <a class="tf-link-white"  href="{!! route('tf.register.get') !!}">
                {!! trans('frontend.login_notify_button_register') !!}
            </a>
        </button>
        <button class="tf_main_login_get tf-link-white btn btn-warning" type="button" data-href="{!! route('tf.login.get') !!}">
            {!! trans('frontend.login_notify_button_login') !!}
        </button>
        <button class="tf_main_contain_action_close btn btn-default" type="button">
            {!! trans('frontend.login_notify_button_close') !!}
        </button>
    </div>
@endsection
