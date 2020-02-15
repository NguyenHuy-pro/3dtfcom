<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/30/2016
 * Time: 10:26 AM
 *
 * $modelCountry
 * $modelProvince
 * $modelArea
 * dataProvince
 * dataProject
 *
 */

$countryId = $dataProvince->countryId();
$provinceId = $dataProvince->provinceId();
?>
<div id="tf_mini_map" class="tf_mini_map tf-mini-map tf_container_remove" data-province="{!! $provinceId !!}">
    <div id="tf_mini_map_location" class="tf-mini-map-location">
        <select id="miniMapCountry" name="miniMapCountry" data-href="{!! route('tf.map.country.access') !!}">
            {!! $modelCountry->getOptionBuilt3d($countryId) !!}
        </select>
        <select id="miniMapProvince" name="miniMapProvince" data-href="{!! route('tf.map.province.access') !!}">
            {!! $modelProvince->getOptionBuilt3d($provinceId, $countryId) !!}
        </select>
    </div>

    <div id="tf_mini_map_content" class="tf-mini-map-content"
         data-href-load-area="{!! route('tf.map.area.coordinates.get') !!}">
        @include('map.control.mini-map.mini-map-content',
            [
                'modelArea' => $modelArea,
                'dataProject'=>$dataProject
            ])
    </div>
    <div id="tf_mini_map_x" class="tf-mini-map-x"></div>
    <div id="tf_mini_map_y" class="tf-mini-map-y"></div>
    <script type="text/javascript">
        $(document).ready(function () {
            tf_map.mini_map_set_xy();
        });
    </script>
</div>
