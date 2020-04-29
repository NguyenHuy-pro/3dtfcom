<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/28/2016
 * Time: 11:08 AM
 */
/*
 *
 * $modelUser
 * $dataBuilding
 * $dataUserBuilding
 *
 *
 */
$hFunction = new Hfunction();
# info if building
$buildingId = $dataBuilding->buildingId();

$date = new DateTime();

$take = 20;
$dateTake = $hFunction->createdAt();
# get posts of building
$buildingActivityList = $dataBuilding->activityOfBuilding($buildingId, $take, $dateTake);
$buildingActivityHighlight = $dataBuilding->activityHighlightOfBuilding($buildingId);
if (count($buildingActivityHighlight) > 0) {
    $dataBuildingPost = $buildingActivityHighlight;
}
?>
<div id="tf_building_activity_content" class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12"
     style="background: #d7d7dd;"
     data-building="{!! $buildingId !!}">
    @if(count($buildingActivityList) > 0)
        @foreach($buildingActivityList as $dataBuildingActivity)
            @if($dataBuildingActivity->checkActivityPost())
                @include('building.posts.content-posts.posts-object', compact('dataBuildingActivity'),
                [
                    'modelUser' => $modelUser,
                    'dataUserBuilding' => $dataUserBuilding
                ])
            @elseif($dataBuildingActivity->checkActivityArticles())
                @include('building.activity.articles.articles-object',compact('dataBuildingActivity'))
            @endif
            <?php
            $newDateTake = $dataBuildingActivity->createdAt();
            ?>
        @endforeach
    @endif
</div>
@if(count($buildingActivityList) > 0)
    @if(count($dataBuilding->activityOfBuilding($buildingId, $take, $newDateTake)) > 0)
        <div id="tf_building_activity_content_more"
             class="tf-building-activity-content-more col-xs-12 col-sm-12 co-md-12 col-lg-12 ">
            <a class="tf-link" data-building="{!! $buildingId !!}" data-take="{!! $take !!}"
               data-href="{!! route('tf.building.activity.more.get') !!}">
                {!! trans('frontend_building.posts_view_more_label') !!}
            </a>
        </div>
    @endif
@endif