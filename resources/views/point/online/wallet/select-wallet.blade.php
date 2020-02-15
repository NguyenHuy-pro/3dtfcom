<?php
/*
 * modelUser
 * dataPointAccess
 *
 */
$hFunction = new Hfunction();

$package = $dataPointAccess['package'];
$orderCode = $dataPointAccess['orderCode'];
?>
@extends('point.online.index')
@section('online_content')

    <div class="panel panel-default tf-border-bot-none">
        <div class="panel-heading">
            &nbsp;{!! trans('frontend_point.online_payment_title_wallet') !!}
            <em>({!! trans('frontend_point.online_payment_title_wallet_notice') !!})</em>
        </div>

        {{--select package--}}
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 tf-padding-top-10 ">
                    <div class="tf_point_wallet thumbnail tf-cursor-pointer tf-border-radius-10 "
                         style="height: 50px;" data-wallet="{!! 1 !!}"
                         data-href="{!! route('tf.point.online.nganluong.payment-detail.get') !!}">
                        <img class="tf-width-height-full" src="{!! url('public\main\icons\logo-nganluong.png') !!}"
                             alt="wallet-name">
                    </div>
                </div>

                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 tf-padding-top-10 ">
                    <div class="tf_point_wallet thumbnail tf-cursor-pointer tf-border-radius-10 "
                         style="height: 50px;" data-wallet="{!! 2 !!}"
                         data-href="{!! route('tf.point.online.nganluong.payment-detail.get') !!}">
                        <img class="tf-width-height-full" src="{!! url('public\main\icons\logo-onepay.png') !!}"
                             alt="wallet-name">
                    </div>
                </div>
            </div>
        </div>

        {{--end select package--}}
        <div class="panel-footer text-center tf-padding-none">
            <div class="row">
                <div class="text-center col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <a class="tf-padding-10 tf-link-full tf-bg-hover tf-color"
                       href="{!! route('tf.point.online.package.get',"$package") !!}">
                        {!! trans('frontend_point.online_payment_wallet_label_back') !!}
                    </a>
                </div>
                <form id="frm_point_online_payment_detail" class="text-center col-xs-6 col-sm-6 col-md-6 col-lg-6"
                      name="frm_point_online_payment_detail" method="get" action="">
                    <input type="hidden" class="txt_point" name="txtPoint" value="{!! $package !!}">
                    <input type="hidden" class="txt_orderCode" name="txtOrderCode" value="{!! $orderCode !!}">
                    <input type="hidden" class="txt_wallet" name="txtWallet" value="">
                    <input name="_token" type="hidden" value="{!! csrf_token() !!}">
                    <a class="tf_point_online_payment_detail tf-padding-10 tf-link-full tf-bg-hover tf-color">
                        {!! trans('frontend_point.online_payment_wallet_label_Next') !!}
                    </a>
                </form>
            </div>
        </div>
    </div>


@endsection