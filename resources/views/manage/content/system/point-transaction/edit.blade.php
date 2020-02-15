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
    <div class="col-md-12 text-center">
        <h3 class="tf-margin-30">Edit point transaction </h3>
    </div>
    <div class="col-md-12 tf-padding-bot-10">
        <form class="tf_frm_edit col-md-8 col-md-offset-2" name="tf_frm_edit" method="post" role="form"
              action="{!! route('tf.m.c.system.point-transaction.edit.post',$dataPointTransaction->transactionId()) !!}">
            <div class="form-group">
                <label class="control-label">Point type <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" disabled="true"
                       value="{!! $dataPointTransaction->pointType->name() !!}">
            </div>
            <div class="form-group">
                <label class="control-label">Point <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtPointValue"
                       value="{!! $dataPointTransaction->pointValue() !!}" placeholder="Enter point value">
            </div>
            <div class="form-group">
                <label class="control-label">USD <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtUsdValue"
                       value="{!! $dataPointTransaction->usdValue() !!}" placeholder="Enter USD value">
            </div>
            <div class="form-group">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
            </div>
        </form>
    </div>
@endsection