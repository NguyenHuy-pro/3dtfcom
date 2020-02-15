<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 1/19/2017
 * Time: 12:34 PM
 */
?>
<div class="tf-project-sample-tool-wrap">
    @foreach($dataBannerSample as $sampleObject)
        <div class="thumbnail tf-margin-bot-none">
            <img id="build-banner-{!! $sampleObject->sampleId() !!}"
                 class="tf_m_c_project_sample_tool"
                 data-sample="{!! $sampleObject->sampleId() !!}"
                 ondragstart="tf_m_c_sample_project.drag(event);"
                 src="{!! asset('public/main/icons/banner-icon.png') !!}" alt="land">

            <div class="caption">
                ({!! $sampleObject->size->name() !!}) px
            </div>
        </div>
    @endforeach
</div>
