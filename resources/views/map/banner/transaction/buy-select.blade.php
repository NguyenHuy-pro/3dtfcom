<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/16/2016
 * Time: 8:41 AM
 *
 * $modelUser
 * $dataBanner
 *
 */
$hFunction = new Hfunction();

#login info
$dataUserLogin = $modelUser->loginUserInfo();

#banner info
$bannerId = $dataBanner->bannerId();
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    {{--user was logged in--}}
    @if(count($dataUserLogin) > 0)
        <?php
        $loginUserId = $dataUserLogin->userId();
        $pointOfUser = $modelUser->point($loginUserId);
        $dataBannerTransaction = $dataBanner->transactionInfo();
        ?>
        {{--exist banner info--}}
        @if(count($dataBannerTransaction) > 0)
            @if($dataBannerTransaction->transactionStatus->checkSaleStatus() && $dataBanner->checkPublished())
                <?php
                $dataRuleBanner = $dataBanner->ruleInfo();
                $bannerPrice = $dataRuleBanner->salePrice();
                $saleMonth = $dataRuleBanner->saleMonth();
                $dateEnd = $hFunction->currentDatePlusMonth($saleMonth);
                ?>
                <form id="frmBannerBuy"
                      class="form-horizontal col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1"
                      data-banner="{!! $bannerId !!}" data-image-add="{!! route('tf.map.banner.image.add.get') !!}"
                      enctype="multipart/form-data" method="post" action="{!! route('tf.map.banner.buy.post') !!}">
                    <div class="form-group text-center">
                        <h3>{!! trans('frontend_map.banner_transaction_title') !!}</h3>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            {!! trans('frontend_map.banner_transaction_point_label')  !!}:
                        </label>

                        <div class="text-left col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <span class="form-control tf-color-red">{!! $bannerPrice !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            {!! trans('frontend_map.banner_transaction_expiration')  !!}:
                        </label>

                        <div class="text-left col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                            <span class="form-control tf-color-red">{!! $dateEnd !!}</span>
                        </div>
                    </div>

                    {{-- the user enough point to payment.--}}
                    @if($pointOfUser >= $bannerPrice)
                        <div class="form-group">
                            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                                <button type="button" class="tf_map_banner_payment btn btn-primary">
                                    {!! trans('frontend_map.button_payment') !!}
                                </button>
                                <button type="button" class="tf_main_contain_action_close btn btn-default">
                                    {!! trans('frontend_map.button_cancel') !!}
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- the user does not enough point to payment.--}}
                        <div class="form-group warning text-center tf-color-red">
                            {!! trans('frontend_map.banner_sale_transaction_notify_point') !!}.
                        </div>
                        <div class="form-group">
                            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <a class="tf-link-white" href="{!! route('tf.point.online.package.get') !!}">
                                    <button type="button" class="btn btn-primary">
                                        {!! trans('frontend_map.button_buy_point') !!}
                                    </button>
                                </a>
                                <button type="button" class="tf_main_contain_action_close btn btn-default">
                                    {!! trans('frontend_map.button_later') !!}
                                </button>
                            </div>
                        </div>
                    @endif
                </form>
            @else
                {{--this banner is selected by others--}}
                <div class="tf-padding-top-30 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {!! trans('frontend_map.banner_transaction_notify_selected') !!}.
                </div>
                <div class="tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <button class="tf_main_contain_action_close btn btn-primary" type="button">
                        {!! trans('frontend_map.button_close') !!}
                    </button>
                </div>
            @endif
        @else
            {{--this banner is selected by others--}}
            <div class="tf-padding-top-30 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {!! trans('frontend_map.banner_transaction_notify_selected') !!}.
            </div>
            <div class="tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button class="tf_main_contain_action_close btn btn-primary" type="button">
                    {!! trans('frontend_map.button_close') !!}
                </button>
            </div>
        @endif
    @else
        {{--user is not login--}}
        <div class="tf-padding-top-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
              {!! trans('frontend_map.banner_sale_transaction_notify_login') !!}.
            </div>
        <div class="tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="{!! route('tf.register.get',"banner/$bannerId") !!}">
                <button class="btn btn-primary" type="button">
                    {!! trans('frontend_map.button_register') !!}
                </button>
            </a>
            <button class="tf_main_login_get btn btn-warning" type="button"
                    data-href="{!! route('tf.login.get') !!}">
                {!! trans('frontend_map.button_login') !!}
            </button>
            <button class="tf_main_contain_action_close btn btn-default" type="button">
                {!! trans('frontend_map.button_close') !!}
            </button>
        </div>
    @endif
@endsection
