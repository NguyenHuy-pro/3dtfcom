<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/30/2016
 * Time: 11:07 AM
 *
 * $modelProvince
 * $dataMapAccess
 *
 */

$provinceAccessId = $dataMapAccess['provinceAccess'];
$dataProvince = $modelProvince->getInfo($provinceAccessId);
?>

{{--search--}}
<div class="tf-main-header-wrap-icon tf-float-left ">
    <a id="tf_map_search_get" class="tf-link-white-bold glyphicon glyphicon-search tf-font-size-14"
       data-href="{!! route('tf.search.search.get') !!}"></a>
</div>

{{--mini map--}}
<div class="tf-main-header-wrap-icon tf-float-left ">
    <a id="tf_main_header_mini_map" class="tf-link-white-bold fa fa-map-marker tf-font-size-16"
       title="{!! trans('frontend_map.header_mini_map_title') !!}"></a>
</div>

{{--Filter--}}
<div class="tf_header_country_filter tf-main-header-wrap-icon" style="float: left;"
     title="{!! trans('frontend_map.header_country_title') !!}">
    <span class="tf-color-white tf-font-bold">
        {!! $dataProvince->country->name() !!}
    </span>

    <a data-toggle="dropdown" class="dropdown-toggle tf_select caret tf-link-white "
       data-href="{!! route('tf.search.filter.country.get') !!}"></a>
</div>

<div class="tf_header_province_filter tf-main-header-wrap-icon" style="float: left;"
     title="{!! trans('frontend_map.header_province_title') !!}">
    <span class="tf-color-white tf-font-bold">
        {!! $dataProvince->name() !!}
    </span>

    <a data-toggle="dropdown" class="dropdown-toggle tf_select caret tf-font-size-16 tf-link-white "
       data-href="{!! route('tf.search.filter.province.get') !!}"></a>
</div>

{{--filter on business--}}
@include('map.components.header.filter-business-type')

