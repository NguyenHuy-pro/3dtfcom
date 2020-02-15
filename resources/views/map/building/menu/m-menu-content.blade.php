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
 * dataBuilding
 */
$loginUserId = $modelUser->loginUserId();
#info of building
$buildingId = $dataBuilding->buildingId();
$dataLandLicense = $dataBuilding->landLicense;
$landId = $dataBuilding->landLicense->landId();

#get user id of land contain building
$dataBuildingUser = $dataBuilding->userInfo();
$buildingUserId = $dataBuildingUser->userId();
?>
@extends('components.container.contain-action-4')
@section('tf_main_action_content')
    <div class="tf_building_menu  panel panel-default tf-border-none tf-padding-none tf-margin-bot-none "
         data-building="{!! $buildingId !!}">
        <div class="panel-body  tf-padding-none">
            <table class="table table-hover tf-margin-padding-none" style="border-collapse: collapse;">
                @if($buildingUserId == $loginUserId)
                    <tr>
                        <td class="text-center">
                            <a class="tf_edit_info tf-link tf-link-full" data-href="{!! route('tf.map.building.info.edit.get', $buildingId) !!}">
                                {!! trans('frontend_map.building_menu_edit_info') !!}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <a class="tf_edit_sample tf-link tf-link-full"
                               data-href="{!! route('tf.map.building.sample.edit.get', $buildingId) !!}">
                                {!! trans('frontend_map.building_menu_edit_sample') !!}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <a class="tf_delete_building tf-link tf-link-full"
                               data-href="{!! route('tf.map.building.delete.get') !!}">
                                {!! trans('frontend_map.building_menu_delete') !!}
                            </a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="text-center">
                            <a class="tf-color-grey tf-link-full" data-href="#">
                                <i class="glyphicon glyphicon-flag tf-color-grey tf-font-size-14"></i>&nbsp;
                                {!! trans('frontend_map.building_menu_report_badInfo') !!}
                            </a>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection
