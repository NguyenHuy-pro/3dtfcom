<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/29/2016
 * Time: 4:02 PM
 *
 * $modelUser
 * $dataBuilding
 *
 */

$modelBileDetect = new Mobile_Detect();
$loginStatus = $modelUser->checkLogin();
if ($loginStatus) $loginUserId = $modelUser->loginUserId();

#info of building
$buildingId = $dataBuilding->buildingId();
$dataLandLicense = $dataBuilding->landLicense;
$landId = $dataLandLicense->landId();

#get user id of land contain building
$dataBuildingUser = $dataBuilding->userInfo();
$buildingUserId = $dataBuildingUser->userId();
?>
<ul class="nav nav-pills tf_building_menu_wrap tf-building-menu-wrap" role="tablist"
    data-building="{!! $buildingId  !!}">

    {{--to home --}}
    <li class="tf_building_menu tf-padding-rig-4">
        <a class="tf-building-menu-icon fa fa-home tf-link"
           href="{!! route('tf.building', $dataBuilding->alias()) !!}" target="_blank"
           title="{!! trans('frontend_map.building_menu_home_title') !!}"></a>
    </li>

    {{--help--}}
    <li class="tf_building_menu tf-padding-rig-4">
        <a class="tf-building-menu-icon glyphicon glyphicon-question-sign tf-link"
           href="{!! route('tf.help', 'building/activities') !!}" target="_blank"
           title="{!! trans('frontend_map.building_menu_help_title') !!}"></a>
    </li>

    {{--logged--}}
    @if($loginStatus)
        @if($buildingUserId == $loginUserId)
            <li class="tf_building_menu  tf-padding-rig-4">
                <a class="tf_map_building_invite_get tf-building-menu-icon  tf-link fa fa-gift"
                   data-license="{!! $dataLandLicense->licenseId() !!}"
                   data-href="{!! route('tf.map.land.invite.get') !!}"></a>
            </li>
        @endif
        @if(!$modelBileDetect->isMobile())
            {{--action--}}
            <li class="tf_building_menu">
                <a class="tf-building-menu-icon dropdown-toggle tf-link glyphicon glyphicon-cog"
                   data-toggle="dropdown" title="{!! trans('frontend_map.building_menu_setting_title') !!}"></a>
                <ul class="dropdown-menu tf-padding-none tf-box-shadow">
                    @if($buildingUserId == $loginUserId)
                        <li>
                            <a class="tf_edit_info tf-link"
                               data-href="{!! route('tf.map.building.info.edit.get', $buildingId) !!}">
                                {!! trans('frontend_map.building_menu_edit_info') !!}
                            </a>
                        </li>
                        <li>
                            <a class="tf_edit_sample tf-link"
                               data-href="{!! route('tf.map.building.sample.edit.get', $buildingId) !!}">
                                {!! trans('frontend_map.building_menu_edit_sample') !!}
                            </a>
                        </li>
                        <li>
                            <a class="tf-color-grey" data-href="#">
                                {!! trans('frontend_map.building_menu_request_design') !!}
                            </a>
                        </li>
                        <li>
                            <a class="tf_delete_building tf-link"
                               data-href="{!! route('tf.map.building.delete.get') !!}">
                                {!! trans('frontend_map.building_menu_delete') !!}
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="tf-color-grey" data-href="#">
                                <i class="glyphicon glyphicon-flag tf-color-grey tf-font-size-14"></i>&nbsp;
                                {!! trans('frontend_map.building_menu_report_badInfo') !!}
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @else
            <li>
                <a class="tf_building_menu_m_get tf-building-menu-icon tf-link glyphicon glyphicon-cog "
                   data-href="{!! route('tf.map.building.m-menu.get') !!}"></a>
            </li>
        @endif
    @endif
</ul>