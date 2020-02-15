<?php
# access project info
$projectRankId = $dataProjectInfoAccess['projectRankID'];
$projectOwnStatus = $dataProjectInfoAccess['projectOwnStatus'];
$settingStatus = $dataProjectInfoAccess['settingStatus'];

# info land
$landId = $dataLand->land_id;
$projectId = $dataLand->projectId();
$sizeId = $dataLand->sizeId();
$top = $dataLand->topPosition();
$left = $dataLand->leftPosition();
$zIndex = $dataLand->zIndex();
$publish = $dataLand->publish();

# get size of land
$landWidth = $dataLand->size->width;
$landHeight = $dataLand->size->height;
?>
<div id="tf_m_build_land_{!! $landId !!}" class="tf_m_build_land tf-m-build-land" data-land="{!! $landId !!}"
     @if($settingStatus)
     data-href-position="{!! route('tf.m.build.land.position.set') !!}"
     @endif
     style="width: {!! $landWidth !!}px;height: {!! $landHeight !!}px;top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">
    {{--not exist license (does not sale)--}}
    @if(!$dataLand->existLicense())

        @include('manage.build.map.land.land-icon',compact(['dataLand' => $dataLand,'dataProjectInfoAccess'=>$dataProjectInfoAccess]))
        {{--is setting--}}
        @if($settingStatus)
            @include('manage.build.map.land.land-menu')
        @endif
        @if($publish == 0)
            <img class="tf-m-build-land-icon-new tf-position-abs tf-zindex-10" alt="new-land"
                 src="{!! asset("public/main/icons/new.png") !!}"/>
        @endif
        {{--exist building--}}
    @else
        <?php
        # building info
        $dataBuilding = $dataLand->buildingInfo();
        ?>
        @if(count($dataBuilding) > 0)
            @include('manage.build.map.building.building');
        @else
            @include('manage.build.map.land.land-icon',compact(['dataLand' => $dataLand,'dataProjectInfoAccess'=>$dataProjectInfoAccess]))
        @endif
    @endif
</div>
