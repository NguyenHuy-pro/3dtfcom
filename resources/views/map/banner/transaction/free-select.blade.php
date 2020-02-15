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
 *
 */

$dataUserLogin = $modelUser->loginUserInfo();
$hFunction = new Hfunction();
$bannerId = $dataBanner->bannerId();
?>

@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    {{--user was logged in--}}
    @if(count($dataUserLogin))
        <?php
        $loginUserId = $dataUserLogin->userId();
        $dataBannerTransaction = $dataBanner->transactionInfo();
        ?>
        @if($dataBanner->checkPublished())
            @if($dataUserLogin->existExchangeBannerFree() || $dataUserLogin->existExchangeBannerInvitation() )
                {{-- user already use the free features. --}}
                <div class="tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {!! trans('frontend_map.banner_free_transaction_notify_used') !!}
                </div>
                <div class="tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <button class="tf_main_contain_action_close btn btn-primary" type="button">
                        {!! trans('frontend_map.button_close') !!}
                    </button>
                </div>
            @else
                {{--exist banner info--}}
                @if(count($dataBannerTransaction) > 0)
                    @if($dataBannerTransaction->transactionStatus->checkFreeStatus())
                        <?php
                        $dataRuleBanner = $dataBanner->ruleInfo();
                        $freeMonth = $dataRuleBanner->freeMonth();
                        $dateEnd = $hFunction->currentDatePlusMonth($freeMonth);
                        ?>
                        <form id="frmBannerFree" class="col-sm-10 col-sm-offset-1 form-horizontal"
                              data-banner="{!! $bannerId !!}"
                              enctype="multipart/form-data" method="post"
                              data-image-add="{!! route('tf.map.banner.image.add.get') !!}"
                              action="{!! route('tf.map.banner.free.post') !!}">
                            <div class="form-group text-center">
                                <h3>{!! trans('frontend_map.banner_free_transaction_title') !!}</h3>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    {!! trans('frontend_map.banner_transaction_point_label') !!}:
                                </label>

                                <div class="text-left col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <span class="form-control tf-color-red">0</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    {!! trans('frontend_map.banner_transaction_expiration') !!}
                                </label>

                                <div class="text-left col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <span class="form-control tf-color-red">{!! $dateEnd !!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                                    <button type="button" class="tf_map_banner_free_agree btn btn-primary">
                                        {!! trans('frontend_map.button_agree') !!}
                                    </button>
                                    <button type="button" class="tf_main_contain_action_close btn btn-default">
                                        {!! trans('frontend_map.button_close') !!}
                                    </button>
                                </div>
                            </div>
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
                    {{--does not exist banner info--}}
                    <div class="tf-padding-top-30 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        {!! trans('frontend_map.banner_transaction_notify_selected') !!}.
                    </div>
                    <div class="tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button class="tf_main_contain_action_close btn btn-primary" type="button">
                            {!! trans('frontend_map.button_close') !!}
                        </button>
                    </div>

                @endif
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
            {!! trans('frontend_map.banner_free_transaction_notify_login') !!}.
        </div>
        <div class="tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a class="tf-link-white" href="{!! route('tf.register.get',"banner/$bannerId") !!}">
                <button class="btn btn-primary" type="button">
                    {!! trans('frontend_map.button_register') !!}
                </button>
            </a>
            <button class="tf_main_login_get btn btn-warning" type="button" data-href="{!! route('tf.login.get') !!}">
                {!! trans('frontend_map.button_login') !!}
            </button>
            <button class="tf_main_contain_action_close btn btn-default" type="button">
                {!! trans('frontend_map.button_later') !!}
            </button>
        </div>
    @endif
@endsection
