<?php
# public info
$publicId = $dataProjectSamplePublic->publicId();
$projectId = $dataProjectSamplePublic->projectId();
$sampleId = $dataProjectSamplePublic->sampleId();
$top = $dataProjectSamplePublic->topPosition();
$left = $dataProjectSamplePublic->leftPosition();
$zIndex = $dataProjectSamplePublic->zIndex();
$typeId = $dataProjectSamplePublic->publicSample->typeId();

?>
<div id="tf_m_c_project_sample_public{!! $publicId !!}" class="tf_m_c_project_sample_public tf-m-c-project-sample-public"
     data-public="{!! $publicId !!}"
     data-type="{!! $typeId !!}"
     data-href-position="{!! route('tf.m.c.sample.project.build.public.position.set') !!}"
     style="top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">

    {{--sample image--}}
    <img alt="{!! $dataProjectSamplePublic->publicSample->publicType->name() !!}" src="{!! $dataProjectSamplePublic->publicSample->pathImage() !!}">
    <div class="btn-toolbar tf_m_c_project_sample_public_menu tf-m-c-project-sample-public-menu tf-display-none tf-border-radius-4" role="toolbar">
        <div class="btn-group btn-group-xs">
            <span class="tf_m_c_project_sample_public_move_status glyphicon glyphicon-move tf-link"></span>
        </div>
        <div class="btn-group btn-group-xs">
        <span class="tf_m_c_project_sample_public_delete glyphicon glyphicon-remove tf-link"
              data-href="{!! route('tf.m.c.sample.project.build.public.delete') !!}"></span>
        </div>
    </div>
</div>


