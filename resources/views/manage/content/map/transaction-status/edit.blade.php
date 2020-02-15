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
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-padding-30">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <h3 class="tf-margin-30">Edit transaction staus</h3>
        </div>
        <div class="col-md-12">
            @if(!empty($dataTransactionStatus))
                <form name="frmEdit" class="tf_frm_edit col-md-8 col-md-offset-2" method="post" role="form"
                      action="{!! route('tf.m.c.map.transactionStatus.edit.post',$dataTransactionStatus->statusId()) !!}">
                    <div class="form-group text-center tf_frm_notify tf-color-red"></div>
                    <div class="form-group">
                        <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                        <input type="text" class="form-control" name="txtName"
                               value="{!! $dataTransactionStatus->name() !!}" placeholder="Enter name">
                    </div>
                    <div class="form-group text-center">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <button type="button" class="tf_save btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection