<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/16/2016
 * Time: 5:01 PM
 *
 *
 * $dataUserStatistic
 *
 *
 */

?>
<div class="tf-main-header-wrap-icon pull-right hidden-xs">
    <a class="tf_notify_get tf-link-action" title="{!! trans('frontend_map.header_friend_title') !!}"
       data-href="{!! route('tf.notify.friend.get') !!}">
        <i class="fa fa-users tf-font-icon"></i>
    </a>
    @if($dataUserStatistic->friendNotifies() > 0)
        <div class="tf-main-header-notify-new tf_main_header_notify_new">
            {!! $dataUserStatistic->friendNotifies() !!}
        </div>
    @endif
</div>
