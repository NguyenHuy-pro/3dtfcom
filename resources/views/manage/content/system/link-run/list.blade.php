<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelLinkRun
 * $dataLinkRun
 */
$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Run link';
?>
@extends('manage.content.system.link-run.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelLinkRun->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.system.link-run.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.system.link-run.status') !!}"
             data-href-view="{!! route('tf.m.c.system.link-run.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.link-run.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.link-run.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Link</th>
                    <th class="text-center">Status</th>
                    <th></th>
                </tr>
                @if(count($dataLinkRun) > 0)
                    <?php
                    $perPage = $dataLinkRun->perPage();
                    $currentPage = $dataLinkRun->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataLinkRun as $itemLinkRun)
                        <?php
                        $linkId = $itemLinkRun->linkId();
                        $status = $itemLinkRun->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $linkId !!}">
                            <td class="text-center">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $itemLinkRun->name() !!}
                            </td>
                            <td>
                                {!! $itemLinkRun->description() !!}
                            </td>
                            <td>
                                {!! $itemLinkRun->link() !!}
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
                        <td class="text-center" colspan="6">
                            <?php
                            $hFunction->page($dataLinkRun);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection