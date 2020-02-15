<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * modelPointType

 */
?>
@extends('manage.content.system.point-transaction.index')
@section('tf_m_c_container_object')
    <div class="col-md-12 text-center">
        <h3 class="tf-margin-30">Add transaction </h3>
    </div>
    <div class="col-md-12">
        <form class="tf_frm_add col-md-8 col-md-offset-2" name="tf_frm_add" method="post" role="form"
              action="{!! route('tf.m.c.system.point-transaction.add.post') !!}">
            @if (Session::has('notifyAddPointTransaction'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddPointTransaction') !!}
                    <?php
                    Session::forget('notifyAddPointTransaction');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Point type <span class="tf-color-red">*</span>:</label>
                <select class="form-control" name="cbPointType">
                    <option value="">Select</option>
                    {!! $modelPointType->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Point <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" name="txtPointValue"
                       placeholder="Enter point value (integer type)">
            </div>
            <div class="form-group">
                <label class="control-label">USD <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" name="txtUsdValue"
                       placeholder="Enter USD value (integer type)">
            </div>
            <div class="form-group">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.system.point-transaction.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>

        </form>
    </div>
@endsection