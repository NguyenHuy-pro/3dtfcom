<?php
/*
 * modelUser
 * modelBank
 * dataSellerAccess
 */
$dataUserLogin = $modelUser->loginUserInfo();
?>

@extends('seller.index')

@section('titlePage')
    {!! trans('frontend_seller.title_page_sign_up') !!}
@endsection

@section('seller_menu')
    @include('seller.components.menu.menu', ['dataSellerAccess' => $dataSellerAccess])
@endsection

@section('seller_content')
    <div class="row">
        <div class="tf-padding-top-30 col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-offset-2">
            <form id="tf_seller_sing_up" class="tf_seller_sing_up form" name="tf_seller_sing_up" role="form"
                  method="post" action="{!! route('tf.seller.sign-up.post' ) !!}">
                <div class="form-group text-left">
                    <em class="tf-text-under">
                        {!! trans('frontend_seller.sign_up_title_sub') !!}
                    </em>
                </div>

                @if(count($dataUserLogin) > 0)
                    @if(!$dataUserLogin->checkIsSeller())
                        <div class="form-group text-center">
                            <h2>{!! trans('frontend_seller.sign_up_title') !!}</h2>
                        </div>
                        <div class="tf_seller_sing_up_notify form-group text-center"></div>
                        <div class="form-group">
                            <label>
                                {!! trans('frontend_seller.sing_up_bank_label') !!}
                            </label>
                            <span class="tf-color-red">*</span>
                            <select class="form-control" name="cbBank">
                                <option value="">
                                    {!! trans('frontend_seller.sing_up_bank_select_label') !!}
                                </option>
                                {!! $modelBank->getOption() !!}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                {!! trans('frontend_seller.sign_up_name_label') !!}
                            </label>
                            <span class="tf-color-red">*</span>
                            <input type="text" class="form-control" name="txtName"
                                   placeholder="{!! trans('frontend_seller.sign_up_name_placeholder') !!}">
                        </div>
                        <div class="form-group">
                            <label>
                                {!! trans('frontend_seller.sign_up_code_label') !!}
                            </label>
                            <span class="tf-color-red">*</span>
                            <input type="text" class="form-control" name="txtPaymentCode"
                                   placeholder="{!! trans('frontend_seller.sign_up_code_placeholder') !!}">
                        </div>
                        <div class="form-group">
                            <label>
                                {!! trans('frontend_seller.sign_up_confirm') !!}
                            </label>
                            <em>({!! trans('frontend_seller.sign_up_confirm_notice') !!})</em>
                            <span class="tf-color-red">*</span>
                            <input type="password" class="form-control" name="txtConfirm">
                        </div>
                        <div class="form-group">
                            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <a class="tf_seller_sing_up_send btn btn-primary">
                                    {!! trans('frontend_seller.sign_up_send') !!}
                                </a>
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="tf-padding-top-10 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                {!! trans('frontend_seller.sign_up_send_note') !!}
                            </div>
                        </div>
                    @else
                        <div class="form-group">
                            <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <span class="tf-em-1-5">
                                    {!! trans('frontend_seller.sign_up_registered_notify') !!}
                                </span>
                                <br/><br/>
                                <a class="tf-link" href="{!! route('tf.user.seller.statistic.get') !!}">
                                    <em>{!! trans('frontend_seller.sign_up_registered_link_label') !!}</em>
                                </a>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="tf-padding-top-30 tf-padding-bot-30 tf-color-red form-group text-center">
                        {!! trans('frontend_seller.sign_up_login_notify') !!}
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection