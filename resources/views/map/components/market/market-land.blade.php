<?php

/*
 *
 * modelCountry
 * modelProvince
 * marketObject
 * dataLand
 *
 */

?>
@extends('map.components.market.market-wrap')
@section('tf_map_market_content')
    @if(count($dataLand) > 0)
        <ul class="tf_market_land_contain list-group" data-href-land="{!! route('tf.map.land.access') !!}"
             data-href-area="{!! route('tf.map.area.get') !!}">
            @foreach($dataLand as $landObject)
                <?php
                $no = (isset($no)) ? $no + 1 : 1;
                $landId = $landObject->landId();
                $sizeId = $landObject->sizeId();
                $projectId = $landObject->projectId();
                $dataProject = $landObject->project;
                if ($marketObject == 'saleLand') {
                    $projectRankId = $dataProject->getRankId();
                    $price = $landObject->price($sizeId, $projectRankId);
                } else {
                    $price = 0;
                }
                ?>
                <li class="list-group-item tf-border-none tf-padding-bot-5 tf-padding-top-5">
                    {!! $no !!}.
                    <a class="tf_market_land_name tf-link" data-province="{!! $dataProject->provinceId() !!}"
                          data-area="{!! $dataProject->areaId() !!}" data-land="{!! $landId !!}">
                        {!! $landObject->name() !!}
                    </a>
                    <a class="tf-link-grey pull-right" href="{!! route('tf.help','point-$/activities') !!}" target="_blank">
                        {!! $price !!} .P
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <span class="tf-color-red">
                {!! trans('frontend_map.market_land_not_found') !!}
            </span>
        </div>
    @endif
@endsection