<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 1/19/2017
 * Time: 4:24 PM
 */
$bannerId = $dataProjectSampleBanner->bannerId();
$projectId = $dataProjectSampleBanner->projectId();
$top = $dataProjectSampleBanner->topPosition();
$left = $dataProjectSampleBanner->leftPosition();
$zIndex = $dataProjectSampleBanner->zIndex();

# sample info
$dataBannerSample = $dataProjectSampleBanner->bannerSample;


?>
<div id="tf_m_c_project_sample_banner_{!! $bannerId !!}" class="tf_m_c_project_sample_banner tf-position-abs"
     data-banner="{!! $bannerId !!}"
     data-href-position="{!! route('tf.m.c.sample.project.build.banner.position.set') !!}"
     style="top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">

    {{--sample image--}}
    <img src="{!! $dataBannerSample->pathImage() !!}">

    <div class="tf-m-c-project-sample-banner-transaction">
        {!! $dataProjectSampleBanner->transactionStatus->name() !!}
    </div>
    <div class="btn-toolbar tf_m_c_project_sample_banner_menu tf-m-c-project-sample-banner-menu" role="toolbar">
        <div class="btn-group btn-group-xs">
            <span class="tf_m_c_project_sample_banner_move_status glyphicon glyphicon-move tf-link"></span>
        </div>
        <div class="btn-group btn-group-xs">
        <span class="tf_m_c_project_sample_banner_delete glyphicon glyphicon-remove tf-link"
              data-href="{!! route('tf.m.c.sample.project.build.banner.delete') !!}"></span>
        </div>
    </div>
</div>