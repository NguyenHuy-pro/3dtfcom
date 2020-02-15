<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
$hObject = new Hfunction();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-md-12 text-center">
        <h3 class="tf-margin-30">Edit Country</h3>
    </div>
    <div class="col-md-12">
        <form class="tf_frm_edit col-md-8 col-md-offset-2" name="tf_frm_edit" enctype="multipart/form-data"
              method="post" role="form"
              action="{!! route('tf.m.c.system.country.edit.post',$dataCountry->countryId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtName" name="txtName"
                       value="{!! old('txtName',$dataCountry->name()) !!}" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Code of country <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtCode" name="txtCode"
                       value="{!! old('txtCode',$dataCountry->countryCode()) !!}" placeholder="Enter code">
            </div>
            <div class="form-group">
                <label class="control-label">Money unit <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtMoney" name="txtMoney"
                       value="{!!$dataCountry->moneyUnit() !!}" placeholder="Enter money unit">
            </div>
            <div>
                <label class="control-label">Flag <span class="tf-color-red">*</span>:</label>
                <img class="form-control" style="width: 100px;height: 70px;"
                     src="{!! $dataCountry->pathImage() !!}">
            </div>
            <div class="form-group">
                <label class="control-label">New flag <span class="tf-color-red">*</span>:</label>
                <?php
                $hObject->selectOneImage('txtFlag', 'txtFlag');
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
