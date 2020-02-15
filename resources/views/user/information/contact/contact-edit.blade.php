<?php
/*
$dataUserContact
$modelProvince
 */

if (count($dataUserContact) > 0) {
    $countryId = $dataUserContact->province->country->countryId();
    $provinceId = $dataUserContact->provinceId();
    $address = $dataUserContact->address();
    $phone = $dataUserContact->phone();
    $email = $dataUserContact->email();
} else {
    $countryId = null;
    $provinceId = null;
    $address = null;
    $phone = null;
    $email = null;
}

?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
        <form id="tfUserFrmContactEdit" name="tfUserFrmContactEdit" class="tf_user_frm_contact_edit form-horizontal"
              role="form" method='post' enctype="multipart/form-data"
              action="{!! route('tf.user.info.contact.edit.post') !!}">
            <div class="form-group">
                <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    <h3>{!! trans('frontend_user.info_contact_edit_title') !!}</h3>
                </div>
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_user.info_contact_edit_label_country') !!}
                </label>
                <select id="tf_user_contact_country" name="cbCountry" class="form-control"
                        data-href="{!! route('tf.user.info.contact.province.get') !!}">
                    <option value="0">{!! trans('frontend_user.info_contact_edit_select_country') !!}</option>
                    {!! $modelCountry->getOption($countryId) !!}
                </select>
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_user.info_contact_edit_label_province') !!}
                </label>

                <div class="row">
                    <div id="tf_user_contact_province_wrap" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include('user.information.contact.select-province', ['modelProvince'=>$modelProvince, 'countryId'=>$countryId])
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_user.info_contact_edit_label_address') !!}
                </label>
                <input class="form-control" type="text" name="txtAddress" value="{!! $address !!}">
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_user.info_contact_edit_label_phone') !!}
                </label>
                <input class="form-control" type="text" name="txtPhone" value="{!! $phone !!}">
            </div>
            <div class="form-group">
                <label>
                    {!! trans('frontend_user.info_contact_edit_label_email') !!}
                </label>
                <input class="form-control" type="text" name="txtEmail" value="{!! $email !!}">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <button class="tf_contact_save btn btn-primary" type="button">
                    {!! trans('frontend.button_save') !!}
                </button>
                <button class="tf_main_contain_action_close btn btn-default" type="button">
                    {!! trans('frontend.button_cancel') !!}
                </button>
            </div>
        </form>
    </div>

@endsection