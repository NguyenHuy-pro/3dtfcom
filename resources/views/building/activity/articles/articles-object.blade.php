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
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
    $userLoginId = null;
}
$buildingArticles = $dataBuildingActivity->buildingArticles;

$buildingId = $buildingArticles->buildingId();
$createdAt = $buildingArticles->createdAt();
$articleAlias = $buildingArticles->alias();
$articlesId = $buildingArticles->articlesId();
?>
<div class="tf_building_activity_object tf-building-activity-articles"
     data-date="{!! $dataBuildingActivity->createdAt() !!}">
    <table class="table">
        @if(!empty($buildingArticles->avatar()))
            <tr>
                <td class="tf-image">
                    <a class="tf-link-bold" @if(!$hFunction->isHandset()) target="_blank" @endif
                    href="{!! route('tf.building.services.article.detail.get',$articleAlias) !!}">
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
                <a class="tf-link-bold" href="{!! route('tf.building.services.article.detail.get',$articleAlias) !!}"
                   @if($hFunction->isHandset()) target="_blank" @endif>
                    {!! $buildingArticles->name() !!}
                </a>
            </td>
        </tr>
        <tr>
            <td class="tf-statistic">
                <span class="tf-color-grey">
                    {!! trans('frontend_building.service_home_object_statistic_view_label') !!} {!! $buildingArticles->totalVisit() !!}
                </span>
                <em class="tf-color-grey">- {!! $createdAt !!}</em>
            </td>
        </tr>
    </table>
</div>
