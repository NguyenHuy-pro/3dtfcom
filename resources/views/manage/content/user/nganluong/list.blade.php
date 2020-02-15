<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelNganLuongOrder
 * dataNganLuongOrder
 */
use Carbon\Carbon;

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
#check action of level
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true; #level execute

?>
@extends('manage.content.user.nganluong.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-Left tf-padding-20 tf-font-size-20 tf-font-bold col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <span class="fa fa-database"></span>
                <span>Order info</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="tf-line-height-40 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                Total : {!! $modelNganLuongOrder->totalRecords() !!}
            </div>
            <div class="tf-line-height-40 text-right col-xs-6 col-sm-6 col-md-6 col-lg-6">

            </div>
        </div>
        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12"
             data-href-view="{!! route('tf.m.c.user.nganluong.view') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Name card</th>
                    <th>Order code</th>
                    <th>Point</th>
                    <th>Total payment</th>
                    <th>Date</th>
                    <th class="tf-width-100 text-right"></th>
                </tr>
                @if(count($dataNganLuongOrder) > 0)
                    <?php
                    $perPage = $dataNganLuongOrder->perPage();
                    $currentPage = $dataNganLuongOrder->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataNganLuongOrder as $orderObject)
                        <?php
                        $n_o = $n_o + 1;
                        $orderId = $orderObject->orderId();
                        ?>
                        <tr class="tf_object" data-object="{!! $orderId !!}">
                            <td class="text-center tf-font-bold">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $orderObject->userCard->name() !!}
                            </td>
                            <td>
                                {!! $orderObject->orderCode() !!}
                            </td>
                            <td>
                                {!! $orderObject->point() !!}
                            </td>
                            <td>
                                {!! $orderObject->price() !!}. {!! $orderObject->moneyCode() !!}
                            </td>
                            <td>
                                {!! Carbon::parse($orderObject->createdAt())->format('d-m-Y H:i:s') !!}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="7">
                            <?php
                            $hFunction->page($dataNganLuongOrder);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection