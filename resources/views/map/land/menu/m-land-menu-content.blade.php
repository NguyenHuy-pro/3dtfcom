<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/16/2016
 * Time: 8:41 AM
 *
 */

/*
 * $modelUser
 * $dataLand
 * dataLandLicense
 */
$hFunction = new Hfunction();

#user login
$dataUserLogin = $modelUser->loginUserInfo();

#land info
$landId = $dataLand->landId();
$loginStatus = $modelUser->checkLogin();

$dataLandLicense = $dataLand->licenseInfo();
?>
@extends('components.container.contain-action-10')
@section('tf_main_action_content')
    <ul class="list-group m_tf_land_menu_content tf-margin-padding-none">
        {{--help--}}
        <a class="list-group-item tf-link-hover-white tf-bg-hover"
           href="{!! route('tf.help', 'land/activities') !!}"
           title="{!! trans('frontend_map.land_menu_help_label') !!}"
           target="_blank">
            {!! trans('frontend_map.land_menu_help_label') !!}
        </a>

        {{--share--}}
        <a class="list-group-item tf_land_share_get tf-link-hover-white tf-bg-hover" data-land="{!! $landId !!}"
           data-href="{!! route('tf.map.land.share.get') !!}"
           title="{!! trans('frontend_map.land_menu_share_label') !!}">
            {!! trans('frontend_map.land_menu_share_label') !!}
        </a>

        {{--logged--}}
        @if($loginStatus)
            <?php
            $loginUserId = $modelUser->loginUserId();
            ?>
            {{--land of user--}}
            @if(count($dataLandLicense) > 0)
                <?php
                $landUserId = $dataLandLicense->userId();
                $licenseId = $dataLandLicense->licenseId();
                ?>
                {{--user login is owner of land--}}
                @if($landUserId == $loginUserId)
                    @if(!$dataLandLicense->existRequestBuild())
                        <a class="tf_land_build_building_sample_get tf-link-hover-white tf-bg-hover list-group-item"
                           data-land="{!! $landId !!}"
                           data-href="{!! route('tf.map.land.build.sample.get') !!}">
                            {!! trans('frontend_map.land_menu_build') !!}
                        </a>
                        <a class="tf_land_request_build tf-link list-group-item tf-border-top-none" data-license="{!! $licenseId !!}"
                           data-href="{!! route('tf.map.land.request-build.get') !!}">
                            {!! trans('frontend_map.land_menu_request_build') !!}
                        </a>
                    @else
                        <a class="tf-link-grey list-group-item" data-license="{!! $licenseId !!}"
                           title="Cancellation of construction requirement.">
                            Cancel build
                        </a>
                    @endif
                    @if($dataLandLicense->allowInvite())
                        @if($dataLandLicense->existInvite())
                            <a class="list-group-item tf-color-grey">
                                {!! trans('frontend_map.land_menu_invited_label') !!}
                            </a>
                        @else
                            <a class="tf_land_invite_get list-group-item tf-link-hover-white tf-bg-hover"
                               data-license="{!! $dataLandLicense->licenseId() !!}"
                               data-href="{!! route('tf.map.land.invite.get') !!}">
                                {!! trans('frontend_map.land_menu_invite_label') !!}
                            </a>
                        @endif
                    @endif
                @endif
            @endif
        @endif
    </ul>
@endsection
