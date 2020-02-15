<?php

/*
 *
 * modelCountry
 * modelProvince
 * marketObject
 *
 */

$provinceId = $dataProvince->provinceId();
$countryId = $dataProvince->countryId();

?>
<div id="tf_map_market_wrap" class="tf_container_remove tf-map-market-wrap tf-zindex-8 panel panel-default tf-box-shadow-top-none">
    <div id="tf_map_market_menu" class="tf-map-market-menu panel-heading tf-padding-top-none tf-padding-bot-none">
        <div class="row">
            <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <select id="tf_map_market_country" class="tf-border-none">
                    {!! $modelCountry->getOptionBuilt3d($countryId) !!}
                </select>
                <select id="tf_map_market_province" class="tf-border-none">
                    {!! $modelProvince->getOptionBuilt3d($provinceId, $countryId) !!}
                </select>
            </div>
        </div>
    </div>
    <div id="tf_map_market_container" class="panel-body tf-map-market-container tf-box-shadow-top-none">
        <div id="tf_map_market_content_top" class="tf-map-market-content-top col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <select class="tf_map_market_menu_object tf-border-none">
                <option @if($marketObject == 'saleLand') selected="selected"
                        @endif  value="{!! route('tf.map.market.land.sale.get') !!}">
                    {!! trans('frontend_map.market_menu_land_sale') !!}
                </option>
                <option @if($marketObject == 'freeLand') selected="selected"
                        @endif value="{!! route('tf.map.market.land.free.get') !!}">
                    {!! trans('frontend_map.market_menu_land_free') !!}
                </option>
                <option @if($marketObject == 'saleBanner') selected="selected"
                        @endif value="{!! route('tf.map.market.banner.sale.get') !!}">
                    {!! trans('frontend_map.market_menu_banner_sale') !!}
                </option>
                <option @if($marketObject == 'freeBanner') selected="selected"
                        @endif value="{!! route('tf.map.market.banner.free.get') !!}">
                    {!! trans('frontend_map.market_menu_banner_free') !!}
                </option>
            </select>
        </div>

        <div id="tf_map_market_content_wrap" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="tf_map_market_content" class="row tf-overflow-auto">
                @yield('tf_map_market_content')
            </div>
        </div>

        <div class="row">
            <div id="tf_map_market_content_bottom"
                 class="tf-line-height-30 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <a class="tf_remove_container tf-link-full tf-color-red tf-bg-hover">
                    {!! trans('frontend.button_close') !!}
                </a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var menuHeight = $('#tf_map_market_menu').outerHeight();
            var height = windowHeight - 80 - menuHeight - $('#tf_map_market_content_top').outerHeight() - $('#tf_map_market_content_bottom').outerHeight();
            $('#tf_map_market_container').css({'top': menuHeight + 1});
            $('#tf_map_market_content').css({'height': height});
        });
    </script>
</div>
