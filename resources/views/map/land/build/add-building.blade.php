<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/25/2016
 * Time: 2:56 PM
 *
 *
 * $modelUser
 * $dataLand
 * $dataBuildingSample
 * $dataBusiness
 * $modelBusinessType
 * $modelBuildingSampleLicense
 *
 *
 */

#user login
$dataUserLogin = $modelUser->loginUserInfo();
$loginUserId = $dataUserLogin->userId();

#land info
$landId = $dataLand->landId();

$sampleId = $dataBuildingSample->sampleId();
$widthSample = $dataBuildingSample->size->width();
$maxName = (($widthSample / 32) * 4); // max length of name // 32px = 6 character
$maxName = ($widthSample > 64) ? $maxName - 2 : $maxName;

$pointStatus = true;

if ($modelBuildingSampleLicense->existSampleOfUser($sampleId, $loginUserId)) {
    $ownerStatus = 1;
} else {
    $ownerStatus = 0;
    if ($dataUserLogin->point() < $dataBuildingSample->price()) $pointStatus = false;
}
$businessTypeId = $dataBuildingSample->businessTypeId();
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <form id="frmLandAddBuilding" name="frmLandAddBuilding"
          class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none " data-land="{!! $landId !!}"
          data-owner-status="{!! $ownerStatus !!}" data-point="{!! $dataBuildingSample->price() !!}"
          method="post" action="{!! route('tf.map.land.building.add.post',"$landId/$sampleId") !!}">
        @if($pointStatus)
            <div id="tf_land_add_building_header" class="panel-heading tf-bg tf-color-white tf-border-none ">
                <i class="fa fa-home tf-font-size-16"></i>&nbsp;
                {!! trans('frontend_map.land_build_add_title') !!}
            </div>
            <div id="tf_land_add_building_body" class="panel-body tf-overflow-auto">
                <div class="form-group text-right">
                    <a class="tf_land_build_building_sample_get tf-link tf-text-under" data-land="{!! $landId !!}"
                       data-href="{!! route('tf.map.land.build.sample.get') !!}">
                        {!! trans('frontend_map.land_build_add_select_other_business') !!}
                    </a>
                </div>
                <div class="form-group">
                    <label>{!! trans('frontend_map.land_build_add_name_label') !!}</label>
                    <span class="tf-color-red">*</span>
                    <input name="txtName" type="text" class="form-control">
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>{!! trans('frontend_map.land_build_add_show_name_label') !!}</label>
                            <em>(At most {!! $maxName !!} words)</em>
                            <span class="tf-color-red">*</span>
                            <input data-length="{!! $maxName !!}" name="txtDisplayName" type="text"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group text-center">
                            <span id="txtPreviewName">Display name</span>
                            <br/>
                            <img alt="sample" src="{!! $dataBuildingSample->pathImage() !!}"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        {!! trans('frontend_map.land_build_add_business_label') !!}
                    </label>: <em>{!! $modelBusinessType->name($businessTypeId) !!}</em>

                    <div class="form-control" style="height: 200px">
                        <ul class="list-group ">
                            <li class="list-group-item tf-margin-padding-none tf-border-none">
                                <input id="frmLandAddBuilding_check_all" name="businessType" type="checkbox"> Check all
                            </li>
                            <li class="list-group-item tf-margin-padding-none tf-border-none">
                                <ul class="list-group" style="max-height: 150px; overflow: auto;">
                                    @foreach($dataBusiness as $itemBusiness)
                                        <li class="list-group-item tf-border-none tf-padding-bot-none">
                                            <div class="checkbox tf-margin-padding-none">
                                                <label>
                                                    <input class="frmLandAddBuilding_business" name="buildingBusiness[]"
                                                           type="checkbox" value="{!! $itemBusiness->businessId() !!}">
                                                    {!! $itemBusiness->name() !!}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
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
            <div id="tf_land_add_building_footer"
                 class="panel panel-footer text-center tf-border-none tf-margin-bot-none tf-bg-whitesmoke">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <button type="button" class="tf_save btn btn-primary">
                    {!! trans('frontend_map.button_save') !!}
                </button>
                <button type="button" class="tf_main_contain_action_close btn btn-default ">
                    {!! trans('frontend_map.button_close') !!}
                </button>
            </div>
            <script type="text/javascript">
                $(document).ready(function () {
                    var headerHeight = $('#tf_land_add_building_header').outerHeight();
                    var footerHeight = $('#tf_land_add_building_footer').outerHeight();
                    $('#tf_land_add_building_body').css('height', windowHeight - headerHeight - footerHeight - 80);
                });
            </script>
        @else
            {{-- the user does not enough point to paymtent.--}}
            <div class="form-group warning tf-padding-30 tf-color-red text-center ">
                {!! trans('frontend_map.land_build_transaction_notify_point') !!}.
            </div>
            <div class="form-group">
                <div class="text-center tf-padding-bot-10 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a class="tf-link-white" href="{!! route('tf.point.online.package.get') !!}">
                        <button type="button" class="btn btn-primary">
                            {!! trans('frontend_map.button_buy_point') !!}
                        </button>
                    </a>
                    <button type="button" class="tf_main_contain_action_close btn btn-default">
                        {!! trans('frontend_map.button_later') !!}
                    </button>
                </div>
            </div>
        @endif
    </form>

@endsection
