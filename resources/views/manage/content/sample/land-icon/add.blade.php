<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * $modelSize
 * $modelTransactionStatus
 */

$hObject = new Hfunction();
$title = 'Add icon sample of project';
?>
@extends('manage.content.sample.land-icon.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30"> {!! $title !!}</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_add" enctype="multipart/form-data" method="post"
              role="form" action="{!! route('tf.m.c.sample.land-icon.add.post') !!}">
            @if (Session::has('notifyAddLandIconSample'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddLandIconSample') !!}
                    <?php
                    Session::forget('notifyAddLandIconSample');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Size standard <span class="tf-color-red">*</span>:</label>
                <select id="cbSize" class="tf_select_size form-control" name="cbSize"
                        data-href="{!! route('tf.m.c.sample.land-icon.image.select') !!}">
                    <option value="">Select</option>
                    {!! $modelSize->getOption() !!}
                </select>
            </div>
            <div class="tf_select_image form-group"></div>
            <div class="form-group">
                <label class="control-label">Transaction status <span class="tf-color-red">*</span>:</label>
                <select id="cbTransactionStatus" class="form-control" name="cbTransactionStatus">
                    <option value="">Select</option>
                    {!! $modelTransactionStatus->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Owner <span class="tf-color-red">*</span>:</label>
                <select id="cbOwnStatus" class="form-control" name="cbOwnStatus">
                    <option value="">Select</option>
                    <option value="0">Normal</option>
                    <option value="1">Owner</option>
                </select>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.sample.land-icon.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection