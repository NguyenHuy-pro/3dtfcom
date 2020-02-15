<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/14/2016
 * Time: 10:49 AM
 */
/*
 * dataArea
 */
?>
<div class="tf-m-build-area-info tf-color-white tf-vertical-middle">
    <span class="tf_m_build_area_open_get tf-link-white tf-border-bottom"
          data-href="{!! route('tf.m.build.project.add.get') !!}">Open project</span> <br>
    Top: {!! $dataArea->topPosition !!}<br>
    Left: {!! $dataArea->leftPosition !!}<br>
    X: {!! $dataArea->x !!}<br>
    Y: {!! $dataArea->y !!}
</div>