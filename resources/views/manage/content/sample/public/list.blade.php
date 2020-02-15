<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelPublicType
 * $modelPublicSample
 * dataPublicSample
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Public sample';
?>
@extends('manage.content.sample.public.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf-bg">
            <div class="col-xs-4 col-sm-4 col-md-4 tf-line-height-40 tf-color-white">
                Total : {!! $modelPublicType->totalRecords() !!}
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 text-right tf-line-height-40">
                <select class="tf_filter_public_type tf-padding-4"
                        data-href="{!! route('tf.m.c.sample.public.filter') !!}" name="cbFilterType">
                    <option value="">All public type</option>
                    {!! $modelPublicType->getOption((isset($filterPublicTypeId))?$filterPublicTypeId:'') !!}
                </select>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.sample.public.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.sample.public.status') !!}"
             data-href-view="{!! route('tf.m.c.sample.public.view') !!}"
             data-href-edit="{!! route('tf.m.c.sample.public.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.sample.public.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th class="text-center">Image</th>
                    <th></th>
                    <th>Size</th>
                    <th>Public type</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if(count($dataPublicSample) > 0)
                    <?php
                    $perPage = $dataPublicSample->perPage();
                    $currentPage = $dataPublicSample->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataPublicSample as $itemPublicSample)
                        <?php
                        $sampleId = $itemPublicSample->sampleId();
                        $status = $itemPublicSample->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $sampleId !!}">
                            <td class="tf-vertical-middle">
                                {!! $n_o +=1 !!}.
                            </td>
                            <td class="text-center tf-vertical-middle">
                                <img style="max-width: 128px;max-height: 128px;" src="{!! $itemPublicSample->pathImage() !!}">
                            </td>
                            <td class="tf-vertical-middle">
                                <span>{!! $itemPublicSample->name() !!}</span>
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $itemPublicSample->size->name() !!}
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $itemPublicSample->publicType->name() !!}
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
                            $hFunction->page($dataPublicSample);
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