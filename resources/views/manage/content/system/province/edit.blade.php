<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $modelStaff
 * modelProvinceType
 * modelCountry
 * dataProvince
 *
 */


?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Edit Province </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_edit col-md-8 col-md-offset-2" name="tf_frm_edit" method="post" role="form"
              action="{!! route('tf.m.c.system.province.edit.post',$dataProvince->provinceId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Country <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbCountry" name="cbCountry">
                    <option value="">Select country</option>
                    {!! $modelCountry->getOption($dataProvince->countryId()) !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Province type <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbProvinceType" name="cbProvinceType">
                    <option value="">Select</option>
                    {!! $modelProvinceType->getOption($dataProvince->typeId()) !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtName" name="txtName" value="{!! $dataProvince->name() !!}"
                       placeholder="Enter name">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
            </div>
        </form>
    </div>
@endsection
