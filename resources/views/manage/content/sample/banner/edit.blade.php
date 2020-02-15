<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * dataBannerSample
 */
$hObject = new Hfunction();
$title = 'Edit banner sample';
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">{!! $title !!} </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-20">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit"
              enctype="multipart/form-data" method="post" role="form"
              action="{!! route('tf.m.c.sample.banner.edit.post',$dataBannerSample->sampleId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group text-center">
                <img style="max-width: 128px;max-height: 128px;" src="{!! $dataBannerSample->pathImage() !!}">
                <br/>({!! $dataBannerSample->size->name() !!})px
            </div>
            <div class="form-group">
                <label class="control-label">Border <span class="tf-color-red">*</span>:</label>
                <input class="form-control" type="number" name="txtBorder"
                       value="{!! $dataBannerSample->border() !!}" placeholder="enter number type">
            </div>
            <div class="form-group">
                <?php
                $dataSize = $dataBannerSample->size;
                ?>
                @include('manage.content.sample.banner.select-image',compact('dataSize'))
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