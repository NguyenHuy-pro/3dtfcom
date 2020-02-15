<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelPayment
 * $dataPayment
 */

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Payment';
?>
@extends('manage.content.system.payment.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-12 col-md-12 text-Left tf-padding-20 tf-font-size-20 tf-font-bold">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf-bg tf-color-white " >
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40">
                Total : {!! $modelPayment->totalRecords() !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 tf-line-height-40 text-right">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.system.payment.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 tf_list_object"
             data-href-status="{!! route('tf.m.c.system.payment.status') !!}"
             data-href-view="{!! route('tf.m.c.system.payment.view') !!}"
             data-href-edit="{!! route('tf.m.c.system.payment.edit.get') !!}"
             data-href-del="{!! route('tf.m.c.system.payment.delete') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Payment name</th>
                    <th>Payment code</th>
                    <th>Contact name</th>
                    <th>Payment type</th>
                    <th>Bank</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if(count($dataPayment) > 0)
                    <?php
                    $perPage = $dataPayment->perPage();
                    $currentPage = $dataPayment->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage;
                    ?>
                    @foreach($dataPayment as $itemPayment)
                        <?php
                        $paymentId = $itemPayment->paymentId();
                        $status = $itemPayment->status();
                        ?>
                        <tr class="tf_object" data-object="{!! $paymentId !!}">
                            <td class="text-center">
                                {!! $n_o += 1 !!}.
                            </td>
                            <td>
                                {!! $itemPayment->paymentName() !!}
                            </td>
                            <td>
                                {!! $itemPayment->paymentCode() !!}
                            </td>
                            <td>
                                {!! $itemPayment->contactName() !!}
                            </td>
                            <td>
                                {!! $itemPayment->paymentType->name() !!}
                            </td>
                            <td>
                                @if(empty($itemPayment->bankId()))
                                    <em>Null</em>
                                @else
                                    {!! $itemPayment->bank->name() !!}
                                @endif
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
                        <td class="text-center" colspan="8">
                            <?php
                            $hFunction->page($dataPayment);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection
