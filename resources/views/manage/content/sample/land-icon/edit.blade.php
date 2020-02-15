<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * modelTransactionStatus
 * dataLandIconSample
 */

$hObject = new Hfunction();
$title = 'Edit banner sample';
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Edit icon sample of land </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-20">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit"
              enctype="multipart/form-data" method="post" role="form"
              action="{!! route('tf.m.c.sample.land-icon.edit.post',$dataLandIconSample->sample_id) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group text-center">
                <img style="max-width: 128px;max-height: 128px;" src="{!! $dataLandIconSample->pathImage() !!}">
                <br/>({!! $dataLandIconSample->size->name() !!})px
            </div>
            <div class="form-group">
                <?php
                $dataSize = $dataLandIconSample->size;
                ?>
                @include('manage.content.sample.land-icon.select-image',compact('dataSize'))
            </div>
            <div class="form-group">
                <label class="control-label">Transaction status <span class="tf-color-red">*</span>:</label>
                <select id="cbTransactionStatus" class="form-control" name="cbTransactionStatus">
                    {!! $modelTransactionStatus->getOption($dataLandIconSample->transactionStatusId()) !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Owner <span class="tf-color-red">*</span>:</label>
                <select id="cbOwnStatus" class="form-control" name="cbOwnStatus">
                    <option value="0" @if($dataLandIconSample->ownStatus() == 0) selected="selected" @endif >Normal
                    </option>
                    <option value="1" @if($dataLandIconSample->ownStatus() == 1) selected="selected" @endif >Owner
                    </option>
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