<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelNotify
 */

$hFunction = new Hfunction();

$actionStatus = false;
$dataStaffLogin = $modelStaff->loginStaffInfo();
if ($dataStaffLogin->level() == 2) $actionStatus = true;
?>
@extends('manage.content.system.notify.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>Notification</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 " style="background-color: #BFCAE6;">
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelNotify->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                <a class="tf-link-bold" href="{!! route('tf.m.c.system.notify.add.get') !!}">
                    <i class="fa fa-plus"></i> &nbsp;Add new
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-view="{!! route('tf.m.c.system.notify.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.notify.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.notify.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th >Name</th>
                    <th class="tf-width-200 text-right"></th>
                </tr>
                @if(count($dataNotify) > 0)
                    <?php
                    $perPage = $dataNotify->perPage();
                    $currentPage = $dataNotify->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage;
                    ?>
                    @foreach($dataNotify as $notifyObject)
                        <?php
                        $n_o = $n_o + 1;
                        $notifyId = $notifyObject->notifyId();
                        ?>
                        <tr class="tf_object" data-object="{!! $notifyId !!}">
                            <td class="text-center tf-font-bold">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $notifyObject->name() !!}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                                @if($actionStatus)
                                    <a class="btn btn-default btn-xs tf_object_edit">
                                        <i class="glyphicon glyphicon-edit tf-color"></i> Edit
                                    </a>
                                    <a class="btn btn-default btn-xs tf_object_delete tf-link">
                                        <i class="glyphicon glyphicon-trash"></i> Delete
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="3">
                            <?php
                            $hFunction->page($dataNotify);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection