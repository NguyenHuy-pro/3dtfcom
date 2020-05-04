<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelProject
 * modelProvinceArea
 * dataProject
 */
use Carbon\Carbon;
$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($modelStaff->checkDepartmentBuild($dataStaffLogin->staffId()) && $dataStaffLogin->level() == 1) $actionStatus = true;
$title = 'Project rule';
?>
@extends('manage.content.map.project.project.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>List project</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                <span>Total : {!! $modelProject->totalRecords()  !!}</span>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.map.project.status') !!}"
             data-href-view="{!! route('tf.m.c.map.project.view') !!}"
             data-href-del="{!! route('tf.m.c.map.project.delete') !!}">
            <table class="table table-hover ">
                <tr>
                    <th class="text-canter" style="width: 20px;">N_o</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Default</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if(count($dataProject) > 0)
                    <?php
                    $perPage = $dataProject->perPage();
                    $currentPage = $dataProject->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataProject as $projectObject)
                        <?php
                        $projectId = $projectObject->projectId();
                        $status = $projectObject->status();
                        ?>
                        <tr class="tf_object @if($n_o%2) info @endif" data-object="{!!  $projectId  !!}">
                            <td class="tf-vertical-middle tf-font-bold">
                                {!! $n_o +=1 !!}.
                            </td>
                            <td class="tf-vertical-middle" style="background-color: green;">
                                <img src="{!! $modelProject->pathIconImage($projectId) !!}">&nbsp;&nbsp;
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $projectObject->name() !!}
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $projectObject->nameCode() !!}
                            </td>
                            <td class="tf-vertical-middle">
                                @if($modelProvinceArea->checkCenter($projectObject->provinceId(), $projectObject->areaId()))
                                    <b>Center</b>
                                @else
                                    <em>Normal</em>
                                @endif
                            </td>
                            <td class="tf-vertical-middle">
                                <a class="@if($status == 1) tf-link-green-bold @else tf_object_status tf-link-grey @endif">
                                    On
                                </a>
                                |
                                <a class="@if($status == 0) tf-link-green-bold @else tf_object_status tf-link-grey @endif">
                                    Off
                                </a>
                            </td>

                            <td class="text-right tf-vertical-middle">
                                <a class="btn btn-default btn-xs tf-link  tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open"></i> View
                                </a>
                                <a class="btn btn-default btn-xs tf_object_delete">
                                    <i class="glyphicon glyphicon-trash tf-color"></i> Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="9">
                            <?php
                            $hFunction->page($dataProject);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection