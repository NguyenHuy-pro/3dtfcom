<?php
/*
 *
 * $dataUser
 * $dataProjectInfoAccess
 * $dataLand
 *
 */

# user login
$dataUserLogin = $modelUser->loginUserInfo();

# access project info
#$dataMapAccess = $dataProjectInfoAccess['dataMapAccess'];
$projectRankId = $dataMapAccess['projectRankId'];
$projectOwnStatus = $dataMapAccess['projectOwnStatus'];
$settingStatus = $dataMapAccess['settingStatus'];


# info land
$landId = $dataLand->landId();
$projectId = $dataLand->projectId();
$sizeId = $dataLand->sizeId();
$top = $dataLand->topPosition();
$left = $dataLand->leftPosition();
$zIndex = $dataLand->zindex();
$publish = $dataLand->publish();

# get size of land
$dataSize = $dataLand->size;
$landWidth = $dataSize->width();
$landHeight = $dataSize->height();

if (isset($dataMapAccess['landAccess']) AND count($dataMapAccess['landAccess']) > 0) {
    $landAccessId = $dataMapAccess['landAccess']->landId();
} else {
    $landAccessId = null;
}
?>
<div id="tf_land_{!! $landId !!}"
     class="tf_land tf-land @if($landAccessId == $landId) tf_land_access tf-zindex-top @endif" data-land="{!! $landId !!}"
     style="width: {!! $landWidth !!}px;height: {!! $landHeight !!}px;top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">
    {{-- land  was published--}}
    @if($publish == 1)
        <?php
        $dataLandLicense = $dataLand->licenseInfo();
        $dataLandTransaction = $dataLand->transactionInfo();
        $transactionStatusId = $dataLandTransaction->transactionStatusid();
        ?>
        {{--exist license (land of user)--}}
        @if(count($dataLandLicense) > 0 )
            <?php
            $dataBuilding = $dataLand->buildingInfo();
            ?>
            {{--exist building--}}
            @if(count($dataBuilding)> 0)
                {{--include building--}}
                @include('map.building.building',compact('dataBuilding'),
                    [
                        'modelUser' => $modelUser
                    ])
            @else
                {{--user logged--}}
                @if(count($dataUserLogin) > 0)
                    <?php
                    //user login
                    $loginUserId = $dataUserLogin->userId();

                    //user of current license (land)
                    $landUserId = $dataLandLicense->userId();
                    if ($loginUserId == $landUserId) {
                        $iconImage = $dataLand->icon($sizeId, $transactionStatusId, 1);
                    } else {
                        $iconImage = $dataLand->icon($sizeId, $transactionStatusId, 0);
                    }
                    ?>
                @else
                    <?php
                    $iconImage = $dataLand->icon($sizeId, $transactionStatusId);
                    ?>
                    @if($dataLandLicense->checkAccessInvite())
                        @include('map.land.invite.invite-notify', ['dataLandLicense'=>$dataLandLicense])
                    @endif
                @endif

                @include('map.land.land-icon',compact('iconImage'),
                    [
                        'dataLand'=>$dataLand
                    ])


                {{--only show menu when does not exist building--}}
                @include('map.land.menu.land-menu', compact('dataLandLicense', 'dataLandTransaction'),
                    [
                        'modelUser' => $modelUser,
                        'dataLand'=>$dataLand
                    ])

            @endif
        @else
            <?php
            $dataRuleLandRank = $dataLand->ruleOfSizeAndRank($sizeId, $projectRankId);
            $iconImage = $dataLand->icon($sizeId, $transactionStatusId);
            ?>
            @include('map.land.transaction.transaction-status',compact('dataLandTransaction','dataRuleLandRank'))

            @include('map.land.land-icon',compact('iconImage'),
                [
                    'dataLand'=>$dataLand
                ])

            {{--show when land is of system--}}
            @include('map.land.menu.land-menu', compact('dataLandLicense', 'dataLandTransaction'),
                [
                    'modelUser' =>$modelUser,
                    'dataLand'=>$dataLand
                ])
        @endif
    @else
        {{--icon waiting publish--}}
        @include('map.land.land-icon-publish')
    @endif
</div>
