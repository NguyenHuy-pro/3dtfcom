<?php
/*
 *
 * $modelUser
 * modelBuilding
 * buildingArticles
 *
 */
# info of user login
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
<table class="table tf_building_service_articles_object tf-building-service-articles-object"
       data-date="{!! $createdAt  !!}" data-articles="{!! $articlesId !!}">
    @if($ownerStatus)
        <tr>
            <td class="tf-menu">
                <div class="btn-group">
                    <a class=" tf-link tf-font-size-14" data-toggle="dropdown">
                        <i class="tf-font-size-20 fa fa-ellipsis-h"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right tf-padding-none tf-font-size-12">
                        <li>
                            <a class="tf_edit tf-bg-hover"
                               data-href="{!! route('tf.building.services.article.edit.get') !!}">
                                {!! trans('frontend_building.service_home_object_menu_edit_label') !!}
                            </a>
                        </li>
                        <li>
                            <a class="tf_delete tf-bg-hover"
                               data-href="{!! route('tf.building.services.article.delete') !!}">
                                {!! trans('frontend_building.service_home_object_menu_delete_label') !!}
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    @endif
    <tr>
        <td id="tf_building_service_articles_content_wrap_{!! $articlesId !!}" class="tf-content-wrap">
            @include('building.services.services-articles-content',[
                'buildingArticles' =>$buildingArticles,
                'dataUserBuilding' =>$dataUserBuilding,
                'modelUser' => $modelUser
            ])
        </td>
    </tr>
    <tr>
        <td class="tf-statistic" style="border: none; padding: 0;">
            <ul class="nav nav-pills">
                <li class="disabled">
                    <a class="tf-link-grey">
                        {!! trans('frontend_building.service_home_object_statistic_comment_label') !!} {!! $buildingArticles->totalComment() !!}
                    </a>
                </li>
                <li class="disabled">
                    <a class="tf-color-grey">
                        {!! trans('frontend_building.service_home_object_statistic_view_label') !!} {!! $buildingArticles->totalVisit() !!}
                    </a>
                </li>
                <li class="disabled">
                    <a class="tf-color-grey">
                        {!! $createdAt !!}
                    </a>
                </li>
            </ul>

        </td>
    </tr>
        <tr>
            <td id="tf_building_service_articles_comment_wrap_{!! $articlesId !!}" class="tf-comment-wrap">
                @include('building.services.comment.comment', compact('modelUser','ownerStatus'), ['dataBuildingArticles'=>$buildingArticles])
            </td>
        </tr>
</table>
