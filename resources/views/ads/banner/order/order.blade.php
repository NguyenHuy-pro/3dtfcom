<?php
/*
 * modelUser
 * modelAdsBanner
 * dataAdsBanner
 */
$name = $dataAdsBanner->name();
?>

@extends('ads.index')

@section('titlePage')
    {!! trans('frontend_ads.banner_order_title') !!}
@endsection

@section('ads_menu')
    @include('ads.components.menu.menu', ['dataAdsAccess' => $dataAdsAccess])
@endsection

@section('ads_content')
    <div class="row">
        <div class="tf-padding-top-10 text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a class="tf-link " href="{!! route('tf.ads.banner.list.get') !!}">
                {!! trans('frontend_ads.banner_order_suggest') !!}.
            </a>
        </div>

        <div class="tf-padding-top-30 col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-offset-2">
            <form id="tf_ads_banner_order" class="tf_ads_banner_order form" role="form" method="post"
                  action="{!! route('tf.ads.order.pay.post',$name ) !!}">
                <div class="form-group text-center">
                    <h2>{!! trans('frontend_ads.banner_order_title') !!}</h2>
                </div>
                <div class="tf_order_notify form-group text-center"></div>
                <div class="form-group">
                    <label>
                        {!! trans('frontend_ads.banner_order_name_label') !!}
                    </label>
                    <input type="text" class="form-control" readonly value="{!! $name !!}">
                </div>
                <div class="form-group">
                    <label>
                        {!! trans('frontend_ads.banner_order_page_label') !!}
                    </label>
                    <input type="text" class="form-control" readonly value="{!! $dataAdsBanner->adsPage->name() !!}">
                </div>
                <div class="form-group">
                    <label>
                        {!! trans('frontend_ads.banner_order_size_label') !!}
                    </label>
                    <input type="text" class="form-control" readonly
                           value="{!! $dataAdsBanner->width().' x '.$dataAdsBanner->height() !!}">
                </div>
                <div class="form-group">
                    <label>
                        {!! trans('frontend_ads.banner_order_price_label') !!}
                    </label>

                    <input class="form-control" type="text" name="txtPriceView" readonly
                           value="{!! '1 / '.$dataAdsBanner->displayAvailable() !!}">
                    <input class="tf_price " type="hidden" name="txtPrice"
                           value="{!! $dataAdsBanner->displayAvailable() !!}">
                </div>

                <div class="form-group">
                    <label>
                        {!! trans('frontend_ads.banner_order_show_label') !!}
                    </label>

                    <select class="tf_show form-control" name="cbShow">
                        <option value="0">Show number</option>
                        @for($i = 1000; $i <= 1000000; $i = $i + 1000)
                            <option value="{!! $i !!}">
                                {!! $i !!}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>
                        {!! trans('frontend_ads.banner_order_total_label') !!}
                    </label>
                    <input type="text" class="tf_total_pay form-control" disabled="disabled" value="0">
                </div>
                <div class="form-group">
                    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <a class="tf_pay btn btn-primary">
                            {!! trans('frontend_ads.banner_order_pay_label') !!}
                        </a>
                        <a class="tf-margin-lef-10 btn btn-default" href="{!! route('tf.ads.banner.list.get') !!}">
                            {!! trans('frontend_ads.banner_order_later_label') !!}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection