<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/25/2016
 * Time: 8:52 AM
 */
?>
<div id="tf_m_build_mini_map" class="tf-m-build-mini-map">
    <div id="tf_m_build_mini_content" class="tf-m-build-mini-content">
        <div id="tf_m_build_mini_wrap" class="tf-m-build-mini-wrap"
             data-href-load-content="{!! route('tf.m.build.map.miniMap.content.get') !!}"
             data-href-load-area="{!! route('tf.m.build.area.coordinates.get') !!}">
        </div>
        <div id="tf_m_build_mini_x" class="tf-m-build-mini-x" style="top: 50px;"></div>
        <div id="tf_m_build_mini_y" class="tf-m-build-mini-y" style="left: 50px;"></div>
    </div>
    <div class="tf-m-build-mini-label"></div>
</div>
