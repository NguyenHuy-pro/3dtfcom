<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/16/2016
 * Time: 8:41 AM
 *
 */
/*
 * modelUser
 * dataBanner
 */
$hFunction = new Hfunction();

$loginStatus = $modelUser->checkLogin();

#banner info
$bannerId = $dataBanner->bannerId();

#license info
$dataLicenseInfo = $dataBanner->licenseInfo();

if (count($dataLicenseInfo) > 0) {
    $dataUserLicense = $dataLicenseInfo->user;
    $licenseUserId = $dataUserLicense->userId();
    $licenseUserAlias = $dataUserLicense->alias();
    $userFullName = $dataUserLicense->fullName();
    $pathAvatar = $dataUserLicense->pathSmallAvatar($licenseUserId, true);
} else {
    $pathAvatar = asset('public/main/icons/3dlogo128.png');
}

$dataBannerImage = $dataBanner->imageInfo();
if (!empty($dataBannerImage)) {
    $bannerImageId = $dataBannerImage->imageId();
    $website = $dataBannerImage->website();
    $totalViewImage = $dataBannerImage->totalVisitImage();
    $totalVisitWebsite = $dataBannerImage->totalVisitWebsite();
} else {
    $bannerImageId = null;
    $website = null;
    $totalViewImage = 0;
    $totalVisitWebsite = 0;
}
$totalVisitBanner = $dataBanner->totalVisit();
?>
@extends('components.container.contain-action-10')
@section('tf_main_action_content')
    <div class="tf_banner_information  panel panel-default tf-border-none tf-padding-none tf-margin-bot-none "
         data-banner="{!! $bannerId !!}">
        <div class="panel-body  tf-padding-none">
            <table class="table table-hover tf-margin-padding-none" style="border-collapse: collapse;">
                @if(count($dataLicenseInfo) > 0)
                    <tr class="">
                        <th class="text-center col-xs-2 col-sm-2 col-md-1 col-lg-1" style="border-top-left-radius: 5px;">
                            <a class="tf-link-bold" href="{!! route('tf.user.home',$licenseUserAlias) !!}"
                               target="_blank"
                               title="{!! $userFullName !!}">
                                <img class="tf-icon-20" alt="{!! $licenseUserAlias !!}" src="{!! $pathAvatar !!}">
                            </a>

                        </th>
                        <th class="text-left col-xs-10 col-sm-10 col-md-11 col-lg-11" style="border-top-right-radius: 5px;">
                            <a class="tf-link-bold" href="{!! route('tf.user.home',$licenseUserAlias) !!}"
                               target="_blank"
                               title="{!! $userFullName !!}">
                                {!! $userFullName !!}
                            </a>
                        </th>
                    </tr>
                @else
                    <tr>
                        <th class="text-center col-xs-2 col-sm-2 col-md-1 col-lg-1" style="border-top-left-radius: 5px;">
                            <img class="tf-icon-20" alt="logo" src="{!! $pathAvatar !!}">
                        </th>
                        <th class="text-left col-xs-10 col-sm-10 col-md-11 co-lg-11" style="border-top-right-radius: 5px;">
                            <a class="tf-link-bold" href="#" target="_blank"
                               title="3dtf.com">
                                {!! trans('frontend.label_system_name') !!}
                            </a>
                        </th>
                    </tr>
                @endif
                <tr>
                    <td class="text-center col-xs-2 col-sm-2 col-md-1 col-lg-1">
                        <span class="glyphicon glyphicon-fullscreen tf-font-size-20"></span>
                    </td>
                    <td class="text-left col-xs-10 col-sm-10 col-md-11 col-lg-11">
                        @if(empty($bannerImageId))
                            {!! trans('frontend.label_none') !!}
                        @else
                            <a class="tf-link tf_detail" href="#">
                                {!! trans('frontend_map.banner_info_label_image_view') !!}
                            </a>
                        @endif
                        <span class="badge pull-right" title="Total visit">
                    {!! $totalViewImage !!}
                </span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center col-xs-2 col-sm-2 col-md-1 col-lg-1 ">
                        <span class="glyphicon glyphicon-globe tf-font-size-20"></span>
                    </td>
                    <td class="text-left col-xs-10 col-sm-10 col-md-11 col-lg-11 ">
                        @if(empty($website))
                            {!! trans('frontend.label_none') !!}
                        @else
                            <a class="tf-link tf_website" href="http://{!! $website !!}" target="_blank">
                                {!! $hFunction->cutString($website, 30,'...') !!}
                            </a>
                        @endif
                        <span class="badge pull-right">
                    {!! $totalVisitWebsite !!}
                </span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center col-xs-2 col-sm-2 col-md-1 col-lg-1 ">
                        <span class="glyphicon glyphicon-eye-open tf-font-size-20"></span>
                    </td>
                    <td class="text-left col-xs-10 col-sm-10 col-md-11 col-lg-11 ">
                        {!! trans('frontend_map.banner_info_label_visited') !!}
                        <span class="badge pull-right">
                    {!! $totalVisitBanner !!}
                </span>
                    </td>
                </tr>

                {{--statistic--}}

            </table>
        </div>
        <div class="panel-body tf-padding-none">
            <table class="table tf-margin-padding-none" style="border-collapse: collapse;">
                <tr>
                    {{--share--}}
                    <td class="text-center">
                        <a class="tf_banner_share_get tf-link-bold tf-margin-padding-none"
                           data-banner="{!! $bannerId !!}"
                           data-href="{!! route('tf.map.banner.share.get') !!}"
                           title="{!! trans('frontend_map.banner_menu_share_title') !!}">
                            {!! trans('frontend_map.banner_menu_share_title') !!}
                        </a>
                    </td>

                    @if($loginStatus)
                        <?php
                        $loginUserId = $modelUser->loginUserId();
                        ?>
                        {{--user login is owner of banner--}}
                        @if($dataBanner->checkBannerOfUser($loginUserId, $bannerId))
                            {{--invite--}}
                            <td class="text-center">
                                <a class="tf_banner_invite_get tf-link-bold" data-banner="{!! $bannerId !!}"
                                   data-href="{!! route('tf.map.banner.invite.get') !!}"
                                   title="{!! trans('frontend_map.banner_menu_invite_title') !!}">
                                    {!! trans('frontend_map.banner_menu_invite_title') !!}
                                </a>
                            </td>

                            @if(count($dataBannerImage) == 0)
                                {{-- not exist image of banner--}}
                                <td class="text-center">
                                    <a class="tf_banner_image_add_get tf-link-bold" data-banner="{!! $bannerId !!}"
                                       data-href="{!! route('tf.map.banner.image.add.get') !!}">
                                        {!! trans('frontend_map.banner_menu_add_image') !!}
                                    </a>
                                </td>
                            @else
                                <td class="text-center">
                                    <a class="tf_banner_image_edit_get tf-link-bold" data-banner="{!! $bannerId !!}"
                                       data-href="{!! route('tf.map.banner.image.edit.get') !!}">
                                        {!! trans('frontend_map.banner_menu_edit_image') !!}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a class="tf_banner_image_delete tf-link-bold" data-banner="{!! $bannerId !!}"
                                       data-href="{!! route('tf.map.banner.image.delete') !!}">
                                        {!! trans('frontend_map.banner_menu_delete') !!}
                                    </a>
                                </td>
                            @endif
                        @else
                            @if(count($dataBannerImage) > 0)
                                <td class="text-center">
                                    <a class="tf_banner_image_report_get tf-link-bold"
                                       data-image="{!! $dataBannerImage->imageId() !!}"
                                       data-href="{!! route('tf.map.banner.image.report.get') !!}">
                                        {!! trans('frontend_map.banner_menu_report_image') !!}
                                    </a>
                                </td>
                            @endif
                        @endif
                    @endif
                    <td class="text-center">
                        <a class="tf-link-bold"
                           href="{!! route('tf.help','advertising-banner/activities') !!}" target="_blank"
                           title="{!! trans('frontend_map.banner_menu_help_title') !!}">
                            {!! trans('frontend_map.banner_menu_help_title') !!}
                        </a>
                    </td>
                </tr>

            </table>
        </div>
    </div>
@endsection
