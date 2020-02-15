<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelUserImageType
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();

#check action of level
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true; #level execute
?>
@extends('manage.content.user.image-type.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-Left tf-padding-20 tf-font-size-20 tf-font-bold col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <span class="fa fa-database"></span>
                <span>Image type</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="tf-line-height-40 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                Total : {!! $modelUserImageType->totalRecords() !!}
            </div>
            <div class=" tf-line-height-40 text-right col-xs-6 col-sm-6 col-md-6 col-lg-6">
                @if($actionStatus)
                    <a class="tf-link-white-bold btn btn-primary"
                       href="{!! route('tf.m.c.user.image-type.add.get') !!}">
                        <i class="fa fa-plus"></i> &nbsp; Add new
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.user.image-type.view') !!}"
             data-href-edit="{!! route('tf.m.c.user.image-type.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.user.image-type.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th></th>
                </tr>
                @if(count($dataImageType) > 0)
                    <?php
                    $perPage = $dataImageType->perPage();
                    $currentPage = $dataImageType->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataImageType as $imageType)
                        <tr class="tf_object" data-object="{!! $imageType->typeId() !!}">
                            <td>
                                {!! $n_o +=1 !!}.
                            </td>
                            <td>
                                {!! $imageType->name() !!}
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
                        <td class="text-center" colspan="3">
                            <?php
                            $hFunction->page($dataImageType);
                            ?>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="text-center tf-color-red" colspan="4">
                            <em>Not found</em>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection