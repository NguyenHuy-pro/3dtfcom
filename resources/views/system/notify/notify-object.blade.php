<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 3/14/2017
 * Time: 1:45 PM
 *
 * $dataNotify
 */
?>
<table class="table table-hover tf_notify_object tf-notify-object"
       data-notify="{!! $dataNotify->notifyId() !!}"
       data-date="{!! $dataNotify->createdAt() !!}">
    <tr>
        <td class="co-xs-8 col-sm-10 col-md-10">
            <i class="glyphicon glyphicon-arrow-right tf-font-size-14 tf-color-grey"></i>&nbsp;
            {!! $dataNotify->name() !!}
        </td>
        <td class="col-xs-4 col-sm-2 col-md-2 text-right">
            <a class="tf_view tf-link pull-left" data-href="#">View</a>
            2016-12-13
        </td>
    </tr>
</table>
