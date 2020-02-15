<?php
/*
 *
 * dataAdsBannerLicense
 *
 */
$hFunction = new Hfunction();
$width = $dataAdsBannerLicense->adsBanner->width();
$height = $dataAdsBannerLicense->adsBanner->height();
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')

    <div class="panel panel-default tf-border-none tf-padding-none tf-margin-bot-none ">
        <div id="tf_ads_set_image_header" class="panel-heading tf-color-white tf-bg  tf-border-none ">
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <i class="glyphicon glyphicon-cog"></i>&nbsp;
                    {!! trans('frontend_user.ads_set_image_title') !!}
                </div>
                <div class="text-right col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                    <span class="tf_main_contain_action_close glyphicon glyphicon-remove tf-link-red "></span>
                </div>
            </div>
        </div>
        <div id="tf_ads_set_image_body" class="panel-body tf-overflow-auto">
            <form id="tf_frm_ads_set_image_add" name="tf_frm_ads_set_image_add"
                  class="form-horizontal col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1"
                  enctype="multipart/form-data" method="post"
                  action="{!! route('tf.user.ads.set-image.post', $dataAdsBannerLicense->name()) !!}">
                <div class="form-group text-center tf-color-green">
                    <h3>
                        {!! trans('frontend_user.ads_set_image_size_notify') !!}: ({!! $width.' x '.$height !!}) px
                    </h3>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2 ">
                        {!! trans('frontend_user.ads_set_image_select_label') !!}
                    </label>

                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        {!! $hFunction->selectOneImageFollowSize('imageFile','imageFile','','checkFileImage','',$width,$height, 128, 64) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        {!! trans('frontend_user.ads_set_image_select_business_label') !!}
                    </label>

                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <select class="tf_business_type form-control" name="cbBusinessType">
                            <option value="">{!! trans('frontend_user.ads_set_image_select_business_notice') !!}</option>
                            {!! $modelBusinessType->getOption() !!}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        {!! trans('frontend_user.ads_set_image_website_label') !!}
                    </label>

                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <input class="form-control" name="txtWebsite" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                        <button type="button" class="tf_save btn btn-primary">
                            {!! trans('frontend_map.button_save') !!}
                        </button>
                        <button type="button" class="tf_main_contain_action_close btn btn-default">
                            {!! trans('frontend_map.button_cancel') !!}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var headerTop = $('#tf_ads_set_image_header').outerHeight();
            $('#tf_ads_set_image_body').css('height', windowHeight - headerTop - 80);
        });
    </script>
@endsection