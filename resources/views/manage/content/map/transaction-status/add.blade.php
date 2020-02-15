<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
?>
@extends('manage.content.map.transaction-status.index')
@section('tf_m_c_map_container')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <h3 class="tf-margin-30">Add transaction status </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-12 col-lg-offset-2" method="post"
              role="form" action="{!! route('tf.m.c.map.transactionStatus.add.post') !!}">
            @if (Session::has('notifyAddTransactionStatus'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddTransactionStatus') !!}
                    <?php
                    Session::forget('notifyAddTransactionStatus');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Enter name">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="button" class="tf_page_back btn btn-default">Close</button>
            </div>
        </form>
    </div>
@endsection