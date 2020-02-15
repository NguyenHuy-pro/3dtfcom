<?php
/*
 * $dataSize
 * $dataBannerImage
 */
$hFunction = new Hfunction();
$dataBannerSample = $dataBannerImage->bannerLicense->banner->bannerSample;
$borderSize = $dataBannerSample->border();
$widthLimit = $dataBannerSample->size->width() -($borderSize*2);
$heightLimit = ($dataBannerSample->size->height()) / 2 - ($borderSize*2);

?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <form id="frm_banner_image_edit" name="frm_banner_image_edit" class="col-sm-10 col-sm-offset-1 form-horizontal"
          enctype="multipart/form-data" method="post" action="{!! route('tf.map.banner.image.edit.post') !!}">
        <div class="form-group text-center">
            <h3>{!! trans('frontend_map.banner_image_edit_tittle') !!}</h3>
        </div>
        <div class="form-group text-center tf-color-red">
            Best size: ({!! $widthLimit.' x '.$heightLimit !!})px
        </div>
        <div class="form-group">
            <label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">
                {!! trans('frontend_map.banner_image_edit_label_image') !!}
            </label>
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                {!! $hFunction->selectOneImageFollowSize('imageFile','imageFile','','checkFileImage','',$widthLimit,$heightLimit, 128, 64) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">
                {!! trans('frontend_map.banner_image_edit_label_web') !!}
            </label>
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <input class="form-control" name="txtWebsite" type="text" value="{!! $dataBannerImage->website() !!}" placeholder="link website">
            </div>
        </div>
        <div class="form-group">
            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <input name="txtBannerImage" type="hidden" value="{!! $dataBannerImage->imageId() !!}">
                <input name="txtBanner" type="hidden" value="{!! $dataBannerImage->bannerId() !!}">
                <button type="button" class="tf_banner_image_edit_post btn btn-primary">
                    {!! trans('frontend_map.button_save') !!}
                </button>
                <button type="button" class="tf_main_contain_action_close btn btn-default" >
                    {!! trans('frontend_map.button_cancel') !!}
                </button>
            </div>
        </div>
    </form>
@endsection