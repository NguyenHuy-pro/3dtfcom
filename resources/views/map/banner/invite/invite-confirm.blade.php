<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/9/2017
 * Time: 12:00 AM
 *
 *
 * dataBannerLicenseInvite
 *
 */
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <form id="frmMapBannerInviteConfirm" name="frmMapBannerInviteConfirm" role="form"
          class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none "
          method="post"
          action="{!! route('tf.map.banner.invite.confirm.post', $dataBannerLicenseInvite->inviteId()) !!}">
        <div class="panel-heading tf-bg tf-color-white tf-border-none ">
            <i class="fa fa-gift tf-font-size-16"></i> &nbsp;
            {!! trans('frontend_map.banner_invite_confirm_tittle') !!}
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
                <div class="tf_container_notify form-group tf-color-red tf-em-1-5 text-center"></div>
                <div class="form-group">
                    <label>
                        {!! trans('frontend_map.banner_invite_confirm_label_email') !!}
                    </label><i class="tf-color-red">*</i>
                    <em class="tf-color-red">
                        ({!! trans('frontend_map.banner_invite_confirm_label_email_notice') !!})
                    </em>
                    <input type="email" class="form-control" name="txtEmail"
                           value="{!! $dataBannerLicenseInvite->email() !!}"
                           placeholder="{!! trans('frontend_map.banner_invite_confirm_input_email_placeholder') !!}">
                </div>

                <div class="form-group">
                    <label>{!! trans('frontend_map.banner_invite_confirm_label_first_name') !!}</label><i
                            class="tf-color-red">*</i>
                    <input type="text" class="form-control" name="txtFirstName">
                </div>
                <div class="form-group">
                    <label>{!! trans('frontend_map.banner_invite_confirm_label_last_name') !!}</label><i
                            class="tf-color-red">*</i>
                    <input type="text" class="form-control" name="txtLastName">
                </div>
                <div class="form-group">
                    <label>{!! trans('frontend_map.banner_invite_confirm_label_pass') !!}</label><i
                            class="tf-color-red">*</i>
                    <input type="password" class="form-control" name="txtPassword">
                </div>
                <div class="form-group">
                    <label>{!! trans('frontend_map.banner_invite_confirm_label_pass_again') !!}</label><i
                            class="tf-color-red">*</i>
                    <input type="password" class="form-control" name="txtPasswordConfirm">
                </div>

                <div class="form-group text-center">
                    <em>If you agree, you will be a <span class="tf-em-1-5">MEMBER</span> of 3dtf.com</em>
                </div>

                <div class="form-group text-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                    <button type="button" class="tf_save btn btn-primary">
                        {!! trans('frontend_map.button_agree') !!}
                    </button>
                    <button type="button" class="tf_main_contain_action_close btn btn-default ">
                        {!! trans('frontend_map.button_close') !!}
                    </button>
                </div>
            </div>

        </div>
    </form>
@endsection
