<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $modelStaff
 * $modelProvinceType
 * $modelCountry
 */


$hFunction = new Hfunction();
?>
@extends('manage.content.system.province.index')
@section('tf_m_c_container_object')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h3 class="tf-margin-30">Add Province </h3>
    </div>
    <div class="col-md-12">
        <form class="tf_frm_add col-md-8 col-md-offset-2" name="tf_frm_add" method="post" role="form"
              action="{!! route('tf.m.c.system.province.add.post') !!}">
            @if (Session::has('notifyAddProvince'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddProvince') !!}
                    <?php
                    Session::forget('notifyAddProvince');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Country <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbCountry" name="cbCountry">
                    <option value="">Select country</option>
                    {!! $modelCountry->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Province type <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbProvinceType" name="cbProvinceType">
                    <option value="">Select type</option>
                    {!! $modelProvinceType->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Enter name">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.system.province.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection