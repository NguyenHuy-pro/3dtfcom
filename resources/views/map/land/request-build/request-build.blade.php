<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/25/2016
 * Time: 2:56 PM
 *
 *
 * modelUser
 * dataLandLicense
 * dataRequestBuildPrice
 *
 *
 */
$hFunction = new Hfunction();
#user login
$dataUserLogin = $modelUser->loginUserInfo();
$loginUserId = $dataUserLogin->userId();
#land info
$dataLand = $dataLandLicense->land;
$landId = $dataLand->landId();

$widthStandard = $dataLand->size->width();
$maxName = (($widthStandard / 32) * 4); // max length of name // 32px = 6 character
$maxName = ($widthStandard > 64) ? $maxName - 2 : $maxName;

//check point
$pointOfUser = $dataUserLogin->point($loginUserId);
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <form id="frmLandRequestBuild" name="frmLandRequestBuild"
          class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none " enctype="multipart/form-data"
          method="post" action="{!! route('tf.map.land.request-build.send',$dataLandLicense->licenseId()) !!}">
        <div id="tf_land_request_build_header" class="panel-heading tf-bg tf-color-white tf-border-none ">
            <i class="fa fa-home tf-font-size-16"></i>&nbsp;
            {!! trans('frontend_map.land_build_add_title') !!}
        </div>
        <div id="tf_land_request_build_body" class="panel-body tf-overflow-auto">
            <div class="form-group text-center">
                <h4>{!! trans('frontend_map.land_build_add_form_title') !!}</h4>
            </div>
            <div class="tf-color-red form-group text-center">
                Cost build: {!! $dataRequestBuildPrice->price() !!} Point
            </div>
            <div class="form-group">
                <label>Customer</label>
                <span class="tf-color-red">*</span>
                <input name="txtUser" type="text" class="form-control" readonly
                       value="{!! $dataUserLogin->fullName() !!}">
            </div>
            <div class="form-group">
                <em class="tf-text-under">* {!! trans('frontend_map.land_build_add_sample_title') !!}</em>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-xs-12 col-sm-4 col-md-2 col-lg-2 ">
                        {!! trans('frontend_map.land_build_add_sample_label')  !!}:
                    </label>

                    <div class="col-xs-12 col-sm-8 col-md-10 col-lg-10">
                        <?php
                        $hFunction->selectOneImage('txtImage', 'txtImage');
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_map.land_build_add_sample_description_label') !!}</label>
                    <textarea class="form-control" name="txtDesignDescription" rows="3"
                              placeholder="About design"></textarea>
            </div>
            <div class="form-group">
                <em class="tf-text-under">* {!! trans('frontend_map.land_build_add_building_title') !!}</em>
            </div>

            <div class="form-group">
                <label>
                    {!! trans('frontend_map.land_build_add_business_label') !!}
                </label>
                <select class="form-control" name="cbBusinessType">
                    <option value="">
                        Select type
                    </option>
                    {!! $modelBusinessType->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_map.land_build_add_name_label') !!}</label>
                <span class="tf-color-red">*</span>
                <input name="txtFullName" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label>{!! trans('frontend_map.land_build_add_show_name_label') !!}</label>
                <em>(At most {!! $maxName !!} words)</em>
                <span class="tf-color-red">*</span>
                <input data-length="{!! $maxName !!}" name="txtDisplayName" type="text"
                       class="form-control">
            </div>

            <div class="form-group">
                <label>{!! trans('frontend_map.land_build_add_summary_label') !!}</label>
                <span class="tf-color-red">*</span>
                <input name="txtShortDescription" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_map.land_build_add_description_label') !!}</label>
                <textarea id="txtDescription" class="form-control" name="txtDescription" rows="10"></textarea>
                <script type="text/javascript">ckeditor('txtDescription')</script>
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_map.land_build_add_website_label') !!}</label>
                <input name="txtWebsite" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_map.land_build_add_email_label') !!}</label>
                <input name="txtEmail" type="text" class="form-control" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_map.land_build_add_phone_label') !!}</label>
                <input name="txtPhone" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>{!! trans('frontend_map.land_build_add_address_label') !!}</label>
                <input name="txtAddress" type="text" class="form-control">
            </div>
        </div>
        <div id="tf_land_request_build_footer"
             class="panel panel-footer text-center tf-border-none tf-margin-bot-none tf-bg-whitesmoke">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
            <button type="button" class="tf_send btn btn-primary">
                {!! trans('frontend_map.button_send') !!}
            </button>
            <button type="button" class="tf_main_contain_action_close btn btn-default ">
                {!! trans('frontend_map.button_close') !!}
            </button>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                var headerHeight = $('#tf_land_request_build_header').outerHeight();
                var footerHeight = $('#tf_land_request_build_footer').outerHeight();
                $('#tf_land_request_build_body').css('height', windowHeight - headerHeight - footerHeight - 80);
            });
        </script>
    </form>
@endsection
