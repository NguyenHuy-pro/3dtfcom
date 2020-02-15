<?php
/*
 * modelUser
 * dataPointAccess
 * dataPointTransaction
 */
$hFunction = new Hfunction();

#user info
$dataUserLogin = $modelUser->loginUserInfo();
$cardId = $dataUserLogin->userCard->cardId();

$transactionId = $dataPointTransaction->transactionId();
$pointTransaction = $dataPointTransaction->pointValue();
$usdTransaction = $dataPointTransaction->usdValue();
$onePoint = $usdTransaction / $pointTransaction; //point/VND

$point = $dataPointAccess['package'];
$wallet = $dataPointAccess['wallet'];
$orderCode = $dataPointAccess['orderCode'];

$vndPayment = $point * $onePoint;


#config nganluong.vn  (basic)
$nganLuong = new NL_Checkout();
$receiver = 'hoangroup@gmail.com';
$transactionInfo = "Payment for buy point in 3DTF";
$price = $vndPayment;

$return_url = route('tf.point.online.nganluong.payment.get', "$point/$wallet/$transactionId/$cardId");
$href = $nganLuong->buildCheckoutUrlExpand($return_url, $receiver, $transactionInfo, $orderCode, $price, 'usd');
/*
$return_url = route('tf.point.online.nganluong.payment.get', $orderCode);
$comments = 'Payment for buy point in 3DTF.COM';
#https://www.nganluong.vn/button_payment.php?receiver=(Email chính tài khoản nhận tiền)&product_name=(Mã đơn đặt hàng)&price=(Tổng giá trị)&return_url=(URL thanh toán thành công)&comments=(Ghi chú về đơn hàng)
$href = "https://www.nganluong.vn/button_payment.php?receiver=$receiver&product_name=$orderCode&price=$price&return_url=$return_url&comments=$comments";
*/
?>
@extends('point.online.index')
@section('online_content')
    <form class="panel panel-default tf-border-none" method="post">
        <div class="panel-heading tf-bg-none tf-border-none text-center ">
            {!! trans('frontend_point.online_payment_detail_title') !!}
        </div>

        {{--detail order--}}
        <div class="panel-body">
            <div class="row">
                <div class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-bordered table-hover tf-border-none">
                        <tr>
                            <th>
                                {!! trans('frontend_point.online_payment_detail_label_code') !!}
                            </th>
                            <th>
                                {!! trans('frontend_point.online_payment_detail_label_point') !!}
                            </th>
                            <th>
                                {!! trans('frontend_point.online_payment_detail_label_total') !!}
                            </th>
                        </tr>
                        <tr>
                            <td>
                                {!! $orderCode !!}
                            </td>
                            <td>
                                {!! $hFunction->dotNumber($point) !!}
                            </td>
                            <td>
                                {!! $hFunction->dotNumber($vndPayment) !!} USD
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class=" tf-padding-20 text-center">
                                <em class="tf-color-red">
                                    {!! trans('frontend_point.online_payment_detail_notice_nganluong') !!}
                                </em>
                                <br/>
                                <br/>
                                <a href="{!! $href !!}">
                                    <img class="tf-border tf-border-radius-5" alt="nganluong.vn"
                                         src="{!! asset('public\main\icons\nganluong11.gif') !!}"/>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{--end detail order--}}
        <div class="panel-footer text-center tf-padding-none">
            <a class="tf-padding-10 tf-link-full tf-bg-hover tf-color"
               href="{!! route('tf.point.online.wallet.get',"$point/$wallet") !!}">
                {!! trans('frontend_point.online_payment_detail_label_back') !!}
            </a>
        </div>

        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    </form>
@endsection