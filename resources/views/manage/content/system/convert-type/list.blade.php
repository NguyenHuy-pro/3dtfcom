<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelConvertType
 * $dataConvertType
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Convert type';
?>
@extends('manage.content.system.business-type.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf-bg tf-color-white ">
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelConvertType->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.system.convert-type.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.system.convert-type.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.convert-type.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.convert-type.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th></th>
                </tr>
                @if(count($dataConvertType))
                    <?php
                    $perPage = $dataConvertType->perPage();
                    $currentPage = $dataConvertType->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataConvertType as $itemConvertType)
                        <tr class="tf_object" data-object="{!! $itemConvertType->typeId() !!}">
                            <td class="text-center">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $itemConvertType->name() !!}
                            </td>
                            <td>
                                {!! $itemConvertType->description() !!}
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
                        <td class="text-center" colspan="4">
                            <?php
                            $hFunction->page($dataConvertType);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection