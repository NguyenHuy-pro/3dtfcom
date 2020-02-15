<?php

/*
 * modelStaff
 * modelProvinceArea
 * modelArea
 * dataArea
 * dataMapAccess
 *
 */

# access info
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccessId = $dataMapAccess['areaAccess'];

#area info
$areaId = $dataArea->areaId();
$top = $dataArea->topPosition();
$left = $dataArea->leftPosition();
$width = $dataArea->width();
$height = $dataArea->height();

// load lai vi tri cu
if (Session::has('tf_m_build_area_history')) {
    # load khi di chuyen vao map (by: mouse over, trend, mini map)
    Session::put('tf_m_build_area_history', Session::get('tf_m_build_area_history') . ',' . $areaId);
} else {
    # load lan dau hoac load lai
    Session::put('tf_m_build_area_history', $areaId);
}

# get project at area in province
$dataProject = $modelProvinceArea->projectInfo($provinceAccess, $areaId);
?>
<div id="tf_m_build_area_{!! $areaId !!}" class="tf_m_build_area tf-m-build-area"
     data-href-position="{!! route('tf.m.build.area.position.get') !!}"
     data-href="{!! route('tf.m.build.area.get') !!}"
     data-area="{!! $areaId !!}"
     style="width: {!! $width !!}px;height: {!! $height !!}px;top: {!! $top !!}px;left: {!! $left !!}px;">
    @if(count($dataProject) > 0)
        {{--exist project --}}
        @include('manage.build.map.project.project',compact('dataProject'),
            [
                'modelStaff' => $modelStaff,
                'modelProvinceArea' => $modelProvinceArea,
                'dataMapAccess'=>$dataMapAccess]
            )
    @else
        {{--area empty--}}
        @if($modelStaff->checkLogin())
            <?php
            $dataStaff = $modelStaff->loginStaffInfo();
            ?>
            @if($dataStaff->level() == 1)
                @include('manage.build.map.area.info',['dataArea'=>$dataArea])
            @endif
        @endif
    @endif

    {{--project is building--}}
    @if($modelProvinceArea->checkSetup())

        {{--disable areas that are not building--}}
        @if($areaId != $areaAccessId)
            @include('manage.build.map.area.mask-setup')
        @endif
    @endif
</div>
