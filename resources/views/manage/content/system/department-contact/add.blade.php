<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $modelDepartment
 */

$hFunction = new Hfunction();
?>
@extends('manage.content.system.department-contact.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Add contact</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_add"
              method="post" role="form"
              action="{!! route('tf.m.c.system.department-contact.add.post') !!}">
            @if (Session::has('notifyAddDepartmentContact'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddDepartmentContact') !!}
                    <?php
                    Session::forget('notifyAddDepartmentContact');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Department <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbDepartment" name="cbDepartment">
                    <option value="">Select</option>
                    {!! $modelDepartment->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Email <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtEmail" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label class="control-label">Phone <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtPhone" placeholder="Enter phone">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.system.department-contact.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection