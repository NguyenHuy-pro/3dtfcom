<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Edit convert </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-10">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offser-1 col-md-8 col-md-offset-2" name="tf_frm_edit" method="post" role="form"
              action="{!! route('tf.m.c.system.convert-point.edit.post',$dataConvertPoint->convertId()) !!}">
            <div class="form-group">
                <label class="control-label">Convert type <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" disabled="true"
                       value="{!! $dataConvertPoint->convertType->name() !!}">
            </div>
            <div class="form-group">
                <label class="control-label">Point <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtPoint"
                       value="{!! $dataConvertPoint->point() !!}" placeholder="Enter point ">
            </div>
            <div class="form-group">
                <label class="control-label">Convert point <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtConvertValue"
                       value="{!! $dataConvertPoint->convertValue() !!}" placeholder="Enter convert point">
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