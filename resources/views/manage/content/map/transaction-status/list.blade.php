<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelTransactionStatus
 * dataTransactionStatus
 */
$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();

#check action of level
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true; #level execute
?>
@extends('manage.content.map.transaction-status.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>Transaction status</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40">
                Total : {!! $modelTransactionStatus->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a class="tf-link-bold" href="{!! route('tf.m.c.map.transactionStatus.add.get') !!}">
                        Add new
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_list_object"
             data-href-edit="{!! route('tf.m.c.map.transactionStatus.edit.get') !!}"
             data-href-status="{!! route('tf.m.c.map.transactionStatus.status') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Name</th>
                    <th class="text-center">Status</th>
                    <th class="tf-width-100"></th>
                </tr>
                @if(count($dataTransactionStatus) > 0)
                    <?php
                    $perPage = $dataTransactionStatus->perPage();
                    $currentPage = $dataTransactionStatus->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataTransactionStatus as $itemTransactionStatus)
                        <?php
                        $n_o = $n_o + 1;
                        $transactionStatusId = $itemTransactionStatus->statusId();
                        $status = $itemTransactionStatus->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $transactionStatusId !!}">
                            <td class="text-center tf-font-bold">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $itemTransactionStatus->name() !!}
                            </td>
                            <td class="text-center ">

                                <span class="@if($status == 1) tf-color-green tf-font-bold @else  @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif  @endif">
                                    On
                                </span>
                                |
                                <span class="@if($status == 0) tf-color-green tf-font-bold @else @if($actionStatus) tf_object_status tf-link-grey @else tf-color-grey @endif @endif">
                                    Off
                                </span>


                            </td>
                            <td class="text-center">
                                @if($actionStatus)
                                    <a class="btn btn-default btn-xs tf_object_edit">
                                        <i class="glyphicon glyphicon-edit tf-color"></i> Edit
                                    </a>
                                @else
                                    <em>---</em>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="4">
                            <?php
                            $hFunction->page($dataTransactionStatus);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection