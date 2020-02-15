<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 12:28 PM
 */
/*
 *
 * $modelUser
 * $dataBannerShare
 *
 *
 */

#action info
?>
<table class="tf_recharge_object table table-hover tf-point-object"
       data-recharge="{!! $dataRecharge->rechargeId() !!}"
       data-date="{!! $dataRecharge->createdAt() !!}">
    <tr>
        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! $dataRecharge->code() !!}
        </td>
        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! $dataRecharge->point() !!}
        </td>
        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! $dataRecharge->createdAt() !!}
            <span class="tf_view fa fa-eye tf-link pull-right tf-font-size-16"></span>
        </td>
    </tr>
</table>
