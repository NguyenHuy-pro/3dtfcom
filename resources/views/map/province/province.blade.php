<?php
/*
 * $modelUser
 * $modelProvince
 * $modelArea
 * $dataMapAccess
 */

# access info
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccess = $dataMapAccess['areaAccess'];

$dataArea = $modelArea->getInfo($areaAccess);

# delete history of load area (refresh page)
$modelArea->forgetAreaLoad();

?>
@if(count($dataArea) > 0)
    <?php
    $areaTop = $dataArea->topPosition();
    $areaLeft = $dataArea->leftPosition();
    $provinceTop = ($areaTop > 0) ? -$areaTop : $areaTop;
    $provinceLeft = ($areaLeft > 0) ? -$areaLeft : $areaLeft;
    ?>
    <div id="tf_province" class="tf_province tf-province" data-province="{!! $provinceAccess !!}"
         style="top:{!! $provinceTop !!}px;left: {!! $provinceLeft !!}px;">
        @include('map.area.area',compact('dataArea'),
            [
                'modelUser' => $modelUser,
                'modelProvince' =>$modelProvince,
                'modelArea' => $modelArea,
                'dataMapAccess'=>$dataMapAccess
            ])
    </div>
@endif
