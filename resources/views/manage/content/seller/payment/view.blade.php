<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 * $dataSellerPayment
 *
 */
$hFunction = new Hfunction();
$dataSellerPaymentDetail = $dataSellerPayment->infoDetailOfPayment();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Payment detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataSellerPayment->createdAt() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="tf-padding-bot-30 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="text-right tf-border-top-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Payment code</em>
                            </td>
                            <td class="tf-border-top-none col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                <label>
                                    {!! $dataSellerPayment->paymentCode() !!}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right tf-border-top-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Date</em>
                            </td>
                            <td class="tf-border-top-none col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                <label>
                                    {!! $hFunction->dateFormatDMY($dataSellerPayment->fromDate(),'/') .' -> '.$hFunction->dateFormatDMY($dataSellerPayment->toDate(),'/') !!}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>User</em>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                <label>
                                    {!! $dataSellerPayment->seller->user->fullName() !!}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Access</em>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                <label>
                                    {!! $dataSellerPayment->totalAccess() !!}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Register</em>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                <label>
                                    {!! $dataSellerPayment->totalRegister() !!}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Total</em>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                <label>
                                    ${!! $dataSellerPayment->totalPay() !!}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Status</em>
                            </td>
                            <td>
                                <label>
                                    {!! ($dataSellerPayment->payStatus() == 0)?'Processing': 'Paid' !!}
                                </label>
                            </td>
                        </tr>
                        @if(count($dataSellerPaymentDetail) > 0)
                            <tr class="">
                                <td class="tf-padding-top-20 text-right tf-border-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                    <label class="tf-text-under">
                                        Payment Info
                                    </label>
                                </td>
                                <td class="tf-border-none col-xs-8 col-sm-9 col-md-10 col-lg-10">

                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                    <em>Transaction name</em>
                                </td>
                                <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                    <label>
                                        {!! $dataSellerPaymentDetail->sellerPaymentInfo->name() !!}
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                    <em>Transaction code</em>
                                </td>
                                <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                    <label>
                                        {!! $dataSellerPaymentDetail->sellerPaymentInfo->paymentCode() !!}
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                    <em>Staff</em>
                                </td>
                                <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                    <label>
                                        {!! $dataSellerPaymentDetail->staff->fullName() !!}
                                    </label>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection