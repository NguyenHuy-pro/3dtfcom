<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $modelConvertType
 */
?>
@extends('manage.content.system.convert-point.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Add convert </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_add" method="post" role="form"
              action="{!! route('tf.m.c.system.convert-point.add.post') !!}">
            @if (Session::has('notifyAddConvertPoint'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddConvertPoint') !!}
                    <?php
                    Session::forget('notifyAddConvertPoint');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Point type <span class="tf-color-red">*</span>:</label>
                <select class="form-control" name="cbConvertType">
                    <option value="">Select</option>
                    {!! $modelConvertType->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Point <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" name="txtPoint"
                       placeholder="Enter point">
            </div>
            <div class="form-group">
                <label class="control-label">Convert point <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" name="txtConvertValue"
                       placeholder="Convert point">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.system.convert-point.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>

        </form>
    </div>
@endsection