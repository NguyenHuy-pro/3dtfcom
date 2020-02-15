<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $modelDepartment
 * $modelCountry
 *
 */

$hObject = new Hfunction();
?>
@extends('manage.content.system.staff.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
            <span class="fa fa-plus"></span>
            <span>New staff</span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-12 col-sm-12 col-md-12" enctype="multipart/form-data" name="tf_frm_add"
              method="POST" role="form" action="{!! route('tf.m.c.system.staff.add.post') !!}">
            @if (Session::has('notifyAddStaff'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddStaff') !!}
                    <?php
                    Session::forget('notifyAddStaff');
                    ?>
                </div>
            @endif
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <label class="control-label">First name <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" name="txtFirstName" placeholder="Enter first name">
                </div>
                <div class="form-group">
                    <label class="control-label">Last name <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" name="txtLastName" placeholder="Enter last name">
                </div>
                <div class="form-group">
                    <label class="control-label">Birthday <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" id="txtBirthday" name="txtBirthday"
                           placeholder="Enter birthday">
                    <script type="text/javascript">
                        tf_main.tf_setDatepicker('#txtBirthday');
                    </script>
                </div>
                <div class="form-group">
                    <label class="control-label">Gender<span class="tf-color-red">*</span>:</label>
                    <select class="form-control" name="cbGender">
                        <option value="">Select</option>
                        <option value="1">Male</option>
                        <option value="0">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Image <span class="tf-color-red">*</span>:</label>
                    <?php
                    $hObject->selectOneImage('txtImage', 'txtImage');
                    ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <label class="control-label">Level<span class="tf-color-red">*</span>:</label>
                    <select class="form-control" id="cbLevel" name="cbLevel">
                        <option value="">Select</option>
                        <option value="2"> Execute (2)</option>
                        <option value="1">Manage (1)</option>
                        <option value="0">Root</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Department<span class="tf-color-red">*</span>:</label>
                    <select class="form-control" id="cbDepartment" name="cbDepartment"
                            data-href="{!! route('tf.m.c.system.staff.manager.select') !!}">
                        <option value="">Select department</option>
                        {!! $modelDepartment->getOption() !!}
                    </select>
                </div>
                <div id="tf_m_c_staff_select_manage" class="form-group"></div>
                <div class="form-group">
                    <label class="control-label">Account <span class="tf-color-red">*</span>:</label>
                    <input type="email" class="form-control" name="txtAccount" placeholder="Enter account (email)">
                </div>
                <div class="form-group">
                    <label class="control-label">Confirm account <span class="tf-color-red">*</span>:</label>
                    <input type="email" class="form-control" name="txtConfirmAccount"
                           placeholder="Enter confrim account">
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <label class="control-label">Country<span class="tf-color-red">*</span>:</label>
                    <select class="form-control" id="cbCountry" name="cbCountry"
                            data-href="{!! route('tf.m.c.system.staff.province.select') !!}">
                        <option value="">Select</option>
                        {!! $modelCountry->getOption() !!}
                    </select>
                </div>
                <div id="tf_m_c_staff_select_province" class="form-group"></div>
                <div class="form-group">
                    <label class="control-label">Address:</label>
                    <input type="text" class="form-control" nametxtAddress="txtAddress" placeholder="Enter address">
                </div>
                <div class="form-group">
                    <label class="control-label">Phone :</label>
                    <input type="text" class="form-control" id="txtPhone" name="txtPhone"
                           placeholder="Enter phone number">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group text-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button type="button" class="tf_save btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="button" class="tf_page_back btn btn-default">Close</button>
                </div>
            </div>
        </form>
    </div>
@endsection