<?php
/*
 * $modelUser
 * $modelProvince
 * $modelArea
 * $dataMapAccess
 * $dataArea
 */

# access info on map
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccess = $dataMapAccess['areaAccess'];
$landAccess = $dataMapAccess['landAccess'];
$bannerAccess = $dataMapAccess['bannerAccess'];

#Area info
$areaId = $dataArea->areaId();
$top = $dataArea->topPosition();
$left = $dataArea->leftPosition();
$width = $dataArea->width();
$height = $dataArea->height();

#note the area loaded
$modelArea->setAreaLoaded($areaId);

# get project at area in province
$dataProject = $modelArea->projectInfoOfProvince($provinceAccess, $areaId);
?>
<div id="tf_area_{!! $areaId !!}" class="tf_area tf-area @if($areaId == $areaAccess) tf_area_watching @endif"
     data-href-position="{!! route('tf.area.position.set') !!}"
     data-area="{!! $areaId !!}"
     data-href-load="{!! route('tf.map.area.get') !!}"
     style="width: {!! $width !!}px;height: {!! $height !!}px;top: {!! $top !!}px;left: {!! $left !!}px; z-index: {!! $areaId !!};">
    {{--exist project--}}
    @if(count($dataProject) > 0)
        @include('map.project.project', compact('dataProject'),
            [
                'modelUser' => $modelUser,
                'dataMapAccess' => $dataMapAccess
            ])
    @endif
</div>
