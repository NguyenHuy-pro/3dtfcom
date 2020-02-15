<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/8/2016
 * Time: 2:35 PM
 */
?>
<div id="tf_owned_wrap" class="tf_main_owned_wrap tf-owned-wrap tf_container_remove tf-zindex-8 tf-box-shadow ">
    <ul id="tf_owned_menu" class="tf-owned-menu nav nav-pills tf-bg" role="tablist">
        <li>
            <a class="tf_owned_menu_object tf_owned_building @if($ownedObject == 'building') tf-link-white-bold tf-text-under @else tf-link-grey @endif"
               data-href="{!! route('tf.owned.building.get') !!}">
                {!! trans('frontend.owned_menu_building') !!}
            </a>
        </li>
        <li>
            <a class="tf_owned_menu_object tf_owned_land @if($ownedObject == 'land') tf-link-white-bold tf-text-under @else tf-link-grey @endif"
               data-href="{!! route('tf.owned.land.get') !!}">
                {!! trans('frontend.owned_menu_Land') !!}
            </a>
        </li>
        <li>
            <a class="tf_owned_menu_object tf_owned_banner @if($ownedObject == 'banner') tf-link-white-bold tf-text-under @else tf-link-grey @endif"
               data-href="{!! route('tf.owned.banner.get') !!}">
                {!! trans('frontend.owned_menu_banner') !!}
            </a>
        </li>
    </ul>
    <div class="panel panel-default tf-border-none ">
        <div id="tf_owned_content_wrap" class="panel-body tf-padding-top-none tf-overflow-auto">
            <div id="tf_map_owned_content" class="row">
                @yield('tf_owned_content')
            </div>
        </div>
        <div id="tf_owned_content_bottom" class="panel-footer tf-line-height-30 tf-margin-padding-none text-center">
            <a class="tf_remove_container tf-link-full tf-color-red tf-bg-hover">
                {!! trans('frontend.button_close') !!}
            </a>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tf_owned_wrap').css('height', windowHeight - 70);
            $('#tf_owned_content_wrap').css('height', windowHeight - 70 - $('#tf_owned_menu').outerHeight() - $('#tf_owned_content_top').outerHeight() - $('#tf_owned_content_bottom').outerHeight());
        });
    </script>
</div>
