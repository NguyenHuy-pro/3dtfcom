<?php
/*
 *
 * $dataBannerLicense
 *
 */

$hFunction = new Hfunction();
$dataBanner = $dataBannerLicense->banner;
$dataBannerSample = $dataBanner->bannerSample;
$borderSize = $dataBannerSample->border();
$widthLimit = $dataBannerSample->size->width() - ($borderSize * 2);
$heightLimit = ($dataBannerSample->size->height()) / 2 - ($borderSize * 2);
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <form id="frm_banner_image_add" name="frm_banner_image_add"
          class="form-horizontal col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1"
          enctype="multipart/form-data" method="post" action="{!! route('tf.map.banner.image.add.post') !!}">
        <div class="form-group text-center">
            <h3>{!! trans('frontend_map.banner_image_add_tittle') !!}</h3>
        </div>
        <div class="form-group text-center tf-color-red">
            Best size: ({!! $widthLimit.' x '.$heightLimit !!})px
        </div>
        <div class="form-group">
            <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">
                {!! trans('frontend_map.banner_image_add_label_image') !!}
            </label>

            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                {!! $hFunction->selectOneImageFollowSize('imageFile','imageFile','','checkFileImage','',$widthLimit,$heightLimit, 128, 64) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">
                {!! trans('frontend_map.banner_image_add_label_web') !!}
            </label>

            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <input class="form-control" name="txtWebsite" type="text">
            </div>
        </div>
        <div class="form-group">
            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <input id="txtBanner" name="txtBanner" type="hidden" value="{!! $dataBanner->bannerId() !!}">
                <input id="txtBannerLicense" name="txtBannerLicense" type="hidden" value="{!! $dataBannerLicense->licenseId() !!}">
                <button type="button" class="tf_banner_image_add_post btn btn-primary">
                    {!! trans('frontend_map.button_save') !!}
                </button>
                <button type="button" class="tf_main_contain_action_close btn btn-default">
                    {!! trans('frontend_map.button_cancel') !!}
                </button>
            </div>
        </div>
    </form>
@endsection