<?php
/*
 *
 * $modelUser
 * $dataBuilding
 *
 */


use App\Models\Manage\Content\System\BusinessType\TfBusinessType;

$hFunction = new Hfunction();
$modelBusinessType = new TfBusinessType();

#login info
$dataUserLogin = $modelUser->loginUserInfo();


# info of building
$buildingId = $dataBuilding->buildingId();
$buildingName = $dataBuilding->name();
$displayName = $dataBuilding->displayName();
$alias = $dataBuilding->alias();
$sampleId = $dataBuilding->sampleId();

# check exist filter on business type
$accessBusinessType = $modelBusinessType->getAccess();
$showStatus = true;
if (!empty($accessBusinessType)) {
    $businessTypeId = $accessBusinessType->typeId();
    $listSample = $modelBusinessType->listBuildingSampleId($businessTypeId);
    if (!in_array($sampleId, $listSample)) $showStatus = false;
}

if($showStatus){
#building sample
$dataBuildingSample = $dataBuilding->buildingSample;
$widthSample = $dataBuildingSample->size->width();

?>

<div id="tf_building_{!! $buildingId !!}" class="tf_building tf-building" data-building="{!! $buildingId !!}">

    {{--information detail--}}
    @include('map.building.information.information',
        [
            'modelUser' => $modelUser,
            'dataBuilding' => $dataBuilding
        ])

    {{--building sample--}}
    <img alt="{!! $alias !!}" src="{!! $dataBuildingSample->pathImage() !!}"/>

    {{--name --}}
    <div class="tf_building_name_wrap tf-building-name-wrap">
        {{--name of building--}}
        <a class="tf_building_name tf-font-bold tf-font-border-blue tf-color-white " title="{!! $buildingName !!}">
            {!! $displayName !!}
        </a>
    </div>

    @if(!empty($dataUserLogin))
        {{-- notify new comment from friends --}}
        @include('map.building.notify.notify',
            [
                'modelUser' => $modelUser,
                'dataBuilding' => $dataBuilding
            ])
    @endif

    {{--menu--}}
    @include('map.building.menu.menu',
        [
            'modelUser' => $modelUser,
            'dataBuilding'=>$dataBuilding
        ])
</div>

<?php
}
?>
