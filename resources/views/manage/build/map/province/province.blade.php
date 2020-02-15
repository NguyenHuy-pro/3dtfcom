<?php
/*
 * modelStaff
 * modelArea
 * dataMapAccess
 */

$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccessId = $dataMapAccess['areaAccess'];

$dataArea = $modelArea->getInfo($areaAccessId);
$top = $dataArea->topPosition();
$left = $dataArea->leftPosition();
$topPositionAccess = ($top > 0) ? -$top : $top;
$leftPositionAccess = ($left > 0) ? -$left : $left;

# delete history of load area
if (Session::has('tf_m_build_area_history')) Session::forget('tf_m_build_area_history');
?>
<div id="tf_m_build_province" class="tf_m_build_province tf-m-build-province"
     data-province="{!! $provinceAccess !!}"
     style="top:{!! $topPositionAccess !!}px;left: {!! $leftPositionAccess !!}px;">
    @include('manage.build.map.area.area',compact('dataArea'),
        [
            'modelStaff'=>$modelStaff,
            'modelProvinceArea' => $modelProvinceArea,
            'modelArea' => $modelArea,
            'dataMapAccess'=>$dataMapAccess
        ])
</div>
