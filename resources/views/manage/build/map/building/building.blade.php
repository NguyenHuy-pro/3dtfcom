<?php

$hFunction = new Hfunction();
# info of building
$buildingId = $dataBuilding->buildingId();
$buildingName = $dataBuilding->name();
$alias = $dataBuilding->alias();
$sampleId = $dataBuilding->sampleId();
$landId = $dataBuilding->landId();

$buildingUserId = $dataBuilding->landLicense->userId($landId);
$dataBuildingUser = $dataBuilding->userInfo($buildingId);

//building sample
$dataBuildingSample = $dataBuilding->buildingSample;
$sizeId = $dataBuildingSample->sizeId();
$widthSample = $dataBuildingSample->size->width();
$sampleImage = $dataBuildingSample->image();



?>
<div id="tf_m_build_building_{!! $buildingId !!}" class="tf_m_build_building tf-m-build-building">
    <img src="{!! $dataBuildingSample->pathImage($sampleImage) !!}"/>
    {{--name --}}
    <div class="dropup tf-m-build-building-name-wrap">
        <span class="dropdown-toggle" data-toggle="dropdown" title="{!! $buildingName !!}">
            <a class="tf-link-white tf-font-border-blue">
                {!! $dataBuilding->displayName() !!}
            </a>
        </span>

        {{--detail--}}
        @include('manage.build.map.building.building-detail',compact(['dataBuilding'=>$dataBuilding]))
    </div>

    {{--menu--}}
    @include('manage.build.map.building.building-menu')
</div>
