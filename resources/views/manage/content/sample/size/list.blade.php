<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelStandard
 * modelSize
 * dataSize
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Size';
?>
@extends('manage.content.sample.size.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-4 col-sm-4 col-md-4 tf-line-height-40">
                Total : {!! $modelSize->totalRecords() !!}
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 tf-line-height-40 text-right">
                <select class="tf_filter_standard" data-href="{!! route('tf.m.c.sample.size.filter') !!}"  name="cbFilterStandard">
                    <option value="">All standard</option>
                    {!! $modelStandard->getOption((isset($filterStandardId))?$filterStandardId:'') !!}
                </select>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.sample.size.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.sample.size.status') !!}"
             data-href-view="{!! route('tf.m.c.sample.size.view') !!}"
             data-href-edit="{!! route('tf.m.c.sample.size.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.sample.size.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Name</th>
                    <th>Size(W\H)</th>
                    <th class="text-center">Icon</th>
                    <th class="text-center">Standard</th>
                    <th class="text-center">Status</th>
                    <th class="text-center"></th>
                </tr>
                @if(count($dataSize) >0)
                    <?php
                    $perPage = $dataSize->perPage();
                    $currentPage = $dataSize->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataSize as $itemSize)
                        <?php
                        $sizeId = $itemSize->sizeId();
                        $status = $itemSize->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $sizeId !!}" >
                            <td class="text-center">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $itemSize->name() !!}
                            </td>
                            <td>
                                ({!! $itemSize->width().' x '.$itemSize->height() !!})px
                            </td>
                            <td class="text-center">
                                <img style="max-width: 150px;max-height: 150px;"
                                     src="{!! $itemSize->pathImage() !!}">
                            </td>
                            <td class="text-center">
                                {!! $itemSize->standard->standardValue() !!}
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
                        <td class="text-center" colspan="7">
                            <?php
                            $hFunction->page($dataSize);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection