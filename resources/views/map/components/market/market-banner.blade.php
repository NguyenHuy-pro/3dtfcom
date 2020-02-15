<?php
/*
 *
 * modelCountry
 * modelProvince
 * marketObject
 * dataBanner
 *
 */

?>
@extends('map.components.market.market-wrap')
@section('tf_map_market_content')
    @if(count($dataBanner) > 0)
        <ul class="tf_market_banner_contain list-group" data-href-banner="{!! route('tf.map.banner.access') !!}"
             data-href-area="{!! route('tf.map.area.get') !!}">
            @foreach($dataBanner as $bannerObject)
                <?php
                $no = (isset($no)) ? $no + 1 : 1;
                $bannerId = $bannerObject->bannerId();
                $dataProject = $bannerObject->project;
                $dataBannerSample = $bannerObject->bannerSample;

                if ($marketObject == 'saleBanner') {
                    $projectRankId = $dataProject->getRankId();
                    $sizeId = $dataBannerSample->sizeId();
                    $price = $bannerObject->price($sizeId, $projectRankId);
                } else {
                    $price = 0;
                }
                ?>
                <li class="list-group-item tf-border-none tf-padding-bot-5 tf-padding-top-5">
                    {!! $no !!}.
                    <a class="tf_market_banner_name tf-link" data-province="{!! $dataProject->provinceId() !!}"
                          data-area="{!! $dataProject->areaId() !!}"
                          data-banner="{!! $bannerId !!}">
                        {!! $bannerObject->name() !!}
                    </a>
                    <a class="tf-link-grey pull-right " href="{!! route('tf.help','point-$/activities') !!}" target="_blank">
                        {!! $price !!} .P
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <span class="tf-color-red">
                {!! trans('frontend_map.market_banner_not_found') !!}
            </span>
        </div>
    @endif
@endsection