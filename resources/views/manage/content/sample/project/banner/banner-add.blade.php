<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 1/19/2017
 * Time: 4:25 PM
 */
$hFunction = new Hfunction();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-md-12 tf-padding-50">
        <form id="frmProjectSampleBannerAdd" name="frmProjectSampleBannerAdd" class="col-md-8 col-md-offset-2"
              method="post" role="form"
              action="{!! route('tf.m.c.sample.project.build.banner.add.post') !!}">
            <div class="form-group text-center">
                <h3>Add banner</h3>
            </div>
            {{--only apply for sale status and free status--}}
            <div class="form-group">
                <label class="control-label">Transaction status <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbTransactionStatus" name="cbTransactionStatus">
                    {!! $hFunction->option($dataBannerAdd['dataTransactionStatus'],2) !!}
                </select>
            </div>

            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="hidden" id="txtProject" name="txtProject" value="{!! $dataProjectSample->projectId() !!}">
                <input type="hidden" id="txtBannerSample" name="txtBannerSample"
                       value="{!! $dataBannerSample->sampleId() !!}">
                <input type="hidden" id="txtTopPosition" name="txtTopPosition"
                       value="{!! $dataBannerAdd['topPosition'] !!}">
                <input type="hidden" id="txtLeftPosition" name="txtLeftPosition"
                       value="{!! $dataBannerAdd['leftPosition'] !!}">
                <button type="button" class="tf_save btn btn-primary">Add</button>
                <button type="button" class="tf_m_c_container_close btn btn-default">Cancel</button>
            </div>
        </form>
    </div>
@endsection