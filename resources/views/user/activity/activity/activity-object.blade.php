<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/27/2017
 * Time: 8:42 PM
 */

/*
* modelUser
* dataUser
* userActivity
 */
$dataUserWall = $userActivity->user;
//wall user info
$userWallId = $dataUserWall->userId();
//user login info
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
    $ownerStatus = ($userWallId == $userLoginId) ? true : false;
} else {
    $loginStatus = false;
    $userLoginId = null;
    $ownerStatus = false;
}

//activity info
$activityId = $userActivity->activityId();
?>
{{-- building-new --}}

<div class="tf_user_activity_object tf-user-activity-object col-xs-12 col-sm-12 col-md-12 col-lg-12"
     data-date="{!! $userActivity->createdAt() !!}" data-activity="{!! $activityId !!}">
    @if($userActivity->checkUserPost())
        {{-- post --}}
        @include('user.activity.activity.post.post-object',
            [
                'modelUser'=>$modelUser,
                'dataUserPost'=>$userActivity->userPost
            ])
    @else
        @if($userActivity->checkNewBuilding())
            @include('user.activity.activity.building-new.building-new-object',
                    [
                        'modelUser'=>$modelUser,
                        'dataBuilding'=>$userActivity->building
                    ])
        @elseif($userActivity->checkBannerImage())
            {{-- add banner image --}}
            @include('user.activity.activity.banner-image.banner-image-object',
                [
                    'modelUser'=>$modelUser,
                    'dataBannerImage'=>$userActivity->bannerImage
                ])
        @elseif($userActivity->checkBuildingBanner())
            {{-- building-banner --}}
            @include('user.activity.activity.building-banner.building-banner-object',
                [
                    'modelUser'=>$modelUser,
                    'dataBuildingBanner'=>$userActivity->buildingBanner
                ])

        @endif
        {{-- statistic--}}
        <div class="tf-user-activity-object-statistic text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {{--comment--}}

            <i class="glyphicon glyphicon-comment"></i>
            <span class="tf_user_activity_comment_total">{!! $userActivity->totalComment() !!}</span>
            <a class="tf-link" href="#">Comment</a>
            &nbsp;

            {{--love--}}
            <i class="glyphicon glyphicon-thumbs-up"></i>
            <span class="tf_user_activity_love_total">{!! $userActivity->totalLove() !!}</span>
            @if($loginStatus)
                @if($dataUserLogin->existLoveUserActivity($activityId))
                    <?php $labelLove = 'UnLove'; ?>
                @else
                    <?php $labelLove = 'Love'; ?>
                @endif
                <a class="tf_user_activity_love tf-link"
                   data-href="{!! route('tf.user.activity.love') !!}">{!! $labelLove !!}</a>
            @else
                <span class="tf-color-grey">love </span>
            @endif
            &nbsp;
            {{-- Share
            <i class="glyphicon glyphicon-random"></i>
            <span> 12 </span>
            <span class="tf-link">Share</span>
            --}}
        </div>

        {{--comment--}}
        @include('user.activity.activity.comment.comment-list',
                    [
                        'modelUser'=>$modelUser,
                        'userActivity'=>$userActivity
                    ])

    @endif

</div>

