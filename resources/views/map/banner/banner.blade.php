<?php
/*
 * $modelUser
 * $dataProjectInfoAccess
 * $dataBanner
 *
 */
#user login
$dataUserLogin = $modelUser->loginUserInfo();

#data access of map
$projectRankId = $dataMapAccess['projectRankId'];
$projectOwnStatus = $dataMapAccess['projectOwnStatus'];

# develop after sale project
$settingStatus = $dataMapAccess['settingStatus'];


# banner info
$bannerId = $dataBanner->bannerId();
$bannerSampleId = $dataBanner->sampleId();
$top = $dataBanner->topPosition();
$left = $dataBanner->leftPosition();
$zIndex = $dataBanner->zindex();
$publish = $dataBanner->publish();

# sample info
$dataBannerSample = $dataBanner->bannerSample;
$bannerWidth = $dataBannerSample->size->width();
$bannerHeight = $dataBannerSample->size->height();


//$bannerAccessId = isset($dataMapAccess['bannerAccess']) ? $dataMapAccess['bannerAccess'] : null;
if (isset($dataMapAccess['bannerAccess']) AND count($dataMapAccess['bannerAccess']) > 0) {
    $bannerAccessId = $dataMapAccess['bannerAccess']->bannerId();
} else {
    $bannerAccessId = null;
}

#check invite
$showGift = false;
if (count($dataUserLogin) == 0) {
    #get invite info
    $inviteCode = isset($dataMapAccess['inviteCode']) ? $dataMapAccess['inviteCode'] : null;
    if (!empty($inviteCode)) {
        $dataBannerLicense = $dataBanner->licenseInfo();
        if (count($dataBannerLicense) > 0) {
            $dataBannerLicenseInvite = $dataBannerLicense->bannerLicenseInviteInfo($dataBannerLicense->licenseId());
            if (count($dataBannerLicenseInvite) > 0) {
                $checkCode = $dataBannerLicenseInvite->inviteCode();
                if ($checkCode == $inviteCode) {
                    $showGift = true;
                }
            }
        }
    }
}

?>
<div id="tf_banner_{!! $bannerId !!}"
     class="tf_banner tf-banner @if($bannerAccessId == $bannerId) tf_banner_access  @endif"
     data-href-visit="{!! route('tf.map.banner.visit') !!}" data-banner="{!! $bannerId !!}"
     style="width: {!! $bannerWidth !!}px;height: {!! $bannerHeight !!}px; top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">

    {{--invite--}}
    @if($showGift)
        @include('map.banner.invite.invite-notify', compact('dataBannerLicenseInvite'))
    @endif
    {{-- banner  was published--}}
    @if($publish == 1)
        <img alt="3dtf-banner" src="{!! $dataBannerSample->pathImage() !!}">
        @include('map.banner.image.banner-image-wrap', compact('dataBannerSample'),[
                'modelUser' => $modelUser,
                'dataBanner' => $dataBanner,
                'dataMapAccess'=>$dataMapAccess,
            ])
    @else
        {{--icon waiting publish--}}
        @include('map.banner.banner-icon-publish')
    @endif
</div>
