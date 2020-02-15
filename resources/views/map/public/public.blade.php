<?php
/*
 * $modelUser
 * dataMapAccess
 * $dataPublic
 *
 */

$publicId = $dataPublic->publicId();
$top = $dataPublic->topPosition();
$left = $dataPublic->leftPosition();
$zIndex = $dataPublic->zindex();
$dataPublicSample = $dataPublic->publicSample;
$width = $dataPublicSample->size->width();
$height = $dataPublicSample->size->height()
?>
<div id="tf_public_{!! $publicId !!}" class="tf_public tf-public" data-public="{!! $publicId !!}"
     style="width:{!! $width !!}px; height:{!! $height !!}px; top: {!! $top !!}px; left: {!! $left !!}px; z-index: {!! $zIndex !!}">
    <img alt="{!! $dataPublicSample->publicType->name() !!}" src="{!! $dataPublicSample->pathImage() !!}">
</div>

