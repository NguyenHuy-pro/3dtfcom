<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $dataBank
 *
 */
$hObject = new Hfunction();

?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Edit Country</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-10">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit" enctype="multipart/form-data"
              method="post" role="form"
              action="{!! route('tf.m.c.system.bank.edit.post',$dataBank->bankId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtName" value="{!! $dataBank->name() !!}"
                       placeholder="Enter name">
            </div>
            <div>
                <label class="control-label">Image:</label>
                <img class="form-control" style="width: 100px;height: 70px;" src="{!! $dataBank->pathImage() !!}">
            </div>
            <div class="form-group">
                <label class="control-label">New Image <span class="tf-color-red">*</span>:</label>
                <?php
                $hObject->selectOneImage('txtImage', 'txtImage');
                ?>
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