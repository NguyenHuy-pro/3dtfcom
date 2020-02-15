<?php
# access project info
$projectRankId = $dataProjectInfoAccess['projectRankID'];
$projectOwnStatus = $dataProjectInfoAccess['projectOwnStatus'];
$settingStatus = $dataProjectInfoAccess['settingStatus'];


# public info
$publicId = $dataPublic->publicId();
$projectId = $dataPublic->projectId();
$sampleId = $dataPublic->sampleId();
$top = $dataPublic->topPosition();
$left = $dataPublic->leftPosition();
$zIndex = $dataPublic->zindex();

?>
<div id="tf_m_build_public_{!! $publicId !!}" class="tf_m_build_public tf-m-build-public"
     data-public="{!! $publicId !!}"
     data-type="{!! $dataPublic->publicSample->typeId() !!}"
     @if($settingStatus)
     data-href-position="{!! route('tf.m.build.publics.position.set') !!}"
     @endif
     style="top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">

    {{--sample image--}}
    <img alt="{!! $dataPublic->publicSample->publicType->name() !!}" src="{!! $dataPublic->publicSample->pathImage() !!}">
    @if($settingStatus)
        @include('manage.build.map.publics.public-menu')
    @endif
</div>


