<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/15/2016
 * Time: 8:13 AM
 */
# banner transaction info
$transactionStatusId = $dataBannerTransaction->transactionStatusId();
?>
<div class="tf_banner_transaction text-center" style="width: 100%; height: 100%;">
    {{--sale--}}
    @if($dataBannerTransaction->transactionStatus->checkSaleStatus())
        <a class="tf-link-bold" href="{!! route('tf.help','point-$/activities') !!}" target="_blank">
            {!! $dataRuleBannerRank->salePrice() !!} .P
        </a>

    @elseif($dataBannerTransaction->transactionStatus->checkFreeStatus())
        {{--free--}}
        <span class="tf-color-red tf-font-bold">
            {!! trans('frontend_map.label_free') !!}
        </span>
    @endif

</div>
