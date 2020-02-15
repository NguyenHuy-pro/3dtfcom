<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelConvertPoint
 *
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Convert point';
?>
@extends('manage.content.system.convert-point.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-6 c0l-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelConvertPoint->totalRecords() !!}
            </div>
            <div class="col-xs-6 c0l-sm-6 col-md-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.system.convert-point.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.system.convert-point.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.convert-point.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.convert-point.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Convert Type</th>
                    <th>Point</th>
                    <th class="text-center">Convert point</th>
                    <th></th>
                </tr>
                @if(count($dataConvertPoint))
                    <?php
                    $perPage = $dataConvertPoint->perPage();
                    $currentPage = $dataConvertPoint->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataConvertPoint as $itemConvertPoint)
                        <tr class="tf_object" data-object="{!! $itemConvertPoint->convertId() !!}">
                            <td>
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $itemConvertPoint->convertType->name() !!}
                            </td>
                            <td>
                                {!! $itemConvertPoint->point() !!}
                            </td>
                            <td class="text-center">
                                {!! $itemConvertPoint->convertValue() !!}
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
                            $hFunction->page($dataConvertPoint);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection