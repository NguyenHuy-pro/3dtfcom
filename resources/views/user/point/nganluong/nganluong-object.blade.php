<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 12:28 PM
 */
/*
 *
 * modelUser
 * dataNganLuongOrder
 *
 *
 */

#action info
?>
<table class="tf_nganluong_object table table-hover tf-point-object"
       data-order="{!! $dataNganLuongOrder->orderId() !!}"
       data-date="{!! $dataNganLuongOrder->createdAt() !!}">
    <tr>
        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! $dataNganLuongOrder->orderCode() !!}
        </td>
        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! $dataNganLuongOrder->point() !!}
        </td>
        <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            {!! $dataNganLuongOrder->createdAt() !!}
            <span class="tf_view fa fa-eye tf-link pull-right tf-font-size-16"></span>
        </td>
    </tr>
</table>
