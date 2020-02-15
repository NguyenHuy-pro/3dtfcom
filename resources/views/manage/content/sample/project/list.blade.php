<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelProjectSample
 * dataProjectSample
 */
$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
$actionStatus = false;
if ($dataStaffLogin->checkDepartmentDesign()) $actionStatus = true;

$level = $dataStaffLogin->level();
$title = 'Project sample';
?>
@extends('manage.content.sample.project.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf-bg tf-color-white ">
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelProjectSample->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                @if($actionStatus && $level == 1)
                    <a href="{!! route('tf.m.c.sample.project.add.get') !!}">
                        <button class="btn btn-primary btn-sm tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-publish-yes="{!! route('tf.m.c.sample.project.build.publish.yes') !!}"
             data-href-publish-no="{!! route('tf.m.c.sample.project.build.publish.no') !!}"
             data-href-build-finish="{!! route('tf.m.c.sample.project.build.finish') !!}"
             data-href-status="{!! route('tf.m.c.sample.project.status') !!}"
             data-href-view="{!! route('tf.m.c.sample.project.view') !!}"
             data-href-edit="{!! route('tf.m.c.sample.project.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.sample.project.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Sample</th>
                    <th>Staff</th>
                    <th>Publish</th>
                    <th>Status</th>
                    <th>Build</th>
                    <th></th>
                </tr>
                @if(count($dataProjectSample) > 0)
                    <?php
                    $perPage = $dataProjectSample->perPage();
                    $currentPage = $dataProjectSample->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataProjectSample as $projectSample)
                        <?php
                        $projectId = $projectSample->projectId();
                        $code = $projectSample->code();
                        $buildStatus = $projectSample->build();
                        $confirm = $projectSample->confirm();
                        $publish = $projectSample->publish();
                        $valid = $projectSample->valid();
                        $status = $projectSample->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $projectId !!}">
                            <td class="tf-vertical-middle">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td class="tf-vertical-middle">
                                <img style="width: 128px; height: 128px;" src="{!! $projectSample->pathSmallImage() !!}"
                                     alt="sample">
                                &nbsp;&nbsp;&nbsp;
                                <span>{!! $code !!}</span>
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $projectSample->staff->fullName() !!}
                            </td>
                            <td class="tf-vertical-middle">
                                @if($buildStatus == 0)
                                    @if($publish == 0)
                                        @if($confirm == 1)
                                            <em>Invalid</em>
                                        @else
                                            @if($level == 1)
                                                <a class="tf_object_publish_yes tf-link">Yes</a>
                                                |
                                                <a class="tf_object_publish_no tf-link">No</a>
                                            @else
                                                <em>Waiting publish</em>
                                            @endif
                                        @endif
                                    @else
                                        <em>Published</em>
                                    @endif
                                @else
                                    <em>Is building</em>
                                @endif

                            </td>
                            <td class="tf-vertical-middle">
                                <span class="@if($status == 1) tf-color-green tf-font-bold @else @if($actionStatus && $level ==1) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    On
                                </span>
                                |
                                    <span class="@if($status == 0) tf-color-green tf-font-bold @else @if($actionStatus && $level==1) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    Off
                                </span>
                            </td>
                            <td class="tf-vertical-middle">
                                @if($buildStatus == 1)
                                    @if($level == 2)
                                        <a class="tf_object_build_finish tf-link">Finish build</a>
                                    @else
                                        <em>Normal</em>
                                    @endif
                                @else
                                    <em>Normal</em>
                                @endif
                            </td>

                            <td class="text-right tf-vertical-middle">
                                <a class="btn btn-default btn-sm tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($actionStatus)
                                    @if($level == 2)
                                        <a class="btn btn-default btn-sm"
                                           href="{!! route('tf.m.c.sample.project.build.public',$projectId) !!}">
                                            <i class="glyphicon glyphicon-wrench tf-color"></i> Build
                                        </a>
                                    @elseif($level == 1)
                                        <a class="btn btn-default btn-sm tf_object_edit">
                                            <i class="glyphicon glyphicon-edit tf-color"></i> Edit info
                                        </a>
                                        <a class="btn btn-default btn-sm tf_object_delete">
                                            <i class="glyphicon glyphicon-trash tf-color"></i> Delete
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr class="odd gradeX" align="center">
                        <td colspan="7">
                            <?php
                            $hFunction->page($dataProjectSample);
                            ?>
                        </td>
                    </tr>
                @else
                    <tr align="center">
                        <td class="text-center" colspan="7">
                            <em>Not found</em>
                        </td>
                    </tr>
                @endif

            </table>
        </div>
    </div>
@endsection