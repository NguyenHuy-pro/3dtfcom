<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:31 PM
 *
 *
 * $modelUser
 * $dataSellerPayment *
 *
 */
$hFunction = new Hfunction();
$fromDate = $dataSellerPayment->fromDate();
$toDate = $dataSellerPayment->toDate();

?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <div class="tf_user_payment_view_container tf_action_height_fix col-xs-12 col-sm-12 col-md-12 col-lg-12"
         data-from="{!! $fromDate !!}" data-to="{!! $toDate !!}"
         data-href_more="{!! route('tf.user.seller.payment.view.more') !!}">
        <table class="table">
            <tr>
                <th class="tf-font-size-20" colspan="2">
                    <i class="fa fa-list"></i>
                    {!! trans('frontend_user.seller_payment_view_title') !!}
                    <button class="tf_main_contain_action_close btn btn-default btn-sm tf-link-red pull-right"
                            type="button">
                        {!! trans('frontend.button_close') !!}
                    </button>
                </th>
            </tr>
            <tr>
                <td class="text-right tf-border-none" colspan="2"></td>
            </tr>
            <tr>
                <td class="text-right col-md-2 col-lg-2 ">
                    <label>{!! trans('frontend_user.seller_payment_view_date_label') !!}:</label>
                </td>
                <td>
                    <em class="tf-text-under">{!! trans('frontend_user.seller_payment_view_from_label') !!}: </em>
                    &nbsp; {!! $hFunction->dateFormatDMY($fromDate,'/') !!}
                    <br/>
                    <em class="tf-text-under">{!! trans('frontend_user.seller_payment_view_to_label') !!}: </em>
                    &nbsp; {!! $hFunction->dateFormatDMY($toDate,'/') !!}
                </td>
            </tr>
            <tr>
                <td class="text-right">
                    <label> {!! trans('frontend_user.seller_payment_view_access_label') !!}:</label>
                </td>
                <td>
                    {!! $dataSellerPayment->totalAccess() !!}
                </td>
            </tr>
            <tr>
                <td class="text-right">
                    <label> {!! trans('frontend_user.seller_payment_view_register_label') !!}:</label>
                </td>
                <td>
                    {!! $dataSellerPayment->totalRegister() !!}
                </td>
            </tr>
            <tr>
                <td class="text-right">
                    <label> {!! trans('frontend_user.seller_payment_view_pay_label') !!}:</label>
                </td>
                <td>
                    {!! $dataSellerPayment->totalPay() !!}
                </td>
            </tr>
            <tr>
                <td class="text-right">
                    <label> {!! trans('frontend_user.seller_payment_view_status_label') !!}:</label>
                </td>
                <td>
                    @if($dataSellerPayment->checkPaid())
                        {!! trans('frontend_user.seller_payment_view_paid_label') !!}
                    @else
                        {!! trans('frontend_user.seller_payment_view_process_label') !!}
                    @endif
                </td>
            </tr>
        </table>
        <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a class="tf_payment_detail_more tf-link" data-object="land">
                {!! trans('frontend_user.seller_payment_view_more_label') !!}
            </a>
        </div>
        <div class="row">
            <div id="tf_payment_detail_more_container" class=" col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>
        </div>
    </div>
@endsection
