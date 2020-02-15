<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/19/2016
 * Time: 11:18 AM
 *
 * $modelUser
 * $modelLandLicense
 * $dataLandLicense
 *
 */

$hFunction = new Hfunction();

// banner info
$licenseId = $dataLandLicense->licenseId();

$dataLandLicenseInvite = $dataLandLicense->landLicenseInviteInfo();
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <form id="frmMapLandInvite" name="frmMapLandInvite" role="form"
          class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none "
          method="post" action="{!! route('tf.map.land.invite.post', $licenseId) !!}">
        <div class="panel-heading tf-bg tf-color-white tf-border-none ">
            <i class="fa fa-gift tf-font-size-16"></i> &nbsp;
            {!! trans('frontend_map.land_invite_title') !!}
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @if(count($dataLandLicenseInvite) > 0)
                    <div class="form-group text-center">
                        {!! trans('frontend_map.land_invite_notify_sent') !!} :<br/>
                        {!! $dataLandLicenseInvite->email() !!}
                    </div>

                    <div class="form-group text-center">
                        <button type="button" class="tf_main_contain_action_close btn btn-default ">
                            {!! trans('frontend_map.button_close') !!}
                        </button>
                    </div>

                @else
                    <div class="tf_container_notify form-group tf-color-red tf-em-1-5 text-center"></div>
                    <div class="form-group">
                        <label>{!! trans('frontend_map.land_invite_email_label') !!}</label>
                        <input type="email" class="form-control" name="txtEmail"
                               placeholder="{!! trans('frontend_map.land_invite_email_placeholder') !!}">
                    </div>

                    <div class="form-group">
                        <label>{!! trans('frontend_map.land_invite_message_label') !!}</label>
                    <textarea class="form-control" name="txtMessage" rows="3"
                              placeholder="{!! trans('frontend_map.land_invite_message_placeholder') !!}"></textarea>

                    </div>
                    <div class="form-group text-center">
                        <i class="tf-color-red">*</i>
                        <em>
                            {!! trans('frontend_map.land_invite_warning') !!}
                        </em>
                    </div>
                    <div class="form-group text-center">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                        <button type="button" class="tf_map_land_invite_send btn btn-primary">
                            {!! trans('frontend_map.button_send') !!}
                        </button>
                        <button type="button" class="tf_main_contain_action_close btn btn-default ">
                            {!! trans('frontend_map.button_close') !!}
                        </button>
                    </div>
                @endif
            </div>

        </div>
    </form>
@endsection
