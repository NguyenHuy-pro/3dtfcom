<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelBannerSample
 * dataBannerSample
 *
 */
$hFunction = new Hfunction();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Banner';
?>
@extends('manage.content.sample.banner.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelBannerSample->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.sample.banner.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.sample.banner.status') !!}"
             data-href-view="{!! route('tf.m.c.sample.banner.view') !!}"
             data-href-edit="{!! route('tf.m.c.sample.banner.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.sample.banner.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th >Size</th>
                    <th class="text-center">Border</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if(count($dataBannerSample) > 0)
                    <?php
                    $perPage = $dataBannerSample->perPage();
                    $currentPage = $dataBannerSample->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataBannerSample as $itemBannerSample)
                        <?php
                        $sampleId = $itemBannerSample->sampleId();
                        $status = $itemBannerSample->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $sampleId !!}">
                            <td class="text-center tf-vertical-middle">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td class="tf-vertical-middle">
                                <img style="width: 96px; height: 96px;"
                                     src="{!! $itemBannerSample->pathImage() !!}" alt="sample">
                                &nbsp;&nbsp;&nbsp;
                                <span>{!! $itemBannerSample->name() !!}</span>
                            </td>
                            <td class="tf-vertical-middle">
                                {!! $itemBannerSample->size->name() !!}
                            </td>
                            <td class="text-center tf-vertical-middle">
                                {!! $itemBannerSample->border() !!}
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
                        <td colspan="6">
                            <?php
                            $hFunction->page($dataBannerSample);
                            ?>
                        </td>
                    </tr>
                @else
                    <tr align="center">
                        <td class="text-center" colspan="6">
                            <em>Not found</em>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection