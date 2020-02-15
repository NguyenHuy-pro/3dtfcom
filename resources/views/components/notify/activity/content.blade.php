<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/16/2016
 * Time: 5:02 PM
 *
 * modelBuilding
 * modelBuildingShare
 * modelBuildingComment
 * modelBannerShare
 * modelLandShare
 * modelBuildingLove
 *
 *
 */

?>
@extends('components.notify.notify-wrap')
@section('tf_notify_top')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <span class="fa fa-globe tf-font-size-14 tf-color-grey"></span>
        {!! trans('frontend.notify_activity_title') !!}
    </div>
@endsection

@section('tf_notify_content')
    <div class="row">
        <table class="table table-hover">
            @if(count($dataNotifyAction) > 0)
                @foreach($dataNotifyAction as $value)
                    <?php
                    $objectId = $value->objectId;
                    ?>
                    {{--notify add new building--}}
                    @if($value->object == 'addBuilding')
                        <?php
                        $dataBuilding = $modelBuilding->getInfo($objectId);
                        if(count($dataBuilding) > 0){
                        //info of user
                        $dataUserBuilding = $dataBuilding->userInfo();
                        $pathAvatar = $dataUserBuilding->pathSmallAvatar($dataUserBuilding->userId(), true);

                        // land id
                        $landId = $dataBuilding->landLicense->land->landId();
                        $dataProject = $dataBuilding->landLicense->land->project;
                        ?>
                        <tr class="tf_notify_action_object tf-border-bottom" data-building="{!! $objectId !!}">
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <img class="avatar tf-icon-50" alt="avatar-of-user" src="{!! $pathAvatar !!}">
                            </td>
                            <td class="col-xs-7 col-sm-7 col-md-7 col-lg-7 tf-padding-lef-none tf-padding-rig-none">
                                <a class="tf-link" href="{!! route('tf.user.home', $dataUserBuilding->alias()) !!}"
                                   target="_blank">
                                    {!! $dataUserBuilding->fullName() !!}
                                </a>
                                Built a new building
                            </td>
                            <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <a class="tf_notify_to_building tf-cursor-pointer"
                                   data-href-land="{!! route('tf.map.land.access') !!}"
                                   data-href-area="{!! route('tf.map.area.get') !!}"
                                   data-province="{!! $dataProject->provinceId() !!}"
                                   data-area="{!! $dataProject->areaId() !!}"
                                   data-land="{!! $landId !!}">
                                    <img alt="{!! $dataBuilding->alias() !!}" style="max-width: 50px; max-height: 50px"
                                         src="{!! $dataBuilding->buildingSample->pathImage() !!}">
                                </a>
                                <a class="tf_notify_hide_object glyphicon glyphicon-record pull-right tf-link-grey"
                                   title="Hide"
                                   data-href="{!! route('tf.notify.action.hide.building-new', $objectId) !!}"></a>
                            </td>
                        </tr>

                        <?php
                        }
                        ?>

                        {{--love building--}}
                    @elseif($value->object == 'loveBuilding')
                        <?php
                        $dataBuildingLove = $modelBuildingLove->getInfo($objectId);

                        $dataBuilding = $dataBuildingLove->building;
                        if(count($dataBuilding) > 0){
                        $dataUserLove = $dataBuildingLove->user;
                        $pathAvatar = $dataUserLove->pathSmallAvatar($dataUserLove->userId(), true);

                        # land id
                        $landId = $dataBuilding->landLicense->landId();
                        $dataProject = $dataBuilding->landLicense->land->project;
                        ?>
                        <tr class="tf_notify_action_object tf-border-bottom" data-love="{!! $objectId !!}">
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <img class="avatar tf-icon-50" alt="avatar-of-user" src="{!! $pathAvatar !!}">
                            </td>
                            <td class="col-xs7 col-sm-7 col-md-7 col-lg-7 tf-padding-lef-none tf-padding-rig-none">
                                <a class="tf-link" href="{!! route('tf.user.home', $dataUserLove->alias()) !!}"
                                   target="_blank">
                                    {!! $dataUserLove->fullName() !!}
                                </a>
                                loved building
                            </td>
                            <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <a class="tf_notify_to_building tf-cursor-pointer"
                                   data-href-land="{!! route('tf.map.land.access') !!}"
                                   data-href-area="{!! route('tf.map.area.get') !!}"
                                   data-province="{!! $dataProject->provinceId() !!}"
                                   data-area="{!! $dataProject->areaId() !!}"
                                   data-land="{!! $landId !!}">
                                    <img alt="{!! $dataBuilding->alias() !!}"
                                         style="max-width: 50px; max-height: 50px;"
                                         src="{!! $dataBuilding->buildingSample->pathImage() !!}">
                                </a>
                                <a class="tf_notify_hide_object glyphicon glyphicon-record pull-right tf-link-grey"
                                   title="Hide"
                                   data-href="{!! route('tf.notify.action.hide.building-love', $objectId) !!}"></a>
                            </td>
                        </tr>

                        <?php
                        }
                        ?>

                        {{--share building--}}
                    @elseif($value->object == 'shareBuilding')
                        <?php

                        # share info of building
                        $dataBuildingShare = $modelBuildingShare->getInfo($objectId);

                        # info of building
                        $dataBuilding = $dataBuildingShare->building;
                        if(count($dataBuilding) > 0){
                        #info of user
                        $dataUserShare = $dataBuildingShare->user;
                        $pathAvatar = $dataUserShare->pathSmallAvatar($dataUserShare->userId(), true);

                        # land id
                        $landId = $dataBuilding->landLicense->land->landId();
                        $dataProject = $dataBuilding->landLicense->land->project;
                        ?>
                        <tr class="tf_notify_action_object tf-border-bottom" data-love="{!! $objectId !!}">
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <a class="" href="#">
                                    <img class="avatar tf-icon-50" alt="avatar-of-user" src="{!! $pathAvatar !!}">
                                </a>
                            </td>
                            <td class="tf-padding-lef-none tf-padding-rig-none col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                <a class="tf-link-bold" href="{!! route('tf.user.home', $dataUserShare->alias()) !!}"
                                   target="_blank">
                                    {!! $dataUserShare->fullName() !!}
                                </a>
                                shared building "{!! $dataBuilding->name() !!}"
                            </td>
                            <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <a class="tf_notify_to_building tf-cursor-pointer"
                                   data-href-land="{!! route('tf.map.land.access') !!}"
                                   data-href-area="{!! route('tf.map.area.get') !!}"
                                   data-province="{!! $dataProject->provinceId() !!}"
                                   data-area="{!! $dataProject->areaId() !!}"
                                   data-land="{!! $landId !!}">
                                    <img alt="{!! $dataBuilding->alias() !!}"
                                         style="max-width: 50px; max-height: 50px;"
                                         src="{!! $dataBuilding->buildingSample->pathImage() !!}">
                                </a>
                                <a class="tf_notify_hide_object glyphicon glyphicon-record pull-right tf-link-grey"
                                   title="Hide" data-href="{!! route('tf.notify.action.hide.building-share', $objectId) !!}"></a>
                            </td>
                        </tr>

                        <?php
                        }
                        ?>

                        {{--comment building--}}
                    @elseif($value->object == 'commentBuilding')
                        <?php
                        $dataBuildingComment = $modelBuildingComment->getInfo($objectId);

                        $dataBuilding = $dataBuildingComment->building;
                        if(count($dataBuilding) > 0){
                        $dataUserComment = $dataBuildingComment->user;
                        $pathAvatar = $dataUserComment->pathSmallAvatar($dataUserComment->userId(), true);

                        # land id
                        $landId = $dataBuilding->landLicense->land->landId();
                        $dataProject = $dataBuilding->landLicense->land->project;
                        ?>

                        <tr class="tf_notify_action_object tf-border-bottom" data-love="{!! $objectId !!}">
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <img class="avatar tf-icon-50" alt="avatar-of-user" src="{!! $pathAvatar !!}">
                            </td>
                            <td class="tf-padding-lef-none tf-padding-rig-none col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                <a class="tf-link-bold" href="{!! route('tf.user.home', $dataUserComment->alias()) !!}"
                                   target="_blank">
                                    {!! $dataUserComment->fullName() !!}
                                </a>
                                comment on building '{!! $dataBuilding->name() !!}'
                            </td>
                            <td class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                <a class="tf_notify_to_building tf-cursor-pointer"
                                   data-href-land="{!! route('tf.map.land.access') !!}"
                                   data-href-area="{!! route('tf.map.area.get') !!}"
                                   data-province="{!! $dataProject->provinceId() !!}"
                                   data-area="{!! $dataProject->areaId() !!}"
                                   data-land="{!! $landId !!}">
                                    <img alt="{!! $dataBuilding->alias() !!}"
                                         style="max-width: 50px; max-height: 50px;"
                                         src="{!! $dataBuilding->buildingSample->pathImage() !!}">
                                </a>
                                <a class="tf_notify_hide_object glyphicon glyphicon-record pull-right tf-link-grey"
                                   title="Hide"
                                   data-href="{!! route('tf.notify.action.hide.comment', $objectId) !!}"></a>
                            </td>
                        </tr>

                        <?php
                        }
                        ?>

                        {{--share banner--}}
                    @elseif($value->object == 'shareBanner')
                        <?php
                        //share info
                        $dataBannerShare = $modelBannerShare->getInfo($objectId);

                        //banner info
                        $dataBanner = $dataBannerShare->banner;
                        if(count($dataBanner) > 0){
                        $bannerId = $dataBanner->bannerId();

                        //user info
                        $dataUserShare = $dataBannerShare->user;
                        $pathAvatar = $dataUserShare->pathSmallAvatar($dataUserShare->userId(), true);

                        //project info
                        $dataProject = $dataBanner->project;
                        ?>
                        <tr class="tf_notify_action_object tf-border-bottom" data-love="{!! $objectId !!}">
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <img class="avatar tf-icon-50" alt="avatar-of-user" src="{!! $pathAvatar !!}">
                            </td>
                            <td class="tf-padding-lef-none tf-padding-rig-none col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                <a class="tf-link" href="{!! route('tf.user.home', $dataUserShare->alias()) !!}"
                                   target="_blank">
                                    {!! $dataUserShare->fullName() !!}
                                </a>
                                shared banner " {!! $dataBanner->name() !!}"
                            </td>
                            <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <a class="tf_notify_to_banner tf-cursor-pointer"
                                   data-href-banner="{!! route('tf.map.banner.access') !!}"
                                   data-href-area="{!! route('tf.map.area.get') !!}"
                                   data-province="{!! $dataProject->provinceId() !!}"
                                   data-area="{!! $dataProject->areaId() !!}"
                                   data-banner="{!! $bannerId !!}">
                                    <img class="tf-icon-50" alt="banner" src="{!! $dataBanner->pathIconDefault() !!}">
                                </a>
                                <a class="tf_notify_hide_object glyphicon glyphicon-record pull-right tf-link-grey"
                                   title="Hide"
                                   data-href="{!! route('tf.notify.action.hide.banner-share', $objectId) !!}"></a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>

                        {{--share land--}}
                    @elseif($value->object == 'shareLand')
                        <?php
                        #share info
                        $dataLandShare = $modelLandShare->getInfo($objectId);
                        $landId = $dataLandShare->landId();

                        #land info
                        $dataLand = $dataLandShare->land;
                        if(count($dataLand) > 0){
                        #user info
                        $dataUserShare = $dataLandShare->user;
                        $pathAvatar = $dataUserShare->pathSmallAvatar($dataUserShare->userId(), true);

                        # project info
                        $dataProject = $dataLand->project;
                        ?>
                        <tr class="tf_notify_action_object tf-border-bottom" data-love="{!! $objectId !!}">
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <img class="avatar tf-icon-50" alt="avatar-of-user" src="{!! $pathAvatar !!}">
                            </td>
                            <td class="tf-padding-lef-none tf-padding-rig-none col-xs-7 col-sm-7 col-md-7 col-lg-7 ">
                                <a class="tf-link" href="{!! route('tf.user.home', $dataUserShare->alias()) !!}"
                                   target="_blank">
                                    {!! $dataUserShare->fullName() !!}
                                </a>
                                shared land " {!! $dataLand->name() !!}"
                            </td>
                            <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <a class="tf_notify_to_land tf-cursor-pointer"
                                   data-href-land="{!! route('tf.map.land.access') !!}"
                                   data-href-area="{!! route('tf.map.area.get') !!}"
                                   data-province="{!! $dataProject->provinceId() !!}"
                                   data-area="{!! $dataProject->areaId() !!}"
                                   data-land="{!! $landId !!}">
                                    <img class="" alt="land" style="max-width: 50px; max-height: 30px;"
                                         src="{!! $dataLand->pathIconDefault() !!}">
                                </a>
                                <a class="tf_notify_hide_object glyphicon glyphicon-record pull-right tf-link-grey"
                                   title="Hide"
                                   data-href="{!! route('tf.notify.action.hide.land-share', $objectId) !!}"></a>
                            </td>
                        </tr>

                        <?php
                        }
                        ?>

                        {{--building post--}}
                    @elseif($value->object == 'buildingPost')
                        <?php
                        //post info
                        $dataBuildingPost = $modelBuildingPost->getInfo($objectId);
                        if(count($dataBuildingPost) > 0){
                        $postCode = $dataBuildingPost->postCode();
                        $postContent = $dataBuildingPost->content();
                        $postImage = $dataBuildingPost->image();

                        //user info of the post
                        $dataUserPost = $dataBuildingPost->user;
                        $pathAvatar = $dataUserPost->pathSmallAvatar($dataUserPost->userId(), true);

                        //building info
                        $dataBuilding = $dataBuildingPost->building;
                        ?>

                        <tr class="tf_notify_action_object tf-border-bottom" data-love="{!! $objectId !!}">
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <img class="avatar tf-icon-50" alt="avatar-of-user" src="{!! $pathAvatar !!}">
                            </td>
                            <td class="tf-padding-lef-none tf-padding-rig-none col-xs-7 col-sm-7 col-md-7 col-lg-7 ">
                                <a class="tf-link-bold" href="{!! route('tf.user.home', $dataUserPost->alias()) !!}"
                                   target="_blank">
                                    {!! $dataUserPost->fullName() !!}
                                </a>
                                posted on
                                <a class="tf-link-bold"
                                   href="{!! route('tf.building.posts.detail.get', $postCode) !!}" target="_blank">
                                    {!! $dataBuilding->name() !!}
                                </a>
                            </td>
                            <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <a class="tf-cursor-pointer" href="{!! route('tf.building.posts.detail.get', $postCode) !!}"
                                   target="_blank">
                                    <img alt="{!! $dataBuilding->alias() !!}"
                                         style="max-width: 50px; max-height: 50px;"
                                         src="{!! $dataBuilding->buildingSample->pathImage() !!}">
                                </a>
                                <a class="tf_notify_hide_object glyphicon glyphicon-record pull-right tf-link-grey"
                                   title="Hide" data-href="{!! route('tf.notify.action.hide.building-post', $objectId) !!}"></a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    @endif
                @endforeach
            @endif
        </table>
    </div>
@endsection

@section('tf_notify_bottom')
    <a class="tf_main_wrap_remove tf-link-full tf-color-red tf-bg-hover">
        {!! trans('frontend.button_close') !!}
    </a>
@endsection