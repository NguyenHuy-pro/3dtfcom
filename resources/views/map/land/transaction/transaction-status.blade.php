<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/15/2016
 * Time: 8:13 AM
 *
 *
 * $dataLandTransaction
 * $dataRuleLandRank
 *
 *
 */

//transaction info
?>
<div class="tf-land-transaction-status text-center">
    {{--sale--}}
    @if($dataLandTransaction->transactionStatus->checkSaleStatus())
        {{--the land is sold.--}}
        <div class="tf-land-transaction-price ">
            <a class="tf-link-bold" href="{!! route('tf.help','point-$/activities') !!}" target="_blank">
                {!! $dataRuleLandRank->salePrice() !!}.P
            </a>

        </div>
    @endif
</div>
