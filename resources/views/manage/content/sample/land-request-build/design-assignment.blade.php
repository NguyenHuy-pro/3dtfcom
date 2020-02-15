<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * modelStaff
 * dataStaff
 * DataLandRequestBuild
 */

$hObject = new Hfunction();
?>
@extends('manage.content.components.container.contain-action-8')
@section('tf_m_c_action_content')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h3 class="tf-margin-30">Design assignment </h3>
    </div>
    <div class="tf-padding-bot-20 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <form class="tf_frm_design_assignment col-xs-12 col-sm-10 col-offset-1 col-md-8 col-md-offset-2"
              name="tf_frm_design_assignment" method="post" role="form"
              action="{!! route('tf.m.c.sample.land_request_build.assignment.post',$dataLandRequestBuild->requestId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>

            <div class="form-group">
                <label class="control-label">Designer<span class="tf-color-red">*</span>:</label>
                <select id="cbDesigner" class="form-control" name="cbDesigner">
                    <option value="">Select designer</option>
                    @if(count($dataStaff) > 0)
                        @foreach($dataStaff as $staff)
                            <option value="{!! $staff->staffId() !!}">
                                {!! $staff->fullName() !!}
                            </option>
                        @endforeach
                    @else
                        <option value="">Null</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Land size:</label>
                <input class="form-control" readonly
                       value="{!! $dataLandRequestBuild->landLicense->land->size->name() !!}">
            </div>
            <div class="form-group">
                <label class="control-label">Request sample:</label>
                <br/>
                <img style="max-height: 150px;max-height: 150px;" src="{!! $dataLandRequestBuild->pathImage() !!}"
                     alt="sample">
            </div>
            <div class="form-group">
                <label class="control-label">Design size<span class="tf-color-red">*</span>:</label>
                <select class="tf_select_size form-control" name="cbSize">
                    <option value="">Standard size</option>
                    @if(count($dataSize) > 0)
                        @foreach($dataSize as $size)
                            <option value="{!! $size->sizeId() !!}">
                                {!! $size->name() !!}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
            </div>
        </form>
    </div>
@endsection