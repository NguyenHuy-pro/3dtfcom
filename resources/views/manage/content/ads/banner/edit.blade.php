<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * dataAdsBanner
 */

$hFunction = new Hfunction();
$title = 'Edit info';
$bannerId = $dataAdsBanner->bannerId();
$width = $dataAdsBanner->width();
$height = $dataAdsBanner->height();
$pageId = $dataAdsBanner->pageId();
$positionId = $dataAdsBanner->positionId();
//price info
$dataAdsBannerPrice = $dataAdsBanner->adsBannerPrice;
if (count($dataAdsBannerPrice) > 0) {
    foreach ($dataAdsBannerPrice as $value) {
        $show = $value->display();
    }
} else {
    $show = 0;
}


?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h3 class="tf-margin-30">{!! $title !!}</h3>
    </div>
    <div class="tf-padding-bot-20 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit"
              method="post" role="form"  enctype="multipart/form-data"
              action="{!! route('tf.m.c.ads.banner.edit.post',$bannerId) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Page:</label>
                <select name="cbPage" class="form-control">
                    <option value="{!! $pageId !!}">
                        {!! $dataAdsBanner->adsPage->name() !!}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Position:</label>
                <select name="cbPosition" class="form-control">
                    <option value="{!! $positionId !!}">
                        {!! $dataAdsBanner->adsPosition->name() !!}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Image size (W / H) <span class="tf-color-red">*</span>:</label>
                <button class="tf_display_width tf-padding-lef-20 tf-padding-rig-20 text-center" type="button">
                    {!! $width !!}
                </button>
                &nbsp;x &nbsp;
                <select name="cbHeight" class="text-center">
                    <option value="{!! $height !!}">
                        {!! $height !!}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Price <span class="tf-color-red">*</span>:</label>
                <select name="cbShow" class="text-center">
                    <option value="0">Select show number</option>
                    @for($i=10 ; $i <= 10000; $i = $i+10)
                        <option value="{!! $i !!}"  @if($show == $i) selected="selected" @endif>
                            {!! $i !!}
                        </option>
                    @endfor
                </select>
                Display &nbsp; / &nbsp; 1 Point
            </div>
            <div class="form-group">
                <label class="control-label">Icon:</label>
                <img style="max-width: 100%; max-height: 100px;" src="{!! $dataAdsBanner->pathIcon() !!}">
            </div>
            <div class="form-group">
                <label class="control-label">New icon <span class="tf-color-red">*</span>:</label>
                {!! $hFunction->selectOneImageFollowSize('imageFile','imageFile','','checkFileImage','',$width,$height, 128, 64) !!}
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
            </div>
        </form>
    </div>
@endsection