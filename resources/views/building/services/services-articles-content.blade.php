<?php
/*
 *
 * $modelUser
 * modelBuilding
 * buildingArticles
 *
 */
# info of user login
$hFunction = new Hfunction();
$mobileDetect = new Mobile_Detect();
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
    $userLoginId = null;
}
$mobileStatus = $mobileDetect->isMobile();

$buildingId = $buildingArticles->buildingId();
$userBuildingId = $dataUserBuilding->userId();
$ownerStatus = false;
if (($loginStatus && $userLoginId == $userBuildingId)) {
    $ownerStatus = true;
}
$createdAt = $buildingArticles->createdAt();
$articleAlias = $buildingArticles->alias();
$articlesId = $buildingArticles->articlesId();
?>
<table class="tf-building-service-articles-content table">
    @if(!empty($buildingArticles->avatar()))
        <tr>
            <td class="tf-image">
                <a class="tf-link-bold" href="{!! route('tf.building.services.article.detail.get',$articleAlias) !!}"
                   @if(!$mobileStatus) target="_blank" @endif>
                    <img style="max-height: 200px; max-width: 100%;"
                         src="{!! $buildingArticles->pathSmallImage() !!}" alt="{!! $articleAlias !!}">
                </a>
            </td>
        </tr>
    @else
        <tr>
            <td class="tf-short-description">
                {!! $buildingArticles->shortDescription() !!}
            </td>
        </tr>
    @endif
    <tr>
        <td class="tf-name">
            <a class="tf-link-bold" @if(!$mobileStatus) target="_blank" @endif
            href="{!! route('tf.building.services.article.detail.get',$articleAlias) !!}">
                {!! $buildingArticles->name() !!}
            </a>
        </td>
    </tr>
</table>
