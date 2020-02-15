<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $modelStaff
 * $modelDepartment
 * $modelStaffManage
 * $modelCountry
 * $modelProvince
 *
 */

$hFunction = new Hfunction();

#staff info
$staffId = $dataStaff->staffId();
$provinceId = $dataStaff->provinceId();
$departmentId = $dataStaff->departmentId();
$gender = $dataStaff->gender();
$level = $dataStaff->level();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Edit staff</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_m_c_system_staff_edit col-xs-12 col-sm-12 col-md-12" enctype="multipart/form-data"
              name="tf_m_c_system_staff_edit" method="POST"
              action="{!! route('tf.m.c.system.staff.edit.post',$staffId) !!}" role="form">
            <div class="form-group tf_frm_notify text-center tf-color-red">
                Develop later
            </div>

            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <label class="control-label">First name <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" name="txtFirstName" placeholder="Enter first name"
                           value="{!! $dataStaff->firstName() !!}">
                </div>
                <div class="form-group">
                    <label class="control-label">Last name <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" name="txtLastName" placeholder="Enter last name"
                           value="{!! $dataStaff->lastName() !!}">
                </div>
                <div class="form-group">
                    <label class="control-label">Birthday <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" id="txtBirthday" name="txtBirthday"
                           placeholder="Enter birthday" value="{!! $dataStaff->birthday() !!}">
                    <script type="text/javascript">
                        tf_main.tf_setDatepicker('#txtBirthday');
                    </script>
                </div>
                <div class="form-group">
                    <label class="control-label">Gender<span class="tf-color-red">*</span>:</label>
                    <select class="form-control" name="cbGender">
                        <option value="1" @if($gender == 1) selected="selected" @endif >Male</option>
                        <option value="0" @if($gender == 0) selected="selected" @endif >Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Image <span class="tf-color-red">*</span>:</label>
                    <?php
                    $hFunction->selectOneImage('txtImage', 'txtImage');
                    ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <label class="control-label">Level<span class="tf-color-red">*</span>:</label>
                    <select class="form-control" id="cbLevel" name="cbLevel">
                        <option value="2" @if($level == 2) selected="selected" @endif >Execute (2)</option>
                        <option value="1" @if($level == 1) selected="selected" @endif >Manage (1)</option>
                        <option value="0" @if($level == 0) selected="selected" @endif >Root</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Department<span class="tf-color-red">*</span>:</label>
                    <select class="form-control" id="cbDepartment" name="cbDepartment"
                            data-href="{!! route('tf.m.c.system.staff.manager.select') !!}">
                        {!! $modelDepartment->getOption($departmentId) !!}
                    </select>
                </div>
                <div id="tf_m_c_staff_select_manage" class="form-group">
                    @if($level > 1)
                        <?php
                        $dataManager = $modelStaff->infoManageByDepartment($departmentId);
                        $managerId = $modelStaff->manager($staffId);
                        ?>
                        <label class="control-label">Manager<span class="tf-color-red">*</span>:</label>
                        <select class="form-control" id="cbManageStaff" name="cbManageStaff">
                            {!! $hFunction->option($dataManager, $managerId) !!}
                        </select>
                    @endif
                </div>
                <div class="form-group">
                    <label class="control-label">Account <span class="tf-color-red">*</span>:</label>
                    <input type="email" class="form-control" name="txtAccount" disable="true"
                           value="{!! $dataStaff->account() !!}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <label class="control-label">Country<span class="tf-color-red">*</span>:</label>
                    <select class="form-control" id="cbCountry" name="cbCountry"
                            data-href="{!! route('tf.m.c.system.staff.province.select') !!}">
                        <option value="">Select</option>
                        {!! $modelCountry->getOption($modelProvince->countryId($provinceId)) !!}
                    </select>
                </div>
                <div id="tf_m_c_staff_select_province" class="form-group"></div>
                <div class="form-group">
                    <label class="control-label">Address:</label>
                    <input type="text" class="form-control" nametxtAddress="txtAddress"
                           value="{!! $dataStaff->address() !!}" placeholder="Enter address">
                </div>
                <div class="form-group">
                    <label class="control-label">Phone :</label>
                    <input type="text" class="form-control" id="txtPhone" name="txtPhone"
                           placeholder="Enter phone number" value="{!! $dataStaff->phone() !!}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group text-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button type="button" class="tf_save btn btn-primary">Update</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
                </div>
            </div>
        </form>
    </div>
@endsection