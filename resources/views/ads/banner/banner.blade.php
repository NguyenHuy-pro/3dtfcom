<?php
/*
 * modelUser
 * modelAdsBanner
 * dataAdsAccess
 * dataAdsBanner
 */
$dataAdsBanner = $modelAdsBanner->infoAvailable();
?>

@extends('ads.index')

@section('titlePage')
    {!! trans('frontend_ads.page_title') !!}
@endsection

@section('ads_menu')
    @include('ads.components.menu.menu', ['dataAdsAccess' => $dataAdsAccess])
@endsection

@section('ads_content')
    <div class="row">
        <div class="tf_ads_banner tf-padding-top-30 col-xs-12 col-sm col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading tf-font-bold">
                    {!! trans('frontend_ads.banner_list_title') !!}
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th style="border-top:none;">
                                {!! trans('frontend_ads.banner_list_name_label') !!}
                            </th>
                            <th style="border-top:none;">
                                {!! trans('frontend_ads.banner_list_position_label') !!}
                            </th>
                            <th style="border-top:none;">
                                {!! trans('frontend_ads.banner_list_size_label') !!}
                            </th>
                            <th style="border-top:none;">
                                {!! trans('frontend_ads.banner_list_price_label') !!}
                            </th>
                            <th style="border-top:none;">
                                {!! trans('frontend_ads.banner_list_view_label') !!}
                            </th>
                            <th style="border-top:none;"></th>
                        </tr>
                        @if(count($dataAdsBanner) > 0)
                            @foreach($dataAdsBanner as $object)
                                <?php
                                $bannerId = $object->bannerId();
                                $name = $object->name();
                                ?>
                                <tr class="tf_ads_banner_object" data-banner="{!! $bannerId !!}">
                                    <td class="tf-vertical-middle">
                                        {!! $name !!}
                                    </td>
                                    <td class="tf-vertical-middle">
                                        {!! $object->adsPage->name().' - '.$object->adsPosition->name() !!}
                                    </td>
                                    <td class="tf-vertical-middle">
                                        {!! $object->width().' x '.$object->height() !!}
                                    </td>

                                    <td class="tf-vertical-middle">
                                        1 / {!! $object->displayAvailable() !!}
                                    </td>
                                    <td class="tf-vertical-middle">
                                        <a class="tf_banner_view_place tf-link"
                                           data-href="{!! route('tf.ads.banner.view.get') !!}">
                                            {!! trans('frontend_ads.banner_list_view') !!}
                                        </a>
                                    </td>
                                    <td class="text-right tf-vertical-middle">
                                        <a class="tf-link btn btn-warning"
                                           href="{!! route('tf.ads.order.detail.get', $name) !!}">
                                            {!! trans('frontend_ads.banner_button_set_ads') !!}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center tf-padding-30" colspan="6">
                                    <em>
                                        {!! trans('frontend_ads.banner_notify_null') !!}
                                    </em>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection