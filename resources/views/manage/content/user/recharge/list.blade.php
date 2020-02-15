<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
/*
 * modelStaff
 * modelRecharge
 * dataRecharge
 */
use Carbon\Carbon;

$hFunction = new Hfunction();
$dataStaffLogin = $modelStaff->loginStaffInfo();
#check action of level
$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true; #level execute

?>
@extends('manage.content.user.recharge.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-Left tf-padding-20 tf-font-size-20 tf-font-bold col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <span class="fa fa-database"></span>
                <span>Recharge info</span>
            </div>
        </div>
        <div class="tf-bg tf-color-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="tf-line-height-40 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                Total : {!! $modelRecharge->totalRecords() !!}
            </div>
            <div class="tf-line-height-40 text-right col-xs-6 col-sm-6 col-md-6 col-lg-6">
                @if($actionStatus)
                    <a class="tf-link-white-bold" href="{!! route('tf.m.c.user.recharge.add.get') !!}">
                        <button class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> &nbsp; Recharge
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12"
             data-href-view="{!! route('tf.m.c.user.recharge.view') !!}">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Name card</th>
                    <th>Recharge code</th>
                    <th>Point</th>
                    <th>Total payment</th>
                    <th class="text-center">Confirm</th>
                    <th>Date</th>
                    <th class="tf-width-100 text-right"></th>
                </tr>
                @if(count($dataRecharge) > 0)
                    <?php
                    $perPage = $dataRecharge->perPage();
                    $currentPage = $dataRecharge->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataRecharge as $rechargeObject)
                        <?php
                        $n_o = $n_o + 1;
                        $rechargeId = $rechargeObject->rechargeId();
                        $confirm = $rechargeObject->confirm();
                        ?>
                        <tr class="tf_object" data-object="{!! $rechargeId !!}">
                            <td class="text-center tf-font-bold">
                                {!! $n_o !!}.
                            </td>
                            <td>
                                {!! $rechargeObject->userCard->name() !!}
                            </td>
                            <td>
                                {!! $rechargeObject->code() !!}
                            </td>
                            <td>
                                {!! $rechargeObject->point() !!}
                            </td>
                            <td>
                                {!! $rechargeObject->totalPayment() !!}. USD
                            </td>
                            <td class="text-center">
                                @if($confirm == 1)
                                    <i class="glyphicon glyphicon-ok-circle tf-color-green tf-font-bold"></i>
                                @else
                                    <i class="glyphicon glyphicon-ok-circle tf-color-grey"></i>
                                @endif
                            </td>
                            <td>
                                {!! Carbon::parse($rechargeObject->createdAt())->format('d-m-Y H:i:s') !!}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="8">
                            <?php
                            $hFunction->page($dataRecharge);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection