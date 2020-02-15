<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/10/2017
 * Time: 2:46 PM
 */

/*
 * modelUser
 * dataBuilding
 * dataBuildingBanner
 * dataUserBuilding
 */

# info of user login
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
    $userLoginId = null;
}

//building info
$buildingId = $dataBuilding->buildingId();

$userBuildingId = $dataUserBuilding->userId();
$ownerStatus = false;
if ($loginStatus) {
    if ($userLoginId == $userBuildingId) $ownerStatus = true;
}


?>
<div class="row">
    <div id="tf_building_title_banner"
         class="tf_building_title_banner tf-building-title-banner text-center col-xs-12 col-sm-12 col-md-12 col-lg-12"
         data-building="{!! $buildingId !!}">
        @if(count($dataBuildingBanner) == 0)
            <img class="tf-building-banner-image" alt="building-banner"
                 src="{!! $dataBuilding->pathBannerImageDefault() !!}"/>
        @else
            <img class="tf_building_banner_view tf-building-banner-image tf-link"
                 data-banner="{!! $dataBuildingBanner->bannerId() !!}"
                 data-href="{!! route('tf.building.banner.view.get') !!}" alt="{!! $alias !!}"
                 src="{!! $dataBuildingBanner->pathFullImage() !!}"/>
        @endif

        @if($loginStatus)
            @if($userLoginId == $userBuildingId)
                {{-- buildings owner --}}
                <div id="tf_building_banner_menu" class="tf-building-banner-menu">
                    <a class="dropdown-toggle tf-link tf-padding-4 tf-border-radius-5 tf-bg-whitesmoke"
                       data-toggle="dropdown">
                        <img class="tf-icon-20" alt="camera"
                             src="{!! asset('public\imgsample\Photograph.png') !!}">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right tf-box-shadow">
                        <li>
                            <a class="tf_banner_add_get tf-bg-hover tf-link-hover-white"
                               data-href="{!! route('tf.building.banner.add.get') !!}">
                                {!! trans('frontend_building.posts_banner_menu_image') !!}
                            </a>
                        </li>
                        @if(count($dataBuildingBanner) > 0)
                            <li>
                                <a class="tf_banner_delete tf-bg-hover tf-link-hover-white"
                                   data-banner="{!! $dataBuildingBanner->bannerId() !!}"
                                   data-href="{!! route('tf.building.banner.delete.get') !!}">
                                    {!! trans('frontend_building.posts_banner_menu_delete') !!}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

            @else
                {{--visit user--}}
                <ul class="tf-building-banner-menu nav nav-pills" role="tablist">
                    @if ($dataUserLogin->checkFollowBuilding($buildingId))
                        <li class="tf-padding-rig-4">
                            <a class="tf-link tf-bg-whitesmoke tf-padding-5 tf-border-radius-4 tf-border dropdown-toggle "
                               data-toggle="dropdown">{!! trans('frontend_building.building_following') !!}</a>
                            <ul class="dropdown-menu dropdown-menu-right tf-padding-none tf-box-shadow">
                                <li>
                                    <a class="tf_building_follow tf-bg-hover text-center"
                                       data-href="{!! route('tf.building.follow.minus') !!}">
                                        {!! trans('frontend_building.building_unFollowing') !!}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="tf-padding-rig-4">
                            <a class="tf_building_follow tf-link tf-bg-whitesmoke tf-padding-5 tf-border-radius-4 tf-border"
                               data-href="{!! route('tf.building.follow.plus') !!}"
                               title="click to follow building">
                                {!! trans('frontend_building.building_follow') !!}
                            </a>
                        </li>
                    @endif

                    <li class="tf-padding-rig-4">
                        <a class="tf-link tf-bg-whitesmoke tf-padding-5 tf-border-radius-4 tf-border dropdown-toggle "
                           data-toggle="dropdown">...</a>
                        <ul class="dropdown-menu dropdown-menu-right tf-padding-none tf-box-shadow">
                            <li>
                                <a class="tf_building_report_info tf-bg-hover text-center"
                                   data-building="{!! $buildingId !!}"
                                   data-href="{!! route('tf.building.report.bad-info.get') !!}">
                                    {!! trans('frontend_building.building_report_label') !!}
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>

            @endif
        @endif
    </div>
</div>
