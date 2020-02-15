<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * $modelBusinessType
 * modelBuildingSample
 * dataBuildingSample
 */
$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Building sample';
?>
@extends('manage.content.sample.building.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: #BFCAE6;">
            <div class="tf-line-height-40 col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                Total : {!! $modelBuildingSample->totalRecords() !!}
            </div>
            <div class="text-right tf-line-height-40 col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                <select class="tf_filter_business_type tf-padding-4"
                        data-href="{!! route('tf.m.c.sample.building.filter') !!}" name="cbFilterType">
                    <option value="">All business type</option>
                    {!! $modelBusinessType->getOption((isset($filterBusinessTypeId))?$filterBusinessTypeId:'') !!}
                </select>
            </div>
            <div class="tf-line-height-40 text-right col-xs-4 col-sm-4 col-md-4 ">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.sample.building.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12 "
             data-href-status="{!! route('tf.m.c.sample.building.status') !!}"
             data-href-view="{!! route('tf.m.c.sample.building.view') !!}"
             data-href-edit="{!! route('tf.m.c.sample.building.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.sample.building.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Size</th>
                    <th>Point</th>
                    <th>Business type</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if(count($dataBuildingSample) > 0)
                    <?php
                    $perPage = $dataBuildingSample->perPage();
                    $currentPage = $dataBuildingSample->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataBuildingSample as $itemBuildingSample)
                        <?php
                        $sampleId = $itemBuildingSample->sampleId();
                        $status = $itemBuildingSample->status;
                        ?>
                        <tr class="tf_object" data-object="{!! $sampleId !!}">
                            <td class="tf-vertical-middle">
                                {!! $n_o +=1 !!}.
                            </td>
                            <td class="tf-vertical-middle">
                                <img style="max-width: 96px;max-height: 96px;"
                                     src="{!! $itemBuildingSample->pathImage() !!}">
                                &nbsp; &nbsp; &nbsp;
                                <span>{!! $itemBuildingSample->name() !!}</span>
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $itemBuildingSample->size->name() !!}
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $itemBuildingSample->price !!}
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $itemBuildingSample->businessType->name() !!}
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
                        <td colspan="7">
                            <?php
                            $hFunction->page($dataBuildingSample);
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