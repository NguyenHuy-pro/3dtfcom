<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * dataAdsPosition
 */
$title = 'Edit info';

$width = $dataAdsPosition->width();
$adsStandard = [120, 125, 160, 180, 200, 234, 250, 300, 320, 366, 468, 580, 728, 750, 930, 970, 980];
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h3 class="tf-margin-30">{!! $title !!}</h3>
    </div>
    <div class="tf-padding-bot-20 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit"
              method="post" role="form"
              action="{!! route('tf.m.c.ads.position.edit.post',$dataAdsPosition->positionId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtName"
                       value="{!! $dataAdsPosition->name() !!}" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Width size <span class="tf-color-red">*</span>:</label>
                <select name="cbWidth" class="form-control">
                    @foreach($adsStandard as $value)
                        <option value="{!! $value !!}"
                                @if($value == $width) selected="selected" @endif>{!! $value !!}</option>
                    @endforeach
                </select>
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