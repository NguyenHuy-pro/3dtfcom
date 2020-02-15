<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/16/2016
 * Time: 5:02 PM
 *
 *
 * $dataUserStatistic
 *
 *
 */
?>
<div class="tf-main-header-wrap-icon pull-right hidden-xs">
    <a class="tf_notify_get tf-link-action" title="{!! trans('frontend_map.header_activity_title') !!}"
       data-href="{!! route('tf.notify.action.get') !!}">
        <i class="fa fa-globe tf-font-icon"></i>
    </a>
    @if($dataUserStatistic->actionNotifies() > 0)
        <div class="tf-main-header-notify-new tf_main_header_notify_new">
            {!! $dataUserStatistic->actionNotifies() !!}
        </div>
    @endif
</div>