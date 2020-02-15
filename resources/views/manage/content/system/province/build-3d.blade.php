<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/12/2016
 * Time: 9:26 AM
 */
$hFunction = new Hfunction();
?>
@extends('manage.content.components.container.contain-action-8')
@section('tf_m_c_action_content')
    <div class="col-md-12 text-center">
        <h3 class="tf-margin-30">SELECT MANAGER </h3>
    </div>
    <div class="col-md-12">
        <form class="tf_frm_build3d col-md-8 col-md-offset-2" name="tf_frm_build3d" method="post" role="form"
              action="{!! route('tf.m.c.system.province.build3d.post',$provinceId) !!}">
            <div class="form-group text-center tf-color-red">
                (<em>You can not cancel when built, You click 'Accept' to build 3D</em>)
            </div>
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Manager <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbManager" name="cbManager">
                    <option value="">Select staff</option>
                    {!! $hFunction->option($dataStaff) !!}
                </select>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Accept</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
            </div>
        </form>
    </div>
@endsection
