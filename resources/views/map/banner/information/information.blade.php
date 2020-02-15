<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/23/2017
 * Time: 6:56 PM
 *
 *
 */
/*
 * modelUser
 * dataBanner
 * dataBannerImage
 */
$hFunction = new Hfunction();

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
<div class="tf_banner_information tf-banner-information tf-box-shadow" data-banner="{!! $bannerId !!}">
    <table class="table tf-height-full" style="border-collapse: collapse;">
        @if(count($dataLicenseInfo) > 0)
            <tr class="">
                <th class="text-center tf-bg col-xs-2 col-sm-2 col-md-1 col-lg-1 " style="border-top-left-radius: 5px;">
                    <a class="tf-link-white-bold" href="{!! route('tf.user.home',$licenseUserAlias) !!}" target="_blank"
                       title="{!! $userFullName !!}">
                        <img class="tf-icon-20" alt="{!! $licenseUserAlias !!}" src="{!! $pathAvatar !!}">
                    </a>

                </th>
                <th class="text-left tf-bg col-xs-10 col-sm-10 col-md-11 col-lg-11" style="border-top-right-radius: 5px;">
                    <a class="tf-link-white-bold" href="{!! route('tf.user.home',$licenseUserAlias) !!}" target="_blank"
                       title="{!! $userFullName !!}">
                        {!! $userFullName !!}
                    </a>
                </th>
            </tr>
        @else
            <tr>
                <th class="text-center tf-bg col-xs-2 col-sm-2 col-md-1 col-lg-1 " style="border-top-left-radius: 5px;">
                    <img class="tf-icon-20" alt="logo" src="{!! $pathAvatar !!}">
                </th>
                <th class="text-left tf-bg col-xs-10 col-sm-10 col-md-11 col-lg-11 " style="border-top-right-radius: 5px;">
                    <a class="tf-link-white-bold" href="#" target="_blank"
                       title="3dtf.com">
                        {!! trans('frontend.label_system_name') !!}
                    </a>
                </th>
            </tr>
        @endif
        <tr>
            <td class="text-center col-xs-2 col-sm-2 col-md-1 col-lg-1 ">
                <span class="glyphicon glyphicon-fullscreen tf-font-size-20"></span>
            </td>
            <td class="text-left col-xs-10 col-sm-10 col-md-11 col-lg-11 ">
                @if(empty($bannerImageId))
                    {!! trans('frontend.label_none') !!}
                @else
                    <a class="tf_detail tf-link" href="#">
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
            <td class="text-left col-xs-10 col-sm-10 col-md-11 col-lg-11">
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
            <td class="col-xs-2 col-sm-2 col-md-1 col-lg-1 text-center">
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
