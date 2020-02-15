<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $modelPaymentType
 * $modelBank
 * $dataPayment
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Edit Payment </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-20">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm-edit" method="post" role="form"
              action="{!! route('tf.m.c.system.payment.edit.post',$dataPayment->paymentId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Payment type <span class="tf-color-red">*</span>:</label>
                <select class="tf_payment_type form-control" name="cbPaymentType">
                    {!! $modelPaymentType->getOption($dataPayment->typeId()) !!}
                </select>
            </div>
            <div class="tf_container_bank form-group @if(is_null($dataPayment->bankId())) tf-display-none @endif">
                <label class="control-label">Bank <span class="tf-color-red">*</span>:</label>
                <select class="tf_bank form-control" name="cbBank">
                    {!! $modelBank->getOption($dataPayment->bank_id) !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Payment Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtPaymentName"
                       value="{!! $dataPayment->paymentName !!}" placeholder="Enter payment name">
            </div>
            <div class="form-group">
                <label class="control-label">Payment code <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtPaymentCode"
                       value="{!! $dataPayment->paymentCode !!}" placeholder="Enter payment code">
            </div>
            <div class="form-group">
                <label class="control-label">Contact Name \ Address <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtContactName"
                       value="{!! $dataPayment->contactName !!}" placeholder="Enter contact name">
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