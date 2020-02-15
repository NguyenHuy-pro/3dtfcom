<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/10/2017
 * Time: 2:47 PM
 */
/*
 * modelUser
 * dataAdsBanner
 *
 */
//user login info
$dataUserLogin = $modelUser->loginUserInfo();

// ads banner info
$bannerId = $dataAdsBanner->bannerId();
$name = $dataAdsBanner->name();
$width = $dataAdsBanner->width();
$height = $dataAdsBanner->height();
//image
$dataAdsBannerImage = $dataAdsBanner->displayImage();
$imageStatus = false;
if (count($dataAdsBannerImage) > 0) {
    $imageStatus = true;
    $imageId = $dataAdsBannerImage->imageId();
    $pathImage = $dataAdsBannerImage->pathImage();
    $website = $dataAdsBannerImage->website();
} else {
    $imageId = null;
    $pathImage = $dataAdsBanner->pathIcon();
    $website = null;
}
?>
<div class="tf_ads_all_banner_wrap tf-ads-all-banner-wrap"  style="width: auto; max-width: 100%; height:auto;" >
    <div class="tf_menu tf-menu">
        {{-- icon--}}
        <img class="tf_menu_icon tf-menu-icon" src="{!! asset('public/main/icons/ads-banner-icon.png') !!}">

        {{-- menu--}}
        <div class="tf_menu_content tf-menu-content list-group tf-box-shadow-top-none">
            <a class="list-group-item tf-bg-hover tf-link-hover-white"
               href="{!! route('tf.ads.order.detail.get', $name) !!}"
               target="_blank">
                Set Ads
            </a>
            @if ($imageStatus && count($dataUserLogin) > 0)
                @if($dataUserLogin->existReportAdsBannerImage($dataAdsBannerImage->imageId()))
                    <a class="list-group-item tf-bg-hover tf-link-hover-white">
                        <em class="tf-color-grey">{!! trans('frontend_ads.banner_object_menu_report_sent') !!}</em>
                    </a>
                @else
                    <a class="tf_bad_info_report list-group-item tf-bg-hover tf-link-hover-white"
                       data-name="{!! $dataAdsBannerImage->name() !!}"
                       data-href="{!! route('tf.ads.report.bad-info.get') !!}">
                        {!! trans('frontend_ads.banner_object_menu_report') !!}
                    </a>
                @endif
                <a class="tf_prevent list-group-item tf-bg-hover tf-link-hover-white" data-image="{!! $imageId !!}"
                   data-prevent="{!! route('tf.ads.banner-image.prevent') !!}">
                    {!! trans('frontend_ads.banner_object_menu_prevent_sent') !!}
                </a>
            @endif
        </div>
    </div>
    @if($imageStatus)
        <a class="tf_visit tf-cursor-pointer" data-image="{!! $imageId !!}"
           data-visit="{!! route('tf.ads.banner-image.visit') !!}" @if(!empty($website)) href="http://{!! $website !!}"
           target="_blank" @endif>
            <img style="max-width: 100%;" src="{!!$pathImage !!}">
        </a>
    @else
        <img style="max-width: 100%;" src="{!!$pathImage !!}">
    @endif
</div>
