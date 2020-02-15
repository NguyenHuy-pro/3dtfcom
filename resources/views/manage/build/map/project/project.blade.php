<?php
/*
 * modelStaff
 * modelProvinceArea
 */

# staff info
$staffId = $modelStaff->loginStaffID();

# access info
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccess = $dataMapAccess['areaAccess'];

# project info
$provinceId = $dataProject->provinceId();
$areaId = $dataProject->areaId();
$projectId = $dataProject->projectId();
$projectName = $dataProject->name();
$projectRankId = $dataProject->getRankId();

# status is setting project
$settingStatus = false;
if ($modelProvinceArea->checkSetup()) {
    if ($provinceAccess == $provinceId AND $areaAccess == $areaId) {
        $settingStatus = true;
    }
}

# own status
$projectOwnStatus = 0;
if ($dataProject->checkManager($staffId)) {
    $projectOwnStatus = 1;
}


# set access project info
$dataProjectInfoAccess = [
        'projectOwnStatus' => $projectOwnStatus,
        'settingStatus' => $settingStatus,
        'projectRankID' => $projectRankId,
];

#element on project
$land = $dataProject->landInfo();
$banner = $dataProject->bannerInfoOnBuild();
$public = $dataProject->publicInfo();

$background = $dataProject->pathImageBackground();
?>
<div id="tf_m_build_project_{!! $projectId !!}"
     class="tf_m_build_project tf-m-build-project @if($areaAccess == $areaId) tf_m_build_project_setup  @endif "
     @if($settingStatus)
     data-href-land="{!! route('tf.m.build.land.add.get') !!}"
     data-href-banner="{!! route('tf.m.build.banner.add.get') !!}"
     data-href-public="{!! route('tf.m.build.publics.add.get') !!}"
     ondrop="tf_m_build_map.drop(event,this);"
     ondragover="tf_m_build_map.allow_drop(event);"
     @endif
     data-project="{!! $projectId !!}"
     style="background: url('{!! $background !!}')">
    @if($settingStatus)
        <di class="tf_m_build_project_grid tf-m-build-project-grid"></di>
    @endif

    {{--icon--}}
    @include('manage.build.map.project.project-icon',compact('settingStatus'),
        [
            'modelStaff' => $modelStaff,
            'modelProvinceArea' => $modelProvinceArea,
            'dataMapAccess' => $dataMapAccess,
            'dataProject' => $dataProject
        ])

    {{--banner--}}
    @if(count($banner) > 0)
        @foreach($banner as $dataBanner)
            @include('manage.build.map.banner.banner',compact('dataBanner','dataProjectInfoAccess'))
        @endforeach
    @endif

    @if(count($land) > 0)
        @foreach($land as $dataLand)
            {{--land--}}
            @include('manage.build.map.land.land',compact('dataLand', 'dataProjectInfoAccess'))
        @endforeach
    @endif

    {{--public--}}
    @if(count($public) > 0)
        @foreach($public as $dataPublic)
            @include('manage.build.map.publics.public',compact('dataPublic', 'dataProjectInfoAccess'))
        @endforeach
    @endif
</div>