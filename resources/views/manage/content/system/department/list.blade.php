<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelDepartment
 */

$hFunction = new Hfunction();

#login info
$dataStaffLogin = $modelStaff->loginStaffInfo();
$level = $dataStaffLogin->level();

$actionStatus = false;
if ($level == 2) $actionStatus = true;
?>
@extends('manage.content.system.department.index')
@section('tf_m_c_map_container')
    <div class="row tf-m-c-container-object">
        <div class="col-md-12">
            <div class="col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>Department</span>
            </div>
        </div>
        <div class="col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-md-6 tf-line-height-40">
                Total : {!! $modelDepartment->totalRecords() !!}
            </div>
            <div class="col-md-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.system.department.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-md-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.system.department.status') !!}"
             data-href-view="{!! route('tf.m.c.system.department.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.department.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.department.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th class="text-center">Status</th>
                    <th class="text-right"></th>
                </tr>
                @if(count($dataDepartment) > 0)
                    <?php
                    $perPage = $dataDepartment->perPage();
                    $currentPage = $dataDepartment->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataDepartment as $itemDepartment)
                        <?php
                        $n_o = $n_o + 1;
                        $departmentId = $itemDepartment->departmentId();
                        $status = $itemDepartment->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $departmentId !!}">
                            <td class="text-center">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $itemDepartment->departmentCode() !!}
                            </td>
                            <td>
                                {!! $itemDepartment->name() !!}
                            </td>
                            <td class="text-center">
                                <span class="@if($status == 1) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    On
                                </span>
                                |
                                    <span class="@if($status == 0) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    Off
                                </span>
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($actionStatus)
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
                    <tr>
                        <td class="text-center" colspan="5">
                            <?php
                            $hFunction->page($dataDepartment);
                            ?>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="text-center" colspan="5">
                            Not found
                        </td>
                    </tr>

                @endif
            </table>
        </div>
    </div>
@endsection