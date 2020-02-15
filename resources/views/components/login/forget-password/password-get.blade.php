<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 12/16/2016
 * Time: 3:43 PM
 */
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <form id="tf_frm_forget_pass" name="tf_frm_forget_pass"
          class="form-horizontal col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1"
          role="form" method='post' action="{!! route('tf.login.forget-pass.post') !!}">
        <div class="form-group text-center">
            <h3>{!! trans('frontend.forget_title') !!}</h3>
        </div>
        <div class="form-group tf_contain_notify text-center tf-color-red tf-padding-10"></div>
        <div class="tf_account_wrap form-group">
            <label class="col-lg-3 control-label">
                {!! trans('frontend.forget_label_account') !!} :
            </label>

            <div class="col-lg-9">
                <input class="form-control" name="txtAccount" type="email"
                       placeholder="{!! trans('frontend.forget_input_account_placeholder') !!}"/>
            </div>
        </div>
        <div class="form-group text-center">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
            <button class="tf_send btn btn-primary btn-sm tf-link-white" type="button">
                {!! trans('frontend.forget_button_send') !!}
            </button>
            <button class="tf_main_contain_action_close btn btn-default btn-sm tf-link" type="button">
                {!! trans('frontend.forget_button_close') !!}
            </button>

        </div>
        <div class="form-group text-center tf-color-red tf-padding-10"></div>
    </form>
@endsection