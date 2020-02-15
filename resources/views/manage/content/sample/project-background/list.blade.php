<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelProjectBackground
 * dataProjectBackground
 */
$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Project background';
?>
@extends('manage.content.sample.project-background.index')
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
                Total : {!! $modelProjectBackground->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.sample.project-background.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.sample.project-background.status') !!}"
             data-href-view="{!! route('tf.m.c.sample.project-background.view') !!}"
             data-href-edit="{!! route('tf.m.c.sample.project-background.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.sample.project-background.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if(count($dataProjectBackground) > 0)
                    <?php
                    $perPage = $dataProjectBackground->perPage();
                    $currentPage = $dataProjectBackground->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataProjectBackground as $projectBackground)
                        <?php
                        $backgroundId = $projectBackground->backgroundId();
                        $status = $projectBackground->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $backgroundId !!}">
                            <td class="tf-vertical-middle">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td class="tf-vertical-middle">
                                <img style="width: 96px;max-height: 96px;"
                                     src="{!! $projectBackground->pathSmallImage() !!}">
                            </td>
                            <td class="tf-vertical-middle">
                                <span class="@if($status == 1) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    On
                                </span>
                                |
                                <span class="@if($status == 0) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    Off
                                </span>
                            </td>
                            <td class="text-right tf-vertical-middle">
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
                    <tr class="odd gradeX" align="center">
                        <td colspan="4">
                            <?php
                            $hFunction->page($dataProjectBackground);
                            ?>
                        </td>
                    </tr>
                @else
                    <tr align="center">
                        <td class="text-center" colspan="4">
                            <em>Not found</em>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection