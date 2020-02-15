<?php
/*
 * $modelUser
 * $dataMapAccess
 * $dataProject
 */

$dataUserLogin = $modelUser->loginUserInfo();

// access info
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccess = $dataMapAccess['areaAccess'];
//$landAccess = $dataMapAccess['landAccess'];
//$bannerAccess = $dataMapAccess['bannerAccess'];

// project info
$provinceId = $dataProject->provinceId();
$areaId = $dataProject->areaId();
$projectId = $dataProject->projectId();
$projectName = $dataProject->name();
$projectRankId = $dataProject->getRankId($projectId);

// own status , user bought this project(develop later)
$projectOwnStatus = 0; // default none

// setup status of project,  user bought this project(develop later)
$settingStatus = false;

//add info access
$dataMapAccess['projectOwnStatus'] = $projectOwnStatus;
$dataMapAccess['settingStatus'] = $settingStatus;
$dataMapAccess['projectOwnStatus'] = $projectOwnStatus;
$dataMapAccess['projectRankId'] = $projectRankId;


$dataProjectBuild = $dataProject->infoProjectBuild($projectId);

$openingStatus = false;
//first publish
if (count($dataProjectBuild) > 0) {
    if ($dataProjectBuild->publishStatus() == 1 && $dataProjectBuild->firstStatus() == 1) {
        $openingStatus = true;
        $projectBackgroundImage = $dataProject->pathImageBackgroundDefault();
    } else {
        $projectBackgroundImage = $dataProject->pathImageBackground();
    }

    //check project publish
    $dataProject->opening($projectId);
} else {
    $projectBackgroundImage = $dataProject->pathImageBackground();
}
?>
<div id="tf_project_{!! $projectId !!}" class="tf_project tf-project " data-project="{!! $projectId !!}"
     style="background: url(' {!! $projectBackgroundImage !!}');">

    @if($openingStatus)
        {{--published--}}
        @include('map.project.icon.project-icon-publish', compact('dataProjectBuild'),
            [
                'dataMapAccess'=> $dataMapAccess,
                'dataProject'=>$dataProject
            ])

    @else
        @include('map.project.icon.project-icon',
            [
                'modelUser'=>$modelUser,
                'dataMapAccess'=>$dataMapAccess,
                'dataProject' => $dataProject
            ])
        <?php
        //element on project
        $land = $dataProject->landInfo();
        $banner = $dataProject->bannerInfo();
        $public = $dataProject->publicInfo();
        ?>
        {{--banner of project--}}
        @if(count($banner) > 0)
            @foreach($banner as $dataBanner)
                @include('map.banner.banner',compact('dataBanner'),
                    [
                        'modelUser'=>$modelUser,
                        'dataMapAccess'=>$dataMapAccess,
                    ])
            @endforeach
        @endif

        {{-- land of project--}}
        @if(count($land) > 0)
            @foreach($land as $dataLand)
                @include('map.land.land',compact('dataLand'),
                    [
                        'modelUser' => $modelUser,
                        'dataMapAccess'=>$dataMapAccess,
                    ])
            @endforeach
        @endif

        {{--public of project--}}
        @if(count($public) > 0)
            @foreach($public as $dataPublic)
                @include('map.public.public',compact('dataPublic', 'dataProjectInfoAccess'),
                    [
                        'modelUser'=>$modelUser
                    ])
            @endforeach
        @endif
    @endif
</div>