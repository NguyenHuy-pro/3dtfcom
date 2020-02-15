<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * modelStaff
 * dataSize
 * dataLandRequestBuildDesign
 */

$hFunction = new Hfunction();
?>
@extends('manage.content.components.container.contain-action-8')
@section('tf_m_c_action_content')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h3 class="tf-margin-30">Upload design</h3>
    </div>
    <div class="tf-padding-bot-20 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <form class="tf_frm_build_design_upload col-xs-12 col-sm-10 col-offset-1 col-md-8 col-md-offset-2"
              name="tf_frm_build_design_upload" method="post" role="form" enctype="multipart/form-data"
              action="{!! route('tf.m.c.sample.land_request_build_design.design.post', $dataLandRequestBuildDesign->designId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Standard size:</label>
                <input class="form-control" value="{!! $dataLandRequestBuildDesign->size->name() !!}">
            </div>
            <div class="form-group">
                <label class="control-label">Image <span class="tf-color-red">*</span>:</label>
                {!! $hFunction->selectOneImageFollowSize('fileImage','fileImage','','checkImgSize','',$dataLandRequestBuildDesign->size->width(),$dataLandRequestBuildDesign->size->height()) !!}
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
            </div>
        </form>
    </div>
@endsection