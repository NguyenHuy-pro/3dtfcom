<?php
/*
 *
 * $modelUser
 * $dataBuilding
 *
 *
 */
#building Info
$buildingId = $dataBuilding->buildingId();

$userBuildingId = $dataUserBuilding->userId();

# get list building of user
$dataRelationBuilding = $dataUserBuilding->buildingInfo($userBuildingId, 0, 10);


$recentBuildingList = (isset($dataBuildingAccess['recentBuilding'])) ? $dataBuildingAccess['recentBuilding'] : null;
$recentBannerImageList = (isset($dataBuildingAccess['recentBannerImage'])) ? $dataBuildingAccess['recentBannerImage'] : null;
$recentProjectList = (isset($dataBuildingAccess['recentProject'])) ? $dataBuildingAccess['recentProject'] : null;
?>

<div class="row">
    <div class="tf-building-news-wrap col-xs-12 col-sm-12 col-md-12 col-lg-12">
        {{--relation building--}}
        @if(count($dataRelationBuilding) > 0)
            @include('building.components.news.relation-building.relation-building', compact('dataRelationBuilding'),
                [
                    'modelUser'=>$modelUser,
                    'dataBuilding'=>$dataBuilding
                ])
        @endif

        {{-- new building --}}
        @if(!empty($recentBuildingList))
            @include('building.components.news.new-building.new-building',
                [
                    'modelUser'=>$modelUser,
                    'dataBuilding'=>$dataBuilding,
                    'recentBuildingList' => $recentBuildingList
                ])
        @endif

        {{-- New image of ad banner--}}
        @if(!empty($recentBannerImageList))
            @include('building.components.news.new-banner-image.new-image',
                [
                    'modelUser'=>$modelUser,
                    'dataBuilding'=>$dataBuilding,
                    'recentBannerImageList' => $recentBannerImageList
                ])
        @endif

        {{--The projects published recently--}}
        @if(count($recentProjectList) > 0)
            @include('building.components.news.new-project.new-project',
                [
                    'modelUser'=>$modelUser,
                    'dataBuilding'=>$dataBuilding,
                    'recentProjectList'=>$recentProjectList
                ])
        @endif


    </div>
</div>
