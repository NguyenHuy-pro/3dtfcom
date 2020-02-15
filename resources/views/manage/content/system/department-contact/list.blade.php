<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelDepartmentContact
 * $dataDepartmentContact
 */
$hFunction = new Hfunction();

#login info
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Contact info of department';
?>
@extends('manage.content.system.department-contact.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelDepartmentContact->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.system.department-contact.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.system.department-contact.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.department-contact.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.department-contact.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th></th>
                </tr>
                @if(count($dataDepartmentContact)> 0)
                    <?php
                    $perPage = $dataDepartmentContact->perPage();
                    $currentPage = $dataDepartmentContact->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataDepartmentContact as $itemContact)
                        <?php
                        $n_o = $n_o + 1;
                        $contactId = $itemContact->contactId();
                        ?>
                        <tr class="tf_object" data-object="{!! $contactId !!}">
                            <td class="text-center">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $itemContact->email() !!}
                            </td>
                            <td>
                                {!! $itemContact->phone() !!}
                            </td>
                            <td>
                                {!! $itemContact->department->name() !!}
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
                            $hFunction->page($dataDepartmentContact);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection