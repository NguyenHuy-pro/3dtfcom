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
$createdAt = $buildingArticles->createdAt();
$articlesId = $buildingArticles->articlesId();
?>
<div id="tf_building_service_tool_articles_object_{!! $articlesId !!}"
     class="tf_building_service_tool_articles_object tf-building-service-tool-articles-object col-xs-12 col-sm-12 col-md-12 col-lg-12"
     data-date="{!! $createdAt  !!}" data-articles="{!! $articlesId !!}">
    @include('building.services.tool.articles-object-content',compact('buildingArticles'), [
        'modelUser'=> $modelUser,
    ])
</div>
