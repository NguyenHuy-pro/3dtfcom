<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $dataDepartmentContact
 *
 */

$hFunction = new Hfunction();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Edit department contact</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit"
              method="post" role="form"
              action="{!! route('tf.m.c.system.department-contact.edit.post',$dataDepartmentContact->contactId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Department <span class="tf-color-red">*</span>:</label>
                <select class="form-control" name="cbDepartment">
                    <option value="">Select</option>
                    {!! $dataDepartmentContact->department->getOption($dataDepartmentContact->departmentId()) !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Email <span class="tf-color-red">*</span>:</label>
                <input type="email" class="form-control" name="txtEmail"
                       value="{!! $dataDepartmentContact->email() !!}" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label class="control-label">Phone <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtPhone"
                       value="{!! $dataDepartmentContact->phone() !!}" placeholder="Enter phone number">
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