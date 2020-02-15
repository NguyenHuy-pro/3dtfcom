<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 *
 * $modelPaymentType
 * $modelBank
 */

?>
@extends('manage.content.system.payment.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Add payment </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_add" method="post" role="form"
              action="{!! route('tf.m.c.system.payment.add.post') !!}">
            @if (Session::has('notifyAddPayment'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddPayment') !!}
                    <?php
                    Session::forget('notifyAddPayment');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Payment type <span class="tf-color-red">*</span>:</label>
                <select class="tf_payment_type form-control" name="cbPaymentType">
                    <option value="">Select</option>
                    {!! $modelPaymentType->getOption() !!}
                </select>
            </div>
            <div class="tf_container_bank form-group tf-display-none">
                <label class="control-label">Bank <span class="tf-color-red">*</span>:</label>
                <select class="tf_bank form-control" name="cbBank">
                    <option value="">Select</option>
                    {!! $modelBank->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Payment Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtPaymentName"
                       placeholder="Enter payment name">
            </div>
            <div class="form-group">
                <label class="control-label">Payment code <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtPaymentCode"
                       placeholder="Enter payment code">
            </div>
            <div class="form-group">
                <label class="control-label">Contact Name \ Address <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtContactName" name="txtContactName"
                       placeholder="Enter contact name">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.system.payment.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection