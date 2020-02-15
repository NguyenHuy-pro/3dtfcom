<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $dataStaff
 *
 */

$hFunction = new Hfunction();

#login info
$dataStaffLogin = $modelStaff->loginStaffInfo();
$level = $dataStaffLogin->level();

$actionStatus = false;
if ($level == 2) $actionStatus = true;
?>
@extends('manage.content.system.staff.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <label>Staff</label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                    Total : {!! $modelStaff->totalRecords() !!}
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                    @if($actionStatus)
                        <a href="{!! route('tf.m.c.system.staff.add.get') !!}">
                            <button class="btn btn-primary tf-link-white-bold">
                                <i class="fa fa-plus"></i> &nbsp; Add new
                            </button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.system.staff.status') !!}"
             data-href-view="{!! route('tf.m.c.system.staff.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.staff.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.staff.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Code</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Account</th>
                    <th>Level</th>
                    <th class="text-center">New</th>
                    <th class="text-center">Confirm</th>
                    <th class="text-center">Status</th>
                    <th class="tf-width-300"></th>
                </tr>
                @if(count($dataStaff))
                    <?php
                    $perPage = $dataStaff->perPage();
                    $currentPage = $dataStaff->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataStaff as $itemStaff)
                        <?php
                        $n_o = $n_o + 1;
                        $staffId = $itemStaff->staffId();
                        $level = $itemStaff->level();
                        $confirm = $itemStaff->confirm();
                        $new = $itemStaff->newInfo();
                        $status = $itemStaff->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $staffId !!}">
                            <td class="text-center">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $itemStaff->nameCode() !!}
                            </td>
                            <td>
                                {!! $itemStaff->firstName() !!}
                            </td>
                            <td>
                                {!! $itemStaff->lastName() !!}
                            </td>
                            <td>
                                {!! $itemStaff->account() !!}
                            </td>
                            <td>
                                <em>
                                    @if($level === 0)
                                        Root
                                    @elseif($level === 1)
                                        Manage
                                    @else
                                        Execute
                                    @endif
                                </em>
                            </td>
                            <td class="text-center">
                                @if($new == 1)
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($confirm == 1)
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="@if($status == 1) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    On
                                </span>
                                @if($level > 0)
                                    |
                                    <span class="@if($status == 0) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    Off
                                </span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($actionStatus && $level > 0)
                                    <a class="btn btn-default btn-xs tf_object_edit">
                                        <i class="glyphicon glyphicon-edit tf-color"></i> Edit
                                    </a>
                                    <a class="btn btn-default btn-xs tf_object_delete">
                                        <i class="glyphicon glyphicon-trash tf-color"></i> Delete
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr class="odd gradeX" align="center">
                        <td colspan="10">
                            <?php
                            $hFunction->page($dataStaff);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection