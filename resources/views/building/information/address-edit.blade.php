<?php
/*
 * modelUser
 * dataBuilding
 */
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
        <form id="tf_building_info_address_frm_edit" name="tfBuildingInfoAddressFrmEdit"
              class="tf_building_info_address_frm_edit form-horizontal "
              role="form" method='post' enctype="multipart/form-data"
              action="{!! route('tf.building.info.address.edit.post', $dataBuilding->buildingId()) !!}">
            <div class="form-group text-center"></div>
            <div class="form-group">
                <label>{!! trans('frontend_building.info_setting_edit_address_label') !!}</label>
                <input class="form-control" type="text" name="txtAddress" value="{!! $dataBuilding->address() !!}"
                       autofocus>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                <button class="tf_save btn btn-primary" type="button">
                    {!! trans('frontend.button_save') !!}
                </button>
                <button class="tf_main_contain_action_close btn btn-default" type="button">
                    {!! trans('frontend.button_cancel') !!}
                </button>
            </div>

        </form>
    </div>
@endsection