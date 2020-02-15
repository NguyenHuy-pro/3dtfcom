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

$modelMobile = new Mobile_Detect();
$provinceAccessId = $dataMapAccess['provinceAccess'];
$dataProvince = $modelProvince->getInfo($provinceAccessId);

$dataBusinessType = (isset($dataMapAccess['businessTypeAccess'])) ? $dataMapAccess['businessTypeAccess'] : null;
if (empty($dataBusinessType)) {
    $businessTypeId = null;
    $businessTypeName = trans('frontend_map.header_filter_business_label');
} else {
    $businessTypeId = $dataBusinessType->typeId();
    $businessTypeName = $dataBusinessType->name();
}
?>
{{--mini map--}}
<div class="tf-main-header-wrap-icon pull-left">
    <span id="tf_main_header_mini_map" class="tf-link-action" data-province="{!! $provinceAccessId !!}"
          data-href="{!! route('tf.map.miniMap.get') !!}">
        <img class="tf-icon-20" title="Mini map" alt="mini_map" src="{!! asset('public/main/icons/miniMap-on.png') !!}"/>
    </span>
</div>

{{--search--}}
@include('components.search.search-form')

{{--show follow bussiness--}}
<div class="tf-main-header-wrap-icon pull-left tf-margin-rig-10 hidden-xs">
    <div class="tf_master_show_business">
        <a class="tf_business_type tf-link-white-bold tf-margin-rig-5" data-business-type="{!! $businessTypeId !!}"
           data-href="{!! route('tf.search.filter.business-type.list') !!}">
            {!! $businessTypeName !!}
            <i class="fa fa-caret-down"></i>
        </a>
    </div>
</div>



