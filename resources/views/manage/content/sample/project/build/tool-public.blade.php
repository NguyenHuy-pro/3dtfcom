<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 1/19/2017
 * Time: 12:34 PM
 */
?>
<div class="tf-project-sample-tool-wrap">
    @if(count($dataPublicSample) > 0)
        @foreach($dataPublicSample as $itemSample)
            <div class="thumbnail tf-margin-bot-none">
                <img id="build-public-{!! $itemSample->sampleId() !!}"
                     class="tf_m_c_project_sample_tool"
                     data-sample="{!! $itemSample->sampleId() !!}"
                     ondragstart="tf_m_c_sample_project.drag(event);"
                     src="{!! $itemSample->pathImage() !!}" alt="public">

                <div class="caption">
                    ({!! $itemSample->size->name() !!}) px
                </div>
            </div>
        @endforeach
    @else
        <div class="thumbnail tf-margin-bot-none tf-color-red">
            not found
        </div>
    @endif
</div>
