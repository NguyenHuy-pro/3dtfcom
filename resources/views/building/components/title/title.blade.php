<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 5/24/2016
 * Time: 10:08 AM
 *
 * dataUserBuilding
 * dataBuilding
 * modelUser
 * dataBuildingBanner
 * dataBuildingAccess
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

# building info
$buildingId = $dataBuilding->buildingId();
$alias = $dataBuilding->alias();

$buildingSampleId = $dataBuilding->sampleId();

$userBuildingId = $dataUserBuilding->userId();

$ownerStatus = false;
if ($loginStatus) {
    if ($userLoginId == $userBuildingId) $ownerStatus = true;
}

?>
{{--banner content--}}
<div id="tf_building_title" class="row tf-building-title" data-building="{!! $buildingId !!}">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('building.components.banner.banner',
                      [
                          'modelUser' => $modelUser,
                          'dataBuilding'=>$dataBuilding,
                          'dataBuildingBanner' => $dataBuildingBanner,
                          'dataBuildingAccess'=>$dataBuildingAccess
                      ]
                  )
    </div>

    {{-- info --}}
    <div class="tf-building-info col-xs-12 col-sm-12 col-md-12 col-lg-12">
        {{-- name of building--}}
        <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1 class="tf-margin-none text-center">
            <span class="tf-color tf-font-bold tf-font-size-24">
                {!! $dataBuilding->name() !!}
            </span>
            </h1>
        </div>
        {{-- sample --}}
        <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
            <a href="{!! route('tf.building', $alias) !!}">
                <img alt="{!! $alias !!}" style="max-width: 100%;"
                     src="{!! $dataBuilding->buildingSample->pathImage() !!}">
            </a>
        </div>

        {{-- statistic --}}
        <div id="tf_building_menu_statistic"
             class="tf-building-menu-statistic col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a class="tf-link-bold" href="{!! route('tf.home', $alias) !!}">
                {!! trans('frontend_building.title_avatar_view_on_map') !!}
                <i class="fa fa-map-marker tf-link-green-bold tf-font-border-blue tf-font-size-30"></i>
            </a>
            &nbsp; &nbsp;
            <i class="fa fa-eye tf-icon"></i>
            {!! $dataBuilding->totalVisitHome() !!}
            &nbsp;<i class="tf-icon tf-color-grey">|</i>&nbsp;
            <i class="fa fa-heart tf-icon"></i>
            <span>{!! $dataBuilding->totalLove !!}</span> &nbsp;
            @if($loginStatus)
                @if ($modelUser->checkLoveBuilding($buildingId, $userLoginId))
                    <a class="tf_building_love tf-link-grey tf-icon fa fa-thumbs-o-up"
                       data-href="{!! route('tf.map.building.love.minus') !!}"></a>
                @else
                    <a class="tf_building_love tf-link tf-icon fa fa-thumbs-o-up"
                       data-href="{!! route('tf.map.building.love.plus') !!}"></a>
                @endif
            @endif
        </div>
    </div>

    {{-- contact --}}
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @include('building.components.contacts.contact', compact(
                        [
                            'modelUser' => $modelUser,
                            'dataBuilding' => $dataBuilding,
                            'dataBuildingAccess' => $dataBuildingAccess
                        ]
                    ))
        </div>
    </div>
</div>