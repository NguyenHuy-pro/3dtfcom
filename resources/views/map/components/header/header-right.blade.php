<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/30/2016
 * Time: 11:07 AM
 *
 * dataUserLogin
 * dataProvince
 *
 */

$dataUserLogin = $modelUser->loginUserInfo();

if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
}

$provinceId = $dataProvince->provinceId();
$countryId = $dataProvince->countryId();
?>

{{--market--}}
<div class="tf-main-header-wrap-icon pull-right">
    <a id="tf_map_market_get" class="tf_map_market_get tf-link-action" data-country="{!! $countryId !!}"
       title="{!! trans('frontend_map.header_market_title') !!}"
       data-province="{!! $provinceId  !!}" data-href="{!! route('tf.map.market.land.sale.get') !!}">
        {!! trans('frontend_map.header_market_label') !!}
    </a>
</div>
