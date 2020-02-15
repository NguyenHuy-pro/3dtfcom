<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 1/19/2017
 * Time: 12:34 PM
 */
?>
<div class="tf-project-sample-tool-wrap">
    @foreach($dataSize as $itemSize)
        <div class="thumbnail tf-margin-bot-none">
            <img id="build-land-{!! $itemSize->sizeId() !!}" class="tf_m_c_project_sample_tool"
                 data-size="{!! $itemSize->sizeId() !!}"
                 ondragstart="tf_m_c_sample_project.drag(event);"
                 src="{!! asset('public/main/icons/icon-land.gif') !!}" alt="land">

            <div class="caption">
                ({!! $itemSize->width() !!} x {!! $itemSize->height() !!})px
            </div>
        </div>
    @endforeach
</div>
