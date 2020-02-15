<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 12:28 PM
 */
/*
 *
 * $modelUser
 * $dataSellerPayment
 *
 *
 */
$hFunction = new Hfunction();
$dataUserLogin = $modelUser->loginUserInfo();

$paymentCode = $dataSellerPayment->paymentCode();
?>
<tr class="tf_user_seller_payment_object">
    <td>
        <a class="tf_seller_payment_view tf-link" data-code="{!! $paymentCode !!}" title="Click to view detail">
            {!! $paymentCode !!}
        </a>
    </td>
    <td>
        {!! $hFunction->dateFormatDMY($dataSellerPayment->fromDate,'/') !!}
    </td>
    <td>
        {!! $hFunction->dateFormatDMY($dataSellerPayment->toDate,'/') !!}
    </td>
    <td class="text-right">
        ${!! $dataSellerPayment->totalPay() !!}
        <br/>
        @if(!$dataSellerPayment->checkPaid())
            <em class="tf-color-grey">{!! trans('frontend_user.seller_payment_processing_label') !!}</em>
        @else
            <em class="tf-color-grey">{!! trans('frontend_user.seller_payment_paid_label') !!}</em>
        @endif
    </td>

</tr>
