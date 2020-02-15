<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/27/2016
 * Time: 10:15 AM
 *
 *
 */

/*
 * modelUser
 * pointAccess
 */

$object = $dataPointAccess['object'];
?>
<div class="row">
    <div class="tf-bg tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <ul class="nav nav-tabs" role="tablist">
            <li class="@if($object == 'online') active @endif">
                <a class="@if($object == 'online') tf-link @else tf-link-white @endif"
                   href="{!! route('tf.point.online.package.get') !!}">
                    {!! trans('frontend_point.menu_label_online') !!}
                </a>
            </li>
            <li class="@if($object == 'direct') active @endif">
                <a class="@if($object == 'direct') tf-link @else tf-link-white @endif"
                   href="{!! route('tf.point.direct.get') !!}">
                    {!! trans('frontend_point.menu_label_direct') !!}
                </a>
            </li>
        </ul>

    </div>
</div>
